<?php

namespace TotoBundle\DataFixtures\ORM;

use Coyote\BaseBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use TotoBundle\Entity\Team;

class LoadTeamData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        $teams = [
            'Albania',
            'Austria',
            'Belgium',
            'Croatia',
            'Czech Republic',
            'England',
            'France',
            'Germany',
            'Hungary',
            'Iceland',
            'Italy',
            'Northern Ireland',
            'Poland',
            'Portugal',
            'Republic of Ireland',
            'Romania',
            'Russia',
            'Slovakia',
            'Spain',
            'Sweden',
            'Switzerland',
            'Turkey',
            'Ukraine',
            'Wales'
        ];

        foreach($teams as $key => $teamName)
        {
            $team = new Team();
            $team->setName($teamName);
            $manager->persist($team);
            $manager->flush();
            $this->addReference('team_' . ($key+1) , $team);
        }
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 10;
    }
}