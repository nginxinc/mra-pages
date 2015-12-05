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
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
//        var_dump($this->getPhotoManager()->getCatalog(1)); exit;

        if ($this->isAuthenticated($request)) {
            return $this->render(
                '/home.html.twig',
                [
                    'firstName' => $this->firstName,
                    'lastName' => $this->lastName,
                    'authenticated' => 'header',
                    'catalogID' => 'orchids',
                    'catalog' => $this->getPhotoManager()->getCatalog(1)
                ]
            );
        }

        return $this->render('/index.html.twig');
    }

    /**
     * @Route("/album/{catalog}/{album}", name="album")
     */

    public function albumAction($catalog, $album, Request $request)
    {
        if ($this->isAuthenticated($request)) {
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
        } else {
            return $this->redirectToRoute('homepage');
        }
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
}