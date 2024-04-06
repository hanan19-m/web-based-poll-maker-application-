<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home page</title>
    <link rel="stylesheet" href="Home_Style.css">
    <link rel="icon" href="Logo.png" />
</head>
<body>
    <?php
    $link = "viewresults.php";
    $link2 = "login.php";
    $usid="0";
    
    if(isset($_SESSION['usid'])){
    $usid = $_SESSION['usid'];
    }

    if ($usid > 0) {
        $link = "polls.php";
        $link2 = "Create.php";
    }
    ?>


<div class="main-container">
    
    <!-- container 1 creat -->
    <div class="container">
        <img src="poll1.png" alt="Avatar" class="image">
            <div class="polaroid">
                <p>Create</p>
                <?php
                echo "<a href='$link2'>"
                    ?>     <!-- to create page -->
                <div class="overlay1">
                <div class="text">Create your poll <br> in seconds</div>
                </div>
                <?php
                echo"</a>";
                ?>
            </div>
    </div>   

    <!-- container 2 vote -->
    <div class="container">
        <img src="vote3.png" alt="Avatar" class="image">
            <div class="polaroid">
            <p>Vote</p>
                <?php
                echo "<a href='$link'>"
                    ?>     <!-- to vote page -->
                <div class="overlay1">
                <div class="text">Vote Now!</div>
                </div>
                <?php
                echo"</a>";
                ?>
            </div>
    </div>  

</div>


<div class="header-container">
<?php
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
    ?>

</div>


</body>
</html>