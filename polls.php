<?php
session_start();
?>
<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Polls</title>
    <link rel="stylesheet" href="pollsStyle.css" />
    <link rel="icon" href="Logo.png" />
</head>
<body >
    <?php
    $usid="0";
    
    if(isset($_SESSION['usid'])){
    $usid = $_SESSION['usid'];
    }

try {
        echo "<div class=container>";

    //page header

         echo "<header>    <a href='home.php'><img src=Logo.png alt=Logo class=logo></a>
    <div class=name> Pollit </div>
    <nav>";

    //Check if the user is logged in

    require('connection.php');
    $sql = "SELECT name FROM users WHERE uid = :usid";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':usid', $usid);
        $stmt->execute();

    //If the user is logged in, display "Welcome username"
        if ($row = $stmt->fetch()) {
            $username = $row['name'];
            echo"<span class=mybutton>";
            echo "Welcome, $username!";
            echo "</span>";
            echo"<a href=logout.php class=mybutton> Logout </a>";
        } 
        
   //If the user is not logged in, user can login or signup

        else {
            echo"<a href=login.php class=mybutton> Log in </a>";
            echo"<a href=Register.php class=mybutton> Sign up </a>";
        }
        
        echo"</nav></header>";


        echo "<h1>Select the poll that is most interesting to you !</h1><hr>";
        echo "<p style=padding-left:43%; padding-right:43%;>Open-polls</p><hr>";

   //display the oppen polls

    $sql = "select * from poll where statues='Open'";
    $rs = $db->query($sql);
        $count = 0;

      //If the expiration date has been passed, the poll will be closed
        foreach ($rs as $r) {
            if($r[4]=="date"){
                 $exp_date=$r[5];
                 $today_date=date('Y/m/d');
                 $exp=strtotime($exp_date);
                 $td=strtotime($today_date);

                if($td>$exp){

                   $sql1 = "update poll set statues='Close' where end_date='$exp_date'";
                    $rs1 = $db->query($sql1);
                }
                 
            }

            echo "<div class= thepoll>";
            echo "<div class= image> <img src=vote3.png alt=image/></div>";

            //display poll title
            echo "<div class=title><a href='pollvote.php?pid={$r[0]}'>{$r[2]}</a></div>";
            echo "</div>";
            global $count;
            $count +=1;
        }

            //if there are no oppen polls display sorry message
        if ($count == 0)
            echo "<p>Sorry, there are no open polls...</p>";


   //display the closed polls

        echo "<hr style=margin-top:10%;><p style=padding-left:43%;>Closed-polls</p><hr>";
        $sql = "select * from poll where statues='Close'";
        $rs = $db->query($sql);
        foreach ($rs as $r) {

            echo "<div class= thepoll>";
            echo "<div class= image> <img src=vote3.png alt=image/></div>";

            //display poll title
            echo "<div class=title><a href='pollresults.php?pid={$r[0]}'>{$r[2]}</a></div>";
            echo "</div>";
        }
        echo "</div>";
        $db = null;
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
    ?>
</body>
</html>

