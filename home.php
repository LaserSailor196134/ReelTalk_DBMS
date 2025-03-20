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
        <!-- TODO: Add a CSS style sheet that specifies random website specifics -->
    </head>
    <body class="bg-secondary" style="font-family: Tahoma"> <!-- Can change the font if wee need to -->
    <div class="container-fluid">
        <?php
        include 'utilitiesh.php';
        makeHeader();
        ?>
    </div>
    <div class="container-fluid">
        <div class="row justify-content-center">
        </div>
        <div class="row justify-content-center py-4">
            <div class="bg-dark rounded text-center col-3 mx-4 py-3">
                <button class="fs-5 btn btn-warning p-3"><i class="fa-solid fa-film"></i> Movies</button>
                <p class="text-light p-3">Find all your favorite movies, see who worked on them, and read user reviews here!
                </p>
            </div>
            <div class="bg-dark rounded text-center col-3 mx-4 py-3">
                <button class="fs-5 btn btn-warning p-3"><i class="fa-solid fa-star"></i> Stars</button>
                <p class="text-light p-3">Search our catalogue of the actors, directors, and more to see what they've made!
                </p>
            </div>
            <div class="bg-dark rounded text-center col-3 mx-4 py-3">
                <button class="fs-5 btn btn-warning p-3"><i class="fa-solid fa-users"></i> Users</button>
                <p class="text-light p-3">Encounter new users, view their recent watchlist, and make friends!
                </p>
            </div>
        </div>
    </div>
    </body>
</html>