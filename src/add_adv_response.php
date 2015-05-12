<?php
if (empty($_POST['name']) || empty($_POST['id'])) {
    header("Location: add_adviser.html");
    exit;
}
?>

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

// Just in case they don't exist
createTables($debug);

$common = new Common($debug);

$name = mysql_real_escape_string(htmlspecialchars($_POST['name']), $common->conn);
$id = mysql_real_escape_string(htmlspecialchars($_POST['id']), $common->conn);

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

                <br>
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
