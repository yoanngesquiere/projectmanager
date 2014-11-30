<?php

namespace ProjectManager\Bundle\CoreBundle\Forms;


/**
 * Class FormCreator
 * This class is used to generate custom buttons for the project manager
 *
 * @package ProjectManager\Bundle\CoreBundle\Forms
 */
class FormCreator {

    /**
     * @var \Symfony\Component\Form\FormFactory
     */
    private $formFactory;

    /**
     * Constructor
     *
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container container
     */
    public function __construct($container)
    {
        $this->formFactory = $container->get('form.factory');
    }


    /**
     * Creates a "delete" button
     *
     * @param string $url destination url
     *
     * @return \Symfony\Component\Form\Form
     */
    public function deleteFormCreator($url)
    {
        $defaultData = array('message' => 'Assign');
        return $this->formFactory->createNamedBuilder('delete_object', 'form', $defaultData, array())
            ->setAction($url)
            ->setMethod('DELETE')
            ->add('submit', 'submit',
                array(
                    'label' => 'Delete',
                    'attr' => array('class' => 'btn btn-primary'),
                )
            )
            ->getForm();
    }

    /**
     * Creates an "edit" button
     *
     * @param string $url destination url
     *
     * @return \Symfony\Component\Form\Form
     */
    public function editFormCreator($url)
    {
        $defaultData = array('message' => 'Assign');
        return $this->formFactory->createNamedBuilder(
            'edit_object', 'form', $defaultData, array(
                'csrf_protection' => false,
                )
            )
            ->setAction($url)
            ->setMethod('GET')
            ->add('submit', 'submit',
                array(
                    'label' => 'Edit',
                    'attr' => array('class' => 'btn btn-primary'),
                )
            )
            ->getForm();
    }

    /**
     * Creates a "new" button
     *
     * @param string $url    destination url
     * @param string $object name of the object that must be created
     *
     * @return \Symfony\Component\Form\Form
     */
    public function newFormCreator($url, $object)
    {
        $defaultData = array('message' => 'Assign');
        return $this->formFactory->createNamedBuilder('new_object', 'form', $defaultData, array())
            ->setAction($url)
            ->setMethod('GET')
            ->add('submit', 'submit',
                array(
                    'label' => 'New '.$object,
                    'attr' => array('class' => 'btn btn-primary'),
                )
            )
            ->getForm();
    }
}

