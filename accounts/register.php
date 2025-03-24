<!-- register.php
 This file represents the page for registering user accounts. 
 Data entered into the form by the user is processed by regpost.php.
 -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Reeltalk | Account Registration</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://kit.fontawesome.com/63ff890171.js" crossorigin="anonymous"></script>
        <script>
            function validateForm() {
                var password = document.forms["register"]["uname"].value;
                var password = document.forms["register"]["password"].value;
                var repassword = document.forms["register"]["repassword"].value;
                if(password != repassword) {
                    alert("passwords do not match");
                    return false;
                }
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
                <h2 class="text-warning fs-3 pt-2 px-2">Register with ReelTalk</h2>
                <a href="login.php" class="link-info link-underline-opacity-0 link-underline-opacity-100-hover fs-6 px-2">Already have an account?</a>
                <form name="register" method="POST" action="regpost.php" onsubmit="return validateForm()">
                    <label class="p-2" for="uname">Username</label>
                    <input class="form-control p-2" type="text" id="uname" name="uname" placeholder="Username" autofocus required>
                    <label class="p-2" for="password">Password</label>
                    <input class="form-control p-2" type="password" id="password" name="password" placeholder="Password (8 characters min)" required>
                    <label class="p-2" for="repassword">Re-enter password</label>
                    <input class="form-control p-2" type="password" id="repassword" name="repassword" placeholder="Password (8 characters min)" required>
                    <input class="btn btn-warning p-2 mt-4" type="submit" value="Register Account">
                </form>
            </div>
        </div>
    </div>
    </body>
</html>