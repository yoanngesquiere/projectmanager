<?php

namespace ProjectManager\Bundle\UserBundle\Controller;

use ProjectManager\Bundle\CoreBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ProjectManager\Bundle\UserBundle\Entity\Team;
use ProjectManager\Bundle\UserBundle\Entity\TeamMember;
use ProjectManager\Bundle\UserBundle\Form\Type\TeamMemberType;

/**
 * Team controller.
 *
 */
class TeamMemberController extends AbstractController
{

    const REPOSITORY_NAME = 'ProjectManagerUserBundle:TeamMember';
    const BASE_URL = 'pm_user_teammember';

	/**
     * List members for a team
     *
     * @Template("ProjectManagerUserBundle:TeamMember:index.html.twig")
     */
    public function listAction($teamId) {
        $em = $this->getDoctrine()->getManager();

        $results = $em->getRepository('ProjectManagerUserBundle:TeamMember')->findBy(array('team'=> $teamId));

        $forms = $this->createDeleteFormsForList($results, self::BASE_URL, array('teamId' => $teamId));


        return array(
            'team_members' => $results,
            'delete_forms' => $forms['delete_forms'],
        );
    }

    public function deleteAction($teamId, $id) {
        $em = $this->getDoctrine()->getManager();
        $teamMember = $em->getRepository(self::REPOSITORY_NAME)->find($id);
        $em->remove($teamMember);
        $em->flush();
        return $this->redirect($this->generateUrl(TeamController::BASE_URL.'_edit', array('id' => $teamId)));
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
