<?php

namespace Coyote\BaseBundle\Tests\Controller;

use Coyote\BaseBundle\Tests\BaseTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

class UserControllerTest extends BaseTestCase
{
    /**
     * @var Client A Client instance
     */
    protected $client;

    protected function setUp()
    {
        $this->client = static::createClient();
        $this->createTestUser();
        $this->login();
    }

    protected function tearDown()
    {
        $this->removeTestUser();
    }

    public function testAddUser()
	{
        $router = $this->client->getContainer()->get('router');
        $this->client->request('GET', $router->generate('coyote_user_list'));

		$crawler = $this->client->getCrawler();

		$this->assertEquals(
				1,
				$crawler->filter('h1:contains("Users")')->count()
		);

		$crawler = $this->client->click($crawler->selectLink('Add User')->link());

        $form = $crawler->selectButton('Create')->form(array(
            'coyote_base_user_add[username]' => 'testuser2',
            'coyote_base_user_add[email]' => 'sometest2@example.com',
            'coyote_base_user_add[plainPassword][first]' => 'pass',
            'coyote_base_user_add[plainPassword][second]' => 'pass',
        ));

        foreach($form['coyote_base_user_add[roles]'] as $fm){
           $fm->tick();
        }

        $this->client->submit($form);
        $this->assertTrue(
            $this->client->getResponse()->isRedirect('/user/'),
            'not redirecting to user_list'
        );

        $crawler = $this->client->followRedirect();

		$this->assertEquals(
				1,
				$crawler->filter('tr:contains("sometest2@example.com")')->count()
		);


        foreach($this->client->getContainer()->getParameterBag()->get('coyote_base.roles') as $role)
        {
            $this->assertEquals(
                1,
                $crawler->filter('tr:contains("sometest2@example.com")')->filter('td:contains("' . $role['name'] . '")')->count()
            );
        };

        $userManager = $this->client->getContainer()->get('fos_user.user_manager');
        $user = $userManager->findUserByEmail('sometest2@example.com');
        $userManager->deleteUser($user);
	}
	
	public function testAddAlreadyExistingUser()
	{
        $this->client->request('GET', '/user/');

		$crawler = $this->client->getCrawler();
		
		$crawler = $this->client->click($crawler->selectLink('Add User')->link());

        $form = $crawler->selectButton('Create')->form(array(
            'coyote_base_user_add[username]' => 'testuser',
            'coyote_base_user_add[email]' => 'sometest@example.com',
            'coyote_base_user_add[plainPassword][first]' => 'pass',
            'coyote_base_user_add[plainPassword][second]' => 'pass',
        ));

        $crawler = $this->client->submit($form);

		$this->assertEquals(
				1,
				$crawler->filter('li:contains("The username is already taken!")')->count()
		);
		
		$this->assertEquals(
				1,
				$crawler->filter('li:contains("The email is already registered!")')->count()
		);
		
		$this->client->click($crawler->selectLink('Cancel')->link());
		
		$this->assertEquals(
                $this->client->getContainer()->get('router')->generate('coyote_user_list', [], true),
				$this->client->getRequest()->getUri()
		);
	}

	public function testChangePassword()
	{
        $router = $this->client->getContainer()->get('router');
        $this->client->request('GET', $router->generate('coyote_user_list'));
		$crawler = $this->client->getCrawler();
		
		$crawler = $this->client->click($crawler->filter('tr:contains("sometest@example.com")')->selectLink('Reset Password')->link());
		
		$form = $crawler->selectButton('Submit')->form(array(
				'fos_user_resetting_form[new][first]' => 'otherpass',
				'fos_user_resetting_form[new][second]' => 'otherpass',
		));
		
		$this->client->submit($form);
		
		$crawler = $this->client->followRedirect();

		$this->assertEquals(
				1,
				$crawler->filter('p:contains("test@example.com")')->count()
		);
		$this->assertEquals(
				1,
				$crawler->filter('li:contains("Password changed")')->count()
		);


        $this->client->request('GET', '/user/');

        $crawler = $this->client->getCrawler();

        $this->assertEquals(
            1,
            $crawler->filter('html:contains("testuser")')->count()
        );
	}

	public function testResetYourOwnPassword()
	{
        $router = $this->client->getContainer()->get('router');
        $this->client->request('GET', $router->generate('fos_user_profile_show'));

		$crawler = $this->client->getCrawler();

		$this->assertEquals(
				1,
				$crawler->filter('p:contains("sometest@example.com")')->count()
		);
		
		
		$form = $crawler->selectButton('Change Password')->form(array(
				'fos_user_change_password_form[current_password]' => 'testpassword',
				'fos_user_change_password_form[new][first]' => 'newpassword',
				'fos_user_change_password_form[new][second]' =>  'newpassword',
		));

		$crawler = $this->client->submit($form);
		
		$this->assertEquals(
				1,
				$crawler->filter('li:contains("Password changed")')->count()
		);

        $admin_host = $this->client->getContainer()->getParameter('admin_host');
        $client = $this->client;
        $client->request('GET', '/logout');
        $crawler = $client->request('GET', '/login');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        //login test
        $form = $crawler->selectButton('Login')->form(array(
            '_username' => BaseTestCase::TEST_USER,
            '_password' => 'newpassword',
        ));

        $client->submit($form);
        $client->followRedirect();

        $client->request('GET', '/user/');

        $crawler = $this->client->getCrawler();

        $this->assertEquals(
            1,
            $crawler->filter('html:contains("testuser")')->count()
        );
	}
	

	public function testBanUser()
	{
        $this->client->request('GET', $this->client->getContainer()->get('router')->generate('coyote_user_list'));

		$crawler = $this->client->getCrawler();
	
        $user = $this->client->getContainer()->get('fos_user.user_manager')->findUserByEmail('sometest@example.com');

		$crawler = $this->client->request('GET', $this->client->getContainer()->get('router')->generate('coyote_user_show', array('id' => $user->getId())));

		$form = $crawler->selectButton('Ban')->form();
		
		$this->client->submit($form);
		$crawler = $this->client->followRedirect();
		
		
		$this->assertEquals(
				1,
				$crawler->filter('li:contains("User Banned")')->count()
		);
		
		$form = $crawler->selectButton('Activate')->form();
		
		$this->client->submit($form);
		$crawler = $this->client->followRedirect();
		
		$this->assertEquals(
				1,
				$crawler->filter('li:contains("User Enabled")')->count()
		);
	}
	
	public function testEditUser()
	{
        $user = $this->client->getContainer()->get('fos_user.user_manager')->findUserByEmail('sometest@example.com');

        $url = $this->client->getContainer()->get('router')->generate('coyote_user_edit', array('id' => $user->getId()));
        $this->client->request('GET', $url);

		$crawler = $this->client->getCrawler();
	
		$form = $crawler->selectButton('Save')->form(array(
				'coyote_base_user_add[username]' => 'testuseredited',
				'coyote_base_user_add[email]' => 'test_edited@example.com',
		));
		
		$this->client->submit($form);
		$crawler = $this->client->followRedirect();
		
		$this->assertEquals(
				1,
				$crawler->filter('p:contains("test_edited@example.com")')->count()
		);
		
		$this->assertEquals(
				1,
				$crawler->filter('p:contains("testuseredited")')->count()
		);
        // change back the user email so the tear down can remove it ...

        $userManager = $this->client->getContainer()->get('fos_user.user_manager');
        $user = $userManager->findUserByEmail('test_edited@example.com');
        $user->setEmail('sometest@example.com');
        $userManager->updateUser($user);
    }
	
	public function testRemoveUser()
	{

        $userManager = $this->client->getContainer()->get('fos_user.user_manager');

        $user = $userManager->createUser();
        $user->setEmail('deleteme@example.com');
        $user->setUsername('deleteme');
        $user->setPlainPassword('testpassword');
        $userManager->updateUser($user);

        $user->getId();

        $url = $this->client->getContainer()->get('router')->generate('coyote_user_remove_warning', array('id' => $user->getId()));
        $this->client->request('GET', $url);

		$crawler = $this->client->getCrawler();
		
		$form = $crawler->selectButton('Delete')->form();
		$this->client->submit($form);

        $this->assertTrue(
            $this->client->getResponse()->isRedirect('/user/')
        );

        $user = $userManager->findUserByEmail('deleteme@example.com');

        $this->assertNull($user);

	}

    //////////////////////////////////////////////////////////
    // the access rights are application specific           //
    // this should be tested on the local application level //
    // but we'll leave it here maybe change my mind i do    //
    //////////////////////////////////////////////////////////

//	public function testPublicAccess()
//	{
//		$this->publicAccessAssertion('GET', '/user/');
//		$this->publicAccessAssertion('GET', '/user/new');
//		$this->publicAccessAssertion('GET', '/user/profile');
//    	$this->publicAccessAssertion('GET', '/user/show/44');
//    	$this->publicAccessAssertion('GET', '/user/edit/44');
//    	$this->publicAccessAssertion('GET', '/user/remove_warning/44');
//    	// POST methods
//    	$this->publicAccessAssertion('POST', '/user/edit/44');
//    	$this->publicAccessAssertion('POST', '/user/reset-password-as-super/44');
//		$this->publicAccessAssertion('POST', '/user/create');
//		$this->publicAccessAssertion('POST', '/user/remove/44');
//		// PUT methods
//		$this->publicAccessAssertion('PUT', '/user/ban/44');
//
//	}

//	protected function publicAccessAssertion($method, $url)
//	{
//		$client = static::createClient();
//		$crawler = $client->request($method, $url);
//		$this->assertTrue(
//				$client->getResponse()->isRedirect('http://localhost/login'),
//				'Not redirecting to login'
//		);
//	}
}
