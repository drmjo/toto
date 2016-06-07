<?php

namespace Coyote\BaseBundle\Controller;

use Coyote\BaseBundle\Controller\DefaultController as Controller;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller
{
	
    public function indexAction()
    {
		return new Response('base index');
    }
}