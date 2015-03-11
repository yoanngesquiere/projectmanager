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
        return $qb
            ->add('select', 'u')
            ->add('from', 'ProjectManagerUserBundle:User u')
            ->add('where', $qb->expr()->not($qb->expr()->exists(
            		'SELECT 0 FROM ProjectManagerUserBundle:TeamMember tm
                	WHERE tm.team = :teamId AND tm.member = u.id')))
            ->setParameter('teamId',  $idTeam);
    }

    public function getAllInfoForTeam($idTeam) {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('tm, u, r')
            ->from('ProjectManagerUserBundle:User', 'u')
            ->join('u.team', 'tm')
            ->join('tm.role', 'r')
            //->join('ProjectManagerUserBundle:User', 'u', 'WITH', 'u.id = tm.member')
            //->join('ProjectManagerUserBundle:Role', 'r', 'WITH', 'r.id = tm.role')
            ->where('tm.team = :teamId')
            ->setParameter('teamId',  $idTeam);
        return $qb->getQuery()
            ->getResult();
    }
}
