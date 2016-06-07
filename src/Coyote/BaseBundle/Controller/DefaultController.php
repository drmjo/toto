<?php

namespace Coyote\BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class DefaultController extends Controller
{

	/**
	 * Entities and ORM
	 */
	protected function getManager(){
		return $this->getDoctrine()->getManager();
	}
	
	/**
	 * Flash Messages
	 */
	protected function addSuccessFlash($message){
		$this->addFlash('success', $message);
	}
	
	protected function addErrorFlash($message){
		$this->addFlash('error', $message);
	}
	
	protected function addFlash($type, $message){
		$this->get('session')->getFlashBag()->add(
				$type,
				$message
		);
	}
	/**
	 * logging 
	 */
	protected function getLogger(){
		return $this->get('logger');
	}
	
	/**
	 * Permissions and Security
	 */
	protected function isManager(){
		return $this->get('security.context')->isGranted('ROLE_MANAGER');
	}
	
    /**
     * Permissions and Security
     */
    protected function getSecurity()
    {
        return $this->get('security.authorization_checker');
    }

    /**
     * @return \Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher
     */
    protected function getDispatcher()
    {
        return $this->get('event_dispatcher');
    }


	/**
	 * Response methods
	 */
	
	protected function addErrorFlashAndRedirect($message, $url, $arguments = false){
		return $this->addFlashAndRedirect('error', $message, $url, $arguments);
	}
	
	protected function addSuccessFlashAndRedirect($message, $url, $arguments = false){
		return $this->addFlashAndRedirect('success', $message, $url, $arguments);
	}
	
	protected function addFlashAndRedirect($type, $message, $url, $arguments = false){
		$this->addFlash($type, $message);
		return $this->redirectToUrl($url, $arguments);
	}
	
	protected function redirectToUrl($url, $arguments = false){
	
		if($arguments){
			return $this->redirect($this->generateUrl($url, $arguments));
		} else {
			return $this->redirect($this->generateUrl($url));
		}
	}

    protected function jsonResponse($data = null, $pretty = false, $statusCode = 200)
    {
        $response = new JsonResponse($data, $statusCode);

        $debug = $this->container->get('kernel')->isDebug();

        if ($pretty || $debug)
            $response->setEncodingOptions(143);

        return $response->setData($data);
    }

}