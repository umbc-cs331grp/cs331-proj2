<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>UMBC COEIT Advising</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="main_style.css">
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-3">
        </div>
        <div class="col-md-6">
            <div class="jumbotron"><h2 class="text-center">UMBC CSEE Advising</h2></div>
        </div>
        <div class="col-md-3">
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
        </div>
        <div class="col-md-4">
            <div id="box">

            <?php
            include_once("tables.php");
            $name = @($_POST['name']);
            $studentID = @($_POST['studentID']);
            $appointmentData = @($_POST['apptSelect']);
            $data = explode(',', $appointmentData);
            $slotID = $data[0];
            $date = $data[1];
            $time = $data[2];
            $adviser = $data[3];
            $insertSlot = $data[4];

            $common = new common($debug);

            $query = "UPDATE " . getSlotsTableName() . " SET " . $insertSlot . "='" . $studentID ."' WHERE slot_id=" . $slotID;
            $common->executeQuery($query, "Update_Slot_Table");

            $query = "UPDATE " . getStudentsTableName() . " SET appointment_id =" . $slotID . ", appointment_date='" . $date . "', appointment_time= '" . $time . "', appointment_adviser='" . $adviser . "' WHERE student_id='" . $studentID ."'";
            $common->executeQuery($query, "Update_Student_Table");

            echo("Successfully registered for appointment: <br> Date: $date <br> From: $time  <br> Adviser: $adviser <br>");
            echo("This page can now be closed.");
            ?>

            </div>
        </div>
    </div>
</div>
</body>
</html>