<!-- filmshow.php:
 This file is for displaying movie profiles based on Movie IDs submitted in queries.
-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ReelTalk | Film Profile</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://kit.fontawesome.com/63ff890171.js" crossorigin="anonymous"></script>
        <style>
            .scrollable-table {
                max-height: 400px;
                display: inline-block;
                overflow: auto;
            }
            .body-col {
                background-color: #FFF3CD;
            }
        </style>
    </head>
    <body class="bg-secondary" style="font-family: Tahoma">
    <div id="top" class="container-fluid">
        <?php
        include 'headfoot.php';
        $my_bar = '
            <input type="text" class="form-control" placeholder="Search movies...">
        ';
        makeHeader($my_bar);
        ?>
        <!-- Example layout. Convert to function later, with relevant  -->
        <div class="container bg-dark rounded mb-5">
            <!-- Film title -->
            <div class="row justify-content-center py-5 mt-5">
                <div class="col-6 bg-warning rounded text-center">
                    <!-- Main film information -->
                    <?php $movie_id = $_POST['movie_id'];
                    include "config.php";
                    $getMovieInfo = $movies -> prepare('SELECT media.mediaID, media.name, media.description, media.MPARating, movie.length, TVShow.episodeCount FROM media
                    LEFT JOIN movie ON movie.mediaID = media.mediaID
                    LEFT JOIN TVShow ON TVShow.mediaID = media.mediaID
                    WHERE media.mediaID = ?');
                    $getMovieInfo -> bind_param('i', $movie_id);
                    $getMovieInfo -> execute();
                    $getMovieInfo -> bind_result($mediaID, $mediaName, $mediaDescription, $MPARating, $movieLength, $episodeCount);
                    $getMovieInfo -> fetch();
                    echo('<h1 class="fs-2 pt-2">' . $mediaName . '</h1>
                    <p class="text-secondary">[poster placeholder]</p>
                    <p class="text-secondary">' . $mediaID . '</p> <!-- Maybe don\'t include ID -->
                </div>
            </div>
            <div class="row justify-content-center pb-5">
                <!-- Film information -->
                <div class="col-5 body-col rounded mx-2">
                    <p class="pt-2">MPA Rating: ' . $MPARating . '</p>
                    <p>Length ' . $movieLength . ' [Episode Count]: ' . $episodeCount . '</p>
                    <p>Release Date: Not in database</p>
                    <p>Description: ' . $mediaDescription . '</p>
                    <p>Review Score: no aggregate score calculation yet.</p>
                    <p>Availability: No streaming availability yet.</p>
                    <!-- Change these to let user place bookmark on page -->
                    <form method="POST" action="pgToCreateBookmark.php">
                        <input type="hidden" name="movie_id" value=' . $movie_id . '>
                        <input class=\"btn btn-light p-1 my-2\" type="submit" value="Add Bookmark">
                    </form>
                    <form method="POST" action="getbookmarkformovie.php">
                        <input type="hidden" name="movie_id" value=' . $movie_id . '>
                        <input class=\"btn btn-light p-1 my-2\" type="submit" value="See Bookmarks">
                    </form>');
                    ?>
                </div>
                <!-- Cast/Crew -->
                <div class="col-5 scrollable-table">
                    <table class="table table-striped table-warning">
                        <thead>
                            <tr>
                                <th>Crew Member</th>
                                <th>Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <!-- These could be links to Star pages in the actual implementation(?) -->
                                <td>Sean Dingle</td>
                                <td>Director</td>
                            </tr>
                            <tr>
                                <td>Tom Dingle</td>
                                <td>Assistant Director</td>
                            </tr>
                            <tr>
                                <td>Baddie McAnderson</td>
                                <td>Actor/Producer</td>
                            </tr>
                            <tr>
                                <td>Jimmy Provalone</td>
                                <td>Actor</td>
                            </tr>
                            <tr>
                                <td>Sarah Provalone</td>
                                <td>Actor</td>
                            </tr>
                            <tr>
                                <td>Echo Rodriguez</td>
                                <td>Actor</td>
                            </tr>
                            <tr>
                                <td>Elhadi Shakshuki</td>
                                <td>Professor</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Bookmarks (This should go on its own page imo)
            - Maybe we could place the users bookmark here?
            - TODO: Create a function for assembling bookmarks.
            <div class="row justify-content-center pb-5">
                <div class="col-4 bg-warning rounded p-2 m-2">
                    <h3 class="fs-5">Review for Nosferatu by movieguy - 5/5 <i class="fa-solid fa-web-awesome"></i></h3>
                    <p>This movie knocked my socks off!</p> # Note movie reviews should have a character limit.
                </div>
            </div>
            -->
        </div>
        <?php makeFooter(); ?>
    </div>
    </body>
</html>