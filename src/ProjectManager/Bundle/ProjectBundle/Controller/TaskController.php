<?php

namespace ProjectManager\Bundle\ProjectBundle\Controller;


use ProjectManager\Bundle\CoreBundle\Controller\AbstractController;
use ProjectManager\Bundle\ProjectBundle\Entity\Task;
use ProjectManager\Bundle\ProjectBundle\Form\Type\TaskType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class TaskController extends AbstractController
{
    const REPOSITORY_NAME = 'ProjectManagerProjectBundle:Task';
    const BASE_URL = 'pm_project_task';

    /**
     * @Template
     */
    public function indexAction($projectId)
    {
        $projectRepository = $this->getRepository(ProjectController::REPOSITORY_NAME);
        $project = $projectRepository->find($projectId);

        $repository = $this->getRepository(self::REPOSITORY_NAME);
        $tasks = $repository->findBy(array('project'=> $project));
        $forms = $this->createDeleteFormsForList($tasks, self::BASE_URL, array('projectId' => $projectId));

        return array(
            'project' => $project,
            'delete_forms' => $forms['delete_forms'],
            'tasks' => $tasks,
        );
    }

    /**
     * @Template
     */
    public function newAction(Request $request, $projectId)
    {
        $projectRepository = $this->getRepository(ProjectController::REPOSITORY_NAME);
        $project = $projectRepository->find($projectId);

        $task = new Task();
        $form = $this->createForm(new TaskType(), $task, array(
            'action' => $this->generateUrl('pm_project_task_add', array('projectId' => $projectId)),
        ))
            ->add('save', 'submit');

        $form->handleRequest($request);

        if ($form->isValid()) {
            $task = $form->getData();
            $task->setProject($project);
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirect($this->generateUrl(ProjectController::BASE_URL.'_edit', array('id' => $projectId)));
        }

        return array(
            'form' => $form->createView(),
            'project' => $project,
        );
    }

    /**
     * Deletes a task
     *
     * @param $projectId Id of the concerned project
     * @param $id        Id of the task
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($projectId, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $task = $em->getRepository(self::REPOSITORY_NAME)->find($id);
        if ($task) {
            $em->remove($task);
            $em->flush();
        }

        return $this->redirect($this->generateUrl(ProjectController::BASE_URL.'_edit', array('id' => $projectId)));
    }
}
