<!-- logout.php
 This file contains a simple php script that ends the user session.
 -->
<?php
session_start();
session_destroy();
echo('<script>
    alert("Logged out successfully");
    window.location.assign("login.php");
    </script>');
    die();
?>