

<?php require '../check_login.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Username</title>
    <link rel="stylesheet" href="../css/formstyle.css">
</head>
<body>
        <?php

        $name_error = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            require '../mysql_connection.php';

            $name = test_input($_POST["username"]);
            if (empty($_POST["username"])) {
                $name_error = " Name is required";
            } else {
                $sql="SELECT * FROM users WHERE username=?";
                $statement = $mysqli->prepare($sql);
                $statement->bind_param("s", $name);
                $statement->execute();
                $result = $statement->get_result();
                if (mysqli_num_rows($result) > 0) {
                    $name_error = " A user with this name already exists. Please use a different name.";
                }else{
                    $id=$_SESSION['id'];
                    $sql="UPDATE users SET username=? WHERE id=$id";
                    $statement = $mysqli->prepare($sql);
                    $statement->bind_param("s", $name);
                    $statement->execute();
                    $statement->close();
                    header("Location:../logout.php");
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
                <h1>Change Username</h1>
                <hr>
                <label for="username"><b>Username</b></label><span class="error"><?php echo $name_error;?></span>
                <input type="text" placeholder="Enter username" name="username" id="username" value="<?php echo $_SESSION['username'];?>">

                <button type="submit" class="button">Change</button>
            </div>
            
            <div class="container question">
                <p>Go back to <a href="../settings.php">Settings</a>.</p>
            </div>
            </form>
        </div>
    
</body>
</html>