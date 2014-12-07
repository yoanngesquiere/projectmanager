<?php

namespace ProjectManager\Bundle\ScheduleBundle\Controller;

use ProjectManager\Bundle\CoreBundle\Controller\AbstractController;

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

    	$firstDayOnCalendar = date('Y-m-d',strtotime("-".$diffWithFirstDay." days"));
        $lastDayOnCalendar = date('Y-m-d',strtotime("+ 7 days", strtotime($firstDayOnCalendar)));
        $users = $this->getRepository('ProjectManagerProjectBundle:Worker')->findAll();
        foreach($users as $user)
        {
            $user->setAssignedTasks($this->getRepository('ProjectManagerProjectBundle:Task')
                ->getTasksForPeriod($firstDayOnCalendar, $lastDayOnCalendar, $user));

        }
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
