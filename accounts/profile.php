<?php
include "./checkloggedin.php";
if(isLoggedIn()) { //if user is logged in
    include "../config.php";
    $loadProfile = $movies -> prepare('SELECT bookmark.* FROM CREATES
    JOIN bookmark ON CREATES.ratingID = bookmark.ratingID
    WHERE CREATES.username = ?'); //get information for every bookmark related to a specified username
    $loadProfile -> bind_param($_SESSION['username']);
    $loadProfile -> execute();
    $loadProfile -> store_result($ratingID, $watchStatus, $numberRating, $description, $dateCreated);
    while(loadProfile -> fetch()) {
        $findMovie = $movies -> prepare('SELECT media.name FROM ABOUT
        JOIN media ON ABOUT.mediaID = media.mediaID
        WHERE ABOUT.ratingID = ?'); //find the name of the movie that is referenced by the bookmark
        $findMovie -> bind_param($ratingID);
        $findMovie -> execute();
        $findMovie -> store_result($movieName);
        $findMovie -> fetch();
        echo ("<p>watch status: $watchStatus </p>
        <p> movie Name $movie </p>
        <p> rating: $numberRating </p>
        <p> description: $description </p>
        <p> created on $dateCreated </p>");
    }
} else { //if user is not logged in

}
?>