<?php

namespace ProjectManager\Bundle\PeopleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ProjectManager\Bundle\PeopleBundle\Entity\Person;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ProjectManager\Bundle\PeopleBundle\Form\Type\PersonType;

class PersonController extends Controller
{
    /**
     * @Template
     */
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()
            ->getRepository('ProjectManagerPeopleBundle:Person');
        $persons = $repository->findAll();
        return array('persons' => $persons);
    }

    /**
     * @Template
     */
    public function updateAction(Request $request, $id=0)
    {
    	$person = new Person();
        if ($id != 0) {
            $em = $this->getDoctrine()->getManager();
            $person = $em->getRepository('ProjectManagerPeopleBundle:Person')->find($id);
        }

        $form = $this->createForm(new PersonType(), $person)
            ->add('save', 'submit');

        $form->handleRequest($request);

	    if ($form->isValid()) {
	    	$person = $form->getData();
	        $em = $this->getDoctrine()->getManager();
		    $em->persist($person);
		    $em->flush();

	        return $this->redirect($this->generateUrl('project_manager_people_list_person'));
	    }

        return array(
            'form' => $form->createView(),
        );
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $person = $em->getRepository('ProjectManagerPeopleBundle:Person')->find($id);
        $em->remove($person);
        $em->flush();
        return $this->redirect($this->generateUrl('project_manager_people_list_person'));
    }
}
