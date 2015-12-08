<?php
/**
 * Created by IntelliJ IDEA.
 * User: chrisstetson
 * Date: 11/16/15
 * Time: 9:58 AM
 */

// src/AppBundle/Controller/LuckyController.php
namespace AppBundle\Controller;

use AppBundle\Services\PhotoManager;
use AppBundle\Services\PhotoUploader;
use GuzzleHttp\Exception\RequestException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\HeaderBag;
use GuzzleHttp\Client;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Encoder\JsonEncode;


class InginiousHomeController extends Controller
{

    private $name;
    private $firstName;
    private $lastName;
    private $photoManager = null;
    private $photoUploader = null;
    private $loginRequired = "Welcome, But Please Login To Your Account";

    public function isAuthenticated(Request $request) {
        $authID = $request->headers->get('Auth-ID');

        if ($authID != "") {
            $this->name = $request->headers->get('Auth-Name');

            $names = explode(' ', $this->name);
            $this->firstName = $names[0];
            $this->lastName = $names[1];

            return true;
        } else {
            return false;
        }
    }

    /**
     * @Route("/")
     */
    public function indexAction(Request $request)
    {
        return $this->render('/index.html.twig');
    }

    /**
     * @Route("/home")
     */
    public function homeAction(Request $request)
    {
        if($this->isAuthenticated($request))
        {
            return $this->render(
                '/home.html.twig',
                [
                    'firstName' => $this->firstName,
                    'lastName' => $this->lastName,
                    'authenticated' => 'header',
                    'catalogID' => 'orchids',
                    'catalog' => $this->getPhotoManager()->getCatalog(1),
                    'uploader' => $this->getPhotoUploader()->getUploader(1)
                ]
            );
        }
        else
        {
            $response = new Response();
            $response->setStatusCode(Response::HTTP_FORBIDDEN);
            return $this->render('/index.html.twig',
                [
                    'loginRequired' => $this->loginRequired
                ]
            );

        }
    }

    /**
     * @Route("/album/{catalog}/{album}", name="album")
     */

    public function albumAction($catalog, $album, Request $request)
    {
        $album = $this->getPhotoManager()->getAlbum($album);
        $images = $album->images;

        return $this->render(
            '/album.html.twig',
            [
                'firstName' => $this->firstName,
                'lastName' => $this->lastName,
                'authenticated' => 'header',
                'catalogID' => $catalog,
                'album' => $album,
                'images' => $images
            ]
        );
    }

    /**
     * @return PhotoManager
     */
    private function getPhotoManager() {
        if ($this->photoManager == null) {
            $this->photoManager = new PhotoManager();
        }

        return $this->photoManager;
    }

    /**
     * @return PhotoUploader
     */
    private function getPhotoUploader() {
        if ($this->photoUploader == null) {
            $this->photoUploader = new PhotoUploader();
        }

        return $this->photoUploader;
    }
}