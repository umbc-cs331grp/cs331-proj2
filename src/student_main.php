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
                include_once("tables.php");



                //Declarations and Such

                $name = @($_POST['name']);
                $studentID = @($_POST['studentID']);
                $major = @($_POST['major']);
                $apptType = @($_POST['apptType']);

                $common = new common($debug);


                if (!rowExists($common, getStudentsTableName(), "student_id", $studentID))
                {
                    $query = "INSERT INTO " . getStudentsTableName() . "(student_id, student_name, student_major, appointment_id) VALUES ('" . $studentID . "', '" . $name . "', '" . $major . "', 'NONE')";
                    $common->executeQuery($query,"student_insertion");
                }

                //See Whether the Student has an appointment
                $query = "SELECT appointment_id FROM " . getStudentsTableName() . " WHERE student_id = '$studentID'";
                $rs = $common->executeQuery($query,"Get_Appointment_Status");
                $data = mysql_fetch_row($rs);
                $apptID = $data[0];




                if($apptID == "NONE") //If no appointment, display various filters to find open appointments.
                {

                    $query = "SELECT adviser_id, adviser_name FROM " . getMainTableName();
                    //echo($query);
                    $rs = $common->executeQuery($query, "get_adviser_names");

                    echo("<form action = '' method='post' id = 'getAppts'>");
                    echo("Advisor Selection <br>");
                    echo("<select name = 'adviserList' form='getAppts'>");
                    echo("<option value='Any'>Any</option>");
                    while($row = mysql_fetch_array($rs, MYSQL_NUM))
                    {
                        echo("<option value=$row[0]> $row[1] </option>");
                    }
                    echo("</select>");

                    echo(" <br> Time Selection </br> <select name = 'timeList' form='getAppts'>");
                    echo("<option value='Any'>Any</option>");
                    echo("<option value='1'>9:00 AM   - 9:30 AM</option>");
                    echo("<option value='2'>9:30 AM - 10:00 AM</option>");
                    echo("<option value='3'>10:00 AM - 10:30 AM </option>");
                    echo("<option value='4'>10:30 AM - 11:00 AM </option>");
                    echo("<option value='5'>11:00 AM - 11:30 AM </option>");
                    echo("<option value='6'>11:30 AM - 12:00 PM </option>");
                    echo("<option value='7'>12:00 PM - 12:30 PM </option>");
                    echo("<option value='8'>12:30 PM - 1:00 PM </option>");
                    echo("<option value='9'>1:00 PM - 1:30 PM </option>");
                    echo("<option value='10'>1:30 PM - 2:00 PM </option>");
                    echo("<option value='11'>2:00 PM - 2:30 PM</option>");
                    echo("<option value='12'>2:30 PM - 3:00 PM </option>");
                    echo("<option value='13'>3:00 PM - 3:30 PM </option>");
                    echo("<option value='14'>3:30 PM - 4:00 PM </option>");
                    echo("</select>");

                    echo(" <br> Date Selection </br> <select name = 'dateList' form='getAppts'>");
                    echo("<option value='Any'>Any</option>");
                    $today = getDateFromTable($common);
                    for($i = 1; $i <= getNumberOfDays(); $i++ )
                    {
                        $todayS = $today->toString();
                        echo($todayS);
                        echo("<option value=$i>$todayS</option>");
                        $today = $today->IncrementDay();
                    }
                    echo("<input type = 'hidden' name='name' value='$name'</input>");
                    echo("<input type = 'hidden' name='major' value='$major'</input>");
                    echo("<input type = 'hidden' name='studentID' value='$studentID'</input>");

                    echo("<br> <br>");
                    echo ("<input type = 'radio' name = 'apptType' value='I' required='required' checked= 'checked'> Individual </input>");
                    echo ("<input type = 'radio' name = 'apptType' value='G' required='required'> Group </input>");
                    echo("</select>");
                    echo("<br><input type='submit' value='Search' name='submit' class='btn btn-default'>");
                    echo("</form>");
                }
                else //if they already have an appointment, display options to cancel appointment.
                {
                    /*
                    $query = "SELECT * FROM " . getStudentsTableName() . " WHERE student_id ='" . $studentID . "'" ;
                    $rs = $common -> executeQuery($query, "Get_Student_Info");
                    */
                    echo("Delete Functionality in Progress");

                }

                if(isset($_POST['submit']) and !isset($_POST['Schedule'])) {
                    //declarations
                    $adviser = @($_POST['adviserList']);
                    $slot = @($_POST['timeList']);
                    $date = @($_POST['dateList']);
                    $type = @($_POST['apptType']);
                    $major = @($_POST['major']);
                    $name = @($_POST['name']);
                    $studentID = @($_POST['studentID']);

                    echo("<br>");

                    $maxDay = $minDay = 0;
                    if ($date != "Any") {
                        $maxDay = $minDay = $date;
                    } else {
                        $maxDay = 10;
                        $minDay = 1;
                    }

                    $maxSlot = $minSlot = 0;
                    if ($slot != "Any") {
                        $maxSlot = $minSlot = $slot;
                    } else {
                        $maxSlot = 14;
                        $minSlot = 1;

                    }

                    //Create Main Table Query
                    $query = "SELECT adviser_num, adviser_name";
                    for ($i = $minDay; $i <= $maxDay; $i++) {
                        $query = $query . ", day" . $i . " ";
                    }
                    $query = $query . " FROM " . getMainTableName();
                    if ($adviser != "Any")
                        $query = $query . " WHERE adviser_id = '" . $adviser . "'";
                    echo("<table border='1' style='width:50%'>");
                    echo("<tr>");
                    echo("<th><center>Schedule</center></th>");
                    echo("<th>Date</th>");
                    echo("<th>Time</th>");
                    echo("<th>Advisor</th>");
                    echo("</tr>");
                    echo("<form name = 'selectAppointment' action='register_appointment.php' method='post' id='scheduleAppts'>");
                    //loop through all selected rows in main table
                    $adviserResult = $common->executeQuery($query, "get_adviserList");
                    while ($adviserRow = mysql_fetch_array($adviserResult, MYSQL_ASSOC)) {

                        $adviserName = $adviserRow['adviser_name']; //Used For Displaying Adviser Name to user
                        $adviserNum = $adviserRow['adviser_num'] - 1; //Used For Algorithm Calculation

                        //make an array of all the Day IDs for that advisor
                        $dayIDs = array();
                        for ($i = $minDay + ($adviserNum * getNumberOfDays()); $i <= $maxDay + ($adviserNum * getNumberOfDays()); ++$i) {
                            array_push($dayIDs, $i);
                        }


                        //Create Slot Query
                        $query = "SELECT day_id ";
                        for ($j = $minSlot; $j <= $maxSlot; $j++) {
                            $query = $query . ", slot" . $j . " ";
                        }
                        $query = $query . "FROM " . getDaysTableName();
                        $query = $query . " WHERE day_id IN (" . implode($dayIDs, ',') . ' )';

                        //loop through all select rows in Day Table
                        $slotRS = $common->executeQuery($query, "Get Slots");
                        while ($slotRow = mysql_fetch_array($slotRS, MYSQL_ASSOC)) {

                            $appointmentDay = $slotRow['day_id'] - ($adviserNum * 10); //Used For Displaying Day to User
                            $dayColumn = $slotRow['day_id'] - 1; //Used For Algorithm Calculation

                            //get formatted Date
                            $today = getDateFromTable($common);
                            for ($i = 1; $i < $appointmentDay; $i++) {
                                $today = $today->IncrementDay();
                            }
                            $appointmentDayS = $today->toString();

                            //Make an Array of all the slot IDs for that day
                            $slotIDs = array();
                            for ($j = $minSlot + ($dayColumn * getAppointMentsInDay()); $j <= $maxSlot + ($dayColumn * getAppointmentsInDay()); $j++) {
                                array_push($slotIDs, $j);
                            }


                            //Created Appointment Query

                            $query = "SELECT * FROM " . getSlotsTableName() . " WHERE (type = '" . $type . "') AND (slot_id IN (" . implode($slotIDs, ',') . ") AND ( (major = '" . $major . "') OR (major is NULL) )) ";
                            $appointmentRS = $common->executeQuery($query, "Get Appointments");
                            while ($appointmentRow = mysql_fetch_array($appointmentRS, MYSQL_ASSOC)) {

                                if($type = 'G')
                                {
                                    //find an open slot
                                    $insertSlot = "student";
                                    for ($k = 1; $k <= $appointmentRow['group_size']; $k++)
                                    {
                                        if ($appointmentRow[$insertSlot . $k] != 'NULL')
                                        {
                                            $insertSlot = $insertSlot . $k;
                                            break;
                                        }
                                    }
                                }

                                if($type = 'I')
                                {
                                    //see if the first slot isn't filled
                                    $studentSlot = "student";
                                    if($appointmentRow['student1'] != 'NULL')
                                        $studentSlot = "Okay";
                                }

                                //Display a radio button allowing the student to select that appointment
                                if ($insertSlot != "student") {
                                    $slotID = $appointmentRow['slot_id'];
                                    $timeS = printDate($slotID, $dayColumn);
                                    echo("<tr>");
                                    echo("<td align = 'center' td width='50%'><input type='radio' name='apptSelect' value='$slotID,$appointmentDayS,$timeS,$adviserName,$insertSlot'>");
                                    echo("<input type='hidden' name='name' class='form-control' value='$name'>");
                                    echo("<td>$appointmentDayS</td>");
                                    echo("<td>$timeS</td>");
                                    echo("<td>$adviserName</td>");
                                    echo("</tr>");


                                }


                            }

                        }

                    }
                    echo("</table>");
                    echo("<br>");

                    echo("<input type='hidden' name='name' class='form-control' value='$name'>");
                    echo("<input type='hidden' name='studentID' class='form-control' value='$studentID'>");
                    echo("<input type='submit' value='schedule' class='btn btn-default'>");
                    echo("</form> <br>");
                }



                function printDate($slotID, $dayID)
                {
                    $switchVal = $slotID - ($dayID * getAppointmentsInDay());
                    {
                        switch  ($switchVal){
                            case 1:
                                return "9:00 AM - 9:30 AM";
                                break;
                            case 2:
                                return "9:30 AM - 10:00 AM";
                                break;
                            case 3:
                                return "10:00 AM - 10:30 AM";
                                break;
                            case 4:
                                return "10:30 AM - 11:00 AM";
                                break;
                            case 5:
                                return "11:00 AM - 11:30 AM";
                                break;
                            case 6:
                                return "11:30 AM - 12:00 AM";
                                break;
                            case 7:
                                return "12:00 PM - 12:30 PM";
                                break;
                            case 8:
                                return "12:30 PM -1:00 PM";
                                break;
                            case 9:
                                return "1:00 PM  - 1:30 PM";
                                break;
                            case 10:
                                return "1:30 PM  - 2:00 PM";
                                break;
                            case 11:
                                return "2:00 PM  - 2:30 PM";
                                break;
                            case 12:
                                return "2:30 PM  - 3:00 PM";
                                break;
                            case 13:
                                return "3:00 PM  - 3:30 PM";
                                break;
                            case 14:
                                return "3:30 PM - 4:00 PM";
                                break;
                        }

                    }

                }

                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>