<?php
session_start();
session_destroy();
echo('<script>
    alert("Logged out successfully");
    window.location.assign("login.html");
    </script>');
    die();
?>