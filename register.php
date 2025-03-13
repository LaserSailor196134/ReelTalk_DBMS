<?php
include "config.php";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['uname'];
    $password = $_POST['password'];
    $checkusername = $movies -> prepare('SELECT * FROM dbuser WHERE username = ?');
    $checkusername -> bind_param('s', $username);
    $checkusername -> execute();
    $checkusername -> store_result();
    if($checkusername -> num_rows > 0) {//if the username already exists
        echo "Username already exists";
    } else {
        //register account first
        $registeraccount = $movies -> prepare ('INSERT INTO account (username, password) VALUES (?, ?)');
        $registeraccount -> bind_param('ss', $username, $password);
        $registeraccount -> execute();
        //then register user afterwards, as it contains a foreign key
        $registeruser = $movies -> prepare ('INSERT INTO dbuser (username) VALUES (?)');
        $registeruser -> bind_param('s', $username);
        $registeruser -> execute();
        header('Location: login.html');
        die();
    }
}
?>