<?php
include "config.php";

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
            window.location.href = "delete.html";
            </script>');
        
    }
    if($checkusername -> fetch_row()[0] == hash("sha256", $password)) {
        $deleteuser = $movies -> prepare("DELETE FROM dbuser WHERE username = ?");
        $deleteuser -> bind_param("s", $username);
        $deleteuser -> execute();
        $deleteaccount = $movies -> prepare("DELETE FROM account WHERE username = ?");
        $deleteaccount -> bind_param("s", $username);
        $deleteaccount -> execute();
        echo('<script>
            alert("Account deleted");
            window.location.href = "login.html";
            </script>');
        close($checkusername);
        close($deleteuser);
        close($deleteaccount);
        close($movies);
        die();
    } else {
        echo('<script>
            alert("Incorrect password");
            window.location.href = "delete.html";');
        close($checkusername);
        close($movies);
    }
}
?>