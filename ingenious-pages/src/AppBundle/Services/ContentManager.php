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
        $this->articlesPath = "http://localhost/content-service/v1/content"; //getenv("ARTICLES_PATH");
    }

    /**
     * Function which makes a request to the content service to retrieve all
     * the articles in the database
     *
     * @return string
     */
    public function getArticles() {
        return $this->getRequest($this->articlesPath);
    }

    /**
     * Function which makes a request to the content service to retrieve an
     * article with the string specified by the articleID parameter
     *
     * @param $articleId string the ID of the article to retrieve
     * @return string
     */
    public function getArticle($articleId) {

        // set the URL to retrieve an article from the content service
        $path = $this->articlesPath . "/" . $articleId;
        return $this->getRequest($path);
    }

    /**
     * Getter function for the client variable.
     *
     * Checks the existing client variable. If one doesn't exist, then a new one
     * is created using the url variable
     *
     * @return Client a guzzle client
     */
    private function getClient() {

        // check the client variable
        if ($this->client == null) {

            // create a new client
            $this->client = new Client(['base_uri' => $this->url]);
        }

        // return the client variable
        return $this->client;
    }

    /**
     * Helper function which takes a path and optional parameters and sends a GET
     * request to the path
     *
     * @param $path string: the URL to GET
     * @param $params array: the optional parameters
     * @return string: a JSON encoded response
     */
    private function getRequest($path, $params = []) {

        try {

            // get the client
            $client = $this->getClient();

            // send the request
            $response = $client->request('GET', $path, $params);

            // get the response body as a string
            $body = $response->getBody()->__toString();

            // create a JsonDecode class and create parse the response as JSON
            $decoder = new JsonDecode();
            return $decoder->decode($body, 'json');
        } catch (RequestException $e) {

            // TODO: rethrow exception
            return null;
        }
    }
}