<?php 

namespace Coyote\BaseBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;

class BaseTestCase extends WebTestCase
{
    const TEST_USER = 'testuser';
    const TEST_PASSWORD = 'testpassword';

	protected function login($user = self::TEST_USER, $pass = self::TEST_PASSWORD)
	{
        $admin_host = $this->client->getContainer()->getParameter('admin_host');
        $this->client->setServerParameter('HTTP_HOST', $admin_host);
        $crawler = $this->client->request('GET', '/login');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

		//login test
		$form = $crawler->selectButton('Login')->form(array(
				'_username' => $user,
				'_password' => $pass,
		));

        $this->client->submit($form);
        $this->client->followRedirect();
	}

    protected function loginAs($username)
    {
        $session = $this->client->getContainer()->get('session');
        $userManager = $this->client->getContainer()->get('fos_user.user_manager');

        $user = $userManager->findUserByUsername($username);

        if(!$user)
            $this->fail('Invalid User');

        $firewall = 'main';
        $token = new UsernamePasswordToken($user, null, $firewall, $user->getRoles());
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);

    }

    protected function createTestUser()
    {
        $userManager = $this->client->getContainer()->get('fos_user.user_manager');

        $user = $userManager->createUser();
        $user->setEmail('sometest@example.com');
        $user->setUsername(self::TEST_USER);
        $user->setPlainPassword(self::TEST_PASSWORD);
        $user->setEnabled(true);
        $user->addRole('ROLE_SUPER_ADMIN');

        $userManager->updateUser($user);
    }

    protected function removeTestUser()
    {
        $userManager = $this->client->getContainer()->get('fos_user.user_manager');
        $user = $userManager->findUserByEmail('sometest@example.com');
        $userManager->deleteUser($user);
    }

//    /**
//     * @return \Symfony\Component\DependencyInjection\ContainerInterface
//     */
//    protected function getContainer()
//    {
//        $client = static::createClient();
//        return $client->getContainer();
//    }
//
//    /**
//     * @return \Symfony\Bundle\FrameworkBundle\Routing\Router
//     */
//    protected function getRouter()
//    {
//        return $this->getContainer()->get('router');
//    }
//
//    /**
//     * @return \Doctrine\Bundle\DoctrineBundle\Registry
//     */
//    protected function getDoctrine()
//    {
//        return $this->getContainer()->get('doctrine');
//    }
//
//    /**
//     * @return string
//     */
//    protected function getAdminHost()
//    {
//        return $this->getContainer()->getParameter('admin_host');
//    }
//
//    /**
//     * @return \FOS\UserBundle\Doctrine\UserManager
//     */
//    protected function getUserManager()
//    {
//        $container = $this->getContainer();
//        $userManager = $container->get('fos_user.user_manager');
//
//        return $userManager;
//    }

}