<?php

namespace ProjectManager\Bundle\ProjectBundle\Entity;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="task")
 */
class Task
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;

    /**
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="tasks")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $project;

    /**
     * @ORM\ManyToOne(targetEntity="Task", inversedBy="subTasks")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $parentTask;

    /**
     * @ORM\OneToMany(targetEntity="Task", mappedBy="parentTask")
     */
    protected $subTasks;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->subTasks = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Task
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set project
     *
     * @param \ProjectManager\Bundle\ProjectBundle\Entity\Project $project
     * @return Task
     */
    public function setProject(\ProjectManager\Bundle\ProjectBundle\Entity\Project $project = null)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return \ProjectManager\Bundle\ProjectBundle\Entity\Project 
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set parentTask
     *
     * @param \ProjectManager\Bundle\ProjectBundle\Entity\Task $parentTask
     * @return Task
     */
    public function setParentTask(\ProjectManager\Bundle\ProjectBundle\Entity\Task $parentTask = null)
    {
        $this->parentTask = $parentTask;

        return $this;
    }

    /**
     * Get parentTask
     *
     * @return \ProjectManager\Bundle\ProjectBundle\Entity\Task 
     */
    public function getParentTask()
    {
        return $this->parentTask;
    }

    /**
     * Add subTasks
     *
     * @param \ProjectManager\Bundle\ProjectBundle\Entity\Task $subTasks
     * @return Task
     */
    public function addSubTask(\ProjectManager\Bundle\ProjectBundle\Entity\Task $subTasks)
    {
        $this->subTasks[] = $subTasks;

        return $this;
    }

    /**
     * Remove subTasks
     *
     * @param \ProjectManager\Bundle\ProjectBundle\Entity\Task $subTasks
     */
    public function removeSubTask(\ProjectManager\Bundle\ProjectBundle\Entity\Task $subTasks)
    {
        $this->subTasks->removeElement($subTasks);
    }

    /**
     * Get subTasks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSubTasks()
    {
        return $this->subTasks;
    }
}