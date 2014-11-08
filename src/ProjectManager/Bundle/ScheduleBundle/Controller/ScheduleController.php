<?php

namespace ProjectManager\Bundle\ScheduleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ScheduleController extends Controller
{
    public function indexAction()
    {
    	//TODO use a parameter, here, monday is the first day
    	$firstDayOfWeek = 1;

    	$weekNumber = date("W");
    	$dayOfWeek = date("w");
    	$diffWithFirstDay = $dayOfWeek - $firstDayOfWeek;

    	//When sunday isn't the first day of the week
    	if ($diffWithFirstDay < 0) {
			$diffWithFirstDay += 7;
    	}

    	$firstDayOnCalendar = date('d.m.Y',strtotime("-".$diffWithFirstDay." days"));

        return $this->render('ProjectManagerScheduleBundle:Schedule:index.html.twig', array('week' => $weekNumber, 'day' => $firstDayOnCalendar));
    }
}
