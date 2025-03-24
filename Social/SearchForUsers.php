<?php
    include '../config.php';

    $searchterm = $_POST['usersearch'];
    echo("<h1>Results</h1>");
    $findUsers = $movies -> prepare('SELECT username, joinDate FROM account WHERE username = ?');
    $findUsers -> bind_param('s',$searchterm);
    $findUsers -> execute();
    $findUsers -> bind_result($username,$joinDate);
    while($findUsers -> fetch()){ //while get next result returns values
        echo("$username --- Joined: $joinDate");
    } 
    
?>