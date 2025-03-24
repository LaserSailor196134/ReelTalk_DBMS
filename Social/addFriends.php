<?php 
include "checkloggedin.php";
if(isLoggedIn()) {
    include "../headfoot.php";
    makeHeader();
} else {
    header("Location: ../home.php");
}
?>