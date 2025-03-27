<!-- castcrew.php:
 This file is for displaying the pages of queried actorIDs.
-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ReelTalk | Stars</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://kit.fontawesome.com/63ff890171.js" crossorigin="anonymous"></script>
        <style>
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
            <input type="text" class="form-control" placeholder="Search cast/crew...">
        ';
        makeHeader($my_bar);
        ?>
        <!-- actorID name biography -->
        <!-- List of films/TV -->
        <?php $actor_id = $_POST['person_id'];
        include "config.php";
        $getActorInfo = $movies -> prepare('SELECT name, biography FROM castCrew
        WHERE actorID = ?');
        $getActorInfo -> bind_param('i', $actor_id);
        $getActorInfo -> execute();
        $getActorInfo -> bind_result($name, $bio);
        $getActorInfo -> fetch();
        echo('
        <div class="container bg-dark rounded mb-5">
            <div class="row justify-content-center pt-5 mt-5">
                <div class="col-4 text-center">
                    <h1 class="fs-2 bg-warning rounded p-2">' . $name . '</h1>
                    <p class="text-secondary">[Photo Placeholder]</p> <!-- Remove if photos unavailable -->
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-8 rounded-top body-col px-3">
                    <h2 class="text-center fs-4 pt-3">Biography</h2>
                    <p>' . $bio . '
                    </p>');
                    ?>
                </div>
            </div>
            <div class="row justify-content-center pb-5">
                <div class="col-8 body-col rounded-bottom">
                    <h2 class="fs-4 py-3 text-center">Filmography</h2>
                    <table class="table table-striped table-warning">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Role</th>
                                <th>Media Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <!-- These could be links to Star pages in the actual implementation(?) -->
                                <td>Loonie Toons</td>
                                <td>Director</td>
                                <td>TV Show</td>
                            </tr>
                            <tr>
                                <td>A Complete Unknown</td>
                                <td>Actor</td>
                                <td>Film</td>
                            </tr>
                            <tr>
                                <td>Wonka</td>
                                <td>Actor/Producer</td>
                                <td>Film</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php makeFooter(); ?>
    </div>
    </body>
</html>