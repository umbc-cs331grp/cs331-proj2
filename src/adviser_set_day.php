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
            <div class="jumbotron"><h2 class="text-center">UMBC COEIT</h2><h2 class="text-center">Engineering and Computer Science Advising</h2></div>
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

include_once("CommonMethods.php");
include_once("tables.php");

$debug = false;

$dayNum = (int)$_POST['day_num'];
$day_id = (int)$_POST['day_id'];
$username = $_POST['username'];
$weekly = $_POST['weekly'];

$common = new Common($debug);
$daysTable = getDaysTableName();
$slotsTable = getSlotsTableName();

// Update the slots in the database
$query = "SELECT * FROM $daysTable WHERE day_id = $day_id";
$rs = $common->executeQuery($query, "get_day");
$row = mysql_fetch_array($rs);

for ($i = 1; $i <= 14; $i++) {
    $slotID = $row["slot$i"];
    $slotType = $_POST["slot$i"];
    $major = $_POST["slot_major_$i"];
    if ($major != "NULL") {
        $major = "'$major'";
    }
    $groupSize = $_POST["slot_group_size_$i"];
    $slotQuery = "UPDATE $slotsTable SET type = '$slotType', major = $major, group_size = '$groupSize' WHERE slot_id = $slotID";
    $common->executeQuery($slotQuery, "update_slots");
}

// Update whether or not day is repeated weekly
if ($weekly == "T") {
    $query = "UPDATE $daysTable SET weekly = 1 WHERE day_id = '$day_id'";
    $common->executeQuery($query, "update_weekly");
} else {
    $query = "UPDATE $daysTable SET weekly = 0 WHERE day_id = '$day_id'";
    $common->executeQuery($query, "update_weekly");
}

echo "<table class='center' align='center'>\n";
echo "<tr>\n<td align='center'>\n";
echo "<p>Updated schedule.</p>";
echo "</td>\n</tr>\n";
echo "<tr>\n<td align='center'>\n";

// Button to return to editing that day
echo "<form name=\"back_to_day\" method=\"post\" action=\"adviser_day.php\">\n";
echo "    <input type=\"hidden\" name=\"username\" value=\"$username\">\n";
echo "    <input type=\"hidden\" name=\"day_num\" value=\"$dayNum\">\n";
echo "    <input type=\"submit\" value=\"Return to Editing\n";
$date = getDateFromTable($common);
$date = $date->getDateOfDay($dayNum);
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
echo "'s Schedule\"  class='btn btn-default'>\n";
echo "</form>\n";

echo "</td>\n</tr>\n";
echo "<tr>\n<td align='center'>\n";

// Button to go back to main page
echo "<form name=\"back_to_main\" method=\"post\" action=\"adviser_main.php\">\n";
echo "    <input type=\"hidden\" name=\"username\" value=\"$username\">\n";
echo "    <input type=\"submit\" value=\"Return to Day Selection\" class='btn btn-default'>\n";
echo "</form>\n";

echo "</td>\n</tr>\n";
echo "</table>\n";

?>

            </div>
        </div>
        <div class="col-md-4">
        </div>
    </div>
</div>

</body>
</html>