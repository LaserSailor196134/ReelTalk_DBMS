<body>
<?php
    include "config.php";
    include 'accounts/checkloggedin.php';
    if(!isLoggedIn()) {
        die();
    } 
    $username = $_SESSION['username'];
    $mediaID = $_POST['movie_id'];
    $watchStatus = $_POST['typeOfBookmark'];
    $review = $_POST['review'];
    $rating = $_POST['rating'];

    $isAlreadyReviewed = $movies -> prepare('');//create a query that checks for duplicate reviews on the same movie from the same user
    
    if($isAlreadyReviewed -> num_rows() == 0) {//if not already reviewed
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
    }
    header("Location: social/profile.php?username = $username");

?>
</body>
