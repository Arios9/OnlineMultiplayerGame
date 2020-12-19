


$(function() {

        var ws_connection = new WebSocket('ws://localhost:8080');

        ws_connection.onopen = function(e) {
            console.log("Connected!");
        };

        ws_connection.onclose = function(e) {
            console.log("Disconnected");
        };

        ws_connection.onmessage = function(e) {
            let move = JSON.parse(e.data);
            let square_id = move.square;
            $("#"+square_id).html(getletter());
        };

        $(".squares").click(function(){
            let square_id = this.id;
            let move = {square: square_id};
            let json_obj = JSON.stringify(move);
            ws_connection.send(json_obj);
        });

        var Xs_turn = false;
        const X_to_html = '<span style="color:blue;">X</span>';
        const O_to_html = '<span style="color:red;">O</span>';

        function getletter(){
            Xs_turn=!Xs_turn;
            return (Xs_turn ? X_to_html : O_to_html);
        }

});