<?php
/**
 * Created by PhpStorm.
 * User: benhorowitz
 * Date: 12/4/15
 * Time: 3:04 PM
 */

namespace AppBundle\Services;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\Serializer\Encoder\JsonDecode;

/**
 * Class UserManager
 * @package AppBundle\Services
 */
class UserManager
{
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
    private $bannerAlbum;//when set, will be an album object

    /**
     * @return Client
     */

    /**
     * @param Client $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * @var Client
     */
    private $client = null;

    /**
     * @param string
     * UserManager constructor.
     */
    public function __construct($authID) {
        $this->url = getenv("USERMANAGER_ENDPOINT_URL");
        $this->userPath = getenv("USERMANAGER_USER_PATH");
        $this->localUserPath = getenv("USERMANAGER_LOCAL_PATH");
        $this->userID = $authID;
        $photoManager = new PhotoManager($this->userID);
        //$this->setBannerAlbum(317);

    }

    /**
     *
     * @return string
     */
    public function getUser() {

        $user = $this->getRequest($this->userPath . "/" . $this->userID);
        $this->setEmail($user->email);
        $this->setName($user->name);
        if(isset($user->banner_album_id))
        {
            $photoManager = new PhotoManager($this->userID);
            $this->setBannerAlbum($photoManager->getAlbum($user->banner_album_id));
            $this->setBanner($this->bannerAlbum->poster_image->large_url); // TODO Fix bug
        }
        if(isset($user->facebook_id))
        {
            $this->setFacebookID($user->facebook_id);
        }
        else{
            $this->setGoogleID($user->google_id);
        }
        return $this;
    }

    /***************************GETTERS***********************?
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
    public function getBanner()
    {
        return $this->banner;
    }

    /**
     * @return string
     */
    public function getUserPath() {

        return $this->UserPath;
    }

    /**
     * @return string
     */
    public function getLocalUserPath() {

        return $this->localUserPath;
    }

    /**
     * @return string
     */
    public function getBannerAlbum()
    {
        return $this->bannerAlbum;
    }




    /***************************SETTERS***********************?
    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param string $facebookID
     */
    public function setFacebookID($facebookID)
    {
        $this->facebookID = $facebookID;
    }

    /**
     * @param string $googleID
     */
    public function setGoogleID($googleID)
    {
        $this->googleID = $googleID;
    }

    /**
     * @param string $banner
     */
    public function setBanner($banner)
    {
        $this->banner = $banner;
    }

    /**
     * @param string $bannerAlbum
     */
    public function setBannerAlbum($bannerAlbum)
    {
        $this->bannerAlbum = $bannerAlbum;
    }

    /***************************UTILS***********************?
    /**
     * @return Client
     */
    private function getClient() {
        if ($this->client == null) {
            $this->client = new Client(['base_uri' => $this->url ]);
        }

        return $this->client;
    }

    /**
     * @param $path
     * @param $params
     * @return string
     */
    private function getRequest($path, $params = []) {
        try
        {
            $client = $this->getClient();
            $response = $client->request('GET', $path, $params);

            $body = $response->getBody()->__toString();

            $decoder = new JsonDecode();
            $user = $decoder->decode($body, true);
            return $user;
        }
        catch (RequestException $e)
        {
            echo $e;
        }
    }
}