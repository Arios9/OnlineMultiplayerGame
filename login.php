
<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/formstyle.css">
</head>
<body>

        <?php

        $name = $password = $error = $hash = $id = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {  

           $name = test_input($_POST['username']);
           $password = test_input($_POST['password']);

           require 'mysql_connection.php';

           $sql="SELECT * FROM users WHERE username=?";
           $statement = $mysqli->prepare($sql);
           $statement->bind_param("s", $name);
           $statement->execute();
           $result = $statement->get_result();           

           if (mysqli_num_rows($result) > 0) {
                $row = $result->fetch_assoc();
                $hash = $row["user_password"];
                $id = $row["id"];
                $check_password = password_verify($password, $hash);
                if ($check_password){
                    $_SESSION['username'] = $name;
                    $_SESSION['id'] = $id;
                    header("Location:/connect4/");
                }
           }else{
            $error = " Wrong username or password"; 
           }

           $statement->close();
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
                <h1>Login</h1>
                <p>Please fill in this form to Login. <span class="error"><?php echo $error;?></span></p>
                <hr>

                <label for="username"><b>Username</b></label>
                <input type="text" placeholder="Enter username" name="username" id="username">

                <label for="password"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" id="password">

                <button type="submit" class="button">Login</button>
            </div>
            
            <div class="container question">
                <p>Don't have an account? <a href="register.php">Register</a>.</p>
            </div>
            </form>
        </div>
    
</body>
</html>