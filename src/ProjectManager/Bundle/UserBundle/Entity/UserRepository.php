<?php

namespace ProjectManager\Bundle\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function createQueryForMembersNotInTeam($idTeam)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb2 = $this->_em->createQueryBuilder();
        return $qb
            ->add('select', 'u')
            ->add('from', 'ProjectManagerUserBundle:User u')
            ->add('where', $qb->expr()->not($qb->expr()->exists(
            		'SELECT 0 FROM ProjectManagerUserBundle:TeamMember tm
                	WHERE tm.team = :teamId AND tm.member = u.id')))
            ->setParameter('teamId',  $idTeam);
    }
}