<!-- users.php:
 This file is for searching the "users" portion of our database.
-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ReelTalk | User Search</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://kit.fontawesome.com/63ff890171.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-secondary" style="font-family: Tahoma">
    <div id="top" class="container-fluid">
        <?php
        include '../config.php';
        include '../headfoot.php';
        include '../accounts/checkloggedin.php';
        $loggedIn = isLoggedIn();

        // Implements mechanism for reading searchterms (as posts are sent to the URL, this also creates addressable queries for sharing).
        $searchterm = isset($_GET['usersearch']) ? $_GET['usersearch'] : ""; // Soley to ensure we don't try to parse usersearch when it doesn't exist.
        $my_bar = '
        <form method="GET" action = "users.php" class="d-flex">
            <input class="form-control" type="string" name="usersearch" id="usersearch" placeholder="Search for users..." value="' . $searchterm . '">
            <input type="submit" class="btn btn-warning mx-2" id="searchbutton" value="Search">
        </form>
        ';
        makeHeader("$my_bar", '../');
        
        $searchterm = '%' . $searchterm . '%';
        $findUsers = $movies -> prepare("SELECT username, joinDate FROM account WHERE username LIKE ?");
        $findUsers -> bind_param('s',$searchterm);
        $findUsers -> execute();
        $findUsers -> store_result();
        if($findUsers -> num_rows > 0 && strlen($searchterm) > 2) { // Checks to see if we should print results.
            $findUsers -> bind_result($username,$joinDate);
            $height = "min-height: 20vh;";

            echo'
            <div class="row justify-content-center mt-4">
                <div class="col-4 bg-warning rounded text-center py-3 my-3">
                    <h1 class="fs-2">Results for Users</h1>
                </div>
            </div>
            <div class="row justify-content-center mb-4">
            ';

            while($findUsers -> fetch()){ //while get next result returns values
                $encoded = urlencode($username);
                echo "
                <div class=\"col-3 bg-dark rounded text-white p-3 m-3\" style=\"min-height: 30vh;\">
                    <h2 class=\"fs-4\">$username</h2>
                    <p class=\"text-secondary\">Joined: $joinDate</p>
                    <form class=\"pe-2\" name=\"profile\" method=\"GET\" action=\"profile.php\" style=\"float: left\">
                        <input type=\"hidden\" name=\"username\" value=\"$encoded\">
                        <input class=\"btn btn-warning p-2 mt-4\" type=\"submit\" value=\"View Profile\">
                    </form>
                ";
                if($loggedIn && $_SESSION['username'] != $username) {//option to follow them if you are logged in, cannot follow yourself 
                    $user = $_SESSION['username'];
                    //check if the user is already being followed
                    $checkFriend = $movies -> prepare('SELECT * FROM FRIENDS_WITH WHERE username1 = ? AND username2 = ?');
                    $checkFriend -> bind_param('ss', $_SESSION['username'], $username);
                    $checkFriend -> execute();
                    $checkFriend -> store_result();
                    if($checkFriend -> num_rows == 0) {
                        echo("
                        <form name=\"addFriend\" method=\"POST\" action=\"addFriend.php\">
                            <input type=\"hidden\" name=\"username\" value=\"$username\">
                            <input class=\"btn btn-warning p-2 mt-4\" type=\"submit\" value=\"Follow\">
                        </form>");
                    } else {
                        echo("<form name=\"removeFollower\" method=\"POST\" action=\"removeFollower.php\">
                            <input type=\"hidden\" name=\"user\" value=\"$user\">
                            <input type=\"hidden\" name=\"follower\" value=\"$username\">
                            <input class=\"btn btn-warning p-2 mt-4\" type=\"submit\" value=\"Unfollow\">
                        </form>");
                    }
                }
                echo '</div>';
            }
            echo '</div>';
        } else {
            $height = "min-height: 75vh;";
        }
        // This is almost solely for footer spacing.
        echo "
        <div class=\"row justify-content-center align-items-center\" style=\" $height \">
            <div class=\"col-2 text-center\">
                <p class=\"bg-dark rounded text-white p-2\">Nothing else but us chickens</p>
            </div>
        </div>
        ";
        makeFooter();
        ?>
    </div>
    </body>
</html>