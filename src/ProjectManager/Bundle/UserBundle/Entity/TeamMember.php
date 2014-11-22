<?php

namespace ProjectManager\Bundle\UserBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="team_member")
 * @ORM\Entity(repositoryClass="ProjectManager\Bundle\UserBundle\Entity\TeamMemberRepository")
 */
class TeamMember
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Team", inversedBy="members")
     * @ORM\JoinColumn(name="team_id", referencedColumnName="id")
     */
    protected $team;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="team")
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id")
     */
    protected $member;


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
     * Gets the value of id.
     *
     * @return mixed
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Sets the value of id.
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
    public function getMember()
    {
        return $this->member;
    }

    /**
     * Sets the value of id.
     *
     * @param mixed $id the id
     *
     * @return self
     */
    public function setMember($member)
    {
        $this->member = $member;

        return $this;
    }
}