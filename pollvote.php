<?php
session_start();
?>
<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pollvote</title>
    <link rel="stylesheet" href="pollvote.css" />
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


    //get the user id and poll id
    $pid="0";
    if(isset($_GET['pid'])){
        $pid = $_GET['pid'];}
    if(isset($_POST['pid'])){
        $pid= $_POST['pid'];}
    $uid = "0";
    $uid = $_SESSION['usid'];
    $usid = "0";
    $date="0";
    $endby="0";
    
    

    //Check if the user has been voted for this poll before
    $sql1 = "select * from vote where pid=$pid";
    $rs1 = $db->query($sql1);
        foreach ($rs1 as $r1) {
            global $usid, $uid;
            $usid = $r1[1];
            if ($usid == $uid)
                break;
        }


        // If the user has not voted for this poll before displaying the poll options
        if ($usid != $uid) {
            $sql = "select * from poll where pid=$pid";
            $rs = $db->query($sql);

            echo "<form method='post' action='vote.php'>\n";
            if ($r = $rs->fetch()) {
                $q = $r[3];            //Question
                $maker=$r[1];         //the poll maker's user id
                $endby=$r[4];        //end tool

                //display poll question
                echo "<h1>$q</h1>\n";

                // If the current user is the creator of this poll
                if($uid==$maker){
                    //if the end tool of this poll is manually
                    if($endby=="manually"){
                        //user can end the poll now
                      echo "<a href='pollresults.php?pid={$pid}&endby={$endby}'>End The Poll Now</a>";
                    }
                    else{
                    //if the end tool of this poll is date
                        $rs = $db->query($sql);
                        if ($r = $rs->fetch()){
                            $date=$r[5]; //end date of the poll
                            //display the end date of this poll
                            echo"<label style=color:white;>End By: $date</label>";
                        }
                    }

                }
                // If the current user is not the creator of this poll
                else{
                        $rs = $db->query($sql);
                        if ($r = $rs->fetch()){
                            $date=$r[5]; //end date of the poll
                            //if the end tool of this poll is manually
                            if($endby=="manually")
                            //display the poll will end by the poll creator
                            echo"<label style=color:white;>End By: The Poll Creator</label>";
                            //if the end tool of this poll is date
                            else
                            //display the end date of this poll
                            echo"<label style=color:white;>End By: $date</label>";
                        }
                    }

                echo "<hr>";
                $sql = "select * from polloptions where pid=$pid";
                $rs = $db->query($sql);
                echo "<div class=options>";

                //display poll options
                foreach ($rs as $r) {
                    echo "<br /><input type='radio' name='op' value='{$r[0]}' class=radio>\t{$r[2]}<br />\n";
                }
                //user can vote or view poll results
                echo "<div class=buttonsub><button type='submit' class=butt>Vote</button>";
                echo "<input type='hidden' name='pid' value='$pid'/>\n";
                echo "\t<a href='pollresults.php?pid={$pid}' class=butt>View results</a></div>\n</form>\n";
            }
            echo "</div>";
            echo "</div>";
        }


        // If the user has voted for this poll before displaying the sorry message
        else {
            $sql = "select * from poll where pid=$pid";
            $rs = $db->query($sql);

            echo "<form method='post' action='vote.php'>\n";
            if ($r = $rs->fetch()) {
                $q = $r[3];            //Question
                $maker=$r[1];         //the poll maker's user id
                $endby=$r[4];        //end tool
                // If the current user is the creator of this poll
                if($uid==$maker){
                    //if the end tool of this poll is manually
                    if($endby=="manually"){
                        //user can end the poll now
                      echo "<a href='pollresults.php?pid={$pid}&endby={$endby}'>End The Poll Now</a>";
                    }
                    else{
                    //if the end tool of this poll is date
                        $rs = $db->query($sql);
                        if ($r = $rs->fetch()){
                            $date=$r[5]; //end date of the poll
                            //display the end date of this poll
                            echo"<label style=color:white;>End By: $date</label>";
                        }
                    }

                }
                // If the current user is not the creator of this poll
                else{
                        $rs = $db->query($sql);
                        if ($r = $rs->fetch()){
                            $date=$r[5]; //end date of the poll
                            //if the end tool of this poll is manually
                            if($endby=="manually")
                            //display the poll will end by the poll creator
                            echo"<label style=color:white;>End By: The Poll Creator</label>";
                            //if the end tool of this poll is date
                            else
                            //display the end date of this poll
                            echo"<label style=color:white;>End By: $date</label>";
                        }
                    }
            }
            //user can not vote but can view poll results or go to home page
            echo "<p class=novote>Sorry, you have already voted in this poll</p>";
            echo "\t<div class=buttonsub><a href='Home.php' class=butt>Go to home page</a>";
            echo "<input type='hidden' name='pid' value='$pid'/>\n";
            echo "<a href='pollresults.php?pid={$pid}' class=butt>View results</a></div>\n</form>\n";

        }
        $db = null;
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
    ?>
</body>
</html>

