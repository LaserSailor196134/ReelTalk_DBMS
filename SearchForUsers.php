<?php
    include 'config.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $searchterm = $_POST['usersearch'];
        echo("$searchterm");
    }
    //echo('SELECT * FROM dbuser WHERE username LIKE $searchterm%') 
?>