<?php
/**
 * User: charlespretzer
 * Date: 11/20/17
 * Time: 18:43
 *
 * Mocks responses from the content service
 */

namespace AppBundle\Services;


use Symfony\Component\Serializer\Encoder\JsonDecode;

class ContentManagerMockTest extends ContentManager {

    /**
     * Holds a JsonDecode response
     *
     * @var JsonDecode
     */
    private $decoder;

    private $article1 = <<<EOT
    {
        "author" : "Article 1 Name", 
        "body" : "This is the body for test article 1",
        "date" : "12345",
        "extract":"Test Extract 1", 
        "id" : "1",
        "location" : "Article 1 Location", 
        "photo" : "Photo 1", 
        "title" : "Article 1" 
    }
EOT;

    private $article2 = <<<EOT
    {
        "author" : "Article 2 Name", 
        "body" : "This is the body for test article 2",
        "date" : "12345",
        "extract" : "Test Extract 2", 
        "id" : "2",
        "location" : "Article 2 Location", 
        "photo" : "Photo 2", 
        "title" : "Article 2" 
    }
EOT;

    private $articlesArray;

    /**
     * ContentManagerMockTest constructor.
     *
     * Overrides the ContentManager#__construct function and sets the decoder
     */
    public function __construct() {
        $this->decoder = new JsonDecode();
        $this->articlesArray = "[".$this->article1.",".$this->article2."]";
    }

    /**
     * Overrides the ContentManager#getArticles function
     *
     * @return null
     */
    public function getArticles() {
        return $this->decoder->decode($this->articlesArray, 'json');
    }

    /**
     * Overrides the ContentManager#getArticle function. Returns a single article
     *
     * @param string $articleId
     * @return mixed
     */
    public function getArticle($articleId) {

        foreach (array($this->article1, $this->article2) as $article ) {
            $articleJson = $this->decoder->decode($article, 'json');
            if ($articleId === $articleJson->id) {
                return $articleJson;
            }
        }

        return null;

    }


}