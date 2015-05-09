<?php
include_once("tables.php");
$common = new Common(false);

$query = "SELECT day1 FROM " . getMainTableName();

$rsMain = $common->executeQuery($query, "get_main");
while($mainRow = mysql_fetch_array($rsMain, MYSQL_ASSOC))
{
$dayQuery = "SELECT slot1, slot2, slot3, slot4, slot5, slot6, slot7,
                             slot8, slot9, slot10, slot11, slot12, slot13, slot14, weekly FROM " . getDaysTableName()
                          . " WHERE day_id =". $mainRow['day1'];
        $rsDay = $common->executeQuery($dayQuery, "get_day");

        while($dayRow = mysql_fetch_array($rsDay, MYSQL_ASSOC))
        {
            $slotQuery = "SELECT * FROM " . getSlotsTableName() . " WHERE slot_id IN (" . $dayRow['slot1'] . ", " . $dayRow['slot2'] . ", " . $dayRow['slot3'] . ", " . $dayRow['slot3'] . ", " . $dayRow['slot4'] . ", " . $dayRow['slot5'] . ", " . $dayRow['slot6'] . ", " . $dayRow['slot7'] . ", " . $dayRow['slot8'] . ", " . $dayRow['slot9'] . ", " . $dayRow['slot10'] . ", " . $dayRow['slot11'] . ", " . $dayRow['slot12'] . ", " . $dayRow['slot13'] . ", " . $dayRow['slot14'] . ")";
            $slotRS = $common->executeQuery($slotQuery, "get_slots");
            
            while($slotRow = mysql_fetch_Array($slotRS, MYSQL_ASSOC))
            {
                $weekly = $dayRow['weekly'];
               if($weekly == 0)
               {
                $slotRow['group_size'] = 10;
                $slotRow['major'] = NULL;

               $query = "UPDATE " . getSlotsTableName(). " SET " $slotRow['slot_id'];
                $common->executeQuery($query, "setSlots");
               } 


                for($x=1; $x<10; $x++)
                {
                    if(!empty($slotRow["student" .$x]))
                    {
                        $apptQuery = "UPDATE " . getStudentsTableName() . " SET appointment_id=NULL, 
                        appointment_date=NULL, appointment_time=NULL, appointment_adviser=NULL WHERE student_id= '" . $slotRow["student" . $x] ."'";
                        $common->executeQuery($apptQuery, "get_appt");
                   }         
               } 

               $query = "UPDATE " . getSlotsTableName(). " SET student1=NULL, student2=NULL, student3=NULL, student4=NULL, 
               student5=NULL, student6=NULL, student7=NULL, student8=NULL, student9=NULL, student10=NULL 
               WHERE slot_id=" . $slotRow['slot_id'];
                $common->executeQuery($query, "setSlots");
        
            }   
        }
    }    

    $query = "SELECT adviser_id, day1, day2, day3, day4, day5, day6, day7, day8, day9, day10 FROM " . getMainTableName();
    $rsMain = $common->executeQuery($query, "get_days_for_swap");
    while($mainRow = mysql_fetch_array($rsMain, MYSQL_ASSOC))
    {
        $temp = $mainRow['day1'];
        $mainRow['day1'] = $mainRow['day2'];
        $mainRow['day2'] = $mainRow['day3'];
        $mainRow['day3'] = $mainRow['day4'];
        $mainRow['day4'] = $mainRow['day5'];
        $mainRow['day5'] = $mainRow['day6'];
        $mainRow['day6'] = $mainRow['day7'];
        $mainRow['day7'] = $mainRow['day8'];
        $mainRow['day8'] = $mainRow['day9'];
        $mainRow['day9'] = $mainRow['day10'];
        $mainRow['day10'] = $temp;

        $query = "UPDATE " . getMainTableName() . " SET day1=" . $mainRow['day1'] . ", day2=" . $mainRow['day2'] 
        . ", day3=" . $mainRow['day3'] . ", day4=" . $mainRow['day4'] . ", day5=" . $mainRow['day5'] 
        . ", day6=" . $mainRow['day6'] . ", day7=" . $mainRow['day7'] . ", day8=" . $mainRow['day8'] 
        . ", day9=" . $mainRow['day9'] . ", day10=" . $mainRow['day10'] . " WHERE adviser_id='" . $mainRow['adviser_id'] ."'";
        $common->executeQuery($query, "set_day");
    }

    $today = getDateFromTable($common);
    $today = $today->incrementToNextWeekday();
    $query = "UPDATE " . getDateTableName() . " SET month=" . $today->month . ", day=" . $today->day . ", day_of_week='" . $today->dayOfWeek . "' WHERE dummy_id = 1"; 
    $common->executeQuery($query, "update date");

?>