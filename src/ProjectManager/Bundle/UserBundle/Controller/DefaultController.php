<?php

namespace ProjectManager\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ProjectManagerPeopleBundle:Default:index.html.twig', array('name' => 'toto'));
    }
}
