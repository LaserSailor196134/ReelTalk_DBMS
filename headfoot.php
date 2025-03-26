<!-- headfoot.php
 This file contains functions that echo reusable portions of HTML.
 Utilities here include drop-down menus for accounts and the website logo.
 The makeAccBtn() call has an include_once for checkloggedin.php.
-->

<?php
// This function echos the HTML/Bootstrap necessary to produce the account button.
// The functionality of this button is dependent on whether the user is logged_in.
// $root_rel provides the location of the root relative to the current folder.
function makeAccBtn($root_rel = './') {
    include_once ($root_rel . "accounts/checkloggedin.php");
    if(isLoggedIn()) {
        echo '
        <div class="dropdown">
            <button class="btn btn-warning dropdown-toggle" type="button" id="accDrop" data-bs-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fa-solid fa-user"></i> ' . ($_SESSION["username"]) . '
            </button>
            <div class="dropdown-menu" aria-labelledby="accDrop">
                <a class="dropdown-item" href="' . $root_rel . 'social/profile.php?username=' . urlencode($_SESSION['username']) . '">Profile</a>
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
function makeBookmark($idb, $user, $film, $date, $status = 'Want to Watch', $desc = 'Plan to Watch!', $rating = 'Unrated', $root_rel = './') {
    include_once ($root_rel . "accounts/checkloggedin.php");
    $idd = $user . $film_id; // IDs for the description and inbox box.
    $rating = strval($rating);

    if(strcmp($rating, 'Unrated') != 0) {
        $rating = 'Rated ' . $rating . ' <i class="fa-solid fa-web-awesome"></i>';
    }
    
    // Keep in mind we can modify the styling as needed;
    echo '
        <div class="col-5 bg-dark text-light rounded p-3 m-2">
            <h3 class="fs-5 text-warning">' . $film . ' Bookmark</h3>
            <p>' . $status . ' - '. $user . ' (' . $date . ')</p>
            <p>' . $desc . '</p><br>
            <p class="text-warning">' . $rating . '</p>
    ';
    
    if(isLoggedIn()) {
        if(strcmp($user, $_SESSION['username']) == 0) {
            echo '
            <div class="dropdown">
                <button class="btn btn-warning dropdown-toggle" type="button" id="' . $idd . '" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    Edit <i class="fa-solid fa-square-pen"></i>
                </button>
                <form class="dropdown-menu drop-up p-3" aria-labelledby="' . $idd . '" style="min-width:30vw">
                    <div class="form-group">
                        <p>Rating:</p>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="' . $idd . 'rate1" value="option1">
                            <label class="form-check-label" for="' . $idd . 'rate1">1</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="' . $idd . 'rate2" value="option2">
                            <label class="form-check-label" for="' . $idd . 'rate2">2 </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="' . $idd . 'rate3" value="option3">
                            <label class="form-check-label" for="' . $idd . 'rate3">3 </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="' . $idd . 'rate4" value="option3">
                            <label class="form-check-label" for="' . $idd . 'rate4">4 </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="' . $idd . 'rate5" value="option3">
                            <label class="form-check-label" for="' . $idd . 'rate5">5 </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <br><label for="' . $idd . 'Input">Description:</label>
                        <input class="form-control" type="text" id="' . $idd . 'Input" name="' . $idd . 'Input" value="' . $desc . '"><br>
                    </div>
                    <button type="submit" class="btn btn-warning">Submit Changes</button>
                </form>
                <button class="btn btn-danger text-dark">Delete <i class="fa-solid fa-trash"></i></button>
            </div>
            ';
        } // We might be able to replace this whole edit dropdown with a contenteditable="true" attribute, we'll have to see.
    }

    echo '
        </div>
    ';
}
?>