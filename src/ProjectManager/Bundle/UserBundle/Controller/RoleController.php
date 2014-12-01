<?php

namespace ProjectManager\Bundle\UserBundle\Controller;

use ProjectManager\Bundle\CoreBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class RoleController extends AbstractController {

    /**
     * Lists all the roles in the application
     *
     * @Template()
     */
    public function indexAction()
    {
        $roles = $this->getRepository('ProjectManagerUserBundle:Role')->findAll();

        $forms = $this->createDeleteFormsForList($roles, 'pm_user_role');

        return array(
            'roles' => $roles,
            'delete_forms' => $forms['delete_forms'],
        );
    }

    public function editAction()
    {

    }

    public function deleteAction()
    {

    }
}

