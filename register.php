<?php
include "config.php";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['uname'];
    $password = $_POST['password'];
    $checkusername = $movies -> prepare('SELECT * FROM users WHERE username = ?');
    $checkusername -> bind_param('s', $username);
    $checkusername -> execute();
    $checkusername -> store_result();
    if($checkusername -> num_rows > 0) {//if the username already exists
        echo "Username already exists";
    } else {
        $register = $movies -> prepare ('INSERT INTO users (username, password) VALUES (?, ?)');
        $register -> bind_params('ss', $username, $password);
        $register -> execute();
        header('Location: login.html');
    }
}
?>