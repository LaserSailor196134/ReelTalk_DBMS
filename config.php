<?php
//creates a connection to the database
define("HOST", "Localhost");
define("USER", "movieguy");
// password should be put in an environment variable instead of hardcoded
define("PASSWORD", "lovemovies"); 
define("DATABASE", "moviedb");

$movies = new mysqli(HOST, USER, PASSWORD, DATABASE);
//idiom
if ($movies === false) {
    die("ERROR: Could not connect. " . $movies->connect_error);
}
?>
