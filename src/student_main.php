<?php
$firstName = $_POST['first-name'];
if(empty($firstName))
{
    header('Location: Student_login.html');
    exit();
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
        <div class="col-md-3">
        </div>
        <div class="col-md-6">
            <div id="box">

                <?php
                include_once("tables.php");



                //Declarations and Such

                $firstName = @($_POST['first-name']);
                $lastName = @($_POST['last-name']);
                $studentID = strtoupper(@($_POST['studentID']));
                $major = @($_POST['major']);
                $apptType = @($_POST['apptType']);

                $common = new common($debug);

                if (!empty($_POST['initial-signup'])) {
                    $firstName = mysql_real_escape_string(htmlspecialchars($firstName), $common->conn);
                    $lastName = mysql_real_escape_string(htmlspecialchars($lastName), $common->conn);
                    $studentID = mysql_real_escape_string(htmlspecialchars($studentID), $common->conn);
                }



                $appointmentFound = false; //used at the very end to determine if we should show the schedule button

                if (!rowExists($common, getStudentsTableName(), "student_id", $studentID))
                {
                    $query = "INSERT INTO " . getStudentsTableName() . "(student_id, student_first_name, student_last_name, student_major) VALUES ('$studentID', '$firstName', '$lastName', '$major')";
                    $common->executeQuery($query,"student_insertion");
                }

                //See Whether the Student has an appointment
                $query = "SELECT appointment_id FROM " . getStudentsTableName() . " WHERE student_id = '$studentID'";
                $rs = $common->executeQuery($query,"Get_Appointment_Status");
                $data = mysql_fetch_array($rs,MYSQL_ASSOC);
                $apptID = $data['appointment_id'];





                if(empty($apptID)) //If no appointment, display various filters to find open appointments.
                {

                    $query = "SELECT adviser_id, adviser_name FROM " . getMainTableName();
                    //echo($query);
                    $rs = $common->executeQuery($query, "get_adviser_names");
                    echo("<table class='center'>");
                    echo("<tr> <td>");
                    echo("<form action = '' method='post' id = 'getAppts'>");
                    echo("<b>Advisor Selection</b><br>");
                    echo("<select name = 'adviserList' form='getAppts' class='form-control'>");
                    echo("<option value='Any'>Any</option>");
                    while($row = mysql_fetch_array($rs, MYSQL_NUM))
                    {
                        echo("<option value=$row[0]> $row[1] </option>");
                    }
                    echo("</tr> </td>");
                    echo("</select>");

                    echo("<tr> <td>");
                    echo(" <br><b> Time Selection</b> </br> <select name = 'timeList' form='getAppts' class='form-control'>");
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
                    echo("</tr> </td>");

                    echo("<tr> <td>");
                    echo(" <br><b>Date Selection</b> </br> <select name = 'dateList' form='getAppts' class='form-control'>");
                    echo("<option value='Any'>Any</option>");
                    $today = getDateFromTable($common);
                    for($i = 1; $i <= getNumberOfDays(); $i++ )
                    {
                        $todayS = $today->toStringWithWeekday();
                        echo($todayS);
                        echo("<option value=$i>$todayS</option>");
                        $today = $today->incrementToNextWeekday();

                    }
                    echo("</select>");
                    echo("</tr> </td>");

                    echo("<input type = 'hidden' name='first-name' value='$firstName'</input>");
                    echo("<input type = 'hidden' name='last-name' value='$lastName'</input>");
                    echo("<input type = 'hidden' name='major' value='$major'</input>");
                    echo("<input type = 'hidden' name='studentID' value='$studentID'</input>");

                    echo("<tr> <td>");
                    echo("<br> Appointment Type: <br>");
                    //ensure the users selection is retained on hitting search
                    if(empty($apptType))
                    {
                        echo ("<input type = 'radio' name = 'apptType' value='I' required='required'> Individual </input>");
                        echo ("<input type = 'radio' name = 'apptType' value='G' required='required'> Group </input>");
                    }
                    else if($apptType == 'I' )
                    {
                        echo ("<input type = 'radio' name = 'apptType' value='I' required='required' checked= 'checked'> Individual </input>");
                        echo ("<input type = 'radio' name = 'apptType' value='G' required='required'> Group </input>");
                    }
                    else if($apptType == 'G')
                    {
                        echo ("<input type = 'radio' name = 'apptType' value='I' required='required'> Individual </input>");
                        echo ("<input type = 'radio' name = 'apptType' value='G' required='required' checked='checked'> Group </input>");
                    }
                    echo("</tr> </td>");

                    echo("<tr> <td>");
                    echo("<br><input type='submit' value='Search' name='submit' class='btn btn-default center-block'>");
                    echo("</tr> </td>");
                    echo("</form>");
                    echo("</table>");
                }
                else //if they already have an appointment, display options to cancel appointment.
                {

                    $query = "SELECT * FROM " . getStudentsTableName() . " WHERE student_id ='" . $studentID . "'" ;
                    $rs = $common -> executeQuery($query, "Get_Student_Info");
                    $studentRow = mysql_Fetch_array($rs, MYSQL_ASSOC);
                    $date =  $studentRow['appointment_date'];
                    $time =  $studentRow['appointment_time'];
                    $adviser =  $studentRow['appointment_adviser'];
                    $slotID =  $studentRow['appointment_id'];
                    echo("<b>You are currently registered for the following appointment:</b> <br> ");
                    echo("<br> <b>Date:</b> " .  $date . "<br> <b>Time:</b> "  . $time .  "<br> <b>Adviser:</b> " . $adviser . "<br>");
                    //echo("<br> Would you like to cancel your Appointment? ");
                    echo("<form action='cancel_appointment.php' method='post'>");
                    echo("<input type = 'hidden' name='studentID' value='$studentID'</input>");
                    echo("<input type = 'hidden' name='slotID' value='$slotID'</input>");
                    echo("<br> <input type='submit' value='Cancel Appointment' name='submit' class='btn btn-danger center-block'>");
                    echo("</form>");
                    echo("<form action='Student_login.html'>");
                    echo("<br> <input type='submit' value='Return To Login' name='submitLogin' class='btn btn-default center-block'>");
                    echo("</form>");


                }


                if(isset($_POST['submit']) and !isset($_POST['Schedule'])) {
                    //declarations
                    $adviser = @($_POST['adviserList']);
                    $slot = @($_POST['timeList']);
                    $date = @($_POST['dateList']);
                    $type = @($_POST['apptType']);
                    $major = @($_POST['major']);
                    $firstName = @($_POST['first-name']);
                    $lastName = @($_POST['last-name']);
                    $studentID = @($_POST['studentID']);

                    echo("<br>");

                    $maxDay = $minDay = 0;
                    if ($date != "Any") {
                        $maxDay = $minDay = $date;
                    } else {
                        $maxDay = getNumberOfDays();
                        $minDay = 1;
                    }

                    $maxSlot = $minSlot = 0;
                    if ($slot != "Any") {
                        $maxSlot = $minSlot = $slot;
                    } else {
                        $maxSlot = getAppointmentsInDay();
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
                    echo("<table border='1' class='table table-bordered' style='width:50%  background-color:#fff'>");
                    echo("<tr>");
                    echo("<th>Schedule</th>");
                    echo("<th>Date</th>");
                    echo("<th>Time</th>");
                    echo("<th>Advisor</th>");
                    echo("</tr>");
                    echo("<form name = 'selectAppointment' action='register_appointment.php' method='post' id='scheduleAppts'>");
                    //loop through all selected rows in main table
                    $adviserResult = $common->executeQuery($query, "get_adviserList");
                    while ($adviserRow = mysql_fetch_array($adviserResult, MYSQL_ASSOC))
                    {
                        $adviserName = $adviserRow['adviser_name']; //Used For Displaying Adviser Name to user
                        $adviserNum = $adviserRow['adviser_num'] - 1; //Used For Algorithm Calculation

                        //make an array of all the Day IDs for that advisor
                        $dayIDs = array();
                        for ($i = $minDay + ($adviserNum * getNumberOfDays()); $i <= $maxDay + ($adviserNum * getNumberOfDays()); ++$i)
                        {
                            array_push($dayIDs, $i);
                        }


                        //Create Slot Query
                        $query = "SELECT day_id ";
                        for ($j = $minSlot; $j <= $maxSlot; $j++)
                        {
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
                            for ($i = 1; $i < $appointmentDay; $i++)
                                $today = $today->incrementToNextWeekday();


                            $appointmentDayS = $today->toStringWithWeekday();
                            $appointmentDayP = $today->toString();
                            //Make an Array of all the slot IDs for that day
                            $slotIDs = array();
                            for ($l = $minSlot + ($dayColumn * getAppointMentsInDay()); $l <= $maxSlot + ($dayColumn * getAppointmentsInDay()); $l++) {
                                array_push($slotIDs, $l);
                            }


                            //Created Appointment Query

                            $query = "SELECT * FROM " . getSlotsTableName() . " WHERE (type = '" . $type . "') AND (slot_id IN (" . implode($slotIDs, ',') . ") AND ( (major = '" . $major . "') OR (major is NULL) )) ";
                            $appointmentRS = $common->executeQuery($query, "Get Appointments");
                            while ($appointmentRow = mysql_fetch_array($appointmentRS, MYSQL_ASSOC)) {
                                $insertSlot = "student";
                                if($type == 'G')
                                {

                                    //find an open slot

                                    for ($k = 1; $k <= $appointmentRow['group_size']; $k++)
                                    {
                                        if (empty($appointmentRow[$insertSlot . $k]))
                                        {
                                            $insertSlot = $insertSlot . $k;
                                            break;
                                        }
                                    }
                                }
                                else if($type == 'I')
                                {
                                    //see if the first slot isn't filled
                                    if(empty($appointmentRow['student1']))
                                        $insertSlot = "student1";
                                }

                                //Display a radio button allowing the student to select that appointment
                                if ($insertSlot != "student") {
                                    $slotID = $appointmentRow['slot_id'];
                                    $timeS = printTime($slotID, $dayColumn);
                                    $appointmentFound = true;
                                    echo("<tr>");
                                    echo("<td align = 'center' width='25%'><input type='radio' name='apptSelect' required='required' value='$slotID,$appointmentDayP,$timeS,$adviserName,$insertSlot'>");
                                    echo("<input type='hidden' name='first-name' class='form-control' value='$firstName'>");
                                    echo("<input type='hidden' name='last-name' class='form-control' value='$lastName'>");
                                    echo("<td>$appointmentDayS</td>");
                                    echo("<td>$timeS</td>");
                                    echo("<td>$adviserName</td>");
                                    echo("</tr>");


                                }


                            }

                        }

                    }
                    echo("</table>");


                    echo("<input type='hidden' name='first-name' class='form-control' value='$firstName'>");
                    echo("<input type='hidden' name='last-name' class='form-control' value='$lastName'>");
                    echo("<input type='hidden' name='studentID' class='form-control' value='$studentID'>");
                    if($appointmentFound)
                        echo("<input type='submit' value='Schedule' class='btn btn-success center-block' style='center'>");
                    else
                        echo("No appointments found matching your search paramaters, try again.");
                    echo("</form> <br>");
                }



                function printTime($slotID, $dayID)
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
        <div class="col-md-3">
        </div>
    </div>


</div>
</body>
</html>