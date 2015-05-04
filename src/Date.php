<?php

class Date {
    var $month;
    var $day;
    var $dayOfWeek;

    function Date($month, $day, $dayOfWeek) {
        $this->month = $month;
        $this->day = $day;
        $this->dayOfWeek = $dayOfWeek;
    }

    function getCopy() {
        return new Date($this->month, $this->day, $this->dayOfWeek);
    }

    function toString() {
        return $this->month . "-" .$this->day;
    }

    function incrementDay() {
        $date = $this->getCopy();

        switch ($date->month) {
            case 3:
                if ($date->day == 31) {
                    $date->day = 1;
                    $date->month = 4;
                } else {
                    $date->day++;
                }
                break;
            case 4:
                if ($date->day == 30) {
                    $date->day = 1;
                    $date->month = 5;
                } else {
                    $date->day++;
                }
                break;
            default:
                $date->day++;
        }

        switch ($date->dayOfWeek) {
            case "Sunday":
                $date->dayOfWeek = "Monday";
                break;
            case "Monday":
                $date->dayOfWeek = "Tuesday";
                break;
            case "Tuesday":
                $date->dayOfWeek = "Wednesday";
                break;
            case "Wednesday":
                $date->dayOfWeek = "Thursday";
                break;
            case "Thursday":
                $date->dayOfWeek = "Friday";
                break;
            case "Friday":
                $date->dayOfWeek = "Saturday";
                break;
            case "Saturday":
                $date->dayOfWeek = "Sunday";
                break;
        }

        return $date;
    }

    function incrementToNextWeekday() {
        $date = $this->getCopy();

        do {
            $date = $date->incrementDay();
        } while (($date->dayOfWeek == "Saturday") || ($date->dayOfWeek == "Sunday"));
    }

    function addDays($days) {
        $date = $this->getCopy();

        for ($i = 0; $i < $days; $i++) {
            $date = $date->incrementDay();
        }

        return $date;
    }

    function getDateOfDay($dayNum) {
        $increment = $dayNum - 1;
        if ($dayNum > 5) {
            $increment += 2;
        }

        return $this->addDays($increment);
    }

    function compare($date) {
        if (($this->month == $date->month) && ($this->day == $date->day)) {
            return 0;
        }
        if (($this->month < $date->month) || (($this->month == $date->month) && ($this->day < $date->day))) {
            return -1;
        }
        return 1;
    }
}