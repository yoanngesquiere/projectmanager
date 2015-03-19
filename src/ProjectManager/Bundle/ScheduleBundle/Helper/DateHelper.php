<?php

namespace ProjectManager\Bundle\ScheduleBundle\Helper;


class DateHelper
{
    const SUNDAY = 0;
    const SATURDAY = 6;

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

        return array(
            'day_number' => $dayNum,
            'date' => date('Y-m-d',strtotime("+".$diffWithFirstDay." days", strtotime($firstDay))),
            'day_added' => $dayAdded,
        );
    }

    public function getCurrentWeekInfo()
    {
        $weekInfo = array();
        $weekInfo['week_number'] = date("W");
        $weekInfo['week_days'] = array();

        // Will be a parameter soon
        $firstDayOfWeek = 1;

        // The diff with first day allows to know the date of the first day
        $dayOfWeek = date("w");
        $diffWithFirstDay = $dayOfWeek - $firstDayOfWeek;

        // When sunday isn't the first day of the week
        if ($diffWithFirstDay < self::SUNDAY) {
            $diffWithFirstDay += 7;
        }

        $firstDayOnCalendar = date('Y-m-d',strtotime("-".$diffWithFirstDay." days"));

        // Manages the days to the first day of the week to the max value for the days (saturday)
        for ($i = $firstDayOfWeek; $i <= self::SATURDAY; $i++) {
            $weekInfo['week_days'][] = $this->getDayInfoInWeek($i, $firstDayOnCalendar, $firstDayOfWeek);
        }

        // Manages the other days (From sunday to the day before the first day of the week)
        for ($i = self::SUNDAY; $i <= ($firstDayOfWeek - 1); $i++) {
            $weekInfo['week_days'][] = $this->getDayInfoInWeek($i, $firstDayOnCalendar, $firstDayOfWeek);
        }

        return $weekInfo;
    }
}