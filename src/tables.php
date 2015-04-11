<?php

include_once("CommonMethods.php");

$MAIN_TABLE = "tbl_advising_main";
$DAYS_TABLE = "tbl_advising_days";
$SLOTS_TABLE = "tbl_advising_slots";

// Creates the 3 tables
function createTables($debug) {
    global $MAIN_TABLE, $DAYS_TABLE, $SLOTS_TABLE;

    $common = new Common($debug);

    $createTableQuery = "CREATE TABLE IF NOT EXISTS " . $MAIN_TABLE . "(
        adviser_id VARCHAR(10) NOT NULL PRIMARY KEY,
        adviser_name TEXT NOT NULL,
        day1 INT(8) NOT NULL,
        day2 INT(8) NOT NULL,
        day3 INT(8) NOT NULL,
        day4 INT(8) NOT NULL,
        day5 INT(8) NOT NULL,
        day6 INT(8) NOT NULL,
        day7 INT(8) NOT NULL,
        day8 INT(8) NOT NULL,
        day9 INT(8) NOT NULL,
        day10 INT(8) NOT NULL
        )";
    $common->executeQuery($createTableQuery, "main_setup");

    $createTableQuery = "CREATE TABLE IF NOT EXISTS " . $DAYS_TABLE . "(
        day_id INT(4) UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
        slot1 INT(8) NOT NULL,
        slot2 INT(8) NOT NULL,
        slot3 INT(8) NOT NULL,
        slot4 INT(8) NOT NULL,
        slot5 INT(8) NOT NULL,
        slot6 INT(8) NOT NULL,
        slot7 INT(8) NOT NULL,
        slot8 INT(8) NOT NULL,
        slot9 INT(8) NOT NULL,
        slot10 INT(8) NOT NULL,
        slot11 INT(8) NOT NULL,
        slot12 INT(8) NOT NULL,
        slot13 INT(8) NOT NULL,
        slot14 INT(8) NOT NULL
        )";
    $common->executeQuery($createTableQuery, "days_setup");

    $createTableQuery = "CREATE TABLE IF NOT EXISTS " . $SLOTS_TABLE . "(
        slot_id INT(8) UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
        type CHAR NOT NULL,
        student1 TEXT,
        student2 TEXT,
        student3 TEXT,
        student4 TEXT,
        student5 TEXT,
        student6 TEXT,
        student7 TEXT,
        student8 TEXT,
        student9 TEXT,
        student10 TEXT
        )";
    $common->executeQuery($createTableQuery, "slots_setup");
}

// Gets the name of the main table
function getMainTableName() {
    global $MAIN_TABLE;
    return $MAIN_TABLE;
}

// Gets the name of the days table
function getDaysTableName() {
    global $DAYS_TABLE;
    return $DAYS_TABLE;
}

// Gets the name of the slots table
function getSlotsTableName() {
    global $SLOTS_TABLE;
    return $SLOTS_TABLE;
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
    $query = "INSERT INTO " . $mainTable .
        " (adviser_id, adviser_name, day1, day2, day3, day4, day5, day6, day7,
        day8, day9, day10)
        VALUES ('" . $adviser_id . "', '" . $adviser_name . "'";
    for ($i = 1; $i <= 10; $i++) {
        $dayID = setupRowForDay($common, $daysTable, getSlotsTableName());
        $query .= ", $dayID";
    }
    $query .= ")";
    $common->executeQuery($query, "get_day");
}


// Sets up the row for a day.
// Returns the day_id
function setupRowForDay($common, $daysTable, $slotsTable) {
    $query = "INSERT INTO " . $daysTable .
        " (slot1, slot2, slot3, slot4, slot5, slot6, slot7,
        slot8, slot9, slot10, slot11, slot12, slot13, slot14)
        VALUES (";
    for ($i = 1; $i <= 14; $i++) {
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
