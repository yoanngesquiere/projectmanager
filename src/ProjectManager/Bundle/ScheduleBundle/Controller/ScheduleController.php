<?php

namespace ProjectManager\Bundle\ScheduleBundle\Controller;

use ProjectManager\Bundle\CoreBundle\Controller\AbstractController;
use ProjectManager\Bundle\ProjectBundle\Entity\Worker;

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
        $users = $this->getRepository('ProjectManagerUserBundle:User')->findAll();
        $usersUpdated = array();
        foreach($users as $user)
        {
            $user = new Worker($user);
            $user->setAssignedTasks($this->getRepository('ProjectManagerProjectBundle:Task')
                ->getTasksForPeriod($firstDayOnCalendar, $lastDayOnCalendar, $user));
            $usersUpdated[] = $user;
        }
        return $this->render(
            'ProjectManagerScheduleBundle:Schedule:index.html.twig',
            array(
                'week' => $weekNumber,
                'first_day_on_calendar' => $firstDayOnCalendar,
                'first_day' => $firstDayOfWeek,
                'users' => $usersUpdated,
            )
        );
    }
}
