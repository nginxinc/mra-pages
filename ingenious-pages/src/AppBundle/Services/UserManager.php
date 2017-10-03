<?php
/**
//  UserManager.php
//  Pages
//
//  Copyright © 2017 NGINX Inc. All rights reserved.
 */

namespace AppBundle\Services;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\Serializer\Encoder\JsonDecode;

/**
 * Class UserManager
 * @package AppBundle\Services
 */
class UserManager {
    const GET_METHOD = 'GET';
    const POST_METHOD = 'POST';

    /**
     * @var string
     */
    private $url;
    /**
     * @var string
     */
    private $userPath;
    /**
     * @var string
     */
    private $localUserPath; //used for local, proxied XHR puts to the user manager

    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $facebookID;
    /**
     * @var string
     */
    private $googleID;

    /**
     * @var string
     */
    private $userID;

    /**
     * @var string
     */
    private $banner;

    /**
     * @var string
     */
    private $profilePicture;

    /**
     * @var number
     */
    private $profilePicturesID;

    /**
     * @var number
     */
    private $coverPicturesID;

    /**
     * @var Client
     */
    private $client = null;

    /**
     * @var string ID
     */
    private $localID = null;

    /**
     * @param string
     * @param $email
     * UserManager constructor.
     */
    public function __construct($authID, $email = null) {
        $this->url = getenv("USERMANAGER_ENDPOINT_URL");
        $this->userPath = getenv("USERMANAGER_USER_PATH");
        $this->localUserPath = getenv("USERMANAGER_LOCAL_PATH");
        $this->userID = $authID;
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getUser() {
        $user = $this->getRequest($this->userPath . "/" . $this->userID);
        $this->setUserData($user);
        return $this;
    }

    /**
     * @return $this|null
     *
     * Queries the User Manager for a user with the specified email address
     */
    public function getUserByEmail() {
        if ($this->email == null) {
            return null;
        }

        $user = $this->getRequest($this->userPath."/email/".$this->email);

        if (isset($user->found) and $user->found == false) {
            return null;
        }

        $this->setUserData($user);

        return $this;
    }

    public function createLocalUser($body) {
        $user = $this->postRequest($this->userPath, $body);

        $this->setUserData($user);
        $this->userID = $user->id;

        return $this;
    }

    public function authUser($password) {
        $body['email'] = $this->getEmail();
        $body['password'] = $password;
        $authResponse = $this->postRequest($this->userPath."/email/auth", ['json' => $body]);

        return $authResponse->authenticated == true;
    }

    /**
     * @param $user
     *
     * Set the member variables with the values from $user
     */
    private function setUserData($user) {
        $this->setEmail($user->email);

        if (isset($user->name)) {
            $this->setName($user->name);
        }
        
        $this->setCoverPicturesID($user->cover_pictures_id);
        $this->setProfilePicturesID($user->profile_pictures_id);
        if(isset($user->banner_url)) {
            $this->setBanner($user->banner_url);
        }
        if(isset($user->profile_picture_url)) {
            $this->setProfilePicture($user->profile_picture_url);
        }

        if(isset($user->facebook_id)) {
            $this->setFacebookID($user->facebook_id);
        } else if (isset($user->google_id)) {
            $this->setGoogleID($user->google_id);
        } else if (isset($user->local_id)) {
            $this->setLocalID($user->local_id);
        }

    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getUserID() {
        return $this->userID;
    }

    /**
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getGoogleID() {
        return $this->googleID;
    }

    /**
     * @return string
     */
    public function getFacebookID() {
        return $this->facebookID;
    }

    /**
     * @return string
     */
    public function getBanner() {
        return $this->banner;
    }

    /**
     * @return string
     */
    public function getProfilePicture() {
        return $this->profilePicture;
    }

    /**
     * @return number
     */
    public function getProfilePicturesID() {
        return $this->profilePicturesID;
    }

    /**
     * @return number
     */
    public function getCoverPicturesID() {
        return $this->coverPicturesID;
    }

    /**
     * @return string
     */
    public function getUserPath() {
        return $this->userPath;
    }

    /**
     * @return string
     */
    public function getLocalUserPath() {
        return $this->localUserPath;
    }

    /**
     * @return Client
     */
    private function getClient() {
        if ($this->client == null) {
            $this->client = new Client(['base_uri' => $this->url ]);
        }
        return $this->client;
    }

    /***************************SETTERS***********************?
    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @param string $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * @param string $facebookID
     */
    public function setFacebookID($facebookID) {
        $this->facebookID = $facebookID;
    }

    /**
     * @param string $googleID
     */
    public function setGoogleID($googleID) {
        $this->googleID = $googleID;
    }

    /**
     * @param string $banner
     */
    public function setBanner($banner) {
        $this->banner = $banner;
    }

    /**
     * @param string $profilePicture
     */
    public function setProfilePicture($profilePicture) {
        $this->profilePicture = $profilePicture;
    }

    /**
     * @param string $profilePicturesID
     */
    public function setProfilePicturesID($profilePicturesID) {
        $this->profilePicturesID = $profilePicturesID;
    }

    /**
     * @param string $coverPicturesID
     */
    public function setCoverPicturesID($coverPicturesID) {
        $this->coverPicturesID = $coverPicturesID;
    }

    /**
     * @param Client $client
     */
    public function setClient($client) {
        $this->client = $client;
    }

    /**
     * @return string localID
     */
    public function getLocalID()
    {
        return $this->localID;
    }

    /**
     * @param string $localID
     */
    public function setLocalID($localID)
    {
        $this->localID = $localID;
    }



    /***************************UTILS***********************?

    /**
     * @param $path
     * @param $params
     * @return string
     */
    private function getRequest($path, $params = []) {
        return $this->makeRequest($path, self::GET_METHOD, $params);
    }

    /**
     * @param $path
     * @param $params
     * @return string
     */
    private function postRequest($path, $params = []) {
        return $this->makeRequest($path, self::POST_METHOD, $params);
    }

    /**
     * @param $path
     * @param $method
     * @param $params
     * @return string
     */
    private function makeRequest($path, $method, $params = []) {
        try {
            $client = $this->getClient();
            $response = $client->request($method, $path, $params);

            $body = $response->getBody()->__toString();

            $decoder = new JsonDecode();
            $user = $decoder->decode($body, true);
            return $user;
        } catch (RequestException $e) {
            echo $e;
        }
    }
}