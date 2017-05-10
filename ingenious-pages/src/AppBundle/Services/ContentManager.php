<?php
/**
 * User: Eduard Borges
 */

namespace AppBundle\Services;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\Serializer\Encoder\JsonDecode;

/**
 * Class ContentManager
 * @package AppBundle\Services
 */
class ContentManager {
    /**
     * @var string
     */
    private $url;
    /**
     * @var string
     */
    private $articlesPath;
    /**
     * @var Client
     */
    private $client = null;

    /**
     * PhotoManager constructor.
     */
    public function __construct() {
        $this->articlesPath = "http://localhost/content-service/v1/content"; //getenv("ARTICLES_PATH");
    }

    /**
     * @return string
     */
    public function getArticles() {
        return $this->getRequest($this->articlesPath);
    }

    /**
     * @param $articleId
     * @return string
     */
    public function getArticle($articleId) {
        $path = $this->articlesPath . "/" . $articleId;
        return $this->getRequest($path);
    }

    /**
     * @return Client
     */
    private function getClient() {
        if ($this->client == null) {
            $this->client = new Client(['base_uri' => $this->url]);
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
        }
        catch (RequestException $e) {
            echo $e;
        }
    }
}