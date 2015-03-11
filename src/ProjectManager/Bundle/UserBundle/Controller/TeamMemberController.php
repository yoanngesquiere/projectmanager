<?php

namespace ProjectManager\Bundle\UserBundle\Controller;

use ProjectManager\Bundle\CoreBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ProjectManager\Bundle\UserBundle\Entity\Team;
use ProjectManager\Bundle\UserBundle\Entity\TeamMember;
use ProjectManager\Bundle\UserBundle\Form\Type\TeamMemberType;

/**
 * Team Member controller.
 */
class TeamMemberController extends AbstractController
{

    const REPOSITORY_NAME = 'ProjectManagerUserBundle:TeamMember';
    const BASE_URL = 'pm_user_teammember';

	/**
     * List members for a team
     *
     * @param int $teamId Id of the team
     * @return array
     * @Template("ProjectManagerUserBundle:TeamMember:index.html.twig")
     */
    public function listAction($teamId) {
        $results = $this->getRepository(self::REPOSITORY_NAME)->getAllInfoForTeam($teamId);
        $teamMembers = array();
        foreach ($results as $user) {
            foreach ($user->getTeam() as $teamMember) {
                $teamMembers[] = $teamMember;
            }
        }
        $forms = $this->createDeleteFormsForList($teamMembers, self::BASE_URL, array('teamId' => $teamId));

        return array(
            'users' => $results,
            'delete_forms' => $forms['delete_forms'],
        );
    }

    /**
     * Deletes one team member line (one team/member/role line)
     *
     * @param int $teamId Id of the team
     * @param int $id     Id of the line
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($teamId, $id) {
        $em = $this->getDoctrine()->getManager();
        $teamMember = $em->getRepository(self::REPOSITORY_NAME)->find($id);
        $em->remove($teamMember);
        $em->flush();
        return $this->redirect($this->generateUrl(TeamController::BASE_URL.'_edit', array('id' => $teamId)));
    }

    /**
     * Deletes all the team member lines for a team/member couple
     *
     * Will replace deleteAction when the UI is changed
     *
     * @param int $teamId
     * @param int $userId
     */
    private function removeUserFromTeam($teamId, $userId) {
        $em = $this->getDoctrine()->getManager();
        $teamMembers = $em->getRepository(self::REPOSITORY_NAME)->findAll();
        foreach($teamMembers as $teamMember) {
            $em->remove($teamMember);
        }
        $em->flush();
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
            $roles = $form->get('role')->getData();

			$data = $form->get('member')->getData();
			foreach ($data as $key => $person) {
				$this->addMemberToTeam($teamId, $person->getId(), $roles);
			}
		} else {
			return $this->redirect($this->generateUrl('pm_user_team_list'));
		}
		return $this->redirect($this->generateUrl('pm_user_team_edit', array('id' => $teamId)));
    }

    /**
     * Creates new team members
     *
     * @param int   $teamId    Id of the team
     * @param int   $MemberId  Id of the user
     * @param array $rolesList List of all roles related to the user for the team
     */
    private function addMemberToTeam($teamId, $MemberId, $rolesList)
    {
    	$em = $this->getDoctrine()->getManager();

        $team = $em->getRepository('ProjectManagerUserBundle:Team')->find($teamId);
        $member = $em->getRepository('ProjectManagerUserBundle:User')->find($MemberId);

        foreach($rolesList as $key => $role) {
            $role = $em->getRepository('ProjectManagerUserBundle:Role')->find($role->getId());
            $teamMember = new TeamMember();
            $teamMember->setTeam($team);
            $teamMember->setMember($member);
            $teamMember->setRole($role);

            $em = $this->getDoctrine()->getManager();
            $em->persist($teamMember);
            $em->flush();
        }
    }

    /**
     * Creates the form that manages team members
     *
     * @param int        $teamId     Id of the team
     * @param TeamMember $teamMember A TeamMember object
     * @return \Symfony\Component\Form\Form
     */
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
