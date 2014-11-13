<?php

namespace ProjectManager\Bundle\UserBundle\Entity;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="ProjectManager\Bundle\UserBundle\Entity\UserRepository")
 */
class User
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
    protected $first_name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $last_name;

    /**
     * @ORM\OneToMany(targetEntity="TeamMember", mappedBy="member")
     */
    protected $team;


    /**
     * Gets the value of id.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the value of id.
     *
     * @param mixed $id the id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets the value of first_name.
     *
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Sets the value of first_name.
     *
     * @param mixed $first_name the first name
     *
     * @return self
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;

        return $this;
    }

    /**
     * Gets the value of last_name.
     *
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Sets the value of last_name.
     *
     * @param mixed $last_name the last name
     *
     * @return self
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function __toString()
    {
        return $this->last_name. ' '.$this->first_name;
    }
}