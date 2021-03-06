<?php

namespace ProjectManager\Bundle\UserBundle\Controller;

use ProjectManager\Bundle\CoreBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ProjectManager\Bundle\UserBundle\Entity\Team;
use ProjectManager\Bundle\UserBundle\Entity\TeamMember;
use ProjectManager\Bundle\UserBundle\Form\Type\TeamMemberType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TeamMemberController
 * @package ProjectManager\Bundle\UserBundle\Controller
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
    public function listAction($teamId)
    {
        $results = $this->getRepository(self::REPOSITORY_NAME)->getAllLinkedInfoForTeam($teamId);
        $forms = $this->createDeleteFormsForList(
            $results, self::BASE_URL, array('teamId' => $teamId, 'postfix' => 'member')
        );

        $roles = $this->getRepository(RoleController::REPOSITORY_NAME)->findAll();

        return array(
            'users' => $results,
            'delete_forms' => $forms['delete_forms'],
            'roles' => $roles,
            'team_id' => $teamId,
        );
    }

    /**
     * Deletes one team member line (one team/member/role line)
     *
     * @param int $teamId Id of the team
     * @param int $id     Id of the line
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteMemberAction($teamId, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $teamMembers = $em->getRepository(self::REPOSITORY_NAME)->getLinesForUserAndTeam($teamId, $id);

        foreach($teamMembers as $teamMember) {
            $em->remove($teamMember);
        }
        $em->flush();
        return $this->redirect($this->generateUrl(TeamController::BASE_URL.'_edit', array('id' => $teamId)));
    }

    /**
     * List members that are not in a team
     *
     * @param int $teamId Id of the current team
     * @Template("ProjectManagerUserBundle:TeamMember:notInList.html.twig")
     * @return array
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
     * Function to add members to the current team.
     * Displays the form and manages the validations
     *
     * @param Request $request http request
     * @param int     $teamId  Current team id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
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
     * Updates roles for a given user and a given team
     *
     * @param Request $request Request
     * @param int     $teamId  Team id
     * @param int     $userId  User Id
     *
     * @return Response
     */
    public function updateRolesForUserInTeamAction(Request $request, $teamId, $userId)
    {
        $data = $request->request->get('roles');
        $return = array();

        $em = $this->getDoctrine()->getManager();
        $teamMembers = $em->getRepository(self::REPOSITORY_NAME)->getLinesForUserAndTeam($teamId, $userId);

        $team = $em->getRepository('ProjectManagerUserBundle:Team')->find($teamId);
        $member = $em->getRepository('ProjectManagerUserBundle:User')->find($userId);

        //Deletes all lines that are no longer right
        foreach($teamMembers as $teamMember) {
            $roleId = $teamMember->getRole()->getId();
            //If the line already exists, we do nothing
            if(($key = array_search($roleId, (array)$data)) !== false) {
                unset($data[$key]);
                $return[$roleId] = $teamMember->getRole()->getName();
            } else { //Or we delete it if it is not selected
                $return[$roleId] = -1;
                $em->remove($teamMember);
            }
        }
        $em->flush();

        //Add new lines
        foreach ((array)$data as $newLine) {
            $role = $em->getRepository('ProjectManagerUserBundle:Role')->find($newLine);
            $teamMember = new TeamMember();
            $teamMember->setTeam($team);
            $teamMember->setMember($member);
            $teamMember->setRole($role);
            $em->persist($teamMember);
            $return[$newLine] = $role->getName();
        }
        $em->flush();

        $response = new Response();
        $response->setContent(json_encode($return));
        $response->headers->set('Content-Type', 'application/json');
        $response->setStatusCode(200);
        return $response;
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
        }
        $em->flush();
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
