<!-- movies.php:
 This file is for searching the "movies" portion of our database.
-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ReelTalk | Movies</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://kit.fontawesome.com/63ff890171.js" crossorigin="anonymous"></script>
        <style>
            .scrollable_table {
                max-height: 400px;
                display: inline-block;
                overflow: auto;
            }
        </style>
    </head>
    <body class="bg-secondary" style="font-family: Tahoma">
    <div id="top" class="container-fluid">
        <!-- Search form that records query. -->
        <?php
        include 'headfoot.php';

        // properly interacts with url for Michael.
        $search_query = isset($_GET["query"]) ? htmlspecialchars($_GET["query"]) : "";

        // Search bar html.
        $my_bar = "
            <form method='GET' action='movies.php' class='d-flex justify-content-center py-5'>
                <input type='text' name='query' class='form-control' placeholder='Search movies...' value='{$search_query}'>
                <button type='submit' class='btn btn-light ms-2'>Search</button>
            </form>
        ";

        makeHeader($my_bar);

        // Check if a search is requested.
        if (!empty($search_query)) {
            $api_key = "API_TOKEN_GOES_HERE"; // Replace with API Bearer token.
            $api_url = "https://api.themoviedb.org/3/search/movie?query=" . urlencode($search_query);
            
            // cURL setup.
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Authorization: Bearer $api_key"
            ]);
            // This line disables ssl verification, security issue if launched but needed for testing.
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            // Execute request and decode JSON response.
            $response = curl_exec($ch);
            curl_close($ch);
            $movies = json_decode($response, true);

            // Check if movies are found
            if (!empty($movies['results'])) {
                echo "<div class='container'><div class='row'>";
                
                foreach ($movies['results'] as $movie) {
                    $title = $movie['title'];
                    $poster = $movie['poster_path'] 
                        ? "https://image.tmdb.org/t/p/w500" . $movie['poster_path'] 
                        : "https://via.placeholder.com/500x750?text=No+Image"; // Placeholder if poster issue.
                    $release_date = !empty($movie['release_date']) ? $movie['release_date'] : "N/A";
                    $overview = !empty($movie['overview']) ? substr($movie['overview'], 0, 100) . "..." : "No description available.";

                    echo "
                    <div class='col-md-3 mb-4'>
                        <div class='card'>
                            <img src='{$poster}' class='card-img-top' alt='{$title}'>
                            <div class='card-body'>
                                <h5 class='card-title'>{$title}</h5>
                                <p class='card-text'><small>Release Date: {$release_date}</small></p>
                                <p class='card-text'>{$overview}</p>
                            </div>
                        </div>
                    </div>";
                }
                echo "</div></div>";
            } else {
                echo "<p class='text-center'>No movies found for '<strong>{$search_query}</strong>'.</p>"; //If nothing found.
            }
        }

        ?>

        <!-- mediaID (invisible) name description MPARating length/episode count -->
        <!-- Example layout. Convert to function later, with relevant  -->
        <div class="container bg-dark rounded mb-5">
            <!-- Film title -->
            <div class="row justify-content-center py-5 mt-5">
                <div class="col-6 bg-warning rounded text-center">
                    <!-- Main film information -->
                    <h1 class="fs-2 pt-2">Nosferatu</h1>
                    <p class="text-secondary">[poster placeholder]</p>
                    <p class="text-secondary">#[ID]</p>
                </div>
            </div>
            <div class="row justify-content-center pb-5">
                <!-- Film information -->
                <div class="col-5 bg-warning rounded mx-2">
                    <p class="pt-2">MPA Rating: R-18</p>
                    <p>Length [Episode Count]: 2hr20min </p>
                    <p>Release Date: 2024-12-25</p>
                    <p>Description: Nosferatu is a gut-busting romp through the faraway land of
                    transylvania. Laughs and gaffs await the whole family in this
                    gravewarming adventure.</p>
                    <p>Review Score: 3.7 / 5</p>
                    <p>Availability: Amazon Prime, Netflix, Disney+</p>
                    <a href="" class="btn btn-light p-1 my-2">Add Bookmark</a>
                    <a href="" class="btn btn-light p-1 my-2 ms-2">See Bookmarks</a>
                </div>
                <!-- Cast/Crew -->
                <div class="col-5 scrollable_table">
                    <table class="table table-striped table-warning">
                        <thead class="">
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
        <?php
        makeFooter();
        ?>
    </div>
    </body>
</html>
