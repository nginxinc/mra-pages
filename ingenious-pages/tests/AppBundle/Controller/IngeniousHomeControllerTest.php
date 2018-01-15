<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class IngeniousHomeControllerTest runs tests against the IngeniousHomeController
 *
 * @package Tests\AppBundle\Controller
 */
class IngeniousHomeControllerTest extends WebTestCase {

    private $authID = null;
    private static $email = 'testing@nginxps.com';
    private static $password = 'testing123';
    private static $articleId = '1';

    /**
     * Test the index route "/"
     */
    public function testIndex() {
        print "---------\ntestIndex\n---------\n";
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Ingenious', $crawler->filter('.hero-banner-title')->text());
    }

    /**
     * Test loading the login page "/login" with a GET request
     */
    public function testLoginGet() {
        print "---------\ntestLoginGet\n---------\n";
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Log in with Facebook', $crawler->filter('#ing_fb_login')->text());
        $this->assertEquals('Log in with Google', $crawler->filter('#ing_gp_login')->text());
        $this->assertGreaterThan(0, $crawler->filter('#user-login')->count());
    }

    /**
     * Test the about page "/about"
     */
    public function testAbout() {
        print "---------\ntestAbout\n---------\n";
        $client = static::createClient();

        $crawler = $client->request('GET', '/about');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('About Microservices', $crawler->filter('.page-header .page-title')->text());
    }

    /**
     * Try to load the photos page without authenticating
     */
    public function testMyPhotosUnauthenticated() {
        print "---------\ntestMyPhotosUnauthenticate\n---------\n";
        $client = static::createClient();

        $crawler = $client->request('GET', '/myphotos');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());

    }

    /**
     * Test creating a user by sending a POST to "/login"
     *
     * @return array|null|string
     */
    public function testCreateUser() {
        print "---------\ntestCreateUser\n---------\n";
        $client = static::createClient(array('debug' => true));
        $body['email'] = 'test@nginxps.com';
        $body['password'] = 'testing';

        $crawler = $client->request('POST',
            '/login', array('email' => self::$email,
                'password' => self::$password), array());
        
        $this->authID = $client->getResponse()->headers->get('Auth-ID');

        $this->assertTrue($this->authID != null);
        return $this->authID;
    }

    /**
     * @depends testCreateUser
     */
    public function testMyPhotos($authID) {
        print "---------\ntestMyPhotos\n---------\n";
        $client = static::createClient(array('debug' => true));

        $crawler = $client->request('GET',
            '/myphotos', array(), array(),
            array('HTTP_Auth-ID' => $authID, 'HTTP_Auth-Provider' => 'local')
        );
        
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
//        print $client->getResponse()->getContent();
        $this->assertContains("My Albums", $crawler->filter('#albums h3.page-title')->text());
    }
    
    /**
     * @depends testCreateUser
     */
    public function testAccount($authID) {
        print "---------\ntestAccount\n---------\n";
        $client = static::createClient(array('debug' => true));

        $crawler = $client->request('GET',
            '/account', array(), array(),
            array('HTTP_Auth-ID' => $authID, 'HTTP_Auth-Provider' => 'local')
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertGreaterThan(0, $crawler->filter('#account-manager')->count());
        $this->assertGreaterThan(0, $crawler->filter('#name')->count());
        $this->assertGreaterThan(0, $crawler->filter('#email')->count());
        $this->assertContains("Update My Account", $crawler->filter('#update-account-button')->text());
    }


    /**
     * Test loading a story with the ID specified in self::$articleId

    public function testStoriesPath() {
        print "---------\ntestStoriesPath\n---------\n";
        $client = static::createClient(array('debug' => true));

        $crawler = $client->request('GET', "/stories/".self::$articleId);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
//        $this->assertGreaterThan(0, $crawler->filter('#account-manager')->count());
//        $this->assertGreaterThan(0, $crawler->filter('#name')->count());
//        $this->assertGreaterThan(0, $crawler->filter('#email')->count());
        $this->assertContains("Article ".self::$articleId, $crawler->filter('.single-post-title h1')->text());
        $this->assertContains("Article ".self::$articleId." Name", $crawler->filter('.author-meta h4')->text());
    }
     */

}
