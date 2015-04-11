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
        <div class="col-md-3">
        </div>
        <div class="col-md-6">
            <div id="box">

<?php

$debug = false;
include_once("CommonMethods.php");
include_once("tables.php");

$dayNum = (int)$_POST['day_num'];
$username = $_POST['username'];

$common = new Common($debug);

$mainTable = getDaysTableName($username);
$slotsTable = getSlotsTableName($username);

echo "<h4 align='center'>";
switch ($dayNum) {
    case 1:
        print("Monday");
        break;
    case 2:
        print("Tuesday");
        break;
    case 3:
        print("Wednesday");
        break;
    case 4:
        print("Thursday");
        break;
    case 5:
        print("Friday");
        break;
}
print("</h4>");

if (!rowExists($common, $mainTable, "day", $dayNum)) {
    setupRowForDay($common, $mainTable, $slotsTable, $dayNum);
}

// Get data for day
$query = "SELECT * FROM " . $mainTable . " WHERE day = " . $dayNum;
$rs = $common->executeQuery($query, "get_day");
$row = mysql_fetch_array($rs);

echo " method='post' action='advisor_set_dadvisor_set_day.php'>";
echo "<input type=\"hidden\" name=\"day_num\" value=\"$dayNum\">";
echo "<input type=\"hidden\" name=\"username\" value=\"$username\">";
echo "<table class='center'>\n";
// Loop over time slots
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

    // Print radio buttons for 3 choices. Check whichever it is currently set to based on database
    $slotQuery = "SELECT type FROM " . $slotsTable . " WHERE slot_id = " . $row["slot" . $i];
    $slotRS = $common->executeQuery($slotQuery, "get_slot");
    $slotRow = mysql_fetch_array($slotRS);
    $slotType = $slotRow['type'];
    echo "<input type=\"radio\" name=\"slot" . $i . "\" value=\"N\"";
    if ($slotType == "N") {
        echo " checked=\"checked\"";
    }
    echo "> Not Available\n";
    echo "</td><td>\n";
    echo "<input type=\"radio\" name=\"slot" . $i . "\" value=\"I\"";
    if ($slotType == "I") {
        echo " checked=\"checked\"";
    }
    echo "> Individual\n";
    echo "</td><td>\n";
    echo "<input type=\"radio\" name=\"slot" . $i . "\" value=\"G\"";
    if ($slotType == "G") {
        echo " checked=\"checked\"";
    }
    echo "> Group\n";
    echo "</td>\n";
    echo "</tr>\n";
}
// Button to update schedule
echo "<tr><td colspan='6' align='center'>";
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
        <div class="col-md-3">
        </div>
    </div>
</div>

</body>
</html>
