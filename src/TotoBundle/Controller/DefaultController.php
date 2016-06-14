<?php

namespace TotoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $games = $em->getRepository('TotoBundle\Entity\Game')->findAll();

        return $this->render('default\index.html.twig', [
            'games' => $games
        ]);
    }
}
