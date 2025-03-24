<!-- regpost.php
 This file handles form information posted by register.php.
 After valid account details are entered, an entry for the user is created within the dbuser table.
 If account details match a database entry, the account will not be created.
 -->
<?php
include "../config.php";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    //getting username and password from the form
    $username = $_POST['uname'];
    $password = $_POST['password'];
    //checking if the username already exists
    $checkusername = $movies -> prepare('SELECT username FROM account WHERE username = ?');
    $checkusername -> bind_param('s', $username);
    $checkusername -> execute();
    $checkusername -> store_result();
    if($checkusername -> num_rows > 0) { //if the username already exists
        echo('<script>
            alert("username already exists");
            window.location.href = "register.php";
        </script>');
        close($checkusername);
        close($movies);
        die();
    } else {
        //register account first
        $registeraccount = $movies -> prepare ('INSERT INTO account (username, password) VALUES (?, ?)');
        $registeraccount -> bind_param('ss', $username, password_hash($password, PASSWORD_BCRYPT));
        $registeraccount -> execute();
        header('Location: login.php');
        close($checkusername);
        close($registeraccount);
        close($movies);
        die();
    }
}
?>