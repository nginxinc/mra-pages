<?php
/**
 * User: charlespretzer
 * Date: 11/20/17
 * Time: 17:24
 *
 * Mocks responses from the album manager service
 *
 */

namespace AppBundle\Services;


use Symfony\Component\Serializer\Encoder\JsonDecode;

class AlbumManagerMockTest extends AlbumManager {

    private $decoder;

    /**
     * JSON representation of an album item
     *
     * @var string
     */
    private $albumJson = <<<EOT
    [
        {
            "id" : "1", 
            "name" : "test album",
            "description" : "Album with hardcoded JSON for tests",
            "created_at" : "12345",
            "updated_at" : "12345",
            "user_id" : "1",
            "poster_image_id" : "1",
            "state" : "saved"
        }
    ]
EOT;

    /**
     * JSON representation of two image items
     *
     * @var string
     */
    private $imageJson = <<<EOT
    [
        {
            "id" : "1",
            "name" : "Test Image 1",
            "description" : "Hardcoded image test info",
            "created_at" : "12345",
            "updated_at" : "12345",
            "album_id" : "1",
            "url" : "https://someaddress.jpg",
            "thumb_url" : "https://someaddress_thumb.jpg",
            "thumb_height" : "20",
            "thumb_width" : "20", 
            "medium_url" : "https://someaddress_medium.jpg",
            "medium_height" : "50",
            "medium_width" : "50",
            "large_url" : "https://someaddress_large.jpg",
            "large_height" : "100",
            "large_width" : "100"
        },
        {
            "id" : "2",
            "name" : "Test Image 2",
            "description" : "Hardcoded image test info 2",
            "created_at" : "12345",
            "updated_at" : "12345",
            "album_id" : "1",
            "url" : "https://someaddress2.jpg",
            "thumb_url" : "https://someaddress2_thumb.jpg",
            "thumb_height" : "20",
            "thumb_width" : "20", 
            "medium_url" : "https://someaddress2_medium.jpg",
            "medium_height" : "50",
            "medium_width" : "50",
            "large_url" : "https://someaddress2_large.jpg",
            "large_height" : "100",
            "large_width" : "100"
        }        
    ]
EOT;

    /**
     * AlbumManagerMockTest constructor. Overrides parent method and creates
     * a decoder instance to be used by the functions in the class
     *
     * @param string $authID
     */
    public function __construct($authID) {
        $this->decoder = new JsonDecode();
    }

    /**
     * Overrides AlbumManager#getAllImages() method. Encodes the
     * $imageJson string to JSON
     *
     * @return mixed
     */
    public function getAllImages() {
        return $this->decoder->decode($this->imageJson, 'json');
    }

    /**
     * Overrides the AlbumManager#getCatalog() function. Encodes the $albumJson
     * variable as JSON
     *
     * @return mixed
     */
    public function getCatalog() {
        return $this->decoder->decode($this->albumJson, 'json');
    }
}