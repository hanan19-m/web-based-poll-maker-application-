<?php

session_start();

if(isset($_POST['submit'])){
try {
    require('connection.php');
    $user = $_POST['email'];
    $sql = "SELECT * FROM users WHERE email=:user";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':user', $user);
    $stmt->execute();
    $row = $stmt->fetch();
    $db = null;
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

$usid = "0";
if ($row) {
    $hashedPassword = $row['password'];
    if (password_verify($_POST['password'], $hashedPassword)) {
        $usid = $row['uid'];
        $_SESSION['usid']=$usid;
        $_SESSION['email']=$user;
        header("Location: mainpage.php");
        exit();
    } else {
        echo "Wrong password, please try again!";
    }
} else {
    echo "Invalid email";
}}

?>

