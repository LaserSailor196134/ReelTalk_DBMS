<?php 
//page that adds a follower when given form data
include "../accounts/checkloggedin.php";
if(!isLoggedIn()) {
    header("Location: ../home.php");
    die();
}
include "../config.php";
$username = $_POST['username'];
$addFriend = $movies -> prepare('INSERT INTO FRIENDS_WITH (username1, username2)VALUES (?, ?)');
$addFriend -> bind_param('ss', $_SESSION['username'], $username);
try {
    $addFriend -> execute();
} catch(Exception $e) {
    echo ('<script>
    alert("cannot follow the same account twice")
    window.location.assign("users.php")
    </script>');
    die();
}
header("Location: profile.php?username=$username");
?>