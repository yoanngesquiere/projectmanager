<?php

namespace ProjectManager\Bundle\ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ProjectManager\Bundle\UserBundle\Entity\User;

/**
 * @ORM\MappedSuperclass
 * @ORM\Table(name="user")
 */
class Worker extends User {

    public function __construct(User $user) {
        $this->id = $user->getId();
        $this->first_name = $user->getFirstName();
        $this->last_name = $user->getLastName();
    }

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
