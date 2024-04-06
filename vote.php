<?php
session_start();
?>
<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vote</title>
    <link rel="stylesheet" href="vote20.css" />
    <link rel="icon" href="Logo.png" />
</head>
<body>
    <?php
  
    try {

        //if user submit poll vote and sellect an option
        if(isset($_POST['op'])){
        require('connection.php');
        $poll = $_POST['pid'];
        $option = $_POST['op'];
        $uid = "0";
        if(isset($_SESSION['usid'])){
           $uid = $_SESSION['usid'];}
        date_default_timezone_set("Asia/Bahrain");
        $date = date("l j \of F Y h:i:s A");

        //insert vote details in the vote table
        $stmt = $db->prepare("INSERT INTO vote (uid, pid, opid, date_time) VALUES (:uid, :pid, :opid, :date)");
        $stmt->bindParam(':uid', $uid);
        $stmt->bindParam(':pid', $poll );
        $stmt->bindParam(':opid', $option);
        $stmt->bindParam(':date', $date);
        $stmt->execute();

        //display thanks statement
        echo "<div class=container>";
        $sql = "select * from users where uid=$uid";
        $rs = $db->query($sql);
        if ($r = $rs->fetch()) {
        $name = $r[1];
        echo "<form method='post' action='pollresults.php'><h1>THANKS FOR VOTING</h1>";
        echo "<h1>$name</h1>";
        echo "<p>$date</p>";

        //user can go to home page or view results
        echo "<input type='hidden' name='pid' value='$poll'/>\n";
        echo "<div class=buttonsub><button type='submit' class=butt>View results</button>";
        echo "\t<a href='Home.php' class=butt>Go to home page</a></div>\n</form>\n";
        }
    }

        //if user submit poll vote and did not sellect an option
        else
            echo "<p class=please><a href=pollvote.php?pid={$_POST['pid']}>Please sellect an option<a></p>";

    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
    echo "</div>";
    $db = null;
    ?>
</body>
</html>

