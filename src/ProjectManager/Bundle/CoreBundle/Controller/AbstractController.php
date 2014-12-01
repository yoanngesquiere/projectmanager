<?php

namespace ProjectManager\Bundle\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ProjectManager\Bundle\CoreBundle\Forms\FormCreator;

class AbstractController  extends Controller
{
    protected function getRepository($repositoryName)
    {
        return $this->getDoctrine()
            ->getRepository($repositoryName);
    }

    protected  function createDeleteFormsForList($entities, $baseName)
    {

        $deleteForms = array();

        $formCreator = new FormCreator($this->container->get('form.factory'));

        foreach ($entities as $entity) {
            $deleteForms[$entity->getId()] = $formCreator->deleteFormCreator(
                $this->generateUrl(
                    $baseName.'_delete',
                    array('id' => $entity->getId())
                )
            )->createView();
        }

        return array(
            'delete_forms' => $deleteForms,
        );
    }
}
