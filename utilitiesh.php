<!-- accountbtn.php
 This file contains functions that echo reusable portions of HTML.
 Utilities here include drop-down menus for accounts and the website logo.
 The makeAccBtn() call has an include_once for checkloggedin.php.
-->
<?php
// This function echos the HTML/Bootstrap necessary to produce the account button.
// The functionality of this button is dependent on whether the user is logged_in.
function makeAccBtn() {
    include_once "checkloggedin.php";
    if(isLoggedIn()) {
        echo '
        <div class="dropdown">
            <button class="btn btn-warning dropdown-toggle" type="button" id="accDrop" data-bs-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fa-solid fa-user"></i> Account
            </button>
            <div class="dropdown-menu" aria-labelledby="accDrop">
                <a class="dropdown-item" href="">My Profile</a>
                <a class="dropdown-item" href="logout.php">Logout</a>
                <a class="dropdown-item text-danger" href="delete.html">Delete Account</a>
            </div>
        </div>
        ';
    } else {
        echo '
        <div class="dropdown">
            <button class="btn btn-warning dropdown-toggle" type="button" id="accDrop" data-bs-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fa-solid fa-user"></i> Account
            </button>
            <div class="dropdown-menu" aria-labelledby="accDrop">
                <a class="dropdown-item" href="login.html">Login</a>
                <a class="dropdown-item" href="register.html">Register</a>
            </div>
        </div>
        ';
    }
}

// This function makes an entire header, with the logo, account button, and an optional search bar between them.
// <br> is provided as a default parameter as it adds nothing but preserves proportions.
// Calls makeAccBtn(), which includes checkloggedin.php.
function makeHeader($search_bar = '<br>') {
    echo '
    <header class="row bg-dark py-1 px-3 justify-content-center align-items-center">
        <div class="bg-warning rounded text-center col-2 p-2">
            <a href="home.php" class="link-body-emphasis link-underline-opacity-0 fs-4">ReelTalk</a> <!-- Insert logo here -->
        </div>
        <div class="col-3 mx-auto"
    ';

    echo $search_bar; // Places the user-inputted search bar. Make sure to add your php-relevant variables here.
    echo '
        </div>
        <div class="text-end col-2 p-3">
    ';

    makeAccBtn();
    echo '
        </div>
    </header>
    ';
}
?>