<!-- accountbtn.php
 This file contains functions that echo reusable portions of HTML.
 Utilities here include drop-down menus for accounts and the website logo.
 The makeAccBtn() call has an include_once for checkloggedin.php.
-->
<?php
// This function echos the HTML/Bootstrap necessary to produce the account button.
// The functionality of this button is dependent on whether the user is logged_in.
function makeAccBtn($root_rel = './') {
    include_once "accounts/checkloggedin.php";
    if(isLoggedIn()) {
        echo '
        <div class="dropdown">
            <button class="btn btn-warning dropdown-toggle" type="button" id="accDrop" data-bs-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fa-solid fa-user"></i> ' . ($_SESSION["username"]) . '
            </button>
            <div class="dropdown-menu" aria-labelledby="accDrop">
                <a class="dropdown-item" href="' . $root_rel . 'social/profile.php?username=' . urlencode($_SESSION['username']) . '">My Profile</a>
                <a class="dropdown-item" href="' . $root_rel . 'accounts/logout.php">Logout</a>
                <a class="dropdown-item text-danger" href="' . $root_rel . 'accounts/delete.php">Delete Account</a>
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
                <a class="dropdown-item" href="' . $root_rel . 'accounts/login.php">Login</a>
                <a class="dropdown-item" href="' . $root_rel . 'accounts/register.php">Register</a>
            </div>
        </div>
        ';
    }
}

// This function makes an entire header, with the logo, account button, and an optional search bar between them.
// <br> is provided as a default parameter as it adds nothing but preserves proportions.
// Calls makeAccBtn(), which includes checkloggedin.php.
function makeHeader($search_bar = '<br>', $root_rel = './') {
    echo '
    <header class="row bg-dark py-1 px-3 justify-content-center align-items-center">
        <div class="bg-warning rounded text-center col-2 p-2">
            <a href="' . $root_rel . 'home.php" class="link-body-emphasis link-underline-opacity-0 fs-4">ReelTalk</a> <!-- Insert logo here -->
        </div>
        <div class="col-4 mx-auto">
    ';

    echo $search_bar; // Places the user-inputted search bar. Make sure to add your php-relevant variables here.
    echo '
        </div>
        <div class="text-end col-2 p-3">
    ';

    makeAccBtn($root_rel);
    echo '
        </div>
    </header>
    ';
}

// Function used to construct footers on our frontend.
// BUG: Supposed to tell user who they're signed in as, got error <<Ignoring session_start() because a session is already active>>
function makeFooter() {
    //include_once 'checkloggedin.php';
    
    echo '
    <footer class="row text-center bg-dark py-3">
        <p class="text-light">
    ';
    
    /*
    if(isLoggedIn()) {
        echo 'Signed in as ' . $_SESSION["username"] . 'br';
    }
    */
    
    echo '
        ReelTalk &copy; Acadia University 2025<br>
        All rights to films presented belong to their respective owners.<br><br>
        <a class="btn btn-warning" href="#top">Back to Top</a></p>
    </footer>
    '; // We might have to remove the top button later depending how we implement searches.
}

// Function used to construct bookmarks for a variety of pages.
// Felt it was better to place here instead of another page for include reasons.
function makeBookmark($user, $film, $date, $description = 'Plan to Watch!', $rating = 'Watchlisted') {
    $rating = strval($rating);
    if(strcmp($rating, 'Watchlisted') != 0) {
        $rating = 'Rated ' . $rating . ' <i class="fa-solid fa-web-awesome"></i>';
    }
    
    // Keep in mind we can modify the styling as needed;
    echo '
        <div class="col-5 bg-dark text-white rounded p-3 m-2">
            <h3 class="fs-5 text-warning">' . $film . ' Bookmark</h3>
            <p class="text-warning">' . $rating . ' by '. $user . ' (' . $date . ')</p>
            <p>' . $description . '</p>
    ';
    
    if(isLoggedIn()) {
        if(strcmp($user, $_SESSION['username']) == 0) {
            echo '
            <button class="btn btn-warning">Edit <i class="fa-solid fa-square-pen"></i></button>
            <button class="btn btn-danger text-dark">Delete <i class="fa-solid fa-trash"></i></button>
            ';
        }
    }
    echo '
        </div>
    ';
}
?>