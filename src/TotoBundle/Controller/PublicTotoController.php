<?php

namespace TotoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TotoBundle\Entity\TotoEntry;
use TotoBundle\Entity\Toto;

class PublicTotoController extends Controller
{
    public function showAction($token)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var Toto $toto */
        $toto = $em->getRepository('TotoBundle\Entity\Toto')->findOneByToken($token);

        if (!$toto) {
            throw $this->createNotFoundException('Toto Not Found');
        }

        $entries = $toto->getEntries();

        $total = 0;
        foreach ($entries as $entry) {
            $this->calculatePoints($entry);
            $total = $entry->getPoints() + $total;
        }

        return $this->render('toto\public.html.twig', array(
            'toto' => $toto,
            'total' => $total,
        ));
    }

    public function calculatePoints(TotoEntry $entry)
    {
        $away_score_actual = $entry->getGame()->getAwayScore();
        $home_score_actual = $entry->getGame()->getHomeScore();
        $home_score_guessed = $entry->getHomeScore();
        $away_score_guessed = $entry->getAwayScore();


        if(null === $away_score_actual
            || null === $home_score_actual
            || null === $home_score_guessed
            || null === $away_score_guessed )
        {
            $entry->setPoints(null);
            return;
        }

        $away_score_actual = (int) $away_score_actual;
        $home_score_actual = (int) $home_score_actual;
        $away_score_guessed = (int) $away_score_guessed;
        $home_score_guessed = (int) $home_score_guessed;

        switch (true)
        {
            case $away_score_actual === $away_score_guessed
                && $home_score_actual === $home_score_guessed:
                $entry->setPoints(5);
                break;
            case $away_score_guessed - $home_score_guessed
                === $away_score_actual - $home_score_actual:
                $entry->setPoints(3);
                break;
            case ( $home_score_actual > $away_score_actual
                    && $home_score_guessed > $away_score_guessed )
                 || ( $home_score_actual < $away_score_actual
                    && $home_score_guessed < $away_score_guessed ):
                $entry->setPoints(1);
                break;
            default:
                $entry->setPoints(0);
        }

    }
}
