<?php
if (empty($_POST['username']) || empty($_POST['day_num']) || empty($_POST['slot'])) {
    header("Location: adviser_login.html");
}
?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>UMBC COEIT Advising</title>
    <style type="text/css">
        td, th {
            padding: 4px 16px 4px 0;
        }
    </style>
</head>
<body>

<?php

$debug = false;
include_once("CommonMethods.php");
include_once("tables.php");

$dayNum = (int)$_POST['day_num'];
$username = $_POST['username'];
$slot = $_POST['slot'];

$common = new Common($debug);

$mainTable = getMainTableName();
$daysTable = getDaysTableName();
$slotsTable = getSlotsTableName();
$studentTable = getStudentsTableName();

$date = getDateFromTable($common);
$date = $date->getDateOfDay($dayNum);

// Print day
echo "<h4>";
echo $date->dayOfWeek;
echo " " . $date->toString();
echo "</h4>";

// Print time slot
switch ($slot) {
    case 1:
        echo "<h4>9:00 AM - 9:30 AM</h4>";
        break;
    case 2:
        echo "<h4>9:30 AM - 10:00 AM</h4>";
        break;
    case 3:
        echo "<h4>10:00 AM - 10:30 AM</h4>";
        break;
    case 4:
        echo "<h4>10:30 AM - 11:00 AM</h4>";
        break;
    case 5:
        echo "<h4>11:00 AM - 11:30 AM</h4>";
        break;
    case 6:
        echo "<h4>11:30 AM - 12:00 PM</h4>";
        break;
    case 7:
        echo "<h4>12:00 PM - 12:30 PM</h4>";
        break;
    case 8:
        echo "<h4>12:30 PM - 1:00 PM</h4>";
        break;
    case 9:
        echo "<h4>1:00 PM - 1:30 PM</h4>";
        break;
    case 10:
        echo "<h4>1:30 PM - 2:00 PM</h4>";
        break;
    case 11:
        echo "<h4>2:00 PM - 2:30 PM</h4>";
        break;
    case 12:
        echo "<h4>2:30 PM - 3:00 PM</h4>";
        break;
    case 13:
        echo "<h4>3:00 PM - 3:30 PM</h4>";
        break;
    case 14:
        echo "<h4>3:30 PM - 4:00 PM</h4>";
        break;
}

// Get data for slot
$query = "SELECT * FROM " . $mainTable . " WHERE adviser_id = '$username'";
$rs = $common->executeQuery($query, "get_day_id");
$row = mysql_fetch_array($rs);
$day_id = $row["day$dayNum"];

$query = "SELECT * FROM $daysTable WHERE day_id = $day_id";
$rs = $common->executeQuery($query, "get_day_info");
$row = mysql_fetch_array($rs);
$slot_id = $row["slot$slot"];

$query = "SELECT * FROM $slotsTable WHERE slot_id = $slot_id";
$rs = $common->executeQuery($query, "get_slot");
$row = mysql_fetch_array($rs);
$type = $row['type'];


// Check if appointment
if (($type == "N") || ($row['student1'] == null)) {
    echo "[No Appointment]";
    return;
}

// Print info about appointment otherwise
if ($type == "I") {
    print("<h5>Individual</h5>");
} elseif ($type == "G") {
    print("<h5>Group</h5>");
}

$major = $row['major'];
echo "<h5>Major: ";
if ($major == null) {
    echo "Any";
} else {
    echo $major;
}
echo "</h5>";

echo "<table>";
echo "<tr><th align='left'>Name</th><th align='left'>ID</th><th align='left'>Major</th></tr>";

if ($type == "I") {
    $student_id = $row["student1"];
    $query = "SELECT * FROM $studentTable WHERE student_id = '$student_id'";
    $rs = $common->executeQuery($query, "get_student");
    $row = mysql_fetch_array($rs);

    echo "<tr>";
    echo "<td>".$row['student_first_name']." ".$row['student_last_name']."</td>";
    echo "<td>$student_id</td>";
    echo "<td>".$row['student_major']."</td>";
    echo "</tr>";
} elseif ($type == "G") {
    for ($i = 1; $i <= getNumberOfDays(); $i++) {
        if (($row["student$i"] == null)  || ($row["student$i"] == "")) {
            continue;
        }

        $student_id = $row["student$i"];
        $query = "SELECT * FROM $studentTable WHERE student_id = '$student_id'";
        $rs = $common->executeQuery($query, "get_student");
        $slotRow = mysql_fetch_array($rs);

        echo "<tr>";
        echo "<td>".$slotRow['student_first_name']." ".$slotRow['student_last_name']."</td>";
        echo "<td>$student_id</td>";
        echo "<td>".$slotRow['student_major']."</td>";
        echo "</tr>";
    }
}



echo "</table>";

?>

</body>
</html>
