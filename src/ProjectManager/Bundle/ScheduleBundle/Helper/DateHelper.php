<?php

namespace ProjectManager\Bundle\ScheduleBundle\Helper;


class DateHelper
{
    const SUNDAY = 0;
    const SATURDAY = 6;

    private $firstWeekday;
    private $nonWorkingDays;
    private $displayNonWorkingDays;

    public function __construct($firstWeekday, $nonWorkingDays, $displayNonWorkingDays)
    {
        $this->firstWeekday = $firstWeekday;
        $this->nonWorkingDays = $nonWorkingDays;
        $this->displayNonWorkingDays = $displayNonWorkingDays;
    }

    private function getDayInfoInWeek($dayNum, $firstDay, $firstDayNum)
    {
        $diffWithFirstDay = $dayNum - $firstDayNum;
        $dayAdded = 0;
        // If we just apply the diff between $dayNum and $firstDayNum, the last days in the calendar
        // will be before the first day. We have to add a week in this case to make sure that the week is correct
        if ($diffWithFirstDay < 0) {
            $diffWithFirstDay += 7;
            $dayAdded = 7;
        }
        $workingDay = true;
        if(in_array($dayNum, $this->nonWorkingDays)) {
            $workingDay = false;
        }

        return array(
            'day_number' => $dayNum,
            'date' => date('Y-m-d',strtotime("+".$diffWithFirstDay." days", strtotime($firstDay))),
            'day_added' => $dayAdded,
            'working_day' => $workingDay,
        );
    }

    private function isDayDisplayable($dayNumber)
    {
        // A displayable day is a working day if we choose to display only the working days
        // otherwise, all days are displayable
        return !in_array($dayNumber, $this->nonWorkingDays) || $this->displayNonWorkingDays;
    }

    public function getCurrentWeekInfo()
    {
        $weekInfo = array();
        $weekInfo['week_number'] = date("W");
        $weekInfo['week_days'] = array();

        // The diff with first day allows to know the date of the first day
        $dayOfWeek = date("w");
        $diffWithFirstDay = $dayOfWeek - $this->firstWeekday;

        // When sunday isn't the first day of the week
        if ($diffWithFirstDay < self::SUNDAY) {
            $diffWithFirstDay += 7;
        }

        $firstDayOnCalendar = date('Y-m-d',strtotime("-".$diffWithFirstDay." days"));

        // Manages the days to the first day of the week to the max value for the days (saturday)
        for ($i = $this->firstWeekday; $i <= self::SATURDAY; $i++) {
            if ($this->isDayDisplayable($i)) {
                $weekInfo['week_days'][] = $this->getDayInfoInWeek($i, $firstDayOnCalendar, $this->firstWeekday);
            }
        }

        // Manages the other days (From sunday to the day before the first day of the week)
        for ($i = self::SUNDAY; $i <= ($this->firstWeekday - 1); $i++) {
            if ($this->isDayDisplayable($i)) {
                $weekInfo['week_days'][] = $this->getDayInfoInWeek($i, $firstDayOnCalendar, $this->firstWeekday);
            }
        }

        return $weekInfo;
    }
}
