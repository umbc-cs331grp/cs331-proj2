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

$debug = false;
include_once("CommonMethods.php");
include_once("tables.php");

$name = $_POST['name'];
$id = $_POST['id'];

// If for some reason name or id didn't post, won't create empty row
if (empty($name) || empty($id)) {
    print("<table class='center'><tr><td>An error has occurred. Please try again later.</td></tr></table>");
    return;
}

createTables($debug);

$common = new Common($debug);

if (rowExists($common, getMainTableName(), "adviser_id", $id)) {
    echo "<table class='center'>";
    echo "  <tr align='center'>";
    echo "    <td>$name is already an adviser.</td>";
    echo "  </tr>";
    echo "  <tr align='center'>";
    echo "    <td>";
    echo "      <form action='add_adviser.html'>";
    echo "          <input type='submit' value='Add a Different Adviser' class='btn btn-default'>";
    echo "      </form>";
    echo "    </td>";
    echo "  <tr>";
    echo "</table>";
} else {
    setupRowForAdviser($common, getMainTableName(), getDaysTableName(), $id, $name);
    echo "<table class='center'>";
    echo "  <tr align='center'>";
    echo "    <td>Added $name as an adviser.</td>";
    echo "  </tr>";
    echo "  <tr align='center'>";
    echo "    <td>";
    echo "      <form action='add_adviser.html'>";
    echo "          <input type='submit' value='Add Another Adviser' class='btn btn-default'>";
    echo "      </form>";
    echo "    </td>";
    echo "  <tr>";
    echo "</table>";
}

?>

            </div>
        </div>
        <div class="col-md-4">
        </div>
    </div>
</div>

</body>
</html>
