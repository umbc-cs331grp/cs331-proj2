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

include_once("CommonMethods.php");
include_once("tables.php");

$debug = false;

$dayNum = (int)$_POST['day_num'];
$username = $_POST['username'];

$common = new Common($debug);
$mainTable = getMainName($username);
$slotsTable = getSlotsName($username);

// Update the database
$query = "SELECT * FROM $mainTable WHERE day = $dayNum";
$rs = $common->executeQuery($query, "get_day");
$row = mysql_fetch_array($rs);

for ($i = 1; $i <= 14; $i++) {
    $slotID = $row["slot$i"];
    $slotType = $_POST["slot$i"];
    $slotQuery = "UPDATE $slotsTable SET type = '$slotType' WHERE slot_id = $slotID";
    $common->executeQuery($slotQuery, "update_slots");
}

echo "<table class='center' align='center'>\n";
echo "<tr>\n<td align='center'>\n";
echo "<p>Updated schedule.</p>";
echo "</td>\n</tr>\n";
echo "<tr>\n<td align='center'>\n";

// Button to return to editing that day
echo "<form name=\"back_to_day\" method=\"post\" action=\"advisor_day.php\">\n";
echo "    <input type=\"hidden\" name=\"username\" value=\"$username\">\n";
echo "    <input type=\"hidden\" name=\"day_num\" value=\"$dayNum\">\n";
echo "    <input type=\"submit\" value=\"Return to Editing\n";
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
echo "'s Schedule\"  class='btn btn-default'>\n";
echo "</form>\n";

echo "</td>\n</tr>\n";
echo "<tr>\n<td align='center'>\n";

// Button to go back to main page
echo "<form name=\"back_to_main\" method=\"post\" action=\"advisor_main.php\">\n";
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