<?php

namespace TotoBundle\DataFixtures\ORM;

use Coyote\BaseBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\UriSafeTokenGenerator;
use TotoBundle\Entity\Team;
use TotoBundle\Entity\Toto;
use TotoBundle\Entity\TotoEntry;

class LoadTotoData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $generator = new UriSafeTokenGenerator();

        $toto = new Toto();
        $toto->setPlayer('Majan');
        $toto = $this->addEntries($toto);
        $toto->setToken($generator->generateToken());
        $manager->persist($toto);
        $manager->flush();

        $toto = new Toto();
        $toto->setPlayer('Richard');
        $toto = $this->addEntries($toto);
        $toto->setToken($generator->generateToken());
        $manager->persist($toto);
        $manager->flush();

        $toto = new Toto();
        $toto->setPlayer('David');
        $toto = $this->addEntries($toto);
        $toto->setToken($generator->generateToken());
        $manager->persist($toto);
        $manager->flush();

        $toto = new Toto();
        $toto->setPlayer('Peter');
        $toto = $this->addEntries($toto);
        $toto->setToken($generator->generateToken());
        $manager->persist($toto);
        $manager->flush();
    }

    public function addEntries(Toto $toto)
    {
        for ($i = 1; $i <= 8; $i++) {
            $game = $this->getReference('game_' . $i);
            $totoEntry = new TotoEntry();
            $totoEntry->setGame($game);
            $toto->addEntry($totoEntry);
        }
        return $toto;
    }
    /**
     * @return int
     */
    public function getOrder()
    {
        return 40;
    }
}