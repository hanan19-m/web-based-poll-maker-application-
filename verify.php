<?php
session_start();

try {
    require('connection.php');

    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $nameexp = "/^[a-zA-Z\s]+$/";
    $emailexp = "/^[^\s@]+@[^\s@]+\.[^\s@]+$/";
    $passwordexp = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/";

    if (!preg_match($nameexp, $name)) {
        echo "Please enter a valid name.";
        return;
    }

    if (!preg_match($emailexp, $email)) {
        echo "Please enter a valid email address.";
        return;
    }

    if (!preg_match($passwordexp, $password)) {
        echo "Please enter a valid password (at least 8 characters, one lowercase letter, one uppercase letter, and one digit).";
        return;
    }

    // Hashing the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Inserting the user's data into the MySQL database
    $stmt = $db->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->execute();

    echo "<div class='message' style='text-align: center; font-size: 24px; margin-bottom: 10px; margin-top: 50px; color: rgb(58, 50, 136);'>
    <h1>You've Successfully Registered!</h1>
</div> <br>";

    echo "<a href='login.php'><button class='btn' 
style='height: 35px; 
background: rgba(115, 17, 124, 0.808);
border-radius: 5px; 
color: #fff; font-size: 15px; 
text-align: center;
align-items: center;

margin: 0 auto;
display: flex;
padding: 10px 10px; 
'>You can Login Now</button></a>";

    $db = null;

} catch (PDOException $ex) {
    echo "Error occurred!";
}

?>