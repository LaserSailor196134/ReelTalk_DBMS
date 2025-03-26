<body>
    <form method = "POST" action = "createBookmark.php" id="form1">
    <h2>Status</h2>
    <?php
    $movieID = $_POST['movie_id'];
    echo("<input type='hidden' name='movie_id' value='$movieID'>");
    ?>
    <select name = "typeOfBookmark">
        <option value = "Want to Watch">Want to Watch</option>
        <option value = "Currently Watching">Currently Watching</option>
        <option value = "Watched">Watched</option>
    </select>

    <h2>Rating</h2>
    <select name = "rating">
        <option value = "null">Rate the Movie</option>
        <option value = "1">* One star</option>
        <option value = "2">** Two stars</option>
        <option value = "3">*** Three stars</option>
        <option value = "4">**** Four stars</option>
        <option value = "5">***** Five stars</option>
    </select>
    <h2>Review</h2>
    <textarea name = "review" rows = "4"></textarea>  
    <input type="submit" value="add review">
    </form>
</body>