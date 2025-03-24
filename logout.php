<?php
session_start();
session_destroy();
echo('<script>
    alert("Logged out successfully");
    window.location.assign("loginpage.php");
    </script>');
    die();
?>