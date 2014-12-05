<?php

namespace ProjectManager\Bundle\ScheduleBundle\Controller;

use ProjectManager\Bundle\CoreBundle\Controller\AbstractController;
use ProjectManager\Bundle\UserBundle\Controller\UserController;

class ScheduleController extends AbstractController
{
    public function indexAction()
    {
    	$firstDayOfWeek = 1;

    	$weekNumber = date("W");
    	$dayOfWeek = date("w");
    	$diffWithFirstDay = $dayOfWeek - $firstDayOfWeek;

    	//When sunday isn't the first day of the week
    	if ($diffWithFirstDay < 0) {
			$diffWithFirstDay += 7;
    	}

    	$firstDayOnCalendar = date('d.m.Y',strtotime("-".$diffWithFirstDay." days"));

        $users = $this->getRepository(UserController::REPOSITORY_NAME)->findAll();

        return $this->render(
            'ProjectManagerScheduleBundle:Schedule:index.html.twig',
            array(
                'week' => $weekNumber,
                'day' => $firstDayOnCalendar,
                'first_day' => $firstDayOfWeek,
                'users' => $users,
            )
        );
    }
}
