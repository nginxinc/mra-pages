<?php
/**
//  ContentManager.php
//  Pages
//
//  Copyright © 2017 NGINX Inc. All rights reserved.
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
        $this->url = getenv("CONTENTSERVICE_ENDPOINT_URL");
        $this->articlesPath = getenv("CONTENTSERVICE_ARTICLE_PATH"); //getenv("ARTICLES_PATH");
    }

    /**
     * @return string
     */
    public function getContentPath() {
        $content = $this->articlesPath;//because we have to use local proxy for JavaScript XHR
        return $content;
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
            return null; // echo $e;
        }
    }
}