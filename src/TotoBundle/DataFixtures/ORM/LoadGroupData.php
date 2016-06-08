<?php

namespace TotoBundle\DataFixtures\ORM;

use Coyote\BaseBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use TotoBundle\Entity\Group;
use TotoBundle\Entity\Team;

class LoadGroupData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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

        $group = new Group();
        $group->setName('A');
        $group->addTeam($this->getReference('team_7'));
        $group->addTeam($this->getReference('team_16'));
        $group->addTeam($this->getReference('team_1'));
        $group->addTeam($this->getReference('team_21'));
        $manager->persist($group);
        $manager->flush();

        $group = new Group();
        $group->setName('B');
        $group->addTeam($this->getReference('team_6'));
        $group->addTeam($this->getReference('team_17'));
        $group->addTeam($this->getReference('team_24'));
        $group->addTeam($this->getReference('team_18'));
        $manager->persist($group);
        $manager->flush();

        $group = new Group();
        $group->setName('C');
        $group->addTeam($this->getReference('team_8'));
        $group->addTeam($this->getReference('team_23'));
        $group->addTeam($this->getReference('team_13'));
        $group->addTeam($this->getReference('team_12'));
        $manager->persist($group);
        $manager->flush();

        $group = new Group();
        $group->setName('D');
        $group->addTeam($this->getReference('team_19'));
        $group->addTeam($this->getReference('team_5'));
        $group->addTeam($this->getReference('team_22'));
        $group->addTeam($this->getReference('team_4'));
        $manager->persist($group);
        $manager->flush();

        $group = new Group();
        $group->setName('E');
        $group->addTeam($this->getReference('team_3'));
        $group->addTeam($this->getReference('team_11'));
        $group->addTeam($this->getReference('team_15'));
        $group->addTeam($this->getReference('team_20'));
        $manager->persist($group);
        $manager->flush();

        $group = new Group();
        $group->setName('F');
        $group->addTeam($this->getReference('team_14'));
        $group->addTeam($this->getReference('team_10'));
        $group->addTeam($this->getReference('team_2'));
        $group->addTeam($this->getReference('team_9'));
        $manager->persist($group);
        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 30;
    }
}