<?php

namespace ProjectManager\Bundle\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ProjectManager\Bundle\UserBundle\Entity\Team;
use ProjectManager\Bundle\UserBundle\Entity\TeamMember;
use ProjectManager\Bundle\UserBundle\Form\Type\TeamMemberType;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @Route("/add/{teamId}/{MemberId}/", name="team_member_add")
     * @Template("ProjectManagerUserBundle:TeamMember:index.html.twig")
     */
    public function addMemberToTeamAction(Request $request, $teamId, $MemberId)
    {
        $this->addMemberToTeam($teamId, $MemberId);
		return $this->redirect($this->generateUrl('team'));
    }

	/**
     * List members for a team
     *
     * @Route("/{teamId}/list/", name="team_member_list")
     * @Template("ProjectManagerUserBundle:TeamMember:index.html.twig")
     */
    public function listAction($teamId){
    	$members = new ArrayCollection();
        $em = $this->getDoctrine()->getManager();

        $results = $em->getRepository('ProjectManagerUserBundle:TeamMember')->findBy(array('team'=> $teamId));
        foreach ($results as $key => $value) {
            $members[] = $value->getMember();
        }

    	return array(
            'members' => $members,
        );
    }

    /**
     * List members that are not in a team
     *
     * @Route("/{teamId}/notInlist/", name="team_member_notInlist")
     * @Template("ProjectManagerUserBundle:TeamMember:notInList.html.twig")
     */
    public function listNotInTeamAction($teamId)
    {
		$teamMember = new TeamMember();
        $form = $this->getAddMembersForm($teamId, $teamMember);
    	return array(
            'form' => $form->createView(),
        );
    }

	/**
     * Submit the form
     *
     * @Route("/{teamId}/add_members/", name="team_member_add_members")
     */
    public function addMembersToTeamAction(Request $request, $teamId)
    {

		$teamMember = new TeamMember();
		$form = $this->getAddMembersForm($teamId, $teamMember);
		$form->handleRequest($request);
		if ($form->isValid()) {
			$data = $form->get('member')->getData();
			foreach ($data as $key => $person) {
				$this->addMemberToTeam($teamId, $person->getId());
			}
		} else {
			return $this->redirect($this->generateUrl('team'));
		}
		return $this->redirect($this->generateUrl('team_edit', array('id' => $teamId)));
    }

    private function addMemberToTeam($teamId, $MemberId)
    {
    	$em = $this->getDoctrine()->getManager();

        $team = $em->getRepository('ProjectManagerUserBundle:Team')->find($teamId);
        $member = $em->getRepository('ProjectManagerUserBundle:User')->find($MemberId);

        $teammember = new TeamMember();
        $teammember->setTeam($team);
        $teammember->setMember($member);

        $em = $this->getDoctrine()->getManager();
		    $em->persist($teammember);
		    $em->flush();
    }

    private function getAddMembersForm($teamId, $teamMember)
	{
        $form = $this->createForm(new TeamMemberType(), $teamMember, array(
            'team_id' => $teamId,
            'action' => $this->generateUrl('team_member_add_members', array('teamId' => $teamId)),
            'method' => 'POST',
        ));
        $form->add('submit', 'submit', array('label' => 'Add'));
        return $form;
	}
}