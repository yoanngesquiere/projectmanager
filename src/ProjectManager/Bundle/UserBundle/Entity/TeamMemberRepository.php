<?php

namespace ProjectManager\Bundle\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Class TeamMemberRepository
 * @package ProjectManager\Bundle\UserBundle\Entity
 */
class TeamMemberRepository extends EntityRepository
{
    /**
     * Returns all the users that are not in the given team
     *
     * @param int $idTeam Id of the team
     * @return array
     */
    public function findMembersNotInTeam($idTeam)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->add('select', 'u')
            ->add('from', 'ProjectManagerUserBundle:User u')
            ->add('where', $qb->expr()->not($qb->expr()->exists(
                'SELECT 0 FROM ProjectManagerUserBundle:TeamMember tm
                WHERE tm.team = :teamId AND tm.member = u.id')))
            ->setParameter('teamId',  $idTeam);

        return $qb->getQuery()
            ->getResult();
    }

    /**
     * Get the user data, the role data for a team
     *
     * @param int $idTeam Id of the team
     * @return array
     */
    public function getAllLinkedInfoForTeam($idTeam) {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('tm, u, r')
            ->from('ProjectManagerUserBundle:User', 'u')
            ->join('u.team', 'tm')
            ->join('tm.role', 'r')
            ->where('tm.team = :teamId')
            ->setParameter('teamId',  $idTeam);
        return $qb->getQuery()
            ->getResult();
    }

    /**
     * Returns all the team member lines for a given team and a given user
     *
     * @param int $teamId team id
     * @param int $userId user id
     * @return array
     */
    public function getLinesForUserAndTeam($teamId, $userId) {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('tm')
            ->from('ProjectManagerUserBundle:TeamMember', 'tm')
            ->where('tm.team = :teamId')
            ->andWhere('tm.member = :userId')
            ->setParameter('teamId',  $teamId)
            ->setParameter('userId',  $userId);
        return $qb->getQuery()
            ->getResult();
    }
}
