<?php

namespace ProjectManager\Bundle\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use ProjectManager\Bundle\UserBundle\Entity\TeamMemberRepository;

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
                'class' => 'ProjectManagerUserBundle:Person',
                'property' => 'firstName',
                'expanded' => true,
                'multiple' => true,
                'query_builder' => function(\ProjectManager\Bundle\UserBundle\Entity\PersonRepository $er) use ($options) {
                    return $er->createQueryForMembersNotInTeam($options['team_id']);
                }
            ));
        ;
    }
    
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
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
