<?php

namespace ProjectManager\Bundle\ProjectBundle\Entity;


use Doctrine\ORM\EntityRepository;

class TaskRepository extends EntityRepository
{
    public function getTasksForPeriod($periodStartDate, $periodEndDate, $user=null)
    {
        $fields = array('COALESCE(t.startDate,:periodStart) AS startDate',
            'COALESCE(t.endDate, :periodEnd) AS endDate',
            't.id',
            't.name');

        $qb = $this->_em->createQueryBuilder();
        $qb->select($fields)
            ->add('from', 'ProjectManagerProjectBundle:Task t');

        //Define date criteria
        $dateCriteria = $qb->expr()->orX(
            $qb->expr()->andX(
            //Task starts before the periods' start and ends after the periods' end
                $qb->expr()->orX(
                    $qb->expr()->gte('t.endDate', ':periodEnd'),
                    $qb->expr()->isNull('t.endDate')
                ),
                $qb->expr()->orX(
                    $qb->expr()->lte('t.startDate', ':periodStart'),
                    $qb->expr()->isNull('t.startDate')
                )
            ),
            //Start date is in the period
            $qb->expr()->between('t.startDate', ':periodStart', ':periodEnd'),
            //End date is in the period
            $qb->expr()->between('t.endDate', ':periodStart', ':periodEnd')
        );

        //Define where clause
        $whereClause = $qb->expr()->andx();
        $whereClause->add($dateCriteria);
        if ($user) {
            $qb->innerJoin('t.assignedTo', 'u', 'WITH', 'u.id = :user');
            $qb->setParameter('user', $user->getId());
        }

        // Build query
        $qb->add('where', $whereClause);

        return $qb->setParameter('periodEnd',  $periodEndDate)
            ->setParameter('periodStart',  $periodStartDate)
            ->getQuery()
            ->getResult();
            ;
    }
}
