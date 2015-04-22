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

$debug = false;
include_once("CommonMethods.php");
include_once("tables.php");

$dayNum = (int)$_POST['day_num'];
$username = $_POST['username'];

$date = getDateFromTable(new Common($debug));
$date = $date->getDateOfDay($dayNum);

echo "<h4 align='center'>";
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

echo "<table class='center'>";

echo "<tr><td align='center'>";
echo "<form name='print_full' method='post' target='_blank' action='adviser_print_day.php'>";
echo "<input type='hidden' name='day_num' value='$dayNum'>";
echo "<input type='hidden' name='username' value='$username'>";
echo "<input type='submit' value='Print Full Schedule' class='btn btn-default'>";
echo "</form>";
echo "</td></tr>";

echo "<tr><td align='center'>";
echo "<form name='print_slot' method='post' target='_blank' action='adviser_print_slot.php'>";
echo "<input type='hidden' name='day_num' value='$dayNum'>";
echo "<input type='hidden' name='username' value='$username'>";
echo "<input type='submit' value='Print Schedule for:' class='btn btn-default'>";
echo "  <select name='slot'>";
echo "      <option value='1'>9:00 AM - 9:30 AM</option>";
echo "      <option value='2'>9:30 AM - 10:00 AM</option>";
echo "      <option value='3'>10:00 AM - 10:30 AM</option>";
echo "      <option value='4'>10:30 AM - 11:00 AM</option>";
echo "      <option value='5'>11:00 AM - 11:30 AM</option>";
echo "      <option value='6'>11:30 AM - 12:00 PM</option>";
echo "      <option value='7'>12:00 PM - 12:30 PM</option>";
echo "      <option value='8'>12:30 PM - 1:00 PM</option>";
echo "      <option value='9'>1:00 PM - 1:30 PM</option>";
echo "      <option value='10'>1:30 PM - 2:00 PM</option>";
echo "      <option value='11'>2:00 PM - 2:30 PM</option>";
echo "      <option value='12'>2:30 PM - 3:00 PM</option>";
echo "      <option value='13'>3:00 PM - 3:30 PM</option>";
echo "      <option value='14'>3:30 PM - 4:00 PM</option>";
echo "  </select>";
echo "</form>";
echo "</td></tr>";

echo "</table>";

// Button to return to choice of days without updating schedule
echo "<br><table class='center'><tr><td><form name=\"back_to_main\" method=\"post\" action=\"adviser_main.php\">\n";
echo "    <input type=\"hidden\" name=\"username\" value=\"$username\">\n";
echo "    <input type=\"submit\" value=\"Return to Day Selection\" class='btn btn-default'>\n";
echo "</form></td></tr></table>\n";

?>

</div>
        </div>
        <div class="col-md-4">
        </div>
    </div>
</div>

</body>
</html>
