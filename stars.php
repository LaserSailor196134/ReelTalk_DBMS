<!-- stars.php:
 This file is for searching the "cast/crew" portion of our database.
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
    </head>
    <body class="bg-secondary" style="font-family: Tahoma">
    <div id="top" class="container-fluid">
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
            <form method='GET' action='stars.php' class='d-flex justify-content-center py-5'>
                <input type='text' name='query' class='form-control' placeholder='Search people...' value='{$search_query}'>
                <button type='submit' class='btn btn-light ms-2'>Search</button>
            </form>
        ";

        makeHeader($my_bar);

        // Check if a search is requested.
        if (!empty($search_query)) {
            $api_url = "https://api.themoviedb.org/3/search/person?query=" . urlencode($search_query);
            
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
            $people = json_decode($response, true);

            // Check if people are found
            if (!empty($people['results'])) {
                echo "<div class='container'><div class='row'>";
                
                foreach ($people['results'] as $person) {
                    $name = $person['name'];
                    $poster = $person['profile_path'] 
                        ? "https://image.tmdb.org/t/p/w500" . $person['profile_path'] 
                        : ""; // Placeholder if poster issue. Needs to be added.
                    $biography = !empty($person['biography']) ? substr($person['biography'], 0, 100) . "..." : "No description available.";
                    $person_id = !empty($person['id']) ? $person['id'] : "Error ID not found."; 

                    echo "
                    <div class='col-md-3 mb-4'>
                        <div class='card'>
                            <img src='{$poster}' class='card-img-top' alt='{$name}'>
                            <div class='card-body'>
                                <form method='POST' action='stars.php'>
                                    <input type='hidden' name='person_id' value='{$person_id}'>
                                    <button type='submit' class='card-title'>{$name}</button>
                                </form>
                                <p class='card-text'>{$biography}</p>
                            </div>
                        </div>
                    </div>";
                }
                echo "</div></div>";
            } else {
                echo "<p class='text-center'>No people found for '<strong>{$search_query}</strong>'.</p>"; //If nothing found.
            }
        }

        //Reads button click and pushes to db.
        if (isset($_POST['person_id'])) {
            $person_id = $_POST['person_id'];
            
            $api_url = "https://api.themoviedb.org/3/person/{$person_id}?api_key={$api_key}&language=en-US";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer $api_key"]);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //Same situation should be truncated for security at some point.
            $response = curl_exec($ch);
            curl_close($ch);

            $person_details = json_decode($response, true);

            if (!empty($person_details)) {
                // Get people details
                $name = $person_details['name'];
                $biography = !empty($person_details['biography']) ? substr($person_details['biography'], 0, 300) : "No description available."; //Had to cap this to avoid hitting issues with db setup.
        
                // Check if person already in db.
                $stmt = $conn->prepare("SELECT actorID FROM castcrew WHERE actorID = ?");
                $stmt->bind_param("i", $person_id);
                $stmt->execute();
                $stmt->store_result();
        
                //Insert data.
                if ($stmt->num_rows == 0) {
                    //Cast table.
                    $stmt_insert_castCrew = $conn->prepare("INSERT INTO castcrew (actorID, name, biography) VALUES (?, ?, ?)");
                    $stmt_insert_castCrew->bind_param("iss", $person_id, $name, $biography);
                    $stmt_insert_castCrew->execute();
                }
                
                echo "<p>Person added.</p>";
            } else {
                echo "<p>No details found for ID: {$person_id}</p>";
            }
        }

        $conn->close();
        ?>
    </div>
    </body>
</html>
