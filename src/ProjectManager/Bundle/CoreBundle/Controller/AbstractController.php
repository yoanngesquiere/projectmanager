<?php

namespace ProjectManager\Bundle\CoreBundle\Controller;

use ReflectionObject;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ProjectManager\Bundle\CoreBundle\Forms\FormCreator;

class AbstractController  extends Controller
{
    protected function getRepository($repositoryName)
    {
        return $this->getDoctrine()
            ->getRepository($repositoryName);
    }

    protected function createDeleteFormsForList($entities, $baseName, $options = array())
    {

        $deleteForms = array();

        $formCreator = new FormCreator($this->container->get('form.factory'));

        foreach ($entities as $entity) {
            $options['id'] = $entity->getId();
            $deleteForms[$entity->getId()] = $formCreator->deleteFormCreator(
                $this->generateUrl(
                    $baseName.'_delete',
                    $options
                )
            )->createView();
        }

        return array(
            'delete_forms' => $deleteForms,
        );
    }

    protected function createDeleteForm($entityId, $baseName, $options = array())
    {
        $formCreator = new FormCreator($this->container->get('form.factory'));
        $options['id'] = $entityId;
        return $formCreator->deleteFormCreator(
            $this->generateUrl(
                $baseName.'_delete',
                $options
            )
        );
    }

    /**
     * Class casting
     *
     * @param string|object $destination
     * @param object $sourceObject
     * @return object
     */
    function cast($destination, $sourceObject)
    {
        if (is_string($destination)) {
            $destination = new $destination();
        }
        $sourceReflection = new ReflectionObject($sourceObject);
        $destinationReflection = new ReflectionObject($destination);
        $sourceProperties = $sourceReflection->getProperties();
        foreach ($sourceProperties as $sourceProperty) {
            $sourceProperty->setAccessible(true);
            $name = $sourceProperty->getName();
            $value = $sourceProperty->getValue($sourceObject);
            if ($destinationReflection->hasProperty($name)) {
                $propDest = $destinationReflection->getProperty($name);
                $propDest->setAccessible(true);
                $propDest->setValue($destination,$value);
            } else {
                $destination->$name = $value;
            }
        }
        return $destination;
    }
}
