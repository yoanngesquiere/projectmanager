<?php

namespace ProjectManager\Bundle\ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ProjectManager\Bundle\UserBundle\Entity\User;
/**
 * @ORM\MappedSuperclass
 * @ORM\Table(name="user")
 */
class Worker extends User {

    /**
     * @ORM\OneToMany(targetEntity="Task", mappedBy="assignedTo")
     */
    private $assignedTasks;

    /**
     * @return mixed
     */
    public function getAssignedTasks()
    {
        return $this->assignedTasks;
    }

    /**
     * @param mixed $assignedTasks
     */
    public function setAssignedTasks($assignedTasks)
    {
        $this->assignedTasks = $assignedTasks;
    }
} 