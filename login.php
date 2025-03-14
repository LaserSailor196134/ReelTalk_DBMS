<?php
include "config.php";

$username = $_POST["uname"];
$password = $_POST["password"];
$checkusername = $movies -> prepare("SELECT password FROM account WHERE username = ?");
$checkusername -> bind_param("s", $username);
$checkusername -> execute();
$checkusername -> store_result();
//account not found
if($checkusername -> num_rows == 0) {
    echo('<script>
        alert("Account does not exist");
        window.location.href = "login.html";
        </script>');
    close($checkusername);
    close($movies);
    die();
}
$checkusername -> bind_result($storedpassword);
$checkusername -> fetch();
//if account exists and password is correct
if(password_verify($password, $storedpassword)) {
    if(!session_start()) {
        echo('<script>
            alert("Session failed to start");
            window.location.href = "login.html";
            </script>');
        close($checkusername);
        close($movies);
        die();
    }
    $_SESSION["username"] = $username;
    echo('<script>
        alert("logged in successfully");
        window.location.href = "home.php";
        </script>');
    close($checkusername);
    close($movies);
    die();
//username found but wrong password
} else {
    echo('<script>
        alert("Incorrect password");
        window.location.assign("login.html");
        </script>');
    close($checkusername);
    close($movies);
    die();
}   
?>