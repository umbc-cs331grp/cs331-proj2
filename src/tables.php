<?php

include_once("CommonMethods.php");
include_once("Date.php");

$MAIN_TABLE = "tbl_advising_main";
$DAYS_TABLE = "tbl_advising_days";
$SLOTS_TABLE = "tbl_advising_slots";
$STUDENTS_TABLE = "tbl_advising_students";
$DATE_TABLE = "tbl_advising_date";
$APPOINTMENTS_IN_DAY = 14;
$NUMBER_DAYS = 10;
$NUM_STUDENTS_PER_SLOT = 10;
$START_MONTH = 3;
$START_DAY = 2;
$START_DAY_OF_WEEK = "Monday";

// Creates the 3 tables
function createTables($debug) {
    global $MAIN_TABLE, $DAYS_TABLE, $SLOTS_TABLE, $STUDENTS_TABLE, $DATE_TABLE;

    $common = new Common($debug);

    $createTableQuery = "CREATE TABLE IF NOT EXISTS " . $STUDENTS_TABLE . "(
        student_id VARCHAR(7) NOT NULL PRIMARY KEY,
        student_first_name TEXT NOT NULL,
        student_last_name TEXT NOT NULL,
        student_major TEXT NOT NULL,
        appointment_id VARCHAR(10),
        appointment_date VARCHAR(4),
        appointment_time VARCHAR(20),
        appointment_adviser VARCHAR(20)
        )";

    $common->executeQuery($createTableQuery, "student_table");

    $createTableQuery = "CREATE TABLE IF NOT EXISTS " . $MAIN_TABLE . "(
        adviser_num INT(4) AUTO_INCREMENT NOT NULL PRIMARY KEY,
        adviser_id VARCHAR(20) NOT NULL,
        adviser_name TEXT NOT NULL";
    for ($i = 1; $i <= getNumberOfDays(); $i++) {
        $createTableQuery .= ", day$i INT(3) NOT NULL";
    }
    $createTableQuery .= ")";
    $common->executeQuery($createTableQuery, "main_setup");


    $createTableQuery = "CREATE TABLE IF NOT EXISTS " . $DAYS_TABLE . "(
        day_id INT(4) UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY, ";
    for ($i = 1; $i <= getAppointmentsInDay(); $i++) {
        $createTableQuery .= "slot$i INT(4) NOT NULL, ";
    }
    $createTableQuery .= "weekly TINYINT(1) NOT NULL DEFAULT '0')";
    $common->executeQuery($createTableQuery, "days_setup");

    $createTableQuery = "CREATE TABLE IF NOT EXISTS " . $SLOTS_TABLE . "(
        slot_id INT(8) UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
        type CHAR NOT NULL,
        group_size TINYINT UNSIGNED NOT NULL DEFAULT 10,
        major VARCHAR(4)";
    for ($i = 1; $i <= getNumStudentsPerSlot(); $i++) {
        $createTableQuery .= ", student$i TEXT";
    }
    $createTableQuery .= ")";
    $common->executeQuery($createTableQuery, "slots_setup");

    $createTableQuery = "CREATE TABLE IF NOT EXISTS " . $DATE_TABLE . "(
        dummy_id TINYINT UNSIGNED NOT NULL PRIMARY KEY,
        month TINYINT UNSIGNED NOT NULL,
        day TINYINT UNSIGNED NOT NULL,
        day_of_week VARCHAR(10) NOT NULL
        )";
    $common->executeQuery($createTableQuery, "slots_setup");
    initializeDate($common);
}

// Gets the name of the main table
function getMainTableName() {
    global $MAIN_TABLE;
    return $MAIN_TABLE;
}

function getStudentsTableName() {
    global $STUDENTS_TABLE;
    return $STUDENTS_TABLE;
}

// Gets the name of the days table
function getDaysTableName() {
    global $DAYS_TABLE;
    return $DAYS_TABLE;
}

function getDateTableName() {
    global $DATE_TABLE;
    return $DATE_TABLE;
}

function getAppointmentsInDay() {
    global $APPOINTMENTS_IN_DAY;
    return $APPOINTMENTS_IN_DAY;
}

function getNumberOfDays()
{
    global $NUMBER_DAYS;
    return $NUMBER_DAYS;
}

function getNumStudentsPerSlot() {
    global $NUM_STUDENTS_PER_SLOT;
    return $NUM_STUDENTS_PER_SLOT;
}

// Gets the name of the slots table
function getSlotsTableName() {
    global $SLOTS_TABLE;
    return $SLOTS_TABLE;
}

function initializeDate($common) {
    global $DATE_TABLE, $START_MONTH, $START_DAY, $START_DAY_OF_WEEK;

    $query = "INSERT INTO $DATE_TABLE (dummy_id, month, day, day_of_week) VALUES (1, $START_MONTH, $START_DAY, '$START_DAY_OF_WEEK')";
    mysql_query($query, $common->conn);
}

function getDateFromTable($common) {
    global $DATE_TABLE;

    $query = "SELECT * FROM $DATE_TABLE WHERE dummy_id = 1";
    $rs = $common->executeQuery($query, "get_date");
    $row = mysql_fetch_array($rs);
    $month = $row['month'];
    $day = $row['day'];
    $dayOfWeek = $row['day_of_week'];

    return new Date($month, $day, $dayOfWeek);
}

function updateDateInTable($date, $common) {
    global $DATE_TABLE;

    if (rowExists($common, $DATE_TABLE, "dummy_id", 1)) {
        $query = "UPDATE $DATE_TABLE SET month = $date->month, day = $date->day, day_of_week = '$date->dayOfWeek' WHERE dummy_id = 1";
    } else {
        $query = "INSERT INTO $DATE_TABLE (dummy_id, month, day, day_of_week) VALUES (1, $date->month, $date->day, '$date->dayOfWeek')";
    }
    $common->executeQuery($query, "update_date");
}

// Checks if a row exists in a given table
function rowExists($common, $table, $field, $value) {
    $query = "SELECT * FROM " . $table . " WHERE " . $field . " = '" . $value . "' LIMIT 1";
    $rs = $common->executeQuery($query, "row_exists");
    while($row = mysql_fetch_array($rs)) {
        return true;
    }
    return false;
}

// Sets up the row for a specific adviser.
// DOES NOT CHECK IF ROW ALREADY EXISTS - you must do that before calling this function, or it may fail and crash
function setupRowForAdviser($common, $mainTable, $daysTable, $adviser_id, $adviser_name) {
    $query = "INSERT INTO $mainTable (adviser_id, adviser_name";
    for ($i = 1; $i <= getNumberOfDays(); $i++) {
        $query .= ", day$i";
    }
    ") VALUES ('$adviser_id', '$adviser_name'";
    for ($i = 1; $i <= getNumberOfDays(); $i++) {
        $dayID = setupRowForDay($common, $daysTable, getSlotsTableName());
        $query .= ", $dayID";
    }
    $query .= ")";
    $common->executeQuery($query, "get_day");
}


// Sets up the row for a day.
// Returns the day_id
function setupRowForDay($common, $daysTable, $slotsTable) {
    $query = "INSERT INTO $daysTable (";
    for ($i = 1; $i <= getAppointmentsInDay(); $i++) {
        if ($i > 1) {
            $query .= ", ";
        }
        $query .= "slot$i";
    }
    ") VALUES (";
    for ($i = 1; $i <= getAppointmentsInDay(); $i++) {
        $slotQuery = "INSERT INTO " . $slotsTable . " (type) VALUES ('N')";
        $common->executeQuery($slotQuery, "init_slots");
        $slotID = mysql_insert_id();
        if ($i != 1) {
            $query .= ", ";
        }
        $query .= $slotID;
    }
    $query .= ")";
    $common->executeQuery($query, "get_day");
    $dayID = mysql_insert_id();
    return $dayID;
}
