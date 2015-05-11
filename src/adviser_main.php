<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>UMBC COEIT Advising</title>
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
        <div class="col-md-3">
        </div>
        <div class="col-md-6">
            <div id="box">

<?php

$debug = false;
include_once("CommonMethods.php");
include_once("tables.php");

// Just in case they don't exist
createTables($debug);

$common = new Common($debug);

$username = mysql_real_escape_string(htmlspecialchars($_POST['username']), $common->conn);

// Main part


if (!rowExists($common, getMainTableName(), "adviser_id", $username)) {
    echo "<table>";
    echo "<tr align='center'><td>You are not registered as an adviser.<br>If you believe this is in error, please contact the head of the department to resolve the issue.</td></tr>";
    echo "<tr align='center'><td>";
    echo "<form name=\"logout\" action=\"adviser_login.html\">\n";
    echo "    <input type=\"submit\" value=\"Return to Login\" class='btn btn-default'>\n";
    echo "</form>\n";
    echo "</td></tr>";
    return;
}

// Buttons for each of the days for editing availability and printing a schedule
$date = getDateFromTable($common);

$endDate = new Date(5, 1, "Friday");

echo "<table class=\"center\">\n";

for ($i = 1; $i <= getNumberOfDays(); $i++) {
    echo "    <tr>\n";
    print("<td align='right'>");
    print($date->dayOfWeek);
    print("</td><td>");
    print($date->toString());
    print("</td>\n");

    echo "        <td>\n";
    echo "            <form name=\"edit_day\" method=\"post\" action=\"adviser_day.php\">\n";
    echo "                <input type=\"hidden\" name=\"day_num\" value=\"$i\">\n";
    echo "                <input type=\"hidden\" name=\"username\" value=\"$username\">\n";
    echo "                <input type=\"submit\" value=\"Edit Availability\" class='btn btn-default'>\n";
    echo "            </form>\n";
    echo "        </td>\n";
    echo "        <td>\n";
    echo "            <form name=\"print_schedule\" method=\"post\" action='adviser_print_main.php'>\n";
    echo "                <input type=\"hidden\" name=\"day_num\" value=\"$i\">\n";
    echo "                <input type=\"hidden\" name=\"username\" value=\"$username\">\n";
    echo "                <input type=\"submit\" value=\"Print Schedule\" class='btn btn-default'>\n";
    echo "            </form>\n";
    echo "        </td>\n";
    echo "    </tr>\n";

    $date = $date->incrementToNextWeekday();
    if ($date->compare($endDate) == 1) {
        break;
    }
}

// Logout
echo "    <tr>\n";
echo "        <td colspan='4' align='center'>\n";
echo "    <br>\n";
echo "<form name=\"logout\" action=\"adviser_login.html\">\n";
echo "    <input type=\"submit\" value=\"Logout\" class='btn btn-default'>\n";
echo "</form>\n";
echo "        </td>";
echo "    </tr>\n";
echo "</table>\n";

?>

            </div>
        </div>
        <div class="col-md-3">
        </div>
    </div>
</div>

</body>
</html>