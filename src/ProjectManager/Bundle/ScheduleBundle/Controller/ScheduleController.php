<?php

namespace ProjectManager\Bundle\ScheduleBundle\Controller;

use ProjectManager\Bundle\CoreBundle\Controller\AbstractController;
use ProjectManager\Bundle\ProjectBundle\Entity\Worker;
use ProjectManager\Bundle\ScheduleBundle\Helper\DateHelper;

class ScheduleController extends AbstractController
{
    public function indexAction()
    {
        $weekNumber = date("W");

        $dateHelper = new DateHelper();
        $weekInfo = $dateHelper->getCurrentWeekInfo();

        $users = $this->getRepository('ProjectManagerUserBundle:User')->findAll();
        $usersUpdated = array();

        foreach($users as $user)
        {
            $user = new Worker($user);
            $user->setAssignedTasks($this->getRepository('ProjectManagerProjectBundle:Task')
                ->getTasksForPeriod(array_values($weekInfo['week_days'])[0]['date'], end($weekInfo['week_days'])['date'], $user));
            $usersUpdated[] = $user;
        }


        return $this->render(
            'ProjectManagerScheduleBundle:Schedule:index.html.twig',
            array(
                'week' => $weekNumber,
                'users' => $usersUpdated,
                'week_info' => $weekInfo,
            )
        );
    }
}
