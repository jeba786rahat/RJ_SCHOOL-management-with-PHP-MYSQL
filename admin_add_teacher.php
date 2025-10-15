<?php
session_start();

// Allow only logged-in admins
if (!isset($_SESSION['username']) || $_SESSION['usertype'] != 'admin') {
    header("Location: login.php"); 
    exit();
}

$host = "localhost";
$user = "root";
$password = "";
$db = "schoolproject";

$data = mysqli_connect($host, $user, $password, $db);

if (isset($_POST['add_teacher'])) {
    $t_name = $_POST['name'];
    $t_description = $_POST['description'];

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $file = $_FILES['image']['name'];
        $dst = "./image/" . time() . "_" . $file;   // unique file name
        $dst_db = "image/" . time() . "_" . $file;

        move_uploaded_file($_FILES['image']['tmp_name'], $dst);

        $sql = "INSERT INTO teacher (name, description, image) 
                VALUES ('$t_name', '$t_description', '$dst_db')";
        $result = mysqli_query($data, $sql);

        if ($result) {
            echo "<script>alert('Teacher Added Successfully');</script>";
        } else {
            echo "<script>alert('Failed to Add Teacher');</script>";
        }
    } else {
        echo "<script>alert('Please select an image');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style type="text/css">
       .div_deg {
        background-color: skyblue;
        padding: 30px;
        width: 500px;
        border-radius: 8px;
       }
    </style>
    <?php include 'admin_css.php'; ?>
</head>
<body>
    <?php include 'admin_sidebar.php'; ?>

    <div class="content">
        <center>
        <h1>Add Teacher</h1><br><br>
        <div class="div_deg">
            <form action="#" method="POST" enctype="multipart/form-data">
                <div>
                    <label>Teacher Name :</label>
                    <input type="text" name="name" required>
                </div><br>
                <div>
                    <label>Description :</label>
                    <textarea name="description" required></textarea>
                </div><br>
                <div>
                    <label>Image :</label>
                    <input type="file" name="image" required>
                </div><br>
                <div>
                    <input type="submit" name="add_teacher" value="Add Teacher" class="btn btn-primary">
                </div>
            </form>
        </div>
        </center>
    </div>
</body>
</html>
