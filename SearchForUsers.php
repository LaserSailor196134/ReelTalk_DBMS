<?php
    include 'config.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $searchterm = $_POST['usersearch'];
        $searchbutton = $_POST['searchbutton'];
        echo('hi')
    }
    //echo('SELECT * FROM dbuser WHERE username LIKE $searchterm%') 
?>