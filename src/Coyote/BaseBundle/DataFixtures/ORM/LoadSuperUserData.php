<?php

namespace Coyote\BaseBundle\DataFixtures\ORM;

use Coyote\BaseBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadSuperUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        $userManager = $this->container->get('fos_user.user_manager');

        $user = new User();
        $user->setUsername('admin');
        $user->setPlainPassword('1234');
        $user->setEmail('admin@example.com');
        $user->setEnabled(true);
        $user->addRole('ROLE_SUPER_ADMIN');

        $userManager->updateUser($user);
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 0;
    }
}