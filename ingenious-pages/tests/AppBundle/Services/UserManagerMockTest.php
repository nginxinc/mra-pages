<?php
/**
 * User: charlespretzer
 * Date: 11/20/17
 * Time: 16:29
 *
 * Mocks responses from the user manager service
 */

namespace AppBundle\Services;

use Symfony\Component\Serializer\Encoder\JsonDecode;

class UserManagerMockTest extends UserManager {

    private $email;
    private $userID = "1";
    private $userPath;
    private $decoder;
    private $user;

    /**
     * JSON string representing a user
     * @var string
     */
    private $testUserData = <<<EOT
     {
        "id": "1", 
        "email" : "test@nginxps.com", 
        "name" : "Test", 
        "cover_pictures_id" : "2", 
        "profile_pictures_id" : "3",
        "article_pictures_id" : "4",
        "banner_url" : "Banner URL Value", 
        "profile_picture_url" : "Profile Picture URL",
        "local_id" : "5"
     } 
EOT;

    /**
     * UserManagerMockTest constructor. Overrides the UserManager constructor
     *
     * @param string $authID
     * @param null $email
     */
    public function __construct($authID, $email = null) {
        $this->decoder = new JsonDecode();
        $this->user = $this->decoder->decode($this->testUserData, 'json');
    }

    /**
     * Overrides the UserManager#getUserByEmail function
     *
     * @return $this
     */
    public function getUserByEmail() {

        $this->setUserData($this->user);
        $this->userID = $this->user->id;
        return $this;
    }

    /**
     * Overrides the UserManager#createLocalUser function
     *
     * @param array $body
     * @return $this
     */
    public function createLocalUser($body) {
        return $this;
    }

    /**
     * Overrides UserManager#getUserID function
     *
     * @return string
     */
    public function getUserID() {
        return $this->userID;
    }

    /**
     * Overrides the UserManager#authUser function. Always returns true
     *
     * @param string $password
     * @return bool
     */
    public function authUser($password) {
        return true;
    }

    /**
     * Overrides the UserManager#getUser function
     *
     * @return $this
     */
    public function getUser() {
        return $this;
    }
}