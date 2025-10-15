<?php
session_start();
error_reporting(0);

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

$id = $_GET['teacher_id'];
$sql = "SELECT * FROM teacher WHERE id='$id'";
$result = mysqli_query($data, $sql);
$info = mysqli_fetch_assoc($result);

if (isset($_POST['update_teacher'])) {
    $name = $_POST['name'];
    $desc = $_POST['description'];

    // If image uploaded
    if ($_FILES['image']['name'] != "") {
        $image = $_FILES['image']['name'];
        $dst = "./image/" . $image;
        $dst_db = "image/" . $image;
        move_uploaded_file($_FILES['image']['tmp_name'], $dst);

        $sql2 = "UPDATE teacher SET name='$name', description='$desc', image='$dst_db' WHERE id='$id'";
    } else {
        $sql2 = "UPDATE teacher SET name='$name', description='$desc' WHERE id='$id'";
    }

    $result2 = mysqli_query($data, $sql2);

    if ($result2) {
        header("Location: admin_view_teacher.php");
        exit();
    } else {
        echo "<script>alert('Update failed. Try again!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Teacher</title>
    <?php include 'admin_css.php'; ?>
    <style>
        .form_box {
            width: 50%;
            margin: 50px auto;
            padding: 30px;
            border: 1px solid #ccc;
            background: #f9f9f9;
            border-radius: 10px;
        }
        .form_box input, .form_box textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }
        .form_box button {
            padding: 10px 20px;
        }
    </style>
</head>
<body>
    <?php include 'admin_sidebar.php'; ?>
    <div class="content">
        <center>
            <h1>Update Teacher Info</h1>
            <div class="form_box">
                <form action="" method="POST" enctype="multipart/form-data">
                    <label>Teacher Name</label>
                    <input type="text" name="name" value="<?php echo $info['name']; ?>" required>

                    <label>About Teacher</label>
                    <textarea name="description" rows="5" required><?php echo $info['description']; ?></textarea>

                    <label>Current Image</label><br>
                    <img src="<?php echo $info['image']; ?>" height="100px" width="100px"><br><br>

                    <label>Change Image</label>
                    <input type="file" name="image">

                    <button type="submit" name="update_teacher" class="btn btn-success">Update</button>
                </form>
            </div>
        </center>
    </div>
</body>
</html>
