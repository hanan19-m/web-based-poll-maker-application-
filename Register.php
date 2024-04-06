<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style11.css">
    <link rel="icon" href="Logo.png" />
    <script src="script.js"></script>
    
    <title>Sign Up</title>
</head>
<body>
    <div class="container">

   
        <div class="box form1">
           <header>Register Here</header>
           <p> Kindly fill in this form to register</p>
           <form id="myForm" onsubmit="return checkEmailAvailability();" method="post" action="verify.php">
                <div class="field ">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" required>
                </div>
                <div class="field ">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
  <span id="email-availability"></span>
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" onkeyup="PasswordStrength()">
        <span id="password-strength"></span>
                </div>

                <div class="Submit">
                    <input type="submit" class="btn" name="submit" value="SignUp" required> 
                    
                </div>
                <br>
                <div class="Login">
                    Already have an account? <a href="login.php">Login Now</a>
                </div>
                </div>
                </div>
            </form>
      
</body>
</html>