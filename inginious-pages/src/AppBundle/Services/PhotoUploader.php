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
 * Class PhotoUploader
 * @package AppBundle\Services
 */
class PhotoUploader
{
    /**
     * @var string
     */
    private $url;
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
        $this->url = getenv("PHOTOUPLOADER_ENDPOINT_URL");
        $this->uploaderPath = getenv("PHOTOUPLOADER_ALBUM_PATH");
    }

    /**
     * @param $userId
     * @return string
     */
    public function getUploader($userId) {
        $params = [
            'query' => [
                'user_id' => $userId
            ]
        ];

        return $this->getRequest($this->uploaderPath, $params);
    }


    /**
     * @return string
     */
    public function getUploaderPath() {
        $uploader = $this->uploaderPath;//because we have to use local proxy for JavaScript XHR
        return $uploader;
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
            return $body; //$decoder->decode($body, 'json');
        }
        catch (RequestException $e)
        {
            echo $e;
        }
    }
}