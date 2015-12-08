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
     * PhotoManager constructor.
     */
    public function __construct() {
        $this->url = getenv("PHOTOMANAGER_ENDPOINT_URL");
        $this->catalogPath = getenv("PHOTOMANAGER_CATALOG_PATH");
        $this->albumPath = getenv("PHOTOMANAGER_ALBUM_PATH");
    }

    /**
     * @param $userId
     * @return string
     */
    public function getCatalog($userId) {
        $params = [
            'query' => [
                'user_id' => $userId
            ]
        ];

        return $this->getRequest($this->catalogPath, $params);
    }

    /**
     * @param $albumId
     * @return string
     */
    public function getAlbum($albumId) {
        $path = $this->albumPath . '/' . $albumId;

        return $this->getRequest($path);
    }

    /**
     * @return Client
     */
    private function getClient() {
        if ($this->client == null) {
            $this->client = new Client(['base_uri' => 'http://' . $this->url]);
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
            return $decoder->decode($body, 'json');
        }
        catch (RequestException $e)
        {
            echo $e;
        }
    }
}