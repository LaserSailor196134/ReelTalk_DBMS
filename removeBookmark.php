<?php 
//removes a bookmark for a user if the user trying to remove the bookmark is the creator of the bookmark
include "./accounts/checkloggedin.php";
if(!isLoggedIn()) {
    header("Location: ./home.php");
    die();
} 
$username = $_POST['username'];
$mediaID = $_POST['mediaID'];
if($_SESSION['username'] == $username) {//if the correct user is deleting the bookmark
    $deleteBookmark = $movies -> prepare('DELETE FROM bookmark WHERE username = ? AND mediaID = ?');
    $deleteBookmark -> bind_param('si', $username, $mediaID);
    $deleteBookmark -> execute();
    //the rest should cascade and delete automatically
    header("Location: ../home.php");//this probably should redirect somewhere better
} else {
    echo('<script>
    alert("how did you even do this?")
    window.location.assign("./home.php)
    </script>');
}

?>