<?php

namespace Coyote\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Form\Model\ChangePassword;

use Coyote\BaseBundle\Controller\DefaultController as Controller;
use Coyote\BaseBundle\Form\Type\UserAddFormType;
use Coyote\BaseBundle\Entity\User;

use Doctrine\Common\Util\Debug;

class UserController extends Controller
{
	public function listAction()
    {
    	
    	$userManager = $this->get('fos_user.user_manager');
    	
  		return $this->render('CoyoteBaseBundle:User:index.html.twig', array(
			'users' => $userManager->findUsers(),
		));
    }
        
    public function profileAction(Request $request)
    {
 		$form = $this->container->get('fos_user.change_password.form');
 		
 		if ('POST' === $request->getMethod()) {
 			$form->setData(new ChangePassword());
 			$form->bind($request);
 			 
 			if ($form->isValid()) {
 				$userManager = $this->get('fos_user.user_manager');
 				
 				$user = $this->getUser();
 				$user->setPlainPassword($form->getData()->new);
 				$userManager->updateUser($user);
 				$this->addSuccessFlash('Password changed');
 			
 			}
 		}
 		
    	return $this->render('CoyoteBaseBundle:User:profile.html.twig', array(
    			'form' => $form->createView(),
    	));
    	
    }
    
    protected function createCreateForm(User $entity)
    {
    	$form = $this->createForm('coyote_base_user_add', $entity, array(
    			'action' => $this->generateUrl('coyote_user_create'),
    			'method' => 'POST',
    			'validation_groups' => array('create', 'Default'),
    	));
    	
    	return $form;
    }
    
    public function showAction($id)
    {
    	$userManager = $this->get('fos_user.user_manager');
    	$user = $userManager->findUserBy(array('id' => $id));
    	 
    	
    	$banForm = $this->createBanForm($id);
    	
    	return $this->render('CoyoteBaseBundle:User:show.html.twig', array(
    		'user' => $user,
    		'ban_form' => $banForm->createView(),
    	));
    }
    
    public function newAction(Request $request)
    {
    	$user = new User();
		    	 
    	// we need to use this for the fos userbundle to validate the form
    	$form = $this->createCreateForm($user);
    	
    	return $this->render('CoyoteBaseBundle:User:new.html.twig', array(
    		'form' => $form->createView(),
    	));
    }
	
    public function createAction(Request $request)
    {
    	$user = new User();
    	
    	$form = $this->createCreateForm($user);
    	$form->handleRequest($request);
    	 
    	if ($form->isValid()) {
    		$userManager = $this->get('fos_user.user_manager');
    		
    		$userManager->updateUser($user);
    		$userManager->createUser();
    		
    		$this->addSuccessFlash('User created');
    		return $this->redirectToUrl('coyote_user_list');
    	}
    	
    	return $this->render('CoyoteBaseBundle:User:new.html.twig', array(
    			'form' => $form->createView(),
    	));
    }
    
    
	public function removeWarningAction($id){
		
		$userManager = $this->get('fos_user.user_manager');
		$user = $userManager->findUserBy(array('id' => $id));
		 
		if(!$user)
			throw $this->createNotFoundException('User not found!');
		
		$form = $this->createDeleteForm($id);
		
		return $this->render('CoyoteBaseBundle:User:delete.html.twig', array(
			'form' => $form->createView(),
			'user' => $user,
		));

	}
   /**
     * Creates a form to delete a Lead entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('coyote_user_remove', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    public function removeAction($id)
    {

    	$userManager = $this->get('fos_user.user_manager');
    	$user = $userManager->findUserBy(array('id' => $id));
    	
    	$username = $user->getUsername();
    	
    	if(!$user)
    		throw $this->createNotFoundException('User Not Found');
    	
        $userManager->deleteUser($user);

		return $this->redirect($this->generateUrl('coyote_user_list'));
	}
	
	protected function createEditForm(User $entity, $id)
	{
		$form = $this->createForm('coyote_base_user_add', $entity, array(
				'action' => $this->generateUrl('coyote_user_edit', array('id' => $id)),
				'method' => 'POST',
		));
		
		$form->remove('plainPassword');
		
		//$form->add('submit', 'submit', array('label' => 'Create'));
		 
		return $form;
	}    
    
    public function editAction(Request $request, $id)
    {
    	$user = $this->getManager()->getRepository('CoyoteBaseBundle:User')->find($id);
    	
    	$form = $this->createEditForm($user, $id);
    	 
    	if ('POST' === $request->getMethod()) {
    	
    		$form->handleRequest($request);
    		
    		if ($form->isValid()) {
    			$userManager = $this->get('fos_user.user_manager');
    			$userManager->updateUser($user);
    	
    			return $this->addSuccessFlashAndRedirect('User "' . $user->getUsername() . '" has been updated successfuly!', 'coyote_user_show', array('id' => $id));
    		}
    	
    	}
    	
    	return $this->render('CoyoteBaseBundle:User:edit.html.twig', array(
    			'form' => $form->createView(),
    	));
    }
    
    public function resetPasswordAsSuperAction($id)
    {
    	$user = $this->getManager()->getRepository('CoyoteBaseBundle:User')->find($id);
		
    	if(!$user)
    		return $this->addErrorFlashAndRedirect('User not found', 'coyote_user_list');
    	
    	$form = $this->container->get('fos_user.resetting.form');
    	$formHandler = $this->container->get('fos_user.resetting.form.handler');
    	$process = $formHandler->process($user);
    	
    	if ($process)
   			return $this->addSuccessFlashAndRedirect('Password changed', 'coyote_user_show', array('id' => $id));
    		    	
    	
    	
    	return $this->render('CoyoteBaseBundle:User:resetPasswordAsSuper.html.twig', array(
    		'user' => $user,
			'form' => $form->createView(),
    	));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function banAction(Request $request, $id)
    {
    	$userManager = $this->get('fos_user.user_manager');
    	$user = $userManager->findUserBy(array('id' => $id));
    	
    	if(!$user)
    		throw $this->createNotFoundException('User not found!');
    	
    	$form = $this->createBanForm($id);
   		$form->handleRequest($request);
   		 
   		if($form->isValid())
   		{
   			if($user->isEnabled())
   			{
   				$user->setEnabled(false);
   				$message = 'User Banned';
   					
   			}else{
   				$user->setEnabled(true);
   				$message = 'User Enabled';
   			}

   			$userManager->updateUser($user);
   			
   			
   			return $this->addSuccessFlashAndRedirect($message, 'coyote_user_show', array('id' => $id));
   			
   		}
    		
    	return $this->addErrorFlashAndRedirect('Could not perform this operation', 'coyote_user_show', array('id' => $id));
    }
    
    private function createBanForm($id){
    	return $this->createFormBuilder()
	    	->setAction($this->generateUrl('coyote_user_ban', array('id' => $id)))
	    	->setMethod('PUT')
	    	//->add('submit', 'submit', array('label' => 'Delete'))
	    	->getForm()
    		;
    }
}
