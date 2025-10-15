<?php
session_start();

// Only allow logged-in students
if (!isset($_SESSION['username']) || $_SESSION['usertype'] != 'student') {
    header("Location: login.php");
    exit();
}

// Sample static results stored in session
if (!isset($_SESSION['results'])) {
    // Each student can have an array of results
    $_SESSION['results'] = [
        'student1' => [
            ["subject"=>"Mathematics", "marks"=>95, "grade"=>"A+"],
            ["subject"=>"Physics", "marks"=>88, "grade"=>"A"],
            ["subject"=>"Graphic Design", "marks"=>92, "grade"=>"A+"],
            ["subject"=>"Computer Science", "marks"=>85, "grade"=>"A"]
        ],
        'student2' => [
            ["subject"=>"Mathematics", "marks"=>78, "grade"=>"B+"],
            ["subject"=>"Physics", "marks"=>82, "grade"=>"A-"],
            ["subject"=>"Graphic Design", "marks"=>90, "grade"=>"A+"],
            ["subject"=>"Computer Science", "marks"=>80, "grade"=>"A-"]
        ]
    ];
}

$student = $_SESSION['username'];
$my_results = $_SESSION['results'][$student] ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Result</title>
<?php include 'student_css.php'; ?>
<style>
    body { font-family: 'Segoe UI', sans-serif; background-color: #f0f4f8; }
    .content { max-width: 700px; margin: 30px auto; padding: 20px; }
    table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 8px; overflow: hidden; }
    th, td { padding: 12px; text-align: center; border-bottom: 1px solid #ddd; }
    th { background-color: #007bff; color: white; }
    tr:nth-child(even) { background-color: #f9f9f9; }
    tr:hover { background-color: #e0f0ff; }
    h1 { text-align: center; color: #333; margin-bottom: 30px; }
</style>
</head>
<body>
<?php include 'student_sidebar.php'; ?>

<div class="content">
    <h1>My Result</h1>
    <?php if(!empty($my_results)): ?>
        <table>
            <tr>
                <th>Subject</th>
                <th>Marks</th>
                <th>Grade</th>
            </tr>
            <?php foreach($my_results as $res): ?>
            <tr>
                <td><?php echo $res['subject']; ?></td>
                <td><?php echo $res['marks']; ?></td>
                <td><?php echo $res['grade']; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p style="text-align:center;">No results available yet.</p>
    <?php endif; ?>
</div>
</body>
</html>
