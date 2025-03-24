<?php
include "../checkloggedin.php";
if(isLoggedIn()) { //if user is logged in
    include "config.php";
    $loadProfile = $movies -> prepare('SELECT bookmark.*, media.name FROM CREATES
    JOIN bookmark ON CREATES.ratingID = bookmark.ratingID
    JOIN ABOUT ON bookmark.ratingID = ABOUT.ratingID
    JOIN media ON ABOUT.mediaID = media.mediaID
    WHERE CREATES.username = ?'); //get information for every bookmark related to a specified username
    $loadProfile -> bind_param($_SESSION['username']);
    $loadProfile -> execute();
    $loadProfile -> store_result($ratingID, $watchStatus, $numberRating, $description, $dateCreated, $movie);
    while(loadProfile -> fetch()) {
        echo ("<p>watch status: $watchStatus </p>
        <p> movie Name $movie </p>
        <p> rating: $numberRating </p>
        <p> description: $description </p>
        <p> created on $dateCreated </p>");
    }
} else { //if user is not logged in

}
?>