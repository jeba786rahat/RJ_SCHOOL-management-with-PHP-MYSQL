<?php
error_reporting(0);
session_start();

// ✅ Show message before clearing session
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    echo "<script>alert('$message');</script>";
    unset($_SESSION['message']); 
}

$host = "localhost";
$user = "root";
$password = "";
$db = "schoolproject";

$data = mysqli_connect($host, $user, $password, $db);

if (!$data) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM teacher";
$result = mysqli_query($data, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Management System</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

  <link rel="stylesheet" type="text/css" href="style.css">
  <style>
      body { font-family: Arial, sans-serif; }

          .main_img { width: 100%; max-height: 400px; object-fit: cover; }
          .img-text { font-size: 22px; font-weight: bold; margin-top: 10px; }
          .welcome-img { width: 100%; border-radius: 5px; }

      .admission_form { max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; }
      .adm_int { margin-bottom: 15px; }
      .label_text { display: block; font-weight: bold; margin-bottom: 5px; }
      .input_deg, .input_txt { width: 100%; padding: 8px; border: 1px solid #aaa; border-radius: 5px; }
  </style>
</head>
<body>

<nav>
  <label class="logo">RJ-School</label>
  <ul>
      <li><a href="#">Home</a></li>
      <li><a href="#">Contact</a></li>
      <li><a href="#">Admission</a></li>
      <li><a href="login.php" class="btn btn-success">Login</a></li>
  </ul>
</nav>

<div class="selection1">
  <img class="main_img" src="school.png" alt="School">
  <div class="img-text">We teach students with care</div>
</div>

<div class="container">
  <div class="row">
      <div class="col-md-4">
          <img class="welcome-img" src="playground.jpg" alt="Playground">
      </div>
      <div class="col-md-8">
          <h1>Welcome to RJ_School</h1>
          <p>
              We warmly welcome you to our school — a place where knowledge, discipline, 
              and values come together to shape the future of every learner. 
              Our institution is more than just a center of education; 
              it is a community that nurtures curiosity, creativity, and character. 🌱Here, learning is not just about books — it is about building confidence, responsibility, and a strong foundation for life. 🌱To be a leading institution in providing quality education and fostering holistic development of students, empowering them to become responsible global citizens.
          </p>
      </div>
  </div>
</div>

<center><h1>Our Facilities</h1></center>
<div class="container">
  <div class="row">
      <?php while($info = $result->fetch_assoc()) { ?>
          <div class="col-md-4 text-center">
              <img src="<?php echo $info['image']; ?>" alt="Teacher" class="img-responsive center-block" style="max-height:200px;">
              <h3><?php echo $info['name']; ?></h3>
              <h5><?php echo $info['description']; ?></h5>
          </div>
      <?php } ?>
  </div>
</div>

<center><h1>Our Courses</h1></center>
<div class="container">
  <div class="row text-center">
      <div class="col-md-4"><img src="web_development.png" alt="Web" class="img-responsive center-block"><h3>Web Development</h3></div>
      <div class="col-md-4"><img src="graphic_design.png" alt="Design" class="img-responsive center-block"><h3>Graphic Design</h3></div>
      <div class="col-md-4"><img src="digital_marketing.png" alt="Marketing" class="img-responsive center-block"><h3>Digital Marketing</h3></div>
  </div>
</div>

<center><h1 class="adm">Admission Form</h1></center>
<div class="admission_form">
  <form action="data_check.php" method="POST">
      <div class="adm_int">
          <label class="label_text">Name</label>
          <input class="input_deg" type="text" name="name" required>
      </div>
      <div class="adm_int">
          <label class="label_text">Email</label>
          <input class="input_deg" type="email" name="email" required>
      </div>
      <div class="adm_int">
          <label class="label_text">Phone</label>
          <input class="input_deg" type="text" name="phone" required>
      </div>
      <div class="adm_int">
          <label class="label_text">Message</label>
          <textarea class="input_txt" name="message"></textarea>
      </div>
      <div>
          <input class="btn btn-primary" type="submit" value="Apply" name="apply">
      </div>
  </form>
</div>

<footer>
  <h2>All © copyright reserved by RJ-School 2025</h2>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
