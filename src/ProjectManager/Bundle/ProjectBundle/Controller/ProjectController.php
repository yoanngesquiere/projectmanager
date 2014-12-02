<?php

namespace ProjectManager\Bundle\ProjectBundle\Controller;

use ProjectManager\Bundle\CoreBundle\Controller\AbstractController;
use ProjectManager\Bundle\ProjectBundle\Entity\Project;
use ProjectManager\Bundle\ProjectBundle\Form\Type\ProjectType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class ProjectController extends AbstractController
{
    const REPOSITORY_NAME = 'ProjectManagerProjectBundle:Project';
    const BASE_URL = 'pm_project_project';

	/**
	 * @Template
	 */
    public function indexAction()
    {
        $repository = $this->getRepository(self::REPOSITORY_NAME);
        $projects = $repository->findAll();

        $forms = $this->createDeleteFormsForList($projects, self::BASE_URL);

        return array(
            'projects' => $projects,
            'delete_forms' => $forms['delete_forms'],
        );
    }

    /**
     * @Template
     */
    public function newAction(Request $request)
    {
        $project = new Project();
        $form = $this->createForm(new ProjectType(), $project)
            ->add('save', 'submit');

        $form->handleRequest($request);

        if ($form->isValid()) {
            $project = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($project);
            $em->flush();

            return $this->redirect($this->generateUrl(self::BASE_URL.'_list'));
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Template
     */
    public function editAction(Request $request, $id)
    {
        $repository = $this->getRepository(self::REPOSITORY_NAME);
        $project = $repository->find($id);
        if(!$project) {
            return $this->redirect($this->generateUrl(self::BASE_URL.'_add'));
        }
        $form = $this->createForm(new ProjectType(), $project)
            ->add('save', 'submit');

        $form->handleRequest($request);

        if ($form->isValid()) {
            $project = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($project);
            $em->flush();

            return $this->redirect($this->generateUrl(self::BASE_URL.'_list'));
        }

        return array(
            'form' => $form->createView(),
        );
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository(self::REPOSITORY_NAME)->find($id);
        $em->remove($project);
        $em->flush();
        return $this->redirect($this->generateUrl(self::BASE_URL.'_list'));
    }
}
