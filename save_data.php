<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create </title>
    <link rel="stylesheet" href="mainpageStyle.css" />
    <link rel="icon" href="Logo.png" />
</head>
<body>

<?php
    try {
    require 'connection.php';
    $uid="0";
    if(isset($_SESSION['usid'])){
    $uid = $_SESSION['usid'];
    }
    if(isset($_POST['submit'])) {
    $Ptitle = $_POST['Ptitle'];
    $question = $_POST['question'];
    $endby=$_POST['option'];
    //$endtype="0";
    $statues="open";
    $options = array();


    if($endby==0){
      $endtype="manually";
      $statues="open";

      $stmt = $db->prepare("INSERT INTO poll (uid, title, question, end_by, statues) VALUES (:uid, :title, :question, :endtype, :statues)");
        $stmt->bindParam(':uid', $uid);
        $stmt->bindParam(':title', $Ptitle );
        $stmt->bindParam(':question', $question);
        $stmt->bindParam(':endtype', $endtype);
        $stmt->bindParam(':statues', $statues);
        $stmt->execute();

    }


    else{
      $endtype="date";
      $enddate=$_POST['enddate'];

      //Check if the expiration date of the created poll has been exceeded, the poll will be closed
      $exp_date=$enddate;
      $today_date=date('Y/m/d');
      $exp=strtotime($exp_date);
      $td=strtotime($today_date);
      if($td>$exp)
      $statues="close";

      //add the created poll to poll table
      $stmt = $db->prepare("INSERT INTO poll (uid, title, question, end_by, end_date, statues) VALUES (:uid, :title, :question, :endtype, :end_date, :statues)");
        $stmt->bindParam(':uid', $uid);
        $stmt->bindParam(':title', $Ptitle );
        $stmt->bindParam(':question', $question);
        $stmt->bindParam(':endtype', $endtype);
        $stmt->bindParam(':end_date', $enddate);
        $stmt->bindParam(':statues', $statues);
        $stmt->execute();
    }

    $pollID= $db -> lastinsertid();
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'input') === 0) {            
            // Add the option to the options array
            $options[] = $value;
        }
    }
    $optionStmt = $db->prepare("INSERT INTO polloptions (pid, `option text`) VALUES (:pid, :opText)");

    foreach ($options as $optionID => $optionText) {
        // Insert the option into the options table with the poll ID as the foreign key
        $optionStmt->execute(array(':pid' => $pollID, ':opText' => $optionText));
    }
    {$cssStyles = 'color: black; align-items:center; text-align:center; font-size: 30px; margin-top: 150px';
        echo '<p style="' . $cssStyles . '">poll created successfully</p>'; 
        echo "<a href='home.php'>
        <div class='back'>
              <button>Back to Home page ! </button>
              </div><br>";
            }
    }
        $db = null;
    }

    catch (PDOException $exc) {
        echo $exc->getMessage ();
        exit () ;
    }

?>
</body>
</html>
