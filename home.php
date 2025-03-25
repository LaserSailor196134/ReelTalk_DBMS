<!-- home.php:
 This file is the landing/navigation page for our project.
 Contains a description of the website/database, social features.
 Also contains links to the Movies, Cast, and User search pages.
-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ReelTalk | Home</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://kit.fontawesome.com/63ff890171.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-secondary" style="font-family: Tahoma"> <!-- Can change the font if we need to -->
    <div id="top" class="container-fluid">
        <?php
        include 'headfoot.php';
        makeHeader();
        ?>
        <div class="container-fluid" style="min-height: 75vh">
            <div class="row justify-content-center py-4">
                <div class="bg-dark rounded text-center col-6 m-4 py-3">
                    <h1 class="text-light fs-1 pt-3">Welcome to ReelTalk!<br></h1>
                    <h2 class="text-warning fs-5">It's like Goodreads for movies<br></h2>
                    <p class="text-light">ReelTalk is an interactive database that allows you to search through all your
                    favourite movies and stars. While searching, you can add films to your watchlist and post reviews with our
                    bookmark features. If that isn't enough, you can take a look at other user reviews and send friend requests.
                    <br>Get to know our database using the navigational tools below.</p>
                </div>
            </div>
            <div class="row justify-content-center py-4">
                <div class="bg-dark rounded text-center col-3 mx-4 py-3">
                    <a href="movies.php" class="fs-5 btn btn-warning p-3"><i class="fa-solid fa-film"></i> Movies</a>
                    <p class="text-light p-3">Find all your favorite movies, see their casts, and read user reviews here!
                    </p>
                </div>
                <div class="bg-dark rounded text-center col-3 mx-4 py-3">
                    <a href="stars.php" class="fs-5 btn btn-warning p-3"><i class="fa-solid fa-star"></i> Stars</a>
                    <p class="text-light p-3">Search our catalogue of  actors, directors, and more to see what they've made!
                    </p>
                </div>
                <div class="bg-dark rounded text-center col-3 mx-4 py-3">
                    <a href="social/users.php" class="fs-5 btn btn-warning p-3"><i class="fa-solid fa-users"></i> Users</a>
                    <p class="text-light p-3">Encounter new users, view their recent bookmarks, and make friends!
                    </p>
                </div>
            </div>
        </div>
        <div class="pt-5">
            <?php makeFooter(); ?>
        <div>
    </div>
    </body>
</html>