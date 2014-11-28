<?php

namespace ProjectManager\Bundle\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ProjectManager\Bundle\UserBundle\Entity\Team;
use ProjectManager\Bundle\UserBundle\Entity\TeamMember;
use ProjectManager\Bundle\UserBundle\Form\Type\TeamMemberType;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Team controller.
 *
 */
class TeamMemberController extends Controller
{

	/**
     * List members for a team
     *
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
			return $this->redirect($this->generateUrl('pm_user_team_list'));
		}
		return $this->redirect($this->generateUrl('pm_user_team_edit', array('id' => $teamId)));
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
            'action' => $this->generateUrl('pm_user_teammember_team_member_add_members', array('teamId' => $teamId)),
            'method' => 'POST',
        ));
        $form->add('submit', 'submit', array('label' => 'Add'));
        return $form;
	}
}
