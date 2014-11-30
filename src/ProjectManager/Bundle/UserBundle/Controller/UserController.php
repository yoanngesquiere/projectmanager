<?php

namespace ProjectManager\Bundle\UserBundle\Controller;

use ProjectManager\Bundle\CoreBundle\Controller\AbstractController;
use ProjectManager\Bundle\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ProjectManager\Bundle\UserBundle\Form\Type\UserType;

class UserController extends AbstractController
{
    const REPOSITORY_NAME = 'ProjectManagerUserBundle:User';
    const BASE_URL = 'pm_user_user';

    /**
     * Lists the users
     *
     * @Template
     * @return array
     */
    public function indexAction()
    {
        $repository = $this->getRepository(self::REPOSITORY_NAME);
        $persons = $repository->findAll();

        $forms = $this->createDeleteFormsForList($persons, self::BASE_URL);

        return array(
            'persons' => $persons,
            'delete_forms' => $forms['delete_forms'],
        );
    }

    /**
     * @Template
     */
    public function updateAction(Request $request, $id=0)
    {
    	$person = new User();
        if ($id != 0) {
            $person = $this->getRepository(self::REPOSITORY_NAME)->find($id);
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

	        return $this->redirect($this->generateUrl(self::BASE_URL.'_list'));
	    }

        return array(
            'form' => $form->createView(),
        );
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $person = $em->getRepository(self::REPOSITORY_NAME)->find($id);
        $em->remove($person);
        $em->flush();
        return $this->redirect($this->generateUrl(self::BASE_URL.'_list'));
    }

}
