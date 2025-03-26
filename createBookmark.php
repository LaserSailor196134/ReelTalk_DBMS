<body?>
<?php
    include "config.php";

    $username = 'Annar';
    $mediaID = 43214321;
    $watchStatus = $_POST['typeOfBookmark'];
    $review = $_POST['review'];
    $rating = $_POST['rating'];

    $saveBookmark = $movies -> prepare("INSERT INTO bookmark(watchStatus,numberRating,description) VALUES (?,?,?)");
    $saveBookmark -> bind_param('sis',$watchStatus,$rating,$review);
    $saveBookmark -> execute();
    $bmID = $movies -> prepare("SELECT LAST_INSERT_ID()");
    $bmID -> execute();
    $bmID -> bind_result($bookmarkID);
    $bmID -> fetch();
    $bmID -> close();

    $saveBookmarkC = $movies -> prepare("INSERT INTO CREATES(username,ratingID) VALUES (?,?)");
    $saveBookmarkC -> bind_param('si',$username,$bookmarkID);
    $saveBookmarkC -> execute();

    $saveBookmarkA = $movies -> prepare("INSERT INTO ABOUT(ratingID,mediaID) VALUES (?,?)");
    $saveBookmarkA -> bind_param('ii',$bookmarkID,$mediaID);
    $saveBookmarkA -> execute();

    echo("successfully saved review")

?>
</body>
