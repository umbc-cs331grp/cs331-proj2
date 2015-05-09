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
        <div class="col-md-4">
        </div>
        <div class="col-md-4">
            <div id="box">

<?php

$debug = false;
include_once("CommonMethods.php");
include_once("tables.php");
include_once("Date.php");

$month = $_POST['month'];
$day = $_POST['day'];
$dayOfWeek = $_POST['day-of-week'];

// If for some reason date didn't fully post
if (empty($month) || empty($day) || empty($dayOfWeek)) {
    print("<table class='center'><tr><td>An error has occurred. Please try again later.</td></tr></table>");
    return;
}

$date = new Date($month, $day, $dayOfWeek);

$common = new Common($debug);

updateDateInTable($date, $common);

echo "<table class='center'><tr><td>Set date to " . $date->dayOfWeek . " " . $date->toString() . "</td></tr></table>";

?>

                <br>
                <table class="center">
                    <tr><td>
                            <form action="manage_date.html">
                                <input type="submit" value="Return to Date Management" class="btn btn-default">
                            </form>
                        </td></tr>
                </table>
                <table class="center">
                    <tr><td>
                            <form action="manage_main.html">
                                <input type="submit" value="Return to Management Home" class="btn btn-default">
                            </form>
                        </td></tr>
                </table>
            </div>
        </div>
        <div class="col-md-4">
        </div>
    </div>
</div>

</body>
</html>
