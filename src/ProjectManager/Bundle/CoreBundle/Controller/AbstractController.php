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

    protected  function createDeleteFormsForList($entities, $baseName, $options = array())
    {

        $deleteForms = array();

        $formCreator = new FormCreator($this->container->get('form.factory'));

        foreach ($entities as $entity) {
            $options['id'] = $entity->getId();
            $deleteForms[$entity->getId()] = $formCreator->deleteFormCreator(
                $this->generateUrl(
                    $baseName.'_delete',
                    $options
                    //array('id' => $entity->getId())
                )
            )->createView();
        }

        return array(
            'delete_forms' => $deleteForms,
        );
    }
}
