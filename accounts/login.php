<!-- login.php
 This file represents the page for users to login. 
 Data entered into the form by the user is processed by loginpost.php.
 -->
<?php 
include 'checkloggedin.php';
if(isLoggedIn()) {
    header("Location: ../home.php");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Reeltalk | Login</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://kit.fontawesome.com/63ff890171.js" crossorigin="anonymous"></script>
        <script>
            function validateForm() {
                var password = document.forms["login"]["password"].value;
                if(password.length < 8) {
                    alert("password must be at least 8 characters long");
                    return false;
                }
                return true;
            }
        </script>
    </head>
    <body class="bg-secondary" style="font-family: Tahoma">
    <div class="container-fluid">
        <?php
        include '../headfoot.php';
        makeHeader('<br>', '../');
        ?>
        <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
            <div class="text-light rounded bg-dark col-6 p-3">
                <h2 class="text-warning fs-3 pt-2 px-2">Login to ReelTalk</h2>
                <a href="register.php" class="link-info link-underline-opacity-0 link-underline-opacity-100-hover fs-6 px-2">Don't have an account?</a>
                <form name="login" method="POST" action="loginpost.php" onsubmit="return validateForm()">
                    <label class="p-2 sr-only" for="uname">Username</label>
                    <input class="form-control p-2 my-4" type="text" id="uname" name="uname" placeholder="Username" autofocus required>
                    <label class="p-2 sr-only" for="password">Password</label>
                    <input class="form-control p-2 mt-4" type="password" id="password" name="password" placeholder="Password" required>
                    <input class="btn btn-warning p-2 mt-4" type="submit" value="Login with Account">
                </form>
            </div>
        </div>
    </div>
    </body>
</html>