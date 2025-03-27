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
    <body id="top" class="bg-secondary" style="font-family: Tahoma">
    <div class="container-fluid">
        <?php
        //get all bookmarks for a movie or tv show
        include './config.php';
        include './headfoot.php';
        $media = urldecode($_GET['mediaID']);     
        makeHeader();

        echo "
        <div class=\"row justify-content-center mt-3\">
            <div class=\"col-5 bg-warning rounded p-3 my-3\">
                <h2 class=\"fs-2 text-center\">Bookmarks for $media</h2>
            </div>
        </div>
        ";

        echo '<div class="row justify-content-center align-items-center" style="min-height: 75vh"'; // Start of the "row" for bookmarks.
        $findUsers = $movies -> prepare("SELECT bookmark.watchStatus, bookmark.numberRating, bookmark.dateCreated, bookmark.description, account.username, media.name FROM media
        JOIN ABOUT ON media.mediaID = ABOUT.mediaID
        JOIN bookmark ON ABOUT.ratingID = bookmark.ratingID
        JOIN CREATES ON bookmark.ratingID = CREATES.ratingID
        JOIN account ON CREATES.username = account.username
        WHERE media.mediaID = ?");
        $findReviews -> bind_param('s',$media);
        $findReviews -> execute();
        $findReviews -> store_result();
        if($findReviews -> num_rows != 0) {
            $findReviews -> bind_result($watchStatus, $numberRating, $dateCreated, $description, $username, $mediaName);
            while($findReviews -> fetch()){ //while get next result returns values
                makeBookmark($media, $username, $mediaName, $dateCreated, $watchStatus, $description, $numberRating); // Lot of planters!
            }
        } else { // Placeholder for no bookmarks. Main purpose is to add padding for the footer.
            echo '
            <div class="col-2 text-center">
                <p class="bg-dark rounded text-white p-2">No Bookmarks in sight</p>
            </div>
            ';
        }
        echo '</div>';
        makeFooter();
        ?>
    </div>
    </body>
</html>
<!--
echo("
        <form name=\"profile\" method=\"GET\" action=\"profile.php\">
            <input type=\"hidden\" name=\"username\" value=\"$encoded\">
            <input class=\"btn btn-warning p-2 mt-4\" type=\"submit\" value=\"View profile\">
        </form>");
--> 