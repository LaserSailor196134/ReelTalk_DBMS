<?php
include "config.php";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    //getting username and password from the form
    $username = $_POST['uname'];
    $password = $_POST['password'];
    //checking if the username already exists
    $checkusername = $movies -> prepare('SELECT * FROM dbuser WHERE username = ?');
    $checkusername -> bind_param('s', $username);
    $checkusername -> execute();
    $checkusername -> store_result();
    if($checkusername -> num_rows > 0) {//if the username already exists
        header("Location: register.html");
        echo("<script>alert(\"username already exists\")</script>");
    } else {
        //register account first
        $registeraccount = $movies -> prepare ('INSERT INTO account (username, password) VALUES (?, ?)');
        $registeraccount -> bind_param('ss', $username, hash('sha256', $password));
        $registeraccount -> execute();
        //then register user afterwards, as it contains a foreign key
        $registeruser = $movies -> prepare ('INSERT INTO dbuser (username) VALUES (?)');
        $registeruser -> bind_param('s', $username);
        $registeruser -> execute();
        header('Location: login.html');
        close($registeraccount);
        close($registeruser);
        close($movies);
        die();
    }
}
?>