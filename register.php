<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Page</title>
  <style>
    /* CSS code here */

    body {
      background: #384047;
      font-family: sans-serif;
      font-size: 16px;
      margin: 0;
      padding: 0;
    }

    .register {
      background: #fff;
      padding: 4em;
      max-width: 400px;
      margin: 50px auto 0;
      box-shadow: 0 0 1em #222;
      border-radius: 4px;
    }

    h1 {
      margin: 0 0 20px;
      padding: 10px;
      text-align: center;
      font-size: 30px;
      color: #555;
      border-bottom: 1px solid #555;
    }

    form {
      margin-top: 20px;
    }

    label {
      display: block;
      margin-bottom: 10px;
      font-weight: bold;
      color: #333;
    }

    input[type="text"],
    input[type="password"],
    input[type="email"],
    textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 16px;
    }

    input[type="submit"] {
      background-color: #007BFF;
      color: #fff;
      padding: 10px 15px;
      border: none;
      border-radius: 4px;
      font-size: 16px;
      cursor: pointer;
    }

    
    textarea {
      height: 100px;
      resize: none; 
    }

    input[type="text"]:focus,
    input[type="password"]:focus,
    input[type="email"]:focus,
    textarea:focus {
      border-color: #007BFF;
      box-shadow: 0 0 5px #007BFF;
    }

    div a {
      color: #007BFF;
      text-decoration: none;
    }

    div a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="register">
    <?php
    if (isset($_POST["submit"])){
      $username = $_POST['username'];
      $email = $_POST['email'];
      $password = $_POST['password'];
      $repeatpassword = $_POST['repeatpassword'];
      $address = $_POST['address'];

      $errors = array();

      if (empty($username) || empty($email) || empty($password) || empty($repeatpassword) || empty($address)) {
        array_push($errors, "Required all fields 233");
       }
       if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Invalid email");
       }
       if (strlen($password) < 9) {
        array_push($errors, "Password must be at least 9 characters long");
       }
       if ($password !== $repeatpassword) {
        array_push($errors, "Password does not match");
       }
       if (empty($address)) {
        array_push($errors, "Address is required");
       }

       if (count($errors) > 0) {
         foreach ($errors as $error) {
           echo "<div class='alert alert-danger'>$error</div>";
         }
       } else {
          $passwordHash = password_hash($password, PASSWORD_DEFAULT);

         

          $sql = "INSERT INTO users (username, email, password, address) VALUES (?, ?, ?, ?)";
          $stmt = mysqli_stmt_init($conn);
          

          if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $passwordHash, $address);
            mysqli_stmt_execute($stmt);
            echo "<div class='alert alert-success'> Registered successfully.</div>";
          } else {
            echo "Error: " . mysqli_error($conn);
          }

          mysqli_close($conn);
        } 
    }
    ?> 
    <h1>User Register</h1>
       
    <form action="register.php" method="post">
      <label for="username">Username:</label>
      <input type="text" name="username" id="username" required>

      <label for="email">Email:</label>
      <input type="email" name="email" id="email" required>

      <label for="password">Password:</label>
      <input type="password" name="password" id="password" required>

      <label for="repeatpassword">Repeat Password:</label>
      <input type="password" name="repeatpassword" id="repeatpassword" required>
    
      <label for="address">Address:</label>
      <textarea rows="5" cols="50" name="address" id="address"></textarea>

      <input type="submit" name="submit" value="Register">
    </form>

    <div>
        <div><p>Already Registered <a href="login.php">Login Here</a></p></div>
    </div>
  </div>
</body>
</html>
