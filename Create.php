<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create</title>
    <link rel="stylesheet" type="text/css" href="CreateStyle1.css" />
    <link rel="icon" href="Logo.png" />
    <!-- Display date picker  -->
    <script>
    function toggleDatePicker() {
    var radio1 = document.getElementById("option1");
    var radio2 = document.getElementById("option2");
    var datepickerContainer = document.getElementById("datepicker-container");

    // If "End Date" is selected, show the date picker
    if (radio2.checked) {
        datepickerContainer.style.display = "block";
    } 
    // Otherwise, if "Manually" is selected, hide the date picker
    else if (radio1.checked) {
        datepickerContainer.style.display = "none";
    }
}

    </script>

</head>
<body>



<div class="header-container">
<?php
$usid="0";
    
    if(isset($_SESSION['usid'])){
    $usid = $_SESSION['usid'];
    }

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
?>
<div class="heading">
<h1 id="head"> Start Creating A New Poll </h1>
<h2 id="subheading"> <i>Complete the below fields to create your poll </i> </h2>
</div>


    <?php echo"<form action=save_data.php method=post>"?>
    <div id="content1">
        <label>Poll Title</label> <br><br>
        <input type="text" name="Ptitle" placeholder="Enter your title" class="box"> <br><br>

        <label >Question</label> <br><br>
        <input type="text" name="question" placeholder="Enter your Question" class="box"> <br><br>

        <label >Answer Options</label> <br><br>

        <!-- Options -->
        <form>
        <div id="input-fields-container">
        <div>
        <input type="text" class="box" name="input1" placeholder="Option 1">
        </div>
        <div>
        <input type="text" class="box" name="input2" placeholder="Option 2">
        </div>
        </div>
        <div id="new-input-field"></div>
        <button type="button" class="btnadd" onclick="addNewInputField()">&#43  Add Option</button>
        

        <script>
         var inputCounter = 2; // Start with 2 input fields

        function addNewInputField() {
        inputCounter++;

        var newInputContainer = document.createElement("div");

        var newInput = document.createElement("input");
        newInput.type = "text";
        newInput.className = "new-input-field";
        newInput.name = "input" + inputCounter;
        newInput.placeholder = "Option " + inputCounter;

        newInputContainer.appendChild(newInput);

        var newInputField = document.getElementById("new-input-field");
        newInputField.appendChild(newInputContainer);
        }
        </script>

        <!-- radio Btn -->
        <fieldset>
    <legend>Ends By</legend>
    <div class="toggle">
    <input type="radio" name="option" value="0" id="option1" checked="checked" onclick="toggleDatePicker()"/> 
<label for="option1">Manually</label>
        <input type="radio" name="option" value="1" id="option2" onclick="toggleDatePicker()" />
        <label for="option2">End Date</label>
    </div>
    
</fieldset>


        <div id="datepicker-container" class="datepicker-container">
        <input type="date" name="enddate" class="datepicker">
        </div> 
        

        
        <div class="Submit">
                    <input type="submit" class="btn" name="submit" value="Create" required> 
                </div>
                </form>


    </div>
    </form>


    

</body>
</html>