<!-- delete.php
 This file represents the page for deleting user accounts. 
 Data entered into the form by the user is processed by delpost.php.
 -->
 <?php 
include 'checkloggedin.php';
if(!isLoggedIn()) {
    header("Location: ../home.php");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Reeltalk | Account Deletion</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://kit.fontawesome.com/63ff890171.js" crossorigin="anonymous"></script>
        <script>
            function validateForm() {
                var password = document.forms["delete"]["password"].value;
                if (password.length < 8) {
                    alert("password must be at least 8 characters long");
                    return false;
                }
                return true;
            }
        </script>
    </head>
    <body class="bg-secondary" style="font-family: Tahoma">
    <div id="top" class="container-fluid">
        <?php
        include '../headfoot.php';
        makeHeader('<br>', '../');
        ?>
        <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
            <div class="text-light rounded bg-dark col-6 p-3">
                <h2 class="text-warning fs-3 pt-2 px-2">Leaving ReelTalk</h2>
                <form name="delete" method="POST" action="delpost.php" onsubmit="return validateForm()">
                    <label class="p-2" for="uname">Username for Account</label> <!-- Delete later -->
                    <input class="form-control p-2" type="text" id="uname" name="uname" placeholder="Username" autofocus required>
                    <label class="p-2" for="password">Password for Account</label>
                    <input class="form-control p-2" type="password" id="password" name="password" placeholder="Password" autofocus required>
                    <div class="form-check m-2">
                        <input class="form-check-input" type="checkbox" id="flexCheckDefault" required>
                        <label class="form-check-label" for="flexCheckDefault">
                            I understand all data associated with my account will be deleted
                        </label>
                    </div>
                    <input class="btn btn-danger text-dark p-2 mt-1" type="submit" value="Delete Account">
                </form>
            </div>
        </div>
        
    </div>
    </body>
</html>