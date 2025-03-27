<!-- pgToCreateBookmark.php
 Represents the frontend for creating bookmarks on a user-account.
-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Reeltalk | Login</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://kit.fontawesome.com/63ff890171.js" crossorigin="anonymous"></script>
    </head>
    <body id="top" class="bg-secondary" style="font-family: Tahoma;">
    <div class="container-fluid">
        <?php
        include 'headfoot.php';
        makeHeader();
        $movieID = $_POST['movie_id'];
        echo("
        <div class=\"container d-flex justify-content-center align-items-center\" style=\"min-height: 80vh;\">
            <form method = \"POST\" action = \"createBookmark.php\" id=\"form1\">
                <input type='hidden' name='movie_id' value='$movieID'>");

        ?>
                <div class="row bg-dark rounded-top">
                    <div class="col-5 m-3">
                        <h2 class="text-light fs-4">Status</h2>
                        <select class="form-select text-white bg-dark" name = "typeOfBookmark">
                            <option value = "Want to Watch">Want to Watch</option>
                            <option value = "Currently Watching">Currently Watching</option>
                            <option value = "Watched">Watched</option>
                        </select>
                    </div>
                    <div class="col-5 m-3">
                        <h2 class="text-light fs-4">Rating</h2>
                        <select class="form-select text-warning bg-dark" name = "rating">
                            <option value = "null">No Rating</option>
                            <option value = "1">One Crown</option>
                            <option value = "2">Two Crowns</option>
                            <option value = "3">Three Crowns</option>
                            <option value = "4">Four Crowns</option>
                            <option value = "5">Five Crowns</option>
                        </select>
                    </div>
                </div>
                <div class="row bg-dark rounded-bottom">
                    <div class="col-11 m-3">
                        <h2 class="text-light fs-4">Review</h2>
                        <textarea class="form-control" name = "review" rows = "5" style="resize: none;"></textarea>  
                        <input class="btn btn-warning mt-3 justify-text-end" type="submit" value="Post Bookmark">
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>