<?php
session_start();

// Only allow logged-in students
if (!isset($_SESSION['username']) || $_SESSION['usertype'] != 'student') {
    header("Location: login.php");
    exit();
}

// Initialize all courses (static data)
if (!isset($_SESSION['courses'])) {
    $_SESSION['courses'] = [
        ["id"=>1,"name"=>"Mathematics","description"=>"Basic to advanced math concepts","duration"=>"6 Months","image"=>"image/OIP.webp"],
        ["id"=>2,"name"=>"Physics","description"=>"Mechanics, Thermodynamics, Optics","duration"=>"4 Months","image"=>"image/physics.jpg"],
        ["id"=>3,"name"=>"Graphic Design","description"=>"Design principles, Photoshop, Illustrator, and UI/UX basics","duration"=>"5 Months","image"=>"graphic_design.png"],
        ["id"=>4,"name"=>"Computer Science","description"=>"Programming and Databases","duration"=>"8 Months","image"=>"web_development.png"]
    ];
}

// Simulate student enrolled courses (array of course IDs)
if (!isset($_SESSION['enrolled_courses'])) {
    // Example: student is enrolled in Graphic Design and Computer Science
    $_SESSION['enrolled_courses'] = [3,4];
}

$enrolled_ids = $_SESSION['enrolled_courses'];
$all_courses = $_SESSION['courses'];

// Filter only the courses this student is enrolled in
$my_courses = array_filter($all_courses, function($course) use ($enrolled_ids) {
    return in_array($course['id'], $enrolled_ids);
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Courses</title>
<?php include 'student_css.php'; ?>
<style>
    body { background-color: #f0f4f8; font-family: 'Segoe UI', sans-serif; }
    .content { max-width: 1000px; margin: 20px auto; padding: 10px; }
    .course-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        padding: 20px;
        margin: 15px;
        display: inline-block;
        vertical-align: top;
        width: 220px;
        text-align: center;
    }
    .course-card img { width: 100%; height: 130px; object-fit: cover; border-radius: 8px; }
    .course-card h3 { margin: 10px 0 5px 0; color: #333; }
    .course-card p { font-size: 14px; color: #555; }
    .course-card span { font-weight: bold; color: #007bff; }
</style>
</head>
<body>
<?php include 'student_sidebar.php'; ?>

<div class="content">
    <h1>My Courses</h1>
    <?php if(!empty($my_courses)): ?>
        <?php foreach($my_courses as $course): ?>
            <div class="course-card">
                <?php if(!empty($course['image'])): ?>
                    <img src="<?php echo $course['image']; ?>" alt="<?php echo $course['name']; ?>">
                <?php else: ?>
                    <img src="image/default_course.png" alt="No Image">
                <?php endif; ?>
                <h3><?php echo $course['name']; ?></h3>
                <p><?php echo $course['description']; ?></p>
                <span><?php echo $course['duration']; ?></span>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>You are not enrolled in any courses yet.</p>
    <?php endif; ?>
</div>
</body>
</html>
