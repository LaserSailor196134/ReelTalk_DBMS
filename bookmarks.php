<?php
    include '../config.php';
    $media = urldecode($_GET['mediaID']);

    echo("<h1>$media Ratings</h1>");
    $findUsers = $movies -> prepare("SELECT bookmark.watchStatus, bookmark.numberRating, bookmark.dateCreated, bookmark.description account.username FROM media
    JOIN ABOUT ON media.mediaID = ABOUT.mediaID
    JOIN bookmark ON ABOUT.ratingID = bookmark.ratingID
    JOIN CREATES ON bookmark.ratingID = CREATES.ratingID
    JOIN account ON CREATES.username = account.username
    WHERE media.mediaID = ?");
    $findReviews -> bind_param('s',$media);
    $findReviews -> execute();
    $findReviews -> store_result();
    $findReviews -> bind_result($watchStatus,$numberRating,$dateCreated,$description, $username);
    while($findReviews -> fetch()){ //while get next result returns values
        echo("$username --- Posted: $dateCreated
            Rating: $numberRating 
            Review: $description");
    }
?>
<!--
echo("
        <form name=\"profile\" method=\"GET\" action=\"profile.php\">
            <input type=\"hidden\" name=\"username\" value=\"$encoded\">
            <input class=\"btn btn-warning p-2 mt-4\" type=\"submit\" value=\"View profile\">
        </form>");
-->