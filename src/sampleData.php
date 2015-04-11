<?php

// Creates sample data for printing schedules
function createSampleData($common)
{
    $tableName = "tbl_advising_main_example";
    $query = "CREATE TABLE IF NOT EXISTS `$tableName` (
  `day` int(4) unsigned NOT NULL,
  `slot1` int(8) NOT NULL,
  `slot2` int(8) NOT NULL,
  `slot3` int(8) NOT NULL,
  `slot4` int(8) NOT NULL,
  `slot5` int(8) NOT NULL,
  `slot6` int(8) NOT NULL,
  `slot7` int(8) NOT NULL,
  `slot8` int(8) NOT NULL,
  `slot9` int(8) NOT NULL,
  `slot10` int(8) NOT NULL,
  `slot11` int(8) NOT NULL,
  `slot12` int(8) NOT NULL,
  `slot13` int(8) NOT NULL,
  `slot14` int(8) NOT NULL,
  PRIMARY KEY (`day`)
)";
    $common->executeQuery($query, "main_sample_create");

    $query = "INSERT INTO `$tableName` (`day`, `slot1`, `slot2`, `slot3`, `slot4`, `slot5`, `slot6`, `slot7`, `slot8`, `slot9`, `slot10`, `slot11`, `slot12`, `slot13`, `slot14`) VALUES
(1, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14),
(2, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28),
(3, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42),
(4, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56),
(5, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70)";
    mysql_query($query, $common->conn);
    //$common->conn($query, "main_sample_data");

    $tableName = "tbl_advising_slots_example";
    $query = "CREATE TABLE IF NOT EXISTS `$tableName` (
  `slot_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `type` char(1) NOT NULL,
  `student1` text NOT NULL,
  `student2` text NOT NULL,
  `student3` text NOT NULL,
  `student4` text NOT NULL,
  `student5` text NOT NULL,
  `student6` text NOT NULL,
  `student7` text NOT NULL,
  `student8` text NOT NULL,
  `student9` text NOT NULL,
  `student10` text NOT NULL,
  PRIMARY KEY (`slot_id`)
)";
    $common->executeQuery($query, "slots_sample_create");

    $query = "INSERT INTO `$tableName` (`slot_id`, `type`, `student1`, `student2`, `student3`, `student4`, `student5`, `student6`, `student7`, `student8`, `student9`, `student10`) VALUES
(1, 'I', '', '', '', '', '', '', '', '', '', ''),
(2, 'I', 'John Doe', '', '', '', '', '', '', '', '', ''),
(3, 'I', 'Richard Roe', '', '', '', '', '', '', '', '', ''),
(4, 'I', 'Jane Doe', '', '', '', '', '', '', '', '', ''),
(5, 'I', '', '', '', '', '', '', '', '', '', ''),
(6, 'I', 'Bobby Tables', '', '', '', '', '', '', '', '', ''),
(7, 'N', '', '', '', '', '', '', '', '', '', ''),
(8, 'N', '', '', '', '', '', '', '', '', '', ''),
(9, 'N', '', '', '', '', '', '', '', '', '', ''),
(10, 'N', '', '', '', '', '', '', '', '', '', ''),
(11, 'G', 'Pace Maybelline', 'Mitch Candice', 'Elnora Marlin', '', '', '', '', '', '', ''),
(12, 'G', 'Elnora Blythe', 'Eliza Blanche', 'Ravenna Erin', 'Annette Israel', 'Olivia Wesley', '', '', '', '', ''),
(13, 'N', '', '', '', '', '', '', '', '', '', ''),
(14, 'N', '', '', '', '', '', '', '', '', '', ''),
(15, 'N', '', '', '', '', '', '', '', '', '', ''),
(16, 'N', '', '', '', '', '', '', '', '', '', ''),
(17, 'N', '', '', '', '', '', '', '', '', '', ''),
(18, 'I', 'Bobby Tables', '', '', '', '', '', '', '', '', ''),
(19, 'I', '', '', '', '', '', '', '', '', '', ''),
(20, 'I', '', '', '', '', '', '', '', '', '', ''),
(21, 'I', 'Ettie Judith', '', '', '', '', '', '', '', '', ''),
(22, 'I', 'Bridget Adolph', '', '', '', '', '', '', '', '', ''),
(23, 'N', '', '', '', '', '', '', '', '', '', ''),
(24, 'N', '', '', '', '', '', '', '', '', '', ''),
(25, 'G', '', '', '', '', '', '', '', '', '', ''),
(26, 'G', 'Laryn Tristram', 'Scott Happy', '', '', '', '', '', '', '', ''),
(27, 'G', 'Lysette Dell', 'Rosabel Jewell', 'Shelley Dollie', 'Darius Lucile', 'Corine Pete', 'Kierra Molly', 'Kaye Lavena', 'Faithe Genesis', 'Leyla Jayne', 'Minty Leroi'),
(28, 'G', 'Jayne Cobb', 'Hoban Washburne', 'Zoe Alleyne Washburne', 'Kaywinnet Lee Frye', '', '', '', '', '', ''),
(29, 'N', '', '', '', '', '', '', '', '', '', ''),
(30, 'N', '', '', '', '', '', '', '', '', '', ''),
(31, 'G', 'Tricia Nena', '', '', '', '', '', '', '', '', ''),
(32, 'G', 'Kynaston Vern', 'Laryn Natille', 'Fannie Bekki', '', '', '', '', '', '', ''),
(33, 'N', '', '', '', '', '', '', '', '', '', ''),
(34, 'N', '', '', '', '', '', '', '', '', '', ''),
(35, 'N', '', '', '', '', '', '', '', '', '', ''),
(36, 'N', '', '', '', '', '', '', '', '', '', ''),
(37, 'I', 'Sandra Amelia', '', '', '', '', '', '', '', '', ''),
(38, 'I', 'Kimberlyn Kinsley', '', '', '', '', '', '', '', '', ''),
(39, 'I', '', '', '', '', '', '', '', '', '', ''),
(40, 'I', 'Emil Carson', '', '', '', '', '', '', '', '', ''),
(41, 'G', '', '', '', '', '', '', '', '', '', ''),
(42, 'G', 'Grace Dax', 'Kallie Maria', '', '', '', '', '', '', '', ''),
(43, 'N', '', '', '', '', '', '', '', '', '', ''),
(44, 'N', '', '', '', '', '', '', '', '', '', ''),
(45, 'I', 'Samantha Lamont', '', '', '', '', '', '', '', '', ''),
(46, 'I', 'Evalyn Kerensa', '', '', '', '', '', '', '', '', ''),
(47, 'N', '', '', '', '', '', '', '', '', '', ''),
(48, 'N', '', '', '', '', '', '', '', '', '', ''),
(49, 'N', '', '', '', '', '', '', '', '', '', ''),
(50, 'N', '', '', '', '', '', '', '', '', '', ''),
(51, 'N', '', '', '', '', '', '', '', '', '', ''),
(52, 'N', '', '', '', '', '', '', '', '', '', ''),
(53, 'N', '', '', '', '', '', '', '', '', '', ''),
(54, 'N', '', '', '', '', '', '', '', '', '', ''),
(55, 'N', '', '', '', '', '', '', '', '', '', ''),
(56, 'N', '', '', '', '', '', '', '', '', '', ''),
(57, 'N', '', '', '', '', '', '', '', '', '', ''),
(58, 'N', '', '', '', '', '', '', '', '', '', ''),
(59, 'N', '', '', '', '', '', '', '', '', '', ''),
(60, 'N', '', '', '', '', '', '', '', '', '', ''),
(61, 'G', 'Antonia Cara', 'Lincoln Janae', 'Nigel Van', 'Saranna Louise', 'Peggie Dona', 'Leila Patrice', 'George Zavanna', '', '', ''),
(62, 'G', 'Maude Daria', 'Sophie Rian', 'Zelda Kiarra', 'Elfrida Kenny', 'Twila Erykah', 'Gracelyn Fallon', '', '', '', ''),
(63, 'G', 'Lyndon Alexa', 'Brenna Kyrsten', '', '', '', '', '', '', '', ''),
(64, 'N', '', '', '', '', '', '', '', '', '', ''),
(65, 'N', '', '', '', '', '', '', '', '', '', ''),
(66, 'I', 'Brady Kiefer', '', '', '', '', '', '', '', '', ''),
(67, 'I', '', '', '', '', '', '', '', '', '', ''),
(68, 'N', '', '', '', '', '', '', '', '', '', ''),
(69, 'I', 'Kassidy Daffodil', '', '', '', '', '', '', '', '', ''),
(70, 'I', 'Harold Hill', '', '', '', '', '', '', '', '', '')";
    mysql_query($query, $common->conn);
    //$common->executeQuery($query, "slots_sample_data");
}