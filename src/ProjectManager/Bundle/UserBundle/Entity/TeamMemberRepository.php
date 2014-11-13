<?php

namespace ProjectManager\Bundle\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;

class TeamMemberRepository extends EntityRepository
{
    public function findMembersNotInTeam($idTeam)
    {
        return $this->createQueryForMembersNotInTeam($idTeam)
        	->getQuery()
            ->getResult();
    }

    public function createQueryForMembersNotInTeam($idTeam)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb2 = $this->_em->createQueryBuilder();
        return $qb
            ->add('select', 'p')
            ->add('from', 'ProjectManagerUserBundle:Person p')
            ->add('where', $qb->expr()->not($qb->expr()->exists(
            		'SELECT 0 FROM ProjectManagerUserBundle:TeamMember tm
                	WHERE tm.team = :teamId AND tm.member = p.id')))
            ->setParameter('teamId',  $idTeam);
    }
}