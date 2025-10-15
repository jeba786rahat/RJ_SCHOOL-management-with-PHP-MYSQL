<?php
session_start();

// Allow only logged-in admins
if (!isset($_SESSION['username']) || $_SESSION['usertype'] != 'admin') {
    header("Location: login.php"); 
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <?php

include'admin_css.php';

    ?>

</head>
<body>
            
           <?php
include 'admin_sidebar.php';
           ?>
    <div class="content">
        <h1>Admin Dashboard</h1>
        <p>In this example, we have added an accordion and a dropdown menu inside the side navigation.

Click on both to understand how they differ from each other. The accordion will push down the content, while the dropdown lays over the content.</p>
<input type="text" name="">
    </div>
</body>
</html>
