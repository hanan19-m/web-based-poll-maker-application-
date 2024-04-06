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
    <title>Log in</title>
</head>
<body>
    <div class="container">
        <div class="box form1">
        <header>Log in</header>
            <form action="config.php" method="post">
                
                <div class="field ">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" required>
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password"  required>
                </div>

                <div class="Submit">
                    <input type="submit" class="btn" name="submit" value="Log in" required> 
                    
                </div>
                <br>
                <div class="register">
                    Don't have an account? <a href="register.php">Register Now</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>