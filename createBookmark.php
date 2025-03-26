<body>
    <form method = "POST" action = "createBookmark.php">
    <h2>Status</h2>
    <select id = "typeOfBookmark">
        <option value = "Want to Watch">Want to Watch</option>
        <option value = "Currently Watching">Currently Watching</option>
        <option value = "Watched">Watched</option>
    </select>

    <h2>Rating</h2>
    <select id = "rating">
        <option value = "null">Rate the Movie</option>
        <option value = "1">* One star</option>
        <option value = "2">** Two stars</option>
        <option value = "3">*** Three stars</option>
        <option value = "4">**** Four stars</option>
        <option value = "5">***** Five stars</option>
    </select>
    <h2>Review</h2>
    <textarea id = "review" rows = "4"></textarea>
    <button id="postbutton">Publish</button>
    </form>
    
    <?php
        include "config.php";
    
        $typeOfBookmark = $_POST['typeOfBookmark'];
        $review = $_POST['review'];
        $rating = $_POST['rating'];

        $saveBookmark = $movies -> prepare("INSERT INTO bookmark(watchStatus,numberRating,description) VALUES ($watchStatus,$rating,$review)");
        $saveBookmark -> execute();
        $bookmarkID -> lastInsertID();

        $getDate = $movies -> prepare("SELECT dateCreated FROM bookmark WHERE bookmarkID = ?");
        $getDate -> bind_param( 'i',$bookmarkID);
        $getDate -> execute();
        $getDate -> store_result();
        $getDate -> bind_result( $date );

        $saveBookmarkC = $movies -> prepare("INSERT INTO CREATES VALUES ($username,$bookmarkID)");
        $saveBookmarkC -> execute();

        $saveBookmarkA = $movies -> prepare("INSERT INTO CREATES VALUES ($bookmarkID,$mediaID)");
        $saveBookmarkA -> execute();

        echo('<h2>Successfully saved bookmark</h2>')


    ?>
</body>