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
include_once("tables.php");


$username = @($_POST['username']);


// Main part
createTables($debug);

// TODO remove later
$common = new Common($debug);
if (!rowExists($common, getMainTableName(), "adviser_id", $username)) {
    setupRowForAdviser($common, getMainTableName(), getDaysTableName(), $username, "temp");
}

// TODO make sure advisers are added?

// Buttons for each of the 5 days of the week for editing availability and printing a schedule
echo "<table class=\"center\">\n";
echo "    <tr>\n";
echo "        <td>Monday</td>\n";
echo "        <td>\n";
echo "            <form name=\"edit_day\" method=\"post\" action=\"advisor_day.php\">\n";
echo "                <input type=\"hidden\" name=\"day_num\" value=\"1\">\n";
echo "                <input type=\"hidden\" name=\"username\" value=\"$username\">\n";
echo "                <input type=\"submit\" value=\"Edit Availability\" class='btn btn-default'>\n";
echo "            </form>\n";
echo "        </td>\n";
echo "        <td>\n";
echo "            <form name=\"print_schedule\" method=\"post\" action=\"advisor_print.php\" target='_blank'>\n";
echo "                <input type=\"hidden\" name=\"day_num\" value=\"1\">\n";
echo "                <input type=\"hidden\" name=\"username\" value=\"$username\">\n";
echo "                <input type=\"submit\" value=\"Print Schedule\" class='btn btn-default'>\n";
echo "            </form>\n";
echo "        </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "        <td>Tuesday</td>\n";
echo "        <td>\n";
echo "            <form name=\"edit_day\" method=\"post\" action=\"advisor_day.php\">\n";
echo "                <input type=\"hidden\" name=\"day_num\" value=\"2\">\n";
echo "                <input type=\"hidden\" name=\"username\" value=\"$username\">\n";
echo "                <input type=\"submit\" value=\"Edit Availability\" class='btn btn-default'>\n";
echo "            </form>\n";
echo "        </td>\n";
echo "        <td>\n";
echo "            <form name=\"print_schedule\" method=\"post\" action=\"advisor_print.php\"  target='_blank'>\n";
echo "                <input type=\"hidden\" name=\"day_num\" value=\"2\">\n";
echo "                <input type=\"hidden\" name=\"username\" value=\"$username\">\n";
echo "                <input type=\"submit\" value=\"Print Schedule\" class='btn btn-default'>\n";
echo "            </form>\n";
echo "        </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "        <td>Wednesday</td>\n";
echo "        <td>\n";
echo "            <form name=\"edit_day\" method=\"post\" action=\"advisor_day.php\">\n";
echo "                <input type=\"hidden\" name=\"day_num\" value=\"3\">\n";
echo "                <input type=\"hidden\" name=\"username\" value=\"$username\">\n";
echo "                <input type=\"submit\" value=\"Edit Availability\" class='btn btn-default'>\n";
echo "            </form>\n";
echo "        </td>\n";
echo "        <td>\n";
echo "            <form name=\"print_schedule\" method=\"post\" action=\"advisor_print.php\"  target='_blank'>\n";
echo "                <input type=\"hidden\" name=\"day_num\" value=\"3\">\n";
echo "                <input type=\"hidden\" name=\"username\" value=\"$username\">\n";
echo "                <input type=\"submit\" value=\"Print Schedule\" class='btn btn-default'>\n";
echo "            </form>\n";
echo "        </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "        <td>Thursday</td>\n";
echo "        <td>\n";
echo "            <form name=\"edit_day\" method=\"post\" action=\"advisor_day.php\">\n";
echo "                <input type=\"hidden\" name=\"day_num\" value=\"4\">\n";
echo "                <input type=\"hidden\" name=\"username\" value=\"$username\">\n";
echo "                <input type=\"submit\" value=\"Edit Availability\" class='btn btn-default'>\n";
echo "            </form>\n";
echo "        </td>\n";
echo "        <td>\n";
echo "            <form name=\"print_schedule\" method=\"post\" action=\"advisor_print.php\" target='_blank'>\n";
echo "                <input type=\"hidden\" name=\"day_num\" value=\"4\">\n";
echo "                <input type=\"hidden\" name=\"username\" value=\"$username\">\n";
echo "                <input type=\"submit\" value=\"Print Schedule\" class='btn btn-default'>\n";
echo "            </form>\n";
echo "        </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "        <td>Friday</td>\n";
echo "        <td>\n";
echo "            <form name=\"edit_day\" method=\"post\" action=\"advisor_day.php\">\n";
echo "                <input type=\"hidden\" name=\"day_num\" value=\"5\">\n";
echo "                <input type=\"hidden\" name=\"username\" value=\"$username\">\n";
echo "                <input type=\"submit\" value=\"Edit Availability\" class='btn btn-default'>\n";
echo "            </form>\n";
echo "        </td>\n";
echo "        <td>\n";
echo "            <form name=\"print_schedule\" method=\"post\" action=\"advisor_print.php\" target='_blank'>\n";
echo "                <input type=\"hidden\" name=\"day_num\" value=\"5\">\n";
echo "                <input type=\"hidden\" name=\"username\" value=\"$username\">\n";
echo "                <input type=\"submit\" value=\"Print Schedule\" class='btn btn-default'>\n";
echo "            </form>\n";
echo "        </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "        <td colspan='3' align='center'>\n";
echo "    <br>\n";
// Logout
echo "<form name=\"logout\" action=\"advisor_login.html\">\n";
echo "    <input type=\"submit\" value=\"Logout\" class='btn btn-default'>\n";
echo "</form>\n";
echo "        </td>";
echo "    </tr>\n";
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