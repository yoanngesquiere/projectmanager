<?php

namespace ProjectManager\Bundle\UserBundle\Controller;

use ProjectManager\Bundle\CoreBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ProjectManager\Bundle\UserBundle\Entity\Role;
use Symfony\Component\HttpFoundation\Request;
use ProjectManager\Bundle\UserBundle\Form\Type\RoleType;

class RoleController extends AbstractController {

    const REPOSITORY_NAME = 'ProjectManagerUserBundle:Role';
    const BASE_URL = 'pm_user_role';

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

    /**
     * Displays the edit form to create or update a role.
     * It also save the updates made on the role
     *
     * @Template()
     * @param Request $request httpRequest
     * @param int     $id      Id of the role to update, if it is an update
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction(Request $request, $id=0)
    {
        $role = new Role();
        if ($id != 0) {
            $role = $this->getRepository(self::REPOSITORY_NAME)->find($id);
        }
        $form = $this->createForm(new RoleType(), $role)
            ->add('save', 'submit');
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($role);
            $em->flush();

            return $this->redirect($this->generateUrl(self::BASE_URL.'_list', array('id' => $role->getId())));
        }

        return array(
            'entity' => $role,
            'form'   => $form->createView(),
        );
    }

    /**
     * Deletes a selected object
     *
     * @param $id Id of the role that must be deleted
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $role = $em->getRepository(self::REPOSITORY_NAME)->find($id);
        $em->remove($role);
        $em->flush();
        return $this->redirect($this->generateUrl(self::BASE_URL.'_list'));
    }
}

