<?php

namespace ProjectManager\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RoleController extends Controller {

    /**
     * Lists all the roles in the application
     *
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $roles = $em->getRepository('ProjectManagerUserBundle:Role')->findAll();

        return array(
            'roles' => $roles,
        );
    }

    public function editAction()
    {

    }

    public function deleteAction()
    {

    }
}

