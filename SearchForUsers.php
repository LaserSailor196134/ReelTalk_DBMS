<?php
    include 'config.php';
    $searchterm = $_POST['usersearch'];
    $searchbutton = $_POST['searchbutton'];

    echo('SELECT * FROM dbuser WHERE username LIKE $searchterm%') 
?>