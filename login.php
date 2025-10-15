<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

  <style>
    body {
        display: flex;
        justify-content: center;
      align-items: center;
      min-height: 100vh;
      background:"playgroun.jpg";
      background-repeat:no-repeat;
      background-attachment: fixed;
      background-size: 100% 100%;
    }
    .form_deg {
      background: rgba(0,0,0,0.8);
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 400px;
    }
    .label_deg {
      display: inline-block;
      width: 100px;
      text-align: right;
      margin-right: 10px;
      background: linear-gradient(90deg, #ff00cc, #3333ff);
      -webkit-background-clip: text;

      -webkit-text-fill-color: transparent;    }
    h2.text-center {
  background: linear-gradient(90deg, #ff00cc, #3333ff);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

    
  </style>
</head>
<body background="playground.jpg">

  <div class="form_deg">
    <h2 class="text-center" >Login  Form
      <h4 ><?php
       error_reporting(0);
       session_start();
       session_destroy();
      echo $_SESSION['loginnMessage'];
      ?></h4>
    </h2>
    <form action="login_check.php" method="POST" class="login_form">
      <div class="form-group">
        <label class="label_deg">Username:</label>
        <input type="text" name="username" class="form-control" required>
      </div>

      <div class="form-group">
        <label class="label_deg">Password:</label>
        <input type="password" name="password" class="form-control" required>
      </div>

      <div class="text-center">
        <input type="submit" class="btn btn-primary" name="submit" value="Login">
      </div>
    </form>
  </div>

  <!-- jQuery (required before Bootstrap JS) -->
  <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
