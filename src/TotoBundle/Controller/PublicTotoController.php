<?php

namespace TotoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PublicTotoController extends Controller
{
    public function showAction($token)
    {
        $em = $this->getDoctrine()->getManager();
        $toto = $em->getRepository('TotoBundle\Entity\Toto')->findOneByToken($token);

        if (!$toto) {
            throw $this->createNotFoundException('Toto Not Found');
        }

        return $this->render('toto\public.html.twig', array(
            'toto' => $toto,
        ));
    }

}
