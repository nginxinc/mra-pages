<?php
/**
//  AlbumManager.php
//  Pages
//
//  Copyright © 2017 NGINX Inc. All rights reserved.
 */

namespace AppBundle\Services;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\Serializer\Encoder\JsonDecode;

/**
 * Class AlbumManager
 * @package AppBundle\Services
 */
class AlbumManager {

    /**
     * @var string
     */
    private $url;
    /**
     * @var string
     */
    private $catalogPath;
    /**
     * @var string
     */
    private $imagesPath;
    /**
     * @var string
     */
    private $albumPath;
    /**
     * @var string
     */
    private $publicAlbumPath;
    /**
     * @var Client
     */
    private $client = null;
    /**
     * @var string
     */
    private $authID = null;

    /**
     * AlbumManager constructor. sets local variables from the system environment
     * variables
     *
     * @param $authID string used to set the authID variable. Represents the ID
     * of a specific user
     */
    public function __construct($authID) {
        $this->url = getenv("ALBUMMANAGER_ENDPOINT_URL") ?: "http://localhost";
        $this->catalogPath = getenv("ALBUMMANAGER_CATALOG_PATH") ?: "/album-manager/albums";
        $this->albumPath = getenv("ALBUMMANAGER_ALBUM_PATH") ?: "/album-manager/albums";
        $this->imagesPath = getenv("ALBUMMANAGER_IMAGES_PATH") ?: "/album-manager/images";
        $this->publicAlbumPath = getenv("ALBUMMANAGER_PUBLIC_PATH") ?: "/album-manager/public";
        $this->authID = $authID;

    }

    /**
     * Function which calls the getReqquest function to retrieve the catalog
     * for the current user from the album manager service
     *
     * The catalog is the top level album for a user and is created when the
     * user is created. When a user creates new albums, they are children of
     * this special catalog album
     *
     * @return string
     */
    public function getCatalog() {
        return $this->getRequest($this->catalogPath);
    }

    /**
     * Retrieve a specific album from the album manager service by calling the
     * getRequest function
     *
     * @param $albumId string, the ID of the album to retrieve
     *
     * @return string the response from the getRequest function
     */
    public function getAlbum($albumId) {

        // set the album path and concatenate the albumID
        $path = $this->albumPath . '/' . $albumId;

        return $this->getRequest($path);
    }

    /**
     * Retrieve a specific album from the album manager service by calling the
     * getRequest function
     *
     * @param $albumId string, the ID of the album to retrieve
     *
     * @return string the response from the getRequest function
     */
    public function getPublicAlbum($albumId) {

        // set the album path and concatenate the albumID
        $path = $this->publicAlbumPath . '/' . $albumId;

        return $this->getRequest($path);
    }

    /**
     * Function which calls getRequest to retrieve all the images for a specific
     * user
     *
     * @return string a JSON response which contains the URLs and IDs of the
     * images from the album manager service
     */
    public function getAllImages() {
        return $this->getRequest($this->imagesPath);
    }

    /**
     * Gets the client variable. If the variable is null, then a new Client
     * is created using the base URL and the authID variable which is the ID
     * of an user
     *
     * @return Client
     */
    private function getClient() {

        // check whether the client is null
        if ($this->client == null) {

            // create a new client and set it to the client variable
            $this->client = new Client(['base_uri' => $this->url, 'headers' => [
                'Auth-ID' => $this->authID
            ]]);
        }

        // return the client
        return $this->client;
    }

    /**
     * Function which is used to make GET requests to the album manager service
     *
     * @param $path string: the URL to call
     * @param $params array: an optional array of parameters
     * @return string: the response encoded as JSON
     */
    private function getRequest($path, $params = []) {

        try {

            // get the client
            $client = $this->getClient();

            // make the request
            $response = $client->request('GET', $path, $params);
            $body = $response->getBody()->__toString();

            // decode and return the response
            $decoder = new JsonDecode();
            return $decoder->decode($body, 'json');
        } catch (RequestException $e) {
            throw $e;
        }
    }
}