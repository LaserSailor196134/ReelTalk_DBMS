<body?>
<?php
    include "config.php";

    $username = 'Annar';
    $mediaID = 43214321;
    $watchStatus = $_POST['typeOfBookmark'];
    $review = $_POST['review'];
    $rating = $_POST['rating'];
    echo("<h1>$username $mediaID $watchStatus $review $rating</h1>");


    $saveBookmark = $movies -> prepare("INSERT INTO bookmark(watchStatus,numberRating,description) VALUES (?,?,?)");
    $saveBookmark -> bind_param('sis',$watchStatus,$rating,$review);
    $saveBookmark -> execute();
    $bookmarkID -> lastInsertID();

    $saveBookmarkC = $movies -> prepare("INSERT INTO CREATES(username,ratingID) VALUES (?,?)");
    $saveBookmarkC -> bind_param('si',$username,$bookmarkID);
    $saveBookmarkC -> execute();

    $saveBookmarkA = $movies -> prepare("INSERT INTO ABOUT(ratingID,mediaID) VALUES (?,?)");
    $saveBookmarkA -> bind_param('ii',$bookmarkID,$mediaID);
    $saveBookmarkA -> execute();


?>
</body>
