<?php

namespace ProjectManager\Bundle\CoreBundle\Forms;


class FormCreator {

    private $formFactory;

    public function __construct($container)
    {
        $this->formFactory = $container->get('form.factory');
    }

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
}

