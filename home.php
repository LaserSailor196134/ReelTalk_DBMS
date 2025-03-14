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
    echo("what the fuck");
    if(session_status() == PHP_SESSION_ACTIVE) {
        echo('welcome' . $_SESSION["username"]);
    } else {
        echo('<script>
        alert("please login first");
        window.location.assign("login.html");');    
    }
    ?>
</html>