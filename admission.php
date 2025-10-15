<?php
session_start();

// Allow only logged-in admins
if (!isset($_SESSION['username']) || $_SESSION['usertype'] != 'admin') {
    header("Location: login.php"); 
    exit();
}

$host = "localhost";
$user = "root";
$password = ""; // <-- added missing semicolon
$db = "schoolproject";

$data = mysqli_connect($host, $user, $password, $db);

if (!$data) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM admission";
$result = mysqli_query($data, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <?php include 'admin_css.php'; ?>
</head>
<body>
   <?php include 'admin_sidebar.php'; ?>

    <div class="content">
        <center>
        <h1>Applied for Admission</h1>
        <br><br>

        <table border="1px" cellspacing="0" cellpadding="10">
            <tr style="background:#f0f0f0;">
                <th style="padding:20px; font-size:15px;">Name</th>
                <th style="padding:20px; font-size:15px;">Email</th>
                <th style="padding:20px; font-size:15px;">Phone</th>
                <th style="padding:20px; font-size:15px;">Message</th>
            </tr>

            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($info = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td style='padding:20px;'>{$info['name']}</td>";
                    echo "<td style='padding:20px;'>{$info['email']}</td>";
                    echo "<td style='padding:20px;'>{$info['phone']}</td>";
                    echo "<td style='padding:20px;'>{$info['message']}</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4' style='text-align:center;'>No applications found</td></tr>";
            }
            ?>
        </table>
        </center>
    </div>
</body>
</html>
