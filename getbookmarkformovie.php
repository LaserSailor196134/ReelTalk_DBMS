<?php
    include 'config.php';
    include 'headfoot.php';
    include 'accounts/checkloggedin.php';
    $loggedIn = isLoggedIn();
    $movie_id = 43214321;
    $findbookmarks = $movies -> prepare("SELECT bookmark.*, account.username FROM ABOUT 
    JOIN bookmark ON ABOUT.ratingID = bookmark.ratingID
    JOIN CREATES ON bookmark.ratingID = CREATES.ratingID
    JOIN account ON CREATES.username = account.username
    WHERE ABOUT.mediaID = ?");
    $findbookmarks -> bind_param('i',$movie_id);
    $findbookmarks -> execute();
    $findbookmarks -> store_result();
    $findbookmarks -> bind_result($ratingID, $watchStatus, $numberRating, $description,$dateCreated, $username);
    while($findbookmarks -> fetch()){ //while get next result returns values
        echo(" $username $dateCreated -- $watchStatus <br> Rating: $numberRating <br> Review: $description <br><br>");      
    }
?>
