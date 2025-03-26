<?php
//loads the profile for a person
include "../accounts/checkloggedin.php";
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
$findFollowing = $movies -> prepare('SELECT COUNT(username1) FROM FRIENDS_WITH WHERE username1 = ?');
$findFollowing -> bind_param('s', $username);
$findFollowing -> execute();
$findFollowing -> bind_result($followingCount);
$findFollowing -> fetch();
echo("<p>following $followingCount users and ");
$findFollowing -> close();
$findFollowedBy = $movies -> prepare('SELECT COUNT(username1) FROM FRIENDS_WITH WHERE username2 = ?');
$findFollowedBy -> bind_param('s', $username);
$findFollowedBy -> execute();
$findFollowedBy -> bind_result($followedCount);
$findFollowedBy -> fetch();
echo("followed by $followedCount users</p>");
$findFollowedBy -> close();
$generateFollowing = $movies -> prepare('SELECT username2 FROM FRIENDS_WITH WHERE username1 = ?');
$generateFollowing -> bind_param('s', $username);
$generateFollowing -> execute();
$generateFollowing -> store_result();
if($generateFollowing -> num_rows == 0) {
    echo("<h3>Not following anyone</h3>");
} else {
    $generateFollowing -> bind_result($followedUser);
    echo("<h3>Following: </h3>");
    while($generateFollowing -> fetch()) {
        echo("<p>$followedUser</p>");
        if(isLoggedIn() && $_SESSION['username'] == $user) {
            echo("
            <form name=\"removeFollower\" method=\"POST\" action=\"removeFollower.php\">
                <input type=\"hidden\" name=\"user\" value=\"$user\">
                <input type=\"hidden\" name=\"follower\" value=\"$followedUser\">
                <input class=\"btn btn-warning p-2 mt-4\" type=\"submit\" value=\"Unfollow\">
            </form>");
        }
    }
}
$generateFollowing -> close();
$generateFollowers = $movies -> prepare('SELECT username1 FROM FRIENDS_WITH WHERE username2 = ?');
$generateFollowers -> bind_param('s', $username);
$generateFollowers -> execute();
$generateFollowers -> store_result();
if($generateFollowers -> num_rows == 0) {
    echo("<h3>No followers</h3>");
} else {
    $generateFollowers -> bind_result($followingUser);
    echo("<h3>Followed by: </h3>");
    while($generateFollowers -> fetch()) {
        echo("<p>$followingUser</p>");
    }
}
$generateFollowers -> close();
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
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/63ff890171.js" crossorigin="anonymous"></script>