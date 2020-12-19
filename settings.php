
<?php require 'check_login.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/settings_style.css">
</head>
<body>
    <?php include 'navbar.php';?>
    <div class="center">
        <h2>Account Settings</h2>
        <a href="settings_actions/change_username.php"><button type="button" class="btn btn-primary btn-lg btn-block">Change Username</button></a>
        <a href="settings_actions/change_password.php"><button type="button" class="btn btn-primary btn-lg btn-block">Change Password</button></a>
        <a href="settings_actions/delete_account.php"><button type="button" class="btn btn-danger btn-lg btn-block">Delete Account</button></a>
    </div>

    


</body>
</html>
