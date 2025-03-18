<?php
function isLoggedIn() {
    session_start();
    if(isset($_SESSION["username"])) {
        return true;
    } else {
        return false;
    }
}
?>