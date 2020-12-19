<?php
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

define('WINS', array('abcd','efgh','ijkl','mnop','aeim','bfjn','cgko','dhlp','afkp','dgjm'));

class GameServer implements MessageComponentInterface {

    protected $clients;

    public function __construct() {
        $this->clients = [];
        echo "Server Started\n";   
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients[$conn->resourceId] = $conn;
        echo "New connection! ({$conn->resourceId})\n";
        $this->addnewConnection($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg) {

        require '../../mysql_connection.php';
        $sql="SELECT * FROM livegames WHERE connturn=$from->resourceId";
        $result = $mysqli->query($sql);
        if ($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $moves_played=$row["moves"];
            $move_for_check=json_decode($msg);
            $square_id=$move_for_check->square;

            if (empty($moves_played)|| !(strpos($moves_played, $square_id) !== false)) {
                $moves_played .= $square_id;
                $next_to_move = ($from->resourceId==$row["conn1"]) ? $row["conn2"] : $row["conn1"];
                $game_id = $row["id"];
                $sql="UPDATE livegames SET connturn=$next_to_move,moves='$moves_played' WHERE id=$game_id";
                $mysqli->query($sql);
                $this->clients[$row["conn1"]]->send($msg);
                $this->clients[$row["conn2"]]->send($msg);
                $this->check_gameover($moves_played,$from);
            }

        }
        $mysqli->close();

    }

    public function onClose(ConnectionInterface $conn) {
        require '../../mysql_connection.php';
        $sql="DELETE FROM livegames WHERE conn1=$conn->resourceId OR conn2=$conn->resourceId";
        $mysqli->query($sql);
        $mysqli->close();
        unset($this->clients[$conn->resourceId]);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }

    private function addnewConnection(ConnectionInterface $conn){
        require '../../mysql_connection.php';
        $sql="SELECT * FROM livegames WHERE connturn IS NULL";
        $result = $mysqli->query($sql);
        if ($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $conn1 = $row["conn1"];
            $sql="UPDATE livegames SET conn2=$conn->resourceId,connturn=$conn1 WHERE conn1=$conn1";
            $mysqli->query($sql);
        }else{
            $sql="INSERT INTO livegames VALUES (null, $conn->resourceId, null, null, null)";
            $mysqli->query($sql);
        }
        $mysqli->close();
    }

    
    private function check_gameover($moves_played,ConnectionInterface $conn){
        if(strlen($moves_played)==16||$this->check_for_win($moves_played))
            $this->onClose($conn);  
    }

    private function check_for_win($moves_played){
        $moves_lastplayer=$this->getmoves_from_last_player($moves_played);
        foreach(WINS as $x)
            if(strpos($moves_lastplayer,$x)!==false)
                return true;
        return false;
    }
    
    private function getmoves_from_last_player($str){
        $arr=[];
        for ($x = strlen($str)-1; $x>=0; $x-=2) 
            array_push($arr,$str[$x]);
        sort($arr);
        $sorted_moves=implode($arr);
        return $sorted_moves;
    }
}