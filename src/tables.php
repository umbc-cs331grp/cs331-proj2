<?php

include_once("CommonMethods.php");

// Creates the 2 tables for a given user
function createTables($username, $debug) {
    $tableName = getMainName($username);
    $common = new Common($debug);
    $createTableQuery = "CREATE TABLE IF NOT EXISTS " . $tableName . "(
        day INT(4) UNSIGNED NOT NULL PRIMARY KEY,
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
    $common->executeQuery($createTableQuery, "main_setup");

    $tableName = getSlotsName($username);
    $createTableQuery = "CREATE TABLE IF NOT EXISTS " . $tableName . "(
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

// Gets the name of the main table based on username
function getMainName($username) {
    return "tbl_" . $username . "_advising_main";
}

// Gets the name of the slots table based on username
function getSlotsName($username) {
    return "tbl_" . $username . "_advising_slots";
}

// Checks if a row exists in a given table
function rowExists($common, $table, $field, $value) {
    $query = "SELECT 1 FROM " . $table . " WHERE " . $field . " = " . $value;
    $rs = $common->executeQuery($query, "row_exists");
    while($row = mysql_fetch_array($rs)) {
        return true;
    }
    return false;
}

// Sets up the row for a specific day.
// DOES NOT CHECK IF ROW ALREADY EXISTS - you must do that before calling this function, or it may fail and crash
function setupRowForDay($common, $mainTable, $slotsTable, $dayNum) {
    $query = "INSERT INTO " . $mainTable .
        " (day, slot1, slot2, slot3, slot4, slot5, slot6, slot7,
        slot8, slot9, slot10, slot11, slot12, slot13, slot14)
        VALUES (" . $dayNum;
    for ($i = 1; $i <= 14; $i++) {
        $slotQuery = "INSERT INTO " . $slotsTable . " (type) VALUES ('N')";
        $common->executeQuery($slotQuery, "init_slots");
        $slotID = mysql_insert_id();
        $query .= ", $slotID";
    }
    $query .= ")";
    $common->executeQuery($query, "get_day");
}
