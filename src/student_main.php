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

//Declarations and Such
$debug = false;
include_once("tables.php");
$common = new Common($debug);
$name = @($_POST['name']);
$studentID = @($_POST['studentID']);
$major = @($_POST['major']);
$common = new common($debug);

if (!rowExists($common, getStudentsTableName(), "student_id", $studentID))
{
    $query = "INSERT INTO " . getStudentsTableName() . "(student_id, student_name, student_major, appointment_id) VALUES ('" . $studentID . "', '" . $name . " ', '" . $major . "', 'NONE')";
    $common->executeQuery($query,"student_insertion");
}

//See Whether the Student has an appointment
$query = "SELECT appointment_id FROM " . getStudentsTableName() . " WHERE student_id = '$studentID'";
$rs = $common->executeQuery($query,"Get_Appointment_Status");
$data = mysql_fetch_row($rs);
$apptID = $data[0];



if($apptID == "NONE")
{

    $query = "SELECT Adviser_id, Adviser_name  FROM " . getMainTableName();
    $rs = $common->executeQuery($query, "Get_Adviser_Names");

    echo("<form action = '' id = 'getAppts'>");
    echo("Advisor Selection <br>");
    echo("<select name = 'adviserList' form='getAppts'>");
    echo("<option value='any'>Any</option>");
    while($row = mysql_fetch_row($rs))
    {
        echo("<option value=$row[0]> $row[1] </option>");
    }
    echo("</select>");

    echo(" <br> Time Selection </br> <select name = 'timeList' form='getAppts'>");
    echo("<option value='Any'>any</option>");
    echo("<option value='1'>9:00 AM   - 9:30 AM</option>");
    echo("<option value='2'>9:30 AM - 10:00 AM</option>");
    echo("<option value='3'>10:00 AM - 10:30 AM </option>");
    echo("<option value='4'>10:30 AM - 11:00 AM </option>");
    echo("<option value='5'>11:00 AM - 11:30 AM </option>");
    echo("<option value='6'>11:30 AM - 12:00 PM </option>");
    echo("<option value='7'>12:00 PM - 12:30 PM </option>");
    echo("<option value='8'>12:30 PM - 1:00 PM </option>");
    echo("<option value='9'>1:00 PM - 1:30 PM </option>");
    echo("<option value='10'>1:30 PM - 2:00 PM </option>");
    echo("<option value='11'>2:00 PM - 2:30 PM</option>");
    echo("<option value='12'>2:30 PM - 3:00 PM </option>");
    echo("<option value='13'>3:00 PM - 3:30 PM </option>");
    echo("<option value='14'>3:30 PM - 4:00 PM </option>");
    echo("</select>");

    //Code For Date Will Go here

    echo("<br><input type='submit' value='Search' class='btn btn-default'>");


}
else
{
echo("This user already has an appointment, Delete functionality will be implemented later.");
}



?>