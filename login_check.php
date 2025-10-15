<?php
session_start();

$host = "localhost";
$user = "root";
$password = "";
$db = "schoolproject";

$data = mysqli_connect($host, $user, $password, $db);

if ($data === false) {
    die("Connection error: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($data, $_POST['username']);
    $pass = mysqli_real_escape_string($data, $_POST['password']);

    $sql = "SELECT * FROM user WHERE username='$name' AND password='$pass'";
    $result = mysqli_query($data, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Store session data
        $_SESSION['username'] = $row['username'];
        $_SESSION['usertype'] = $row['usertype'];

        if ($row["usertype"] == "student") 
        {
            $_SESSION['username']=$name;



            header("Location: studenthome.php");
            exit();
        } elseif ($row["usertype"] == "admin") 
        {
            $_SESSION['username']=$name;


            header("Location: adminhome.php");
            exit();
        }
    } else {
        session_start();

        $message= "❌ Username or password do not match";
        
        $_SESSION['loginnMessage']=$message;

        header("location:login.php");
    }
}
?>
