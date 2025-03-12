<?php
define("HOST", "Localhost");
define("USER", "movieguy");
// password should be put in a JSON instead of hardcoded
define("PASSWORD", "lovemovies"); 
define("DATABASE", "moviedb");

$movies = new mysqli(HOST, USER, PASSWORD, DATABASE);
//idiom
if ($movies === false) {
    die("ERROR: Could not connect. " . $movies->connect_error);
}
?>