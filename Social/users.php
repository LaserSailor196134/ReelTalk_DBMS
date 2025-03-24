<!-- users.php:
 This file is for searching the "users" portion of our database.
-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ReelTalk | Users</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://kit.fontawesome.com/63ff890171.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-secondary" style="font-family: Tahoma">
    <div id="top" class="container-fluid">
        <?php
        include '../headfoot.php';
        // This placeholder is for the search bar to lookup
        $my_bar = '
            <form method = "POST" action = "SearchForUsers.php">
            <h1>Search for Users</h1><input type="string" name="usersearch" id="usersearch">
            <button id="searchbutton">Search</button>
            </form>
        ';
        makeHeader($my_bar,"../");
        ?>
    </div>
    </body>
</html>