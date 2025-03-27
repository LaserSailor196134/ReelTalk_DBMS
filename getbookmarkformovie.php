<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Reeltalk | Bookmarks</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://kit.fontawesome.com/63ff890171.js" crossorigin="anonymous"></script>
    </head>
    <body id="top" class="bg-secondary" style="font-family: Tahoma">
    <div class="container-fluid">
        <?php
        include 'config.php';
        include 'headfoot.php';
        include 'accounts/checkloggedin.php';
        $loggedIn = isLoggedIn();
        $movie_id = urldecode($_GET['mediaID']); // Test if this works.
        
        // Header and bookmarks heading.
        makeHeader();
        echo "
        <div class=\"row justify-content-center mt-3\">
            <div class=\"col-5 bg-warning rounded p-3 my-3\">
                <h2 class=\"fs-2 text-center\">Bookmarks for $movie_id</h2>
            </div>
        </div>
        ";

        echo '<div class="row justify-content-center align-items-center" style="min-height: 75vh"'; // Start of the "row" for bookmarks.
        $findbookmarks = $movies -> prepare("SELECT bookmark.*, account.username, media.name FROM ABOUT 
        JOIN bookmark ON ABOUT.ratingID = bookmark.ratingID
        JOIN CREATES ON bookmark.ratingID = CREATES.ratingID
        JOIN account ON CREATES.username = account.username
        WHERE ABOUT.mediaID = ?");
        $findbookmarks -> bind_param('i',$movie_id);
        $findbookmarks -> execute();
        $findbookmarks -> store_result();
        if($findbookmarks -> num_rows != 0) {
            $findbookmarks -> bind_result($ratingID, $watchStatus, $numberRating, $description, $dateCreated, $username, $mediaName);
            while($findbookmarks -> fetch()){ //while get next result returns values
                makeBookmark($media, $username, $mediaName, $dateCreated, $watchStatus, $description, $numberRating); // Lot of planters!
            }
        } else { // Placeholder for no bookmarks. Main purpose is to add padding for the footer.
            echo '
            <div class="col-2 text-center">
                <p class="bg-dark rounded text-white p-2">No Bookmarks in sight</p>
            </div>
            ';
        }
        // End of row + footer.
        echo '</div>';
        makeFooter();
        ?>
    </div>
    </body>
</html>
