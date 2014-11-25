<?php

namespace ProjectManager\Bundle\UserBundle\Entity;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="role")
 */
class Role
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
     * @ORM\OneToMany(targetEntity="TeamMember", mappedBy="role")
     */
    protected $grantedTo;

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
     * Gets the team associated to the object.
     *
     * @return mixed
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Sets the team associated to the object.
     *
     * @param mixed $id the id
     *
     * @return self
     */
    public function setTeam($team)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * Gets the value of id.
     *
     * @return mixed
     */
    public function getGrantedTo()
    {
        return $this->grantedTo;
    }

    /**
     * Sets the value of id.
     *
     * @param mixed $id the id
     *
     * @return self
     */
    public function setGrantedTo($grantedTo)
    {
        $this->grantedTo = $grantedTo;

        return $this;
    }
}
