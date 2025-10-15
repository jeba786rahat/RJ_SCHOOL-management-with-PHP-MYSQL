<?php
session_start();

// Allow only logged-in admins
if (!isset($_SESSION['username']) || $_SESSION['usertype'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Initialize courses in session
if (!isset($_SESSION['courses'])) {
    $_SESSION['courses'] = [
        [
            "id" => 1,
            "name" => "Mathematics",
            "description" => "Basic to advanced math concepts",
            "duration" => "6 Months",
            "image" => "image/OIP.webp"
        ],
        [
            "id" => 2,
            "name" => "Physics",
            "description" => "Mechanics, Thermodynamics, Optics",
            "duration" => "4 Months",
            "image" => "image/physics.jpg"
        ],
        [
            "id" => 3,
            "name" => "Graphic Design",
            "description" => "Design principles, Photoshop, Illustrator, and UI/UX basics",
            "duration" => "5 Months",
            "image" => "graphic_design.png"
        ],
        [
            "id" => 4,
            "name" => "Computer Science",
            "description" => "Programming and Databases",
            "duration" => "8 Months",
            "image" => "web_development.png"
        ]
    ];
}

$courses = &$_SESSION['courses'];

// Handle update
$update_id = $_GET['update_id'] ?? null;
$current_course = null;

if ($update_id) {
    foreach ($courses as &$course) {
        if ($course['id'] == $update_id) {
            $current_course = &$course;
            break;
        }
    }
    if (isset($_POST['update_course']) && $current_course) {
        $current_course['name'] = $_POST['name'];
        $current_course['description'] = $_POST['description'];
        $current_course['duration'] = $_POST['duration'];

        // Handle image update
        if (!empty($_FILES['image']['name'])) {
            $file = $_FILES['image']['name'];
            $unique = time() . "_" . $file;
            $dst = "./image/" . $unique;
            move_uploaded_file($_FILES['image']['tmp_name'], $dst);
            $current_course['image'] = $dst;
        }

        header("Location: courses.php");
        exit();
    }
}

// Handle delete
$delete_id = $_GET['delete_id'] ?? null;
if ($delete_id) {
    foreach ($courses as $key => $course) {
        if ($course['id'] == $delete_id) {
            unset($courses[$key]);
            $_SESSION['courses'] = array_values($courses); // reindex
            header("Location: courses.php");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Courses Management</title>
    <?php include 'admin_css.php'; ?>
    <style>
        .table_th { padding: 15px; font-size: 18px; background: #ddd; }
        .table_td { padding: 15px; background: #f9f0dc; text-align: center; }
        .form_box { width: 500px; margin: 20px auto; padding: 20px; background: #f2e9d8; border-radius: 8px; }
        .form_box input, .form_box textarea { width: 100%; margin-top: 8px; }
        .btn { padding: 5px 10px; text-decoration: none; border-radius: 5px; }
        .btn-success { background-color: #28a745; color: white; }
        .btn-danger { background-color: #dc3545; color: white; }
    </style>
</head>
<body>
<?php include 'admin_sidebar.php'; ?>

<div class="content">
    <center>
        <h1>Courses Management</h1>

        <!-- Update Form -->
        <?php if ($current_course) { ?>
        <div class="form_box">
            <h2>Update Course</h2>
            <form action="?update_id=<?php echo $current_course['id']; ?>" method="POST" enctype="multipart/form-data">
                <label>Course Name</label><br>
                <input type="text" name="name" value="<?php echo $current_course['name']; ?>" required><br><br>

                <label>Description</label><br>
                <textarea name="description" rows="4" required><?php echo $current_course['description']; ?></textarea><br><br>

                <label>Duration</label><br>
                <input type="text" name="duration" value="<?php echo $current_course['duration']; ?>" required><br><br>

                <label>Current Image</label><br>
                <?php if ($current_course['image']) { ?>
                    <img src="<?php echo $current_course['image']; ?>" height="100" width="100"><br><br>
                <?php } ?>

                <label>Change Image</label><br>
                <input type="file" name="image"><br><br>

                <button type="submit" name="update_course" class="btn btn-success">Update Course</button>
            </form>
        </div>
        <?php } ?>

        <!-- Courses Table -->
        <table border="1">
            <tr>
                <th class="table_th">Course Name</th>
                <th class="table_th">Description</th>
                <th class="table_th">Duration</th>
                <th class="table_th">Image</th>
                <th class="table_th">Action</th>
            </tr>
            <?php foreach ($courses as $course) { ?>
            <tr>
                <td class="table_td"><?php echo $course['name']; ?></td>
                <td class="table_td"><?php echo $course['description']; ?></td>
                <td class="table_td"><?php echo $course['duration']; ?></td>
                <td class="table_td">
                    <?php if ($course['image']) { ?>
                        <img src="<?php echo $course['image']; ?>" height="100" width="100">
                    <?php } else { echo "No Image"; } ?>
                </td>
                <td class="table_td">
                    <a class="btn btn-success" href="?update_id=<?php echo $course['id']; ?>">Update</a>
                    <a class="btn btn-danger" onclick="return confirm('Are you sure?')" href="?delete_id=<?php echo $course['id']; ?>">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </center>
</div>
</body>
</html>
