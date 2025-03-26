<?php
//removes someone who you are following from your following list
include "../accounts/checkLoggedIn.php";
if(!isLoggedIn()) {
    header("Location: home.php");
    die();
}
include "../config.php";
$toRemove = $_POST['follower'];
$user = $_POST['user'];
if($user = $_SESSION['username']) {//if the user requesting to remove a follower is the user logged in
    $removeFollowing = $movies -> prepare('DELETE FROM FRIENDS_WITH WHERE username1 = ? AND username2 = ?');
    $removeFollowing -> bind_param('ss', $user, $toRemove);
    $removeFollowing -> execute();
    $encoded = urlencode($user);
    header("Location: profile.php?username=$encoded");
} else {
    echo('<script>
    alert("how did you get this to happen")
    window.location.assign("../home.php")
    </script>');
}
?>