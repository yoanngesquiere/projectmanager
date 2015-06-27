<?php

namespace ProjectManager\Bundle\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamMemberType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('member', 'entity', array(
                'class' => 'ProjectManagerUserBundle:User',
                'expanded' => true,
                'multiple' => true,
                'query_builder' => function(\ProjectManager\Bundle\UserBundle\Entity\UserRepository $er) use ($options) {
                    return $er->createQueryForMembersNotInTeam($options['team_id']);
                }
            ))
            ->add('role', 'entity', array(
                'class' => 'ProjectManagerUserBundle:Role',
                'expanded' => true,
                'multiple' => true,
                /*'query_builder' => function(\ProjectManager\Bundle\UserBundle\Entity\UserRepository $er) use ($options) {
                    return $er->createQueryForMembersNotInTeam($options['team_id']);
                }*/));
        ;
    }
    
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ProjectManager\Bundle\UserBundle\Entity\TeamMember',
            'team_id' => null
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'projectmanager_bundle_Userbundle_team_member';
    }
}
