<?php

namespace ProjectManager\Bundle\ProjectBundle\Controller;

use ProjectManager\Bundle\CoreBundle\Controller\AbstractController;
use ProjectManager\Bundle\ProjectBundle\Entity\Project;
use ProjectManager\Bundle\ProjectBundle\Form\Type\ProjectType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
    public function newAction()
    {
        $form = $this->createForm(new ProjectType(), new Project())
            ->add('save', 'submit');

        return array(
            'form' => $form->createView(),
        );
    }
}
