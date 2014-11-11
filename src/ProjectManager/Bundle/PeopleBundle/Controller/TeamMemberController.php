<?php

namespace ProjectManager\Bundle\PeopleBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ProjectManager\Bundle\PeopleBundle\Entity\Person;
use ProjectManager\Bundle\PeopleBundle\Entity\Team;
use ProjectManager\Bundle\PeopleBundle\Entity\TeamMember;

/**
 * Team controller.
 *
 * @Route("/teammember")
 */
class TeamMemberController extends Controller
{
	/**
     * Creates a new Team entity.
     *
     * @Route("/add/{teamId}/{MemberId}/", name="team_create")
     * @Template("ProjectManagerPeopleBundle:Team:index.html.twig")
     */
    public function addMemberToTeamAction(Request $request, $teamId, $MemberId)
    {
        $em = $this->getDoctrine()->getManager();

        $team = $em->getRepository('ProjectManagerPeopleBundle:Team')->find($teamId);
        $member = $em->getRepository('ProjectManagerPeopleBundle:Person')->find($MemberId);

        //TODO check if objects exist

        $teammember = new TeamMember();
        $teammember->setTeam($team);
        $teammember->setMember($member);

        $em = $this->getDoctrine()->getManager();
		    $em->persist($teammember);
		    $em->flush();
		    
		return $this->redirect($this->generateUrl('team'));
    }
}