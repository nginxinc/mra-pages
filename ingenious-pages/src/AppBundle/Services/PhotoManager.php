<?php
/**
//  PhotoManager.php
//  Pages
//
//  Copyright © 2017 NGINX Inc. All rights reserved.
 */

namespace AppBundle\Services;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\Serializer\Encoder\JsonDecode;

/**
 * Class PhotoManager
 * @package AppBundle\Services
 */
class PhotoManager {
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
     * @var Client
     */
    private $client = null;
    /**
     * @var string
     */
    private $authID = null;

    /**
     * PhotoManager constructor.
     * @param $authID
     */
    public function __construct($authID) {
        $this->url = getenv("PHOTOMANAGER_ENDPOINT_URL");
        $this->catalogPath = getenv("PHOTOMANAGER_CATALOG_PATH");
        $this->albumPath = getenv("PHOTOMANAGER_ALBUM_PATH");
        $this->imagesPath = getenv("PHOTOMANAGER_IMAGES_PATH");
        $this->authID = $authID;

    }

    /**
     * @return string
     * @internal param $userId
     */
    public function getCatalog() {

        return $this->getRequest($this->catalogPath);
    }

    /**
     * @param $albumId
     * @return string
     */
    public function getAlbum($albumId) {
        $path = $this->albumPath . '/' . $albumId;

        return $this->getRequest($path);
    }

    public function getAllImages() {
        return $this->getRequest($this->imagesPath);
    }

    /**
     * @return Client
     */
    private function getClient() {
        if ($this->client == null) {
            $this->client = new Client(['base_uri' => $this->url, 'headers' => [
                'Auth-ID' => $this->authID
            ]]);
        }

        return $this->client;
    }

    /**
     * @param $path
     * @param $params
     * @return string
     */
    private function getRequest($path, $params = []) {
        try {
            $client = $this->getClient();

            $response = $client->request('GET', $path, $params);
            $body = $response->getBody()->__toString();

            $decoder = new JsonDecode();
            return $decoder->decode($body, 'json');
        } catch (RequestException $e) {
            echo $e;
        }
    }
}