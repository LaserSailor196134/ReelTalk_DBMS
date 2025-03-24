<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <title>Reeltalk | Home</title>
    <!--need a css file and bootstrap or smt-->
    <header>
        <a href="">first part of header</a><br>
        <a href="">second part of header</a><br>
        <a href="">third part of header</a><br>
        <a href="">fourth part of header</a><br>
    </header>
    <br><br>
    <?php
    include "checkloggedin.php";
    if(isLoggedIn()) {
        echo('welcome, ' . $_SESSION["username"] . "<br>");
        echo('<a href="logout.php">logout</a>');
    } else {
        echo('<script>
        alert("please login first");
        window.location.assign("loginPage.php");
        </script>');    
    }
    ?>
</html>