<!-- loginpost.php
 This file handles form information posted by delete.php.
 If account details match a database entry, the account gets removed by the database.
 -->
<?php
include "../config.php";
include "./checkloggedin.php";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["uname"];
    $password = $_POST["password"];
    $checkusername = $movies -> prepare("SELECT password FROM account WHERE username = ?");
    $checkusername -> bind_param("s", $username);
    $checkusername -> execute();
    $checkusername -> store_result();
    if($checkusername -> num_rows == 0) {
        echo('<script>
            alert("Account does not exist");
            window.location.href = "delete.php";
            </script>');
        close($checkusername);
        close($movies);
        die();
        
    }
    $checkusername -> bind_result($storedpassword);
    $checkusername -> fetch();
    if(password_verify($password, $storedpassword)) { 
        //deletes bookmarks associated with the username
        $deleteBookmarks = $movies -> prepare('DELETE FROM bookmark
        WHERE ratingID IN (
        SELECT ratingID FROM CREATES WHERE username = ?)');
        $deleteBookmarks -> bind_param('s', $username);
        $deleteBookmarks -> execute();
        $deleteBookmarks -> close();
        //after the bookmarks deletes the account
        $deleteaccount = $movies -> prepare("DELETE FROM account WHERE username = ?");
        $deleteaccount -> bind_param("s", $username);
        $deleteaccount -> execute();
        if(isLoggedIn()) { // Destroys the session if the user is logged in with the account.
            session_destroy();
        }
        echo('<script>
            alert("Account deleted");
            window.location.href = "login.php";
            </script>');
        close($checkusername);
        close($deleteuser);
        close($deleteaccount);
        close($movies);
        die();
    } else {
        echo('<script>
            alert("Incorrect password");
            window.location.href = "delete.php";
            </script>');
        close($checkusername);
        close($movies);
    }
}
?>