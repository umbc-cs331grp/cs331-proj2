<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>UMBC CSEE Advising</title>
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
                $slotID = @($_POST['slotID']);
                $studentID = @($_POST['studentID']);

                $common = new common($debug);

                $query = "UPDATE " . getStudentsTableName() . " SET appointment_id = NULL, appointment_date = NULL, appointment_time = NULL, appointment_adviser = NULL WHERE student_id='" . $studentID."'";
                $common->executeQuery($query, "delete_from_students_table");

                $query = "SELECT * FROM " .getSlotsTableName() . " WHERE slot_id =" . $slotID;
                $rs = $common->executeQuery($query, "get_slot_for_deletion");
                $deleteRow = mysql_fetch_array($rs, MYSQL_ASSOC);
                $studentSlot = "student";
                for($i = 1; $deleteRow[$studentSlot] != $studentID; $i++ )
                {
                    $studentSlot = "student" . $i;
                }
                $query = "UPDATE " . getSlotsTableName() . " SET " . $studentSlot . " = NULL WHERE slot_id =" . $slotID;
                $common->executeQuery($query, "delete from slots");

                echo("Successfully Canceled Appointment <br>");
                echo("This page can now be closed.");
                ?>

            </div>
        </div>
    </div>
</div>
</body>
</html>