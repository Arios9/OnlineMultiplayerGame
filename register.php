
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/formstyle.css">
</head>
<body>

<?php

        $name_error = $password_error = $password_repeat_error=
        $name = $password = $password_repeat = "";


        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            require 'mysql_connection.php';
            $error_exists=false;

            $name = test_input($_POST["username"]);
            if (empty($_POST["username"])) {
                $name_error = " Name is required";
                $error_exists=true;
            } else {
                $sql="SELECT * FROM users WHERE username=?";
                $statement = $mysqli->prepare($sql);
                $statement->bind_param("s", $name);
                $statement->execute();
                $result = $statement->get_result();
                if (mysqli_num_rows($result) > 0) {
                    $name_error = " A user with this name already exists. Please use a different name.";
                    $error_exists=true;
                }
            }

            $password = test_input($_POST["password"]);
            $uppercase = preg_match('@[A-Z]@', $password);
            $lowercase = preg_match('@[a-z]@', $password);
            $number = preg_match('@[0-9]@', $password);
            $specialchar = preg_match('@[^\w]@', $password);

            if(!$uppercase || !$lowercase || !$number || !$specialchar || strlen($password) < 8) {
                $password_error = ' should be at least 8 characters in length and include at least 1 upper case letter, 1 number and 1 special character.';
                $error_exists=true;
            }
            $password_repeat = test_input($_POST["password_repeat"]);
            if($password!==$password_repeat){
                $password_repeat_error = " Those passwords didn't match. Try again.";
                $error_exists=true;
            }

            if(!$error_exists){
                $sql="INSERT INTO users (username, user_password) VALUES (?,?)";
                $statement = $mysqli->prepare($sql);
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $statement->bind_param("ss", $name, $hash);
                $statement->execute();
                $statement->close();
                header("Location:login.php");
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
                <h1>Register</h1>
                <p>Please fill in this form to Register.</p>
                <hr>

                <label for="username"><b>Username</b></label><span class="error"><?php echo $name_error;?></span>
                <input type="text" placeholder="Enter username" name="username" id="username" value="<?php echo $name;?>">

                <label for="password"><b>Password</b></label><span class="error"><?php echo $password_error;?></span>
                <input type="password" placeholder="Enter Password" name="password" id="password" value="<?php echo $password;?>">

                <label for="password_repeat"><b>Repeat Password</b></label><span class="error"><?php echo  $password_repeat_error;?></span>
                <input type="password" placeholder="Repeat Password" name="password_repeat" id="password_repeat" value="<?php echo $password_repeat;?>">
                <hr>

                <button type="submit" class="button">Register</button>
            </div>
            
            <div class="container question">
                <p>Already have an account? <a href="login.php">Login</a>.</p>
            </div>
            </form>
        </div>
    
</body>
</html>