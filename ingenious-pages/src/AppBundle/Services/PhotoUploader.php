<?php
/**
//  PhotoUploader.php
//  Pages
//
//  Copyright © 2017 NGINX Inc. All rights reserved.
 */

namespace AppBundle\Services;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * Class PhotoUploader stores the path to the uploader service
 *
 * @package AppBundle\Services
 */
class PhotoUploader {

    /**
     * @var string
     */
    private $uploaderPath;


    /**
     * AlbumManager constructor.
     *
     * Sets some variables from system environment variables
     */
    public function __construct() {
        $this->uploaderPath = getenv("PHOTOUPLOADER_ALBUM_PATH");
    }


    /**
     * Return the uploader variable set from the system environment variable in
     * the constructor
     *
     * @return string
     */
    public function getUploaderPath() {

        // we have to use local proxy for JavaScript XHR
        $uploader = $this->uploaderPath;
        return $uploader;
    }

}