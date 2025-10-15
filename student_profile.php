<?php
session_start();

// Allow only logged-in students
if (!isset($_SESSION['username']) || $_SESSION['usertype'] != 'student') {
    header("Location: login.php");
    exit();
}

// Database connection
$host = "localhost";
$user = "root";
$password = "";
$db = "schoolproject";

$conn = mysqli_connect($host, $user, $password, $db);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$username = $_SESSION['username'];

// Fetch student info
$sql = "SELECT * FROM user WHERE username='$username'";
$result = mysqli_query($conn, $sql);
$info = mysqli_fetch_assoc($result);

// Handle profile update
if (isset($_POST['update_profile'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); // Ideally, hash passwords

    $sql_update = "UPDATE user SET email='$email', phone='$phone', password='$password' WHERE username='$username'";
    if (mysqli_query($conn, $sql_update)) {
        echo "<script>alert('Profile updated successfully');</script>";
        header("Location: student_profile.php");
        exit();
    } else {
        echo "<script>alert('Error updating profile');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Profile</title>
<?php include 'student_css.php'; ?>
<style>
    body { font-family: 'Segoe UI', sans-serif; background-color: #f0f4f8; }
    .content { display: flex; justify-content: center; align-items: center; min-height: 90vh; }
    .card { background: #fff; padding: 40px 30px; border-radius: 12px; box-shadow: 0 6px 20px rgba(0,0,0,0.1); width: 450px; }
    h1 { text-align: center; margin-bottom: 30px; color: #333; }
    form div { margin-bottom: 20px; }
    label { display: block; font-weight: 600; margin-bottom: 5px; color: #555; }
    input[type="text"], input[type="email"], input[type="number"], input[type="password"] {
        width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px; font-size: 16px; transition: 0.3s;
    }
    input:focus { border-color: #007bff; box-shadow: 0 0 5px rgba(0,123,255,0.3); outline: none; }
    .btn-primary { background-color: #007bff; color: white; padding: 12px; border: none; border-radius: 8px; cursor: pointer; width: 100%; font-size: 16px; }
    .btn-primary:hover { background-color: #0056b3; }
</style>
</head>
<body>
<?php include 'student_sidebar.php'; ?>

<div class="content">
    <div class="card">
        <h1>My Profile</h1>
        <form method="POST" action="#">
            <div>
                <label>Email</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($info['email']); ?>" required>
            </div>
            <div>
                <label>Phone</label>
                <input type="number" name="phone" value="<?php echo htmlspecialchars($info['phone']); ?>" required>
            </div>
            <div>
                <label>Password</label>
                <input type="text" name="password" value="<?php echo htmlspecialchars($info['password']); ?>" required>
            </div>
            <div>
                <input type="submit" name="update_profile" value="Update" class="btn-primary">
            </div>
        </form>
    </div>
</div>
</body>
</html>
