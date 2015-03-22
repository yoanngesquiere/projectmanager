<?php

namespace ProjectManager\Bundle\ScheduleBundle\Controller;

use ProjectManager\Bundle\CoreBundle\Controller\AbstractController;

class ScheduleController extends AbstractController
{
    public function indexAction()
    {
        $dateService = $this->container->get("pm_date_helper");
        $weekInfo = $dateService->getCurrentWeekInfo();

        $users = $this->getRepository('ProjectManagerUserBundle:User')->findAll();
        $usersUpdated = array();

        foreach($users as $user)
        {
            $user->setAssignedTasks($this->getRepository('ProjectManagerProjectBundle:Task')
                ->getTasksForPeriod(
                    array_values($weekInfo['week_days'])[0]['date'],
                    end($weekInfo['week_days'])['date'], $user
                )
            );
            $usersUpdated[] = $user;
        }

        return $this->render(
            'ProjectManagerScheduleBundle:Schedule:index.html.twig',
            array(
                'users' => $usersUpdated,
                'week_info' => $weekInfo,
            )
        );
    }
}
