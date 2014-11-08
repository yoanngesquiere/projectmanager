<?php

namespace ProjectManager\Bundle\ScheduleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ProjectManagerScheduleBundle:Default:index.html.twig', array('name' => 'test'));
    }
}
