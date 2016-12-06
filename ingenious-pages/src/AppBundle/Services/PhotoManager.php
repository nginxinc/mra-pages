<?php
/**
 * Created by Intellij.
 * User: Chris Stetson
 * Date: 12/4/15
 * Time: 3:04 PM
 */

namespace AppBundle\Services;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\Serializer\Encoder\JsonDecode;

/**
 * Class PhotoManager
 * @package AppBundle\Services
 */
class PhotoManager
{
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
    private $albumPath;
    /**
     * @var string
     */
    private $uploaderURL;
    /**
     * @var string
     */
    private $uploaderPath;
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
     */
    public function __construct($authID) {
        $this->url = getenv("PHOTOMANAGER_ENDPOINT_URL");
        $this->catalogPath = getenv("PHOTOMANAGER_CATALOG_PATH");
        $this->albumPath = getenv("PHOTOMANAGER_ALBUM_PATH");
        $this->authID = $authID;

    }

    /**
     * @param $userId
     * @return string
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
        $path = '/images';
        return $this->getRequest($path);
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
        try
        {
            $client = $this->getClient();
            //$client->
            $response = $client->request('GET', $path, $params);
            $body = $response->getBody()->__toString();

            $decoder = new JsonDecode();
            return $decoder->decode($body, 'json');
        }
        catch (RequestException $e)
        {
            echo $e;
        }
    }
}