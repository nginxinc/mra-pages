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
 * Class UserManager is a service that provides communication with the
 * user-manager service
 *
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
     * UserManager constructor sets variables from environment variables and
     * sets the userID and email variables from the $authID and $email parameters,
     * respectively
     *
     * @param $authID string: the ID of the user associated with this UserManager
     * @param $email string: the email address of the user associated with this
     * UserManager
     */
    public function __construct($authID, $email = null) {
        $this->url = getenv("USERMANAGER_ENDPOINT_URL");
        $this->userPath = getenv("USERMANAGER_USER_PATH");
        $this->localUserPath = getenv("USERMANAGER_LOCAL_PATH");
        $this->userID = $authID;
        $this->email = $email;
    }

    /**
     * Getter function which uses the getRequest function to retrieve information
     * about the user specified by the userID variable
     *
     * @return $this
     */
    public function getUser() {

        // retrieve the user data from the user-manager service
        $user = $this->getRequest($this->userPath . "/" . $this->userID);

        // set this objects variables from the returned user
        $this->setUserData($user);

        return $this;
    }

    /**
     * @return $this|null
     *
     * Queries the User Manager for a user with the specified email address
     */
    public function getUserByEmail() {

        // ensure that the email variable is set
        if ($this->email == null) {
            return null;
        }

        // call the user-manager service
        $user = $this->getRequest($this->userPath."/email/".$this->email);

        // verify that the email address is not set
        if (isset($user->found) and $user->found == false) {
            return null;
        }

        $this->setUserData($user);
        $this->userID = $user->id;

        return $this;
    }

    /**
     * Create a user which can be authenticated locally
     *
     * @param $body array JSON encoded email and password
     * @return $this
     */
    public function createLocalUser($body) {

        // send the request to the user-manager service
        $user = $this->postRequest($this->userPath, $body);

        $this->setUserData($user);
        $this->userID = $user->id;

        return $this;
    }

    /**
     * Authorize a user local user
     *
     * @param $password string, the password to compare
     * @return bool
     */
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
    protected function setUserData($user) {
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
     * Calls the makeRequest function using the GET method and passes parameters
     *
     * @param $path string: the URL of the user-manager service
     * @param $params array: parameters to send with the request
     * @return string a JSON encoded response
     */
    private function getRequest($path, $params = []) {
        return $this->makeRequest($path, self::GET_METHOD, $params);
    }

    /**
     * Calls the makeRequest function using the POST method and passes parameters
     *
     * @param $path string: the URL of the user-manager service
     * @param $params array: parameters to send with the request
     * @return string a JSON encoded response
     */
    private function postRequest($path, $params = []) {
        return $this->makeRequest($path, self::POST_METHOD, $params);
    }

    /**
     * High order function which uses the $method parameter to send a request to the
     * specified $path
     *
     * @param $path string: the URL of the user-manager service
     * @param $method string: the HTTP method
     * @param $params array: parameters to send with the request
     * @return string a JSON encoded response
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