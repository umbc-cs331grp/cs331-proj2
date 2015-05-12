<?php
if (empty($_POST['username']) || empty($_POST['day_num'])) {
    header("Location: adviser_login.html");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>UMBC COEIT Advising</title>
    <style type="text/css">
        td {
            padding: 4px;
        }
    </style>
</head>
<body>

<?php

function getNameFromId($common, $id, $table) {
    $nameQuery = "SELECT * FROM $table WHERE student_id = '$id'";
    $rs = $common->executeQuery($nameQuery, "get_name");
    $row = mysql_fetch_array($rs);
    return $row['student_first_name'] . " " . $row['student_last_name'];
}

$debug = false;
include_once("CommonMethods.php");
include_once("tables.php");

$dayNum = (int)$_POST['day_num'];
$username = $_POST['username'];

$common = new Common($debug);

$mainTable = getMainTableName();
$daysTable = getDaysTableName();
$slotsTable = getSlotsTableName();
$studentTable = getStudentsTableName();

$date = getDateFromTable($common);
$date = $date->getDateOfDay($dayNum);

echo "<h4>";
echo $date->dayOfWeek;
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
for ($i = 1; $i <= getAppointmentsInDay(); $i++) {
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

    // Query database for slot info
    $slotQuery = "SELECT * FROM $slotsTable WHERE slot_id = " . $row["slot$i"];
    $slotRS = $common->executeQuery($slotQuery, "get_slot");
    $slotRow = mysql_fetch_array($slotRS);

    echo "<td>Major: ";
    $major = $slotRow['major'];
    if ($major == null) {
        echo "Any";
    } else {
        echo $major;
    }
    echo "</td>";

    // Find out what type of appointment and who has signed up
    echo "<td>\n";
    $slotType = $slotRow['type'];

    if ($slotType == "N") {
        print("[No Appointment]");
    } elseif ($slotType == "I") {
        if (($slotRow['student1'] == null) || ($slotRow['student1'] == "")) {
            print("[No Appointment]");
        } else {
            print("Individual: ". getNameFromId($common, $slotRow['student1'], $studentTable));
        }
    } elseif ($slotType == "G") {
        if (($slotRow['student1'] == null) || ($slotRow['student1'] == "")) {
            print("[No Appointment]");
        } else {
            print("Group: ".getNameFromId($common, $slotRow['student1'], $studentTable));
        }
        for ($j = 2; $j <= getNumberOfDays(); $j++) {
            if (($slotRow["student$j"] == null)  || ($slotRow["student$j"] == "")) {
                break;
            }
            print(", ".getNameFromId($common, $slotRow["student$j"], $studentTable));
        }
    }

    echo "</td>\n";
    echo "</tr>\n";
}
echo "</table>\n";

?>

</body>
</html>