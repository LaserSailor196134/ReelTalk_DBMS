<?php
include "../accounts/checkloggedin.php";
if(isLoggedIn()) { //if user is logged in
    include "../headfoot.php";
    include "../config.php";
    makeHeader('<br>', '../');
    //load user's user info
    $user = urldecode($_GET['username']);
    $loadProfile = $movies -> prepare('SELECT username, joinDate FROM account WHERE username = ?');
    $loadProfile -> bind_param('s', $user);
    $loadProfile -> execute();
    $loadProfile -> bind_result($username, $joinDate);
    $loadProfile -> fetch();
    echo("<h2>$username's profile</h2>
    <h3>Joined on $joinDate</h3>");
    $loadProfile -> close();

    //should load friends list here, and find following and follower count

    //this loads all of the users's bookmarks, add 
    $loadBookmarks = $movies -> prepare('SELECT bookmark.watchStatus, bookmark.numberRating, bookmark.description, bookmark.dateCreated, media.name FROM CREATES
    JOIN bookmark ON CREATES.ratingID = bookmark.ratingID
    JOIN ABOUT ON bookmark.ratingID = ABOUT.ratingID
    JOIN media ON ABOUT.mediaID = media.mediaID
    WHERE CREATES.username = ?'); //get information for every bookmark related to a specified username
    $loadBookmarks -> bind_param('s', $_SESSION['username']);
    $loadBookmarks -> execute();
    $loadBookmarks -> store_result();
        if($loadBookmarks -> num_rows > 0) {
            echo("<h2>Bookmarks</h2>");
            $loadBookmarks -> bind_result($watchStatus, $numberRating, $description, $dateCreated, $movie);
            while($loadBookmarks -> fetch()) {
                echo ("<p>watch status: $watchStatus </p>
                <p> movie Name $movie </p>
                <p> rating: $numberRating </p>
                <p> description: $description </p>
                <p> created on $dateCreated </p>");
            }
        } else {
            echo ("<h2>No bookmarks written</h2>");
        }
} else { //if user is not logged in
    header("Location: ../home.php");
}
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/63ff890171.js" crossorigin="anonymous"></script>