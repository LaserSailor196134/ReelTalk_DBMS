<!-- profile.php
 Page for displaying user profiles based on a submitted query's table parse.
-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ReelTalk | User Profile</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://kit.fontawesome.com/63ff890171.js" crossorigin="anonymous"></script>
        <style>
            .scrollable-table {
                max-height: 400px;
                display: inline-block;
                overflow: auto;
            }
        </style>
    </head>
    <body class="bg-secondary" style="font-family: Tahoma">
    <div id="top" class="container-fluid">
        <?php
        //loads the profile for a person
        include "../accounts/checkloggedin.php";
        include "../headfoot.php";
        include "../config.php";

        makeHeader('<br>', '../');
        
        //load user's user info
        $user = urldecode($_GET['username']);
        $loadProfile = $movies -> prepare('SELECT username, joinDate FROM account WHERE username = ?');
        $loadProfile -> bind_param('s', $user);
        $loadProfile -> execute();
        $loadProfile -> bind_result($username, $joinDate);
        $loadProfile -> fetch();
        echo "
        <div class=\"row justify-content-center pt-5 m-1\">
            <div class=\"col-4 bg-dark rounded p-3\">
                <h2 class=\"fs-2 text-white\">Profile for $username</h2>
                <p class=\"fs-5 text-secondary\">Joined on $joinDate</p>
            </div>
        ";
        $loadProfile -> close();

        // Find following and follower count.
        $findFollowing = $movies -> prepare('SELECT COUNT(username1) FROM FRIENDS_WITH WHERE username1 = ?');
        $findFollowing -> bind_param('s', $username);
        $findFollowing -> execute();
        $findFollowing -> bind_result($followingCount);
        $findFollowing -> fetch();
        $findFollowing -> close();
        
        $findFollowedBy = $movies -> prepare('SELECT COUNT(username1) FROM FRIENDS_WITH WHERE username2 = ?');
        $findFollowedBy -> bind_param('s', $username);
        $findFollowedBy -> execute();
        $findFollowedBy -> bind_result($followedCount);
        $findFollowedBy -> fetch();
        $findFollowedBy -> close();
        
        echo "
            <div class=\"col-2 bg-dark rounded p-3 ms-3\">
                <p class=\"text-white\">Following $followingCount <br>Followed by $followedCount</p>
        ";
        
        // Adding follow/unfollow button to profiles.
        if(isLoggedIn() &&  $_SESSION['username'] != $user) {
            $viewer = $_SESSION['username']; // $viewer is the current page viewer. Useful for echo. 
            $checkFriend = $movies -> prepare('SELECT * FROM FRIENDS_WITH WHERE username1 = ? AND username2 = ?');
            $checkFriend -> bind_param('ss', $viewer, $user);
            $checkFriend -> execute();
            $checkFriend -> store_result();
            if($checkFriend -> num_rows == 0) {
                echo "
                <form name=\"addFriend\" method=\"POST\" action=\"addFriend.php\">
                    <input type=\"hidden\" name=\"username\" value=\"$user\">
                    <input class=\"btn btn-warning py-2 px-4\" type=\"submit\" value=\"Follow\">
                </form>
                ";
            } else { // Might want to double check this works.
                echo "
                <form name=\"removeFollower\" method=\"POST\" action=\"removeFollower.php\">
                    <input type=\"hidden\" name=\"user\" value=\"$viewer\">
                    <input type=\"hidden\" name=\"follower\" value=\"$user\">
                    <input class=\"btn btn-warning p-2 px-4\" type=\"submit\" value=\"Unfollow\">
                </form>
                ";
            }
        }
        echo '
            </div>
        </div>
        ';

        // Fetch for the user biography goes here!
        echo "
        <div class=\"row justify-content-center\">
            <div class=\"col-6 bg-dark rounded-top p-3 mt-2\">
                <p class=\"text-white\">Description:<br>
                Greetings! I love movies! This is a placeholder biography in case we implement the feature.</p>
            </div>
        </div>
        ";

        // Generate list for following.
        echo "
        <div class=\"row justify-content-center\">
            <div class=\"col-6 bg-dark rounded-bottom\">
                <div class=\"scrollable-table\">
                    <table class=\"table table-striped table-dark\" style=\"width: 20vw\">
                        <thead>
                            <tr><th>Following List</th></tr>
                        </thead>
                        <tbody>
        ";

        $generateFollowing = $movies -> prepare('SELECT username2 FROM FRIENDS_WITH WHERE username1 = ?');
        $generateFollowing -> bind_param('s', $username);
        $generateFollowing -> execute();
        $generateFollowing -> store_result();
        if($generateFollowing -> num_rows == 0) {
            echo "<tr><td> - None Followed - </td></tr>";
        } else {
            $generateFollowing -> bind_result($followedUser);
            while($generateFollowing -> fetch()) {
                echo "<tr><td> $followedUser </td></tr>";
                // Allows profiles to unfollow if needed.
                if(isLoggedIn() && $_SESSION['username'] == $user) {
                    echo("
                    <form name=\"removeFollower\" method=\"POST\" action=\"removeFollower.php\">
                        <input type=\"hidden\" name=\"user\" value=\"$user\">
                        <input type=\"hidden\" name=\"follower\" value=\"$followedUser\">
                        <input class=\"btn btn-warning p-2 mt-4\" type=\"submit\" value=\"Unfollow\">
                    </form>");
                }
            }
        }
        $generateFollowing -> close();

        $generateFollowers = $movies -> prepare('SELECT username1 FROM FRIENDS_WITH WHERE username2 = ?');
        $generateFollowers -> bind_param('s', $username);
        $generateFollowers -> execute();
        $generateFollowers -> store_result();
        echo "
                        </tbody>
                    </table>
                </div>
                <div class=\"scrollable-table\">
                    <table class=\"table table-striped table-dark\" style=\"width: 20vw\">
                        <thead>
                            <tr><th>Follower List</th></tr>
                        </thead>
                        <tbody>
        ";
        if($generateFollowers -> num_rows == 0) {
            echo "<tr><td> - No Followers - </td></tr>";
        } else {
            $generateFollowers -> bind_result($followingUser);
            while($generateFollowers -> fetch()) {
                echo "<tr><td> $followingUser </td></tr>";
            }
        }
        $generateFollowers -> close();

        echo "
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        ";

        //this loads all of the users's bookmarks, add 
        $loadBookmarks = $movies -> prepare('SELECT media.mediaID, bookmark.watchStatus, bookmark.numberRating, bookmark.description, bookmark.dateCreated, media.name FROM CREATES
        JOIN bookmark ON CREATES.ratingID = bookmark.ratingID
        JOIN ABOUT ON bookmark.ratingID = ABOUT.ratingID
        JOIN media ON ABOUT.mediaID = media.mediaID
        WHERE CREATES.username = ?'); //get information for every bookmark related to a specified username
        $loadBookmarks -> bind_param('s', $_SESSION['username']);
        $loadBookmarks -> execute();
        $loadBookmarks -> store_result();
        echo "
        <div class=\"row justify-content-center mt-3\">
            <div class=\"col-4 bg-warning rounded p-3 my-3\">
                <h2 class=\"fs-3 text-center\">Bookmarks</h2>
            </div>
        </div>
        <div class=\"row justify-content-center align-items-center\" style=\"min-height: 20vh\">
        ";
        if($loadBookmarks -> num_rows > 0) {
            $loadBookmarks -> bind_result($ratingID, $watchStatus, $numberRating, $description, $dateCreated, $movie);
            while($loadBookmarks -> fetch()) {
                makeBookmark($ratingID, $user, $movie, $dateCreated, $watchStatus, $description, $numberRating, '../');
            }
        } else {
            // makeBookmark($user, 'Nosferatu', '2025', root_rel : '../');
            echo "
                <div class=\"col-2 text-center\">
                    <p class=\"bg-dark rounded text-white p-2\">No Bookmarks in sight</p>
                </div>
            ";
        }
        echo '</div>';
        makeFooter();
        ?>
        </div>
    </div>
    </body>
</html>