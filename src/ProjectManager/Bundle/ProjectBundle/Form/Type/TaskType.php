<?php

namespace ProjectManager\Bundle\ProjectBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TaskType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text');
        $builder->add('startDate', 'date', array(
            'empty_value' => '',
            'widget' => 'single_text',
            'required'=>false,
        ));
        $builder->add('endDate', 'date', array(
            'empty_value' => '',
            'widget' => 'single_text',
            'required'=>false,
        ));
        $builder->add('assignedTo', 'entity', array(
            'empty_value' => 'user.select',
            'required'=>false,
            'class' => 'ProjectManagerUserBundle:User',
        ));
    }


    public function getName()
    {
        return 'task';
    }
}
