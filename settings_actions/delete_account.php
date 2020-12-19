

<?php require '../check_login.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
    <link rel="stylesheet" href="../css/formstyle.css">
</head>
<body>

    <?php

        $password_error = $password  = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            require '../mysql_connection.php';

            $password = test_input($_POST["password"]);
            $sql="SELECT * FROM users WHERE id=?";
            $statement = $mysqli->prepare($sql);
            $statement->bind_param("s", $_SESSION["id"]);
            $statement->execute();
            $result = $statement->get_result();
            if (mysqli_num_rows($result) > 0) {
                $row = $result->fetch_assoc();
                $hash = $row["user_password"];
                $check_password = password_verify($password, $hash);
                if ($check_password){
                    $sql="DELETE FROM users WHERE id=?";
                    $statement = $mysqli->prepare($sql);
                    $statement->bind_param("s", $_SESSION["id"]);
                    $statement->execute();
                    header("Location:../logout.php");
                }else {
                    $password_error=" Wrong password";
                }
            }
            
            $mysqli->close();
        }

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    ?>

        <div class="center">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
            <div class="container">
                <h1>Delete Account</h1>
                <hr>
                <label for="password"><b>Password</b></label><span class="error"><?php echo $password_error;?></span>
                <input type="password" placeholder="Enter Password" name="password" id="password" value="<?php echo $password;?>">

                <button type="submit" class="button" style="background-color:red;">Delete</button>
            </div>
            
            <div class="container question">
                <p>Go back to <a href="../settings.php">Settings</a>.</p>
            </div>
            </form>
        </div>
    
</body>
</html>