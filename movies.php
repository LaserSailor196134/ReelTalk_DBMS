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
            .card {
                background-color: #FFF3CD;
            }
        </style>
    </head>
    <body class="bg-secondary" style="font-family: Tahoma">
    <div id="top" class="container-fluid">
        <!-- Search form that records query. -->
        <?php
        include 'headfoot.php';
        $api_key = "eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJlN2RlMmE4YWYxYmRmMzdiY2NhNDI2Y2ZjNTQ4MWFkMyIsIm5iZiI6MTczODg3OTc3Ni41MzksInN1YiI6IjY3YTUzMzIwNTA4OGI5NDU5NzJmZTBhNyIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.PhOMmKjQYwxCiCfCrD0pFIhNpwC3nB5S1tIxRy3qkS4"; // Replace with your actual TMDB API key

        //Link with db.
        $conn = new mysqli("localhost", "root", "", "moviedb"); //These should prob be variables for server, username, password and db respectively but whatevs.
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

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
                        : ""; // Placeholder if poster issue. Needs to be added.
                    $release_date = !empty($movie['release_date']) ? $movie['release_date'] : "N/A";
                    $overview = !empty($movie['overview']) ? substr($movie['overview'], 0, 100) . "..." : "No description available.";
                    $movie_id = !empty($movie['id']) ? $movie['id'] : "Error ID not found."; 

                    echo "
                    <div class='col-md-3 mb-4'>
                        <div class='card'>
                            <img src='{$poster}' class='card-img-top' alt='{$title}'>
                            <div class='card-body'>
                                <form method='POST' action='movies.php'>
                                    <input type='hidden' name='movie_id' value='{$movie_id}'>
                                    <button type='submit' class='card-title'>{$title}</button>
                                </form>
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

        //Reads button click and pushes to db.
        if (isset($_POST['movie_id'])) {
            $movie_id = $_POST['movie_id'];
            
            $api_url = "https://api.themoviedb.org/3/movie/{$movie_id}?api_key={$api_key}&language=en-US";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer $api_key"]);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //Same situation should be truncated for security at some point.
            $response = curl_exec($ch);
            curl_close($ch);

            $movie_details = json_decode($response, true);

            if (!empty($movie_details)) {
                // Get movie details, bunch of extra stuff in case we want it.
                $title = $movie_details['title'];
                $poster_path = !empty($movie_details['poster_path']) ? "https://image.tmdb.org/t/p/w500" . $movie_details['poster_path'] : "";
                $release_date = !empty($movie_details['release_date']) ? $movie_details['release_date'] : "N/A";
                $overview = !empty($movie_details['overview']) ? substr($movie_details['overview'], 0, 300) : "No description available."; //Had to cap this to avoid hitting issues with db setup.
                $mpa_rating = !empty($movie_details['mpaa_rating']) ? $movie_details['mpaa_rating'] : "N/A";
                $rating = !empty($movie_details['vote_average']) ? $movie_details['vote_average'] : "N/A";
                $runtime = !empty($movie_details['runtime']) ? $movie_details['runtime'] : "N/A";
        
                // Check if movie already in db.
                $stmt = $conn->prepare("SELECT mediaID FROM media WHERE mediaID = ?");
                $stmt->bind_param("i", $movie_id);
                $stmt->execute();
                $stmt->store_result();
        
                //Insert data.
                if ($stmt->num_rows == 0) {
                    //Media table.
                    $stmt_insert_media = $conn->prepare("INSERT INTO media (mediaID, name, description, MPARating) VALUES (?, ?, ?, ?)");
                    $stmt_insert_media->bind_param("isss", $movie_id, $title, $overview, $mpa_rating);
                    $stmt_insert_media->execute();
                    
                    //Movie Table.
                    $stmt_movie = $conn->prepare("INSERT INTO movie (mediaID, length) VALUES (?, ?)");
                    $stmt_movie->bind_param("ii", $movie_id, $runtime);
                    $stmt_movie->execute();
                }
        
                //Cast/crew stuff NOTICE ---- I don't think this works rn have to keep working on it.
                if (!empty($movie_details['cast']) && is_array($movie_details['cast'])) {
                    foreach ($movie_details['cast'] as $cast_member) {
                        $actor_name = $cast_member['name']; 
            
                        // Check if cast already in db.
                        $stmt_cast = $conn->prepare("SELECT actorID FROM castCrew WHERE name = ?");
                        $stmt_cast->bind_param("s", $actor_name);
                        $stmt_cast->execute();
                        $stmt_cast->store_result();
            
                        //Insert data
                        if ($stmt_cast->num_rows == 0) {
                            $stmt_insert_cast = $conn->prepare("INSERT INTO castCrew (actorID, name, biography) VALUES (NULL, ?, ?)");
                            $stmt_insert_cast->bind_param("ss", $actor_name, $cast_member['biography']);
                            $stmt_insert_cast->execute();
                            $actor_id = $stmt_insert_cast->insert_id;
                        } else {
                            $stmt_cast->bind_result($actor_id);
                            $stmt_cast->fetch();
                        }
            
                        //Contributed link stuff.
                        $stmt_contributed = $conn->prepare("INSERT INTO CONTRIBUTED (mediaID, actorID, role) VALUES (?, ?, ?)");
                        $stmt_contributed->bind_param("iis", $movie_id, $actor_id, $cast_member['role']);
                        $stmt_contributed->execute();
                    }
                }
                
                //Post click screen
                echo "
                    <div class='container bg-dark rounded mb-5'>
                        <!-- Film title -->
                        <div class='row justify-content-center py-5 mt-5'>
                            <div class='col-6 bg-warning rounded text-center'>
                                <!-- Main film information -->
                                <h1 class='fs-2 pt-2'>{$title}</h1>
                                <img src='{$poster_path}' class='card-img-top' alt='{$title}'>
                                <p class='text-secondary'>#{$movie_id}</p>
                            </div>
                        </div>
                        <div class='row justify-content-center pb-5'>
                            <!-- Film information -->
                            <div class='col-5 bg-warning rounded mx-2'>
                                <p class='pt-2'>Rating: {$mpa_rating}</p>
                                <p>Runtime: {$runtime}</p>
                                <p>Release date: {$release_date}</p>
                                <p>{$overview}</p>
                                <p>{$rating} /10</p>
                                <!-- Bookmarks still need to be done -->
                                <a href='' class='btn btn-light p-1 my-2'>Add Bookmark</a> 
                                <a href='' class='btn btn-light p-1 my-2 ms-2'>See Bookmarks</a>
                            </div>
                            <!-- Cast/Crew -->
                            <div class='col-5 scrollable_table'>
                                <table class='table table-striped table-warning'>
                                    <thead class=''>
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
                                            <td>Albus Dumbledore.</td>
                                            <td>Professor</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>";
            } else {
                echo "<p>No movie details found for ID: {$movie_id}</p>";
            }
        }
        ?>

        <!-- <h5 class='card-title'>{$title}</h5> Deprecated code-->
        <!-- mediaID (invisible) name description MPARating length/episode count -->
        <!-- Example layout. Convert to function later, with relevant  -->
        
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
        $conn->close();

        makeFooter();
        ?>
    </div>
    </body>
</html>
