<!-- checkloggedin.php
 This file contains a simple helper function to check if the user is logged in.
-->
<?php
function isLoggedIn() {
    if(session_status() == 1) {
        session_start();
    }
    if(isset($_SESSION["username"])) {
        return true;
    } else {
        return false;
    }
}
?>