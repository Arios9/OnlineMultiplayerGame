<?php require '../check_login.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="../css/formstyle.css">
</head>
<body>

<?php

        $old_password_error = $new_password_error = $password_repeat_error=
        $old_password = $new_password = $password_repeat = "";


        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            require '../mysql_connection.php';
            $error_exists=false;

            $old_password = test_input($_POST["old_password"]);
                
            
                $sql="SELECT * FROM users WHERE id=?";
                $statement = $mysqli->prepare($sql);
                $statement->bind_param("s", $_SESSION["id"]);
                $statement->execute();
                $result = $statement->get_result();     
                $row = $result->fetch_assoc();
                $hash = $row["user_password"];
                $check_password = password_verify($old_password, $hash);
                if (!$check_password){
                    $old_password_error=" Wrong password";
                    $error_exists=true;
                }

            $new_password = test_input($_POST["new_password"]);
            $uppercase = preg_match('@[A-Z]@', $new_password);
            $lowercase = preg_match('@[a-z]@', $new_password);
            $number = preg_match('@[0-9]@', $new_password);
            $specialchar = preg_match('@[^\w]@', $new_password);

            if(!$uppercase || !$lowercase || !$number || !$specialchar || strlen($new_password) < 8) {
                $new_password_error = ' should be at least 8 characters in length and include at least 1 upper case letter, 1 number and 1 special character.';
                $error_exists=true;
            }
            $password_repeat = test_input($_POST["password_repeat"]);
            if($new_password!==$password_repeat){
                $password_repeat_error = " Those passwords didn't match. Try again.";
                $error_exists=true;
            }

            if(!$error_exists){
                $sql="UPDATE users SET user_password=? WHERE id=?";
                $statement = $mysqli->prepare($sql);
                $hash = password_hash($new_password, PASSWORD_DEFAULT);
                $statement->bind_param("ss", $hash, $_SESSION["id"]);
                $statement->execute();
                $statement->close();
                header("Location:../logout.php");
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
                <h1>Change Password</h1>
                <hr>

                <label for="old_password"><b>Old Password</b></label><span class="error"><?php echo $old_password_error;?></span>
                <input type="password" placeholder="Enter Old Password" name="old_password" id="old_password" value="<?php echo $old_password;?>">

                <label for="new_password"><b>New Password</b></label><span class="error"><?php echo $new_password_error;?></span>
                <input type="password" placeholder="Enter New Password" name="new_password" id="new_password" value="<?php echo $new_password;?>">

                <label for="password_repeat"><b>Repeat New Password</b></label><span class="error"><?php echo  $password_repeat_error;?></span>
                <input type="password" placeholder="Repeat New Password" name="password_repeat" id="password_repeat" value="<?php echo $password_repeat;?>">
                <hr>

                <button type="submit" class="button">Change</button>
            </div>
            
            <div class="container question">
                <p>Go back to <a href="../settings.php">Settings</a>.</p>
            </div>
            </form>
        </div>
    
</body>
</html>