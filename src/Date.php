<?php

class Date {
    var $month;
    var $day;

    function Date($month, $day) {
        $this->month = $month;
        $this->day = $day;
    }

    function getCopy() {
        return new Date($this->month, $this->day);
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

        return $date;
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
}