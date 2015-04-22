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
include_once("tables.php");


$username = @($_POST['username']);


// Main part
createTables($debug);

$common = new Common($debug);
resetDate($common); // TODO remove

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

echo "<table class=\"center\">\n";

for ($i = 1; $i <= 10; $i++) {
    echo "    <tr>\n";
    // TODO replace with some way of getting actual day name / date
    print("<td align='right'>");
    switch ($i) {
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

    if ($i == 5) {
        $date = $date->addDays(3);
    } else {
        $date = $date->addDays(1);
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