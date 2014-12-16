<?php

namespace ProjectManager\Bundle\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$builder->add('username', 'text', array('label' => 'user.form.username'));
        if(!$options['user_exists']) {
    	   $builder->add('password', 'password', array('label' => 'user.form.password'));
        }
        $builder->add('first_name', 'text', array('label' => 'user.form.firstName'));
    	$builder->add('last_name', 'text', array('label' => 'user.form.lastName'));
    	$builder->add('email', 'email', array('label' => 'user.form.email'));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'user_exists' => 0
        ));
    }

    public function getName()
    {
        return 'person';
    }
}
