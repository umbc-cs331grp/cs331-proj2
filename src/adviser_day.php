<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>UMBC COEIT Advising</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="main_style.css">
    <style>
        select.align-right {
            text-align: right;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-3">
        </div>
        <div class="col-md-6">
            <div class="jumbotron"><h2 class="text-center">UMBC COEIT</h2><h2 class="text-center">Engineering and Computer Science Advising</h2></div>
        </div>
        <div class="col-md-3">
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-8">
            <div id="box">

<?php

$debug = false;
include_once("CommonMethods.php");
include_once("tables.php");

$dayNum = (int)$_POST['day_num'];
$username = $_POST['username'];

$common = new Common($debug);
$individualStartDate = new Date(3, 23, "Monday");

// Get day id
$mainTable = getMainTableName();
$stmt = "SELECT * FROM $mainTable WHERE adviser_id = '$username'";
$rs = $common->executeQuery($stmt, "get_day_id");
$row = mysql_fetch_array($rs);
$day_id = (int)$row["day$dayNum"];


$daysTable = getDaysTableName($username);
$slotsTable = getSlotsTableName($username);

$date = getDateFromTable($common);
$date = $date->getDateOfDay($dayNum);

// Check if individual appointments should be available yet
$individual = true;
$columns = 8;
if ($date->compare($individualStartDate) == -1) {
    $individual = false;
    $columns = 7;
}

echo "<h4 align='center'>";
echo $date->dayOfWeek;
echo " " . $date->toString();
echo "</h4>";

/*if (!rowExists($common, $daysTable, "day", $dayNum)) {
    setupRowForDay($common, $daysTable, $slotsTable, $dayNum);
}*/

// Get data for day
$query = "SELECT * FROM $daysTable WHERE day_id = $day_id";
$rs = $common->executeQuery($query, "get_day");
$row = mysql_fetch_array($rs);

echo "<form method='post' action='adviser_set_day.php'>";
echo "<input type=\"hidden\" name=\"day_num\" value=\"$dayNum\">";
echo "<input type=\"hidden\" name=\"day_id\" value=\"$day_id\">";
echo "<input type=\"hidden\" name=\"username\" value=\"$username\">";
echo "<table class='center'>\n";
// Loop over time slots
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

    $slotQuery = "SELECT * FROM $slotsTable WHERE slot_id = " . $row["slot" . $i];
    $slotRS = $common->executeQuery($slotQuery, "get_slot");
    $slotRow = mysql_fetch_array($slotRS);

    // Print major options
    $major = $slotRow['major'];
    echo "<td></td>";
    echo "<td>Major: ";
    echo "<select name='slot_major_$i'>";
    echo "    <option value='NULL'";
    if (($major != "CMSC") && ($major != "CMPE") && ($major != "ENME") && ($major != "ENCH") && ($major != "ENES")) {
        echo " selected='selected'";
    }
    echo ">All</option>";
    echo "    <option value='CMSC'";
    if ($major == "CMSC") {
        echo " selected='selected'";
    }
    echo ">CMSC</option>";
    echo "    <option value='CMPE'";
    if ($major == "CMPE") {
        echo " selected='selected'";
    }
    echo ">CMPE</option>";
    echo "    <option value='ENME'";
    if ($major == "ENME") {
        echo " selected='selected'";
    }
    echo ">ENME</option>";
    echo "    <option value='ENCH'";
    if ($major == "ENCH") {
        echo " selected='selected'";
    }
    echo ">ENCH</option>";
    echo "    <option value='ENES'";
    if ($major == "ENES") {
        echo " selected='selected'";
    }
    echo ">ENES</option>";
    echo "</select>";
    echo "</td>\n";


    // Print radio buttons for 3 choices. Check whichever it is currently set to based on database
    echo "<td>\n";
    $slotType = $slotRow['type'];
    echo "<input type=\"radio\" name=\"slot" . $i . "\" value=\"N\"";
    if ($slotType == "N") {
        echo " checked=\"checked\"";
    }
    echo "> Not Available\n";
    echo "</td>\n";
    if ($individual) {
        echo "<td><input type=\"radio\" name=\"slot" . $i . "\" value=\"I\"";
        if ($slotType == "I") {
            echo " checked=\"checked\"";
        }
        echo "> Individual</td>";
    }
    echo "<td>\n";
    echo "<input type=\"radio\" name=\"slot" . $i . "\" value=\"G\"";
    if ($slotType == "G") {
        echo " checked=\"checked\"";
    }
    echo "> Group (size:";


    // Group size
    $groupSize = $slotRow['group_size'];
    echo "<select name='slot_group_size_$i' class='align-right'>";
    echo "    <option value='10'";
    if (($groupSize != "9") && ($groupSize != "8") && ($groupSize != "7") && ($groupSize != "6") && ($groupSize != "5")) {
        echo " selected='selected'";
    }
    echo ">10</option>";
    echo "    <option value='9'";
    if ($groupSize == "9") {
        echo " selected='selected'";
    }
    echo ">9</option>";
    echo "    <option value='8'";
    if ($groupSize == "8") {
        echo " selected='selected'";
    }
    echo ">8</option>";
    echo "    <option value='7'";
    if ($groupSize == "7") {
        echo " selected='selected'";
    }
    echo ">7</option>";
    echo "    <option value='6'";
    if ($groupSize == "6") {
        echo " selected='selected'";
    }
    echo ">6</option>";
    echo "    <option value='5'";
    if ($groupSize == "5") {
        echo " selected='selected'";
    }
    echo ">5</option>";
    echo "</select>";
    echo ")</td>\n";

    echo "</tr>\n";
}

// Day can be repeated
if ($dayNum > (getNumberOfDays() - 5)) {
    $query = "SELECT weekly FROM $daysTable WHERE day_id = $day_id";
    $rs = $common->executeQuery($query, "get_weekly");
    $row = mysql_fetch_array($rs);
    $weekly = $row['weekly'];

    echo "<tr><td colspan='$columns' align='center'>";
    echo "<input type='checkbox' name='weekly' value='T'";
    if ($weekly == "1") {
        echo " checked";
    }
    echo "> Use Weekly";
    echo "</td>";
}

// Button to update schedule
echo "<tr><td colspan='$columns' align='center'>";
echo "<input type=\"submit\" value=\"Update\" class='btn btn-default'>";
echo "</td>";

echo "</table>\n";
echo "</form>\n";

echo "<br>\n";
// Button to return to choice of days without updating schedule
echo "<table class='center'><tr><td><form name=\"back_to_main\" method=\"post\" action=\"adviser_main.php\">\n";
echo "    <input type=\"hidden\" name=\"username\" value=\"$username\">\n";
echo "    <input type=\"submit\" value=\"Return to Day Selection\" class='btn btn-default'>\n";
echo "</form></td></tr></table>\n";

?>

            </div>
        </div>
        <div class="col-md-2">
        </div>
    </div>
</div>

</body>
</html>
