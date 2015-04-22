<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>UMBC CSEE Advising</title>
    <style type="text/css">
        td {
            padding: 4px;
        }
    </style>
</head>
<body>

<?php

$debug = false;
include_once("CommonMethods.php");
include_once("tables.php");
//include_once("sampleData.php");

$dayNum = (int)$_POST['day_num'];
$username = $_POST['username'];

$common = new Common($debug);
//createSampleData($common);

$mainTable = getMainTableName();
$daysTable = getDaysTableName();
$slotsTable = getSlotsTableName();

$date = getDateFromTable(new Common($debug));
$date = $date->getDateOfDay($dayNum);

echo "<h4>";
switch ($dayNum) {
    case 1:
    case 6:
        print("Monday");
        break;
    case 2:
    case 7:
        print("Tuesday");
        break;
    case 3:
    case 8:
        print("Wednesday");
        break;
    case 4:
    case 9:
        print("Thursday");
        break;
    case 5:
    case 10:
        print("Friday");
        break;
}
echo " " . $date->toString();
echo "</h4>";

// Get data for day
$query = "SELECT * FROM " . $mainTable . " WHERE adviser_id = '$username'";
$rs = $common->executeQuery($query, "get_day_id");
$row = mysql_fetch_array($rs);
$day_id = $row["day$dayNum"];

$query = "SELECT * FROM $daysTable WHERE day_id = $day_id";
$rs = $common->executeQuery($query, "get_day_info");
$row = mysql_fetch_array($rs);

echo "<table>\n";
for ($i = 1; $i <= 14; $i++) {
    echo "<tr>\n";
    // Print time slots
    switch ($i) {
        case 1:
            echo "<td>9:00 AM</td><td>-</td><td>9:30 AM</td>\n";
            break;
        case 2:
            echo "<td>9:30 AM</td><td>-</td><td>10:00 AM</td>\n";
            break;
        case 3:
            echo "<td>10:00 AM</td><td>-</td><td>10:30 AM</td>\n";
            break;
        case 4:
            echo "<td>10:30 AM</td><td>-</td><td>11:00 AM</td>\n";
            break;
        case 5:
            echo "<td>11:00 AM</td><td>-</td><td>11:30 AM</td>\n";
            break;
        case 6:
            echo "<td>11:30 AM</td><td>-</td><td>12:00 PM</td>\n";
            break;
        case 7:
            echo "<td>12:00 PM</td><td>-</td><td>12:30 PM</td>\n";
            break;
        case 8:
            echo "<td>12:30 PM</td><td>-</td><td>1:00 PM</td>\n";
            break;
        case 9:
            echo "<td>1:00 PM</td><td>-</td><td>1:30 PM</td>\n";
            break;
        case 10:
            echo "<td>1:30 PM</td><td>-</td><td>2:00 PM</td>\n";
            break;
        case 11:
            echo "<td>2:00 PM</td><td>-</td><td>2:30 PM</td>\n";
            break;
        case 12:
            echo "<td>2:30 PM</td><td>-</td><td>3:00 PM</td>\n";
            break;
        case 13:
            echo "<td>3:00 PM</td><td>-</td><td>3:30 PM</td>\n";
            break;
        case 14:
            echo "<td>3:30 PM</td><td>-</td><td>4:00 PM</td>\n";
            break;
    }
    echo "<td>\n";

    // Find out what type of appointment and who has signed up
    $slotQuery = "SELECT * FROM $slotsTable WHERE slot_id = " . $row["slot$i"];
    $slotRS = $common->executeQuery($slotQuery, "get_slot");
    $slotRow = mysql_fetch_array($slotRS);
    $slotType = $slotRow['type'];

    if ($slotType == "N") {
        print("[No Appointment]");
    } elseif ($slotType == "I") {
        if (($slotRow['student1'] == null) || ($slotRow['student1'] == "")) {
            print("[No Appointment]");
        } else {
            print("Invididual: ".$slotRow['student1']);
        }
    } elseif ($slotType == "G") {
        if (($slotRow['student1'] == null) || ($slotRow['student1'] == "")) {
            print("[No Appointment]");
        } else {
            print("Group: ".$slotRow['student1']);
        }
        for ($j = 2; $j <=10; $j++) {
            if (($slotRow["student$j"] == null)  || ($slotRow["student$j"] == "")) {
                break;
            }
            print(", ".$slotRow["student$j"]);
        }
    }

    echo "</td>\n";
    echo "</tr>\n";
}
echo "</table>\n";

?>

</body>
</html>