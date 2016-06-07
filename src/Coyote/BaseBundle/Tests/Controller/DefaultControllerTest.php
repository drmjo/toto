<?php

namespace Coyote\BaseBundle\Tests\Controller;

use Coyote\BaseBundle\Tests\BaseTestCase;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Router;
use Symfony\Bundle\FrameworkBundle\Client;

class DefaultControllerTest extends BaseTestCase
{
    /**
     * @var Client A Client instance
     */
    protected $client;

    protected function setUp()
    {
        $this->client = static::createClient();
        $this->createTestUser();
    }

    protected function tearDown()
    {
        $this->removeTestUser();
    }

	public function testLogin()
    {
        /**
         * @var $router \Symfony\Component\Routing\Router
         */
        $router = $this->client->getContainer()->get('router');

        try {
            $router->generate('fos_user_security_login');
        } catch(RouteNotFoundException $e)
        {
            $this->fail($e->getMessage());
        }

        $crawler = $this->client->request('GET', $router->generate('fos_user_security_login'));
		$this->assertEquals(200, $this->client->getResponse()->getStatusCode());

		$this->assertEquals(
            1,
            $crawler->filter('h2:contains("Please sign in")')->count()
		);

		//login test
		$form = $crawler->selectButton('Login')->form(array(
			'_username' => 'testuser',
			'_password' => 'testpassword',
		));

		$this->assertEquals(
            $router->generate('fos_user_security_check', [], true), // this generates an absolute url
            $form->getUri()
        );

		$this->client->submit($form);

		$this->assertTrue(
			$this->client->getResponse()->isRedirect()
		);

		$crawler = $this->client->followRedirect();

		$this->assertEquals(1, $crawler->filter('a:contains("Logout")')->count(), 'No Logout on page');
	}
	
// 	public function testFloodControl() {
// 		$this->client = static::createClient();
//        $router = $this->getRouter();
//
//        try {
//            $router->generate('fos_user_security_login');
//        } catch(RouteNotFoundException $e)
//        {
//            $this->fail($e->getMessage());
//        }
//
//
//        $crawler = $this->client->request('GET', $router->generate('fos_user_security_login'));
//
//		$form = $crawler->selectButton('Login')->form(array(
//				'_username' => 'wrong User',
//				'_password' => 'wrong Pass',
//		));
//
//		//try to login 4 times
//		for($i=0;$i<4;$i++){
//			$this->client->submit($form);
//		}
//
// 		$crawler = $this->client->followRedirect();
//		$this->assertEquals(
//				500,
//				$this->client->getResponse()->getStatusCode()
//		);
//
//		// after it blocks the user form logging in it records the attemps in the database
//		// that will cause all the other tests to fail ... it will block the localIP
//		// 127.0.0.1 any request comming from that ip will result in a 500
//		// all the entries from this test must be remove before the other tests can be performed
//
//		$em = $this->getDoctrine()->getManager();
//
//		$sql = "DELETE FROM cc_security_session WHERE login_attempt_username = :username";
//		$params = array('username'=>'wrong User');
//
//		$stmt = $em->getConnection()->prepare($sql);
//		$stmt->execute($params);
// 	}
}
