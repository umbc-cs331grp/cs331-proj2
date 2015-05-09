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
include_once("sampleData.php");

function drop($common) {
    $mainTable = getMainTableName();
    $daysTable = getDaysTableName();
    $slotsTable = getSlotsTableName();
    $studentsTable = getStudentsTableName();
    $dateTable = getDateTableName();

    $stmt = "DROP TABLE IF EXISTS $mainTable, $daysTable, $slotsTable, $studentsTable, $dateTable";

    $common->executeQuery($stmt, "drop_tables");
}

$action = $_POST['action'];

$common = new Common($debug);

switch ($action) {
    case "drop":
        drop($common);
        echo "<table class='center'><tr><td>Successfully dropped tables.</td></tr></table>";
        break;
    case "init":
        createTables($debug);
        echo "<table class='center'><tr><td>Successfully initialized tables.</td></tr></table>";
        break;
    case "reset":
        drop($common);
        // TODO fix with actual sample data
        //createSampleData($common);
        echo "<table class='center'><tr><td>Successfully reset sample data.</td></tr></table>";
        break;
}

?>

                <br>
                <table class="center">
                    <tr><td>
                            <form action="manage_tables.html">
                                <input type="submit" value="Return to Table Management" class="btn btn-default">
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