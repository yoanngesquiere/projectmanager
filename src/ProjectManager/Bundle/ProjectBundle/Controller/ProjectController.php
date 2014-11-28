<?php

namespace ProjectManager\Bundle\ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ProjectController extends Controller
{
	/**
	 * @Template
	 */
    public function indexAction($name)
    {
        return array('name' => $name);
    }
}
