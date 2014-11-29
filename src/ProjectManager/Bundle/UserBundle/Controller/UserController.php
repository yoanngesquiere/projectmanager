<?php

namespace ProjectManager\Bundle\UserBundle\Controller;

use ProjectManager\Bundle\CoreBundle\Forms\FormCreator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ProjectManager\Bundle\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ProjectManager\Bundle\UserBundle\Form\Type\UserType;

class UserController extends Controller
{
    /**
     * Lists the users
     *
     * @Template
     * @param Request $request
     * @return array
     */
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()
            ->getRepository('ProjectManagerUserBundle:User');
        $persons = $repository->findAll();

        $deleteForms = array();
        $formCreator = new FormCreator($this->container);

        foreach ($persons as $person) {
            $deleteForms[$person->getId()] = $formCreator->deleteFormCreator(
                $this->generateUrl(
                    'pm_user_delete_person',
                    array('id' => $person->getId())
                )
            )->createView();
        }

        return array(
            'persons' => $persons,
            'delete_form' => $deleteForms,
        );
    }

    /**
     * @Template
     */
    public function updateAction(Request $request, $id=0)
    {
    	$person = new User();
        if ($id != 0) {
            $em = $this->getDoctrine()->getManager();
            $person = $em->getRepository('ProjectManagerUserBundle:User')->find($id);
        }

        $form = $this->createForm(new UserType(), $person, array('user_exists' => ($id > 0)))
            ->add('save', 'submit');

        $form->handleRequest($request);

	    if ($form->isValid()) {
	    	$person = $form->getData();
            if ($id == 0) {
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($person);
                $password = $encoder->encodePassword($person->getPassword(), $person->getSalt());
                $person->setPassword($password);
            }
	        $em = $this->getDoctrine()->getManager();
		    $em->persist($person);
		    $em->flush();

	        return $this->redirect($this->generateUrl('pm_user_user_list'));
	    }

        return array(
            'form' => $form->createView(),
        );
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $person = $em->getRepository('ProjectManagerUserBundle:User')->find($id);
        $em->remove($person);
        $em->flush();
        return $this->redirect($this->generateUrl('pm_user_user_list'));
    }

}
