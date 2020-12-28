<?php require 'check_login.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LiveGame</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/board_style.css">

</head>
<body>
    <?php include 'navbar.php';?>

    <table>
        <tr>
            <td class="squares" id="a"></td>
            <td class="squares" id="b"></td>
            <td class="squares" id="c"></td>
            <td class="squares" id="d"></td>
        </tr>
        <tr>
            <td class="squares" id="e"></td>
            <td class="squares" id="f"></td>
            <td class="squares" id="g"></td>
            <td class="squares" id="h"></td>
        </tr>
        <tr>
            <td class="squares" id="i"></td>
            <td class="squares" id="j"></td>
            <td class="squares" id="k"></td>
            <td class="squares" id="l"></td>
        </tr>
        <tr>
            <td class="squares" id="m"></td>
            <td class="squares" id="n"></td>
            <td class="squares" id="o"></td>
            <td class="squares" id="p"></td>
        </tr>
    </table>

    <script src="play_online.js"></script>
</body>
</html>
