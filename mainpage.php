<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Main Page</title>
    <link rel="stylesheet" href="mainpageStyle.css" />
    <link rel="icon" href="Logo.png" />
</head>
<body>
    <?php
    $usid="0";
    if(isset($_SESSION['usid'])){
    $usid = $_SESSION['usid'];
    }
    

    try {
        require('connection.php');
        $sql = "SELECT * FROM users WHERE uid = :usid";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':usid', $usid);
        $stmt->execute();

        if ($row = $stmt->fetch()) {
            $name = $row['name'];
            echo "<a href='home.php'>
            <div class='message'>
                  <button>Welcome to the main page, $name!</button>
                  </div><br>";
        } else {
            echo "User not found.";
        }

        $db = null;
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
    ?>
</body>
</html>