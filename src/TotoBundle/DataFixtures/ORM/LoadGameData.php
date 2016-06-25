<?php

namespace TotoBundle\DataFixtures\ORM;

use Coyote\BaseBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use TotoBundle\Entity\Game;
use TotoBundle\Entity\Team;

class LoadGameData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    private $counter = 1;

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

//+----+---------------------+---------------------+---------------------+
//| id | name                | created_at          | updated_at          |
//    +----+---------------------+---------------------+---------------------+
//|  1 | Albania             | 2016-06-07 23:09:52 | 2016-06-07 23:09:52 |
//|  2 | Austria             | 2016-06-07 23:09:52 | 2016-06-07 23:09:52 |
//|  3 | Belgium             | 2016-06-07 23:09:52 | 2016-06-07 23:09:52 |
//|  4 | Croatia             | 2016-06-07 23:09:52 | 2016-06-07 23:09:52 |
//|  5 | Czech Republic      | 2016-06-07 23:09:52 | 2016-06-07 23:09:52 |
//|  6 | England             | 2016-06-07 23:09:52 | 2016-06-07 23:09:52 |
//|  7 | France              | 2016-06-07 23:09:52 | 2016-06-07 23:09:52 |
//|  8 | Germany             | 2016-06-07 23:09:52 | 2016-06-07 23:09:52 |
//|  9 | Hungary             | 2016-06-07 23:09:52 | 2016-06-07 23:09:52 |
//| 10 | Iceland             | 2016-06-07 23:09:52 | 2016-06-07 23:09:52 |
//| 11 | Italy               | 2016-06-07 23:09:52 | 2016-06-07 23:09:52 |
//| 12 | Northern Ireland    | 2016-06-07 23:09:52 | 2016-06-07 23:09:52 |
//| 13 | Poland              | 2016-06-07 23:09:52 | 2016-06-07 23:09:52 |
//| 14 | Portugal            | 2016-06-07 23:09:52 | 2016-06-07 23:09:52 |
//| 15 | Republic of Ireland | 2016-06-07 23:09:52 | 2016-06-07 23:09:52 |
//| 16 | Romania             | 2016-06-07 23:09:52 | 2016-06-07 23:09:52 |
//| 17 | Russia              | 2016-06-07 23:09:52 | 2016-06-07 23:09:52 |
//| 18 | Slovakia            | 2016-06-07 23:09:52 | 2016-06-07 23:09:52 |
//| 19 | Spain               | 2016-06-07 23:09:52 | 2016-06-07 23:09:52 |
//| 20 | Sweden              | 2016-06-07 23:09:52 | 2016-06-07 23:09:52 |
//| 21 | Switzerland         | 2016-06-07 23:09:52 | 2016-06-07 23:09:52 |
//| 22 | Turkey              | 2016-06-07 23:09:52 | 2016-06-07 23:09:52 |
//| 23 | Ukraine             | 2016-06-07 23:09:52 | 2016-06-07 23:09:52 |
//| 24 | Wales               | 2016-06-07 23:09:52 | 2016-06-07 23:09:52 |
//+----+---------------------+---------------------+---------------------+

        $this->setupGame('team_21', 'team_13', $manager);
        $this->setupGame('team_24', 'team_12', $manager);
        $this->setupGame('team_4', 'team_14', $manager);

        $this->setupGame('team_7', 'team_15', $manager);
        $this->setupGame('team_8', 'team_18', $manager);
        $this->setupGame('team_9', 'team_3', $manager);

        $this->setupGame('team_11', 'team_19', $manager);
        $this->setupGame('team_6', 'team_10', $manager);
    }

    private function setupGame($home, $away, $manager)
    {
        $game = new Game();
        $game->setHomeTeam($this->getReference($home));
        $game->setAwayTeam($this->getReference($away));
        $this->addReference('game_' . $this->counter, $game);
        $this->counter++;
        $manager->persist($game);
        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 20;
    }
}
