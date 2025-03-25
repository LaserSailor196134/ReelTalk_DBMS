<?php
    include '../config.php';
    include '../headfoot.php';
    include '../accounts/checkloggedin.php';
    $loggedIn = isLoggedIn();
    $searchterm = '%'.$_POST['usersearch'].'%';
    makeHeader('<br>', '../');
    echo("<h1>Results</h1>");
    $findUsers = $movies -> prepare("SELECT username, joinDate FROM account WHERE username LIKE ?");
    $findUsers -> bind_param('s',$searchterm);
    $findUsers -> execute();
    $findUsers -> bind_result($username,$joinDate);
    while($findUsers -> fetch()){ //while get next result returns values
        $encoded = urlencode($username);
        echo("$username --- Joined: $joinDate");
        echo("
        <form name=\"profile\" method=\"GET\" action=\"profile.php\">
            <input type=\"hidden\" name=\"username\" value=\"$encoded\">
            <input class=\"btn btn-warning p-2 mt-4\" type=\"submit\" value=\"View profile\">
        </form>");
        if($loggedIn && $_SESSION['username'] != $username) {//option to follow them if you are logged in, cannot follow yourself, might want to add a way to prevent having a follow button on people who are already being followed 
            echo("
            <form name=\"addFriend\" method=\"POST\" action=\"addFriend.php\">
                <input type=\"hidden\" name=\"username\" value=\"$username\">
                <input class=\"btn btn-warning p-2 mt-4\" type=\"submit\" value=\"Follow\">
            </form>");
        }
    }  
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/63ff890171.js" crossorigin="anonymous"></script>