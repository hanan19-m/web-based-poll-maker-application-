<?php
session_start();
?>
<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pollvote</title>
    <link rel="stylesheet" href="Spollresult.css" />
    <link rel="icon" href="Logo.png" />
</head>
<body>
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


        $endby = "0";
        $pid="0";
        if(isset($_GET['pid'])){
        $pid = $_GET['pid'];}
        if(isset($_POST['pid'])){
        $pid= $_POST['pid'];}
        $uid="0";
        if(isset($_SESSION['usid'])){
            $uid = $_SESSION['usid'];
        }


        //if the poll creator click on "end the poll"
        if(isset($_GET['endby'])){
            $endby = $_GET['endby'];
            if($endby=="manually"){
            $sql0 = "select * from poll where pid=$pid";
            $rs0 = $db->query($sql0);
            if($r0 = $rs0->fetch()){
               //update the poll statues from open to close
                $update="update poll set statues='close' where pid=$pid";
                $rsup = $db->query($update);
                echo "<label style=color:red;>The poll has been closed</label><br/>";
                echo"<br/><a href='Home.php' style=color:white;>Go to home page</a>";
            }
        }}


        //display the poll results
            $sql = "select * from poll where pid=$pid";
            $rs = $db->query($sql);
        
        
            echo "<form method='post' action='pollvote.php'>\n";
            //Question
            if ($r = $rs->fetch()) {
                $q = $r[3];
                $opArray = array();
                $optextArray = array();
                $index = 0;
                $index1 = 0;
                //display poll question
                echo "<h1>$q</h1>\n";
                echo "<hr>";

                // save the ids of the poll options to the 'opArray' array
                $sql = "select * from polloptions where pid=$pid";
                $rs = $db->query($sql);
                echo "<div class=options>";
                foreach ($rs as $r) {
                    global $index, $opArray;
                    $opArray[$index] = $r[0];
                    $index += 1;
                }

               // save the texts of the poll options to the 'optextArray' array
                $rs = $db->query($sql);
                foreach ($rs as $r) {
                    global $index1, $optextArray;
                    $optextArray[$index1] = $r[2];
                    $index1 += 1;
                }


               // Calculate the total number of votes in the poll and save it as 'totalvote'
                $totalvote = 0;
                $sql3 = "select * from vote where pid=$pid";
                $rs3 = $db->query($sql3);
                foreach ($rs3 as $r3) {
                    global $totalvote;
                    $totalvote += 1;
                }


                $count = 0;
                $index1 = 0;
                $per = 100.0;
                $dev = 0.0;
                $ans = 0.0;
                $votenum = array();


               //Calculate and display the percentage and number of votes for each option
                foreach ($opArray as $opid) {
                    global $count, $votenum, $index1, $optextArray, $totalvote, $per;
                    $count = 0;

                    //calculate number of votes for each option
                    $sql2 = "select * from vote where opid=$opid";
                    $rs2 = $db->query($sql2);
                    foreach ($rs2 as $r2) {
                        $count += 1;
                    }

                    //calculate the percentage of each option
                    $votenum[$opid] = $count;
                    //if this option has been voted
                    if ($totalvote > 0) {
                        $dev = $count / $totalvote;
                        $ans = $per * $dev;
                    }
                    //if this option has not been voted percentage=0%
                    else
                        $ans = 0.0;

                    //display the poll options with number of votes and percentage
                    echo "<div class=op>";
                    echo "<div class=optext>$optextArray[$index1]</div>";
                    $ans=number_format($ans, 2);
                    echo "<div class=opvalue>$votenum[$opid] votes ($ans%)</div>";
                    echo "</div>";
                    echo"<div class=bar style=width:$ans%;></div><hr/>";
                    $index1 += 1;
                }

                //if the user loged in
                if ($uid > 0) {
                //user can go to vote
                $sql4 = "select * from poll where statues='Open' and pid=$pid";
                $rs4 = $db->query($sql4);
                    if ($r4 = $rs4->fetch()) {
                    echo "<p class=login>Vote now!</p>";
                    echo "<input type='hidden' name='pid' value='$pid'/>\n";
                    echo "<div class=buttonsub><button type='submit' class=butt>Go to vote</button></div></form>";
                    }
                }

                //if the user not loged in
                else{
                //user can login to vote
                $sql4 = "select * from poll where statues='Open' and pid=$pid";
                $rs4 = $db->query($sql4);
                    if ($r4 = $rs4->fetch()) {
                    echo "<p class=login>login to vote now!</p>";
                    echo "<input type='hidden' name='pid' value='$pid'/>\n";
                    echo "<div class=buttonsub><a href=login.php class=butt>Login</a></div>";
                    }
                }
            echo "</div>";
            echo "</div>";
        }

        $db = null;
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
    ?>
</body>
</html>

