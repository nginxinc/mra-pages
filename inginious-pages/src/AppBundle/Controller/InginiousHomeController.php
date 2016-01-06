<?php
/**
 * Created by IntelliJ IDEA.
 * User: chrisstetson
 * Date: 11/16/15
 * Time: 9:58 AM
 */

namespace AppBundle\Controller;

use AppBundle\Services\PhotoManager;
use AppBundle\Services\PhotoUploader;
use AppBundle\Services\UserManager;
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
    private $userManager = null;
    private $loginRequired = "Welcome, But Please Login To Your Account";
    private $authID = null;
    private $user = null;
    private $banner = null;
    private $banner_message = "Upload an image for your banner.";
    private $bannerImages = null;
    private $bannerAlbumID = null;
    private $bannerPosterID = null;


    public function isAuthenticated(Request $request) {
        $this->authID = $request->headers->get('Auth-ID');

        if ($this->authID != "") {
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
     * @Route("/myphotos")
     */
    public function myphotosAction(Request $request)
    {
        if($this->isAuthenticated($request))
        {
            if($this->user == null)
            {
                $user = $this->getUserManager($this->authID)->getUser();
                $this->user = $user;
            }
            if($this->user->getBanner() != null)
            {
                $this->banner = $this->user->getBanner();
                $this->banner_message = "Welcome " . $this->firstName . " " . $this->lastName;
            }
            $catalog = $this->getPhotoManager($request)->getCatalog();
            return $this->render(
                '/home.html.twig',
                [
                    'firstName' => $this->firstName,
                    'lastName' => $this->lastName,
                    'authenticated' => 'header',
                    'catalogID' => $this->firstName . ' ' . $this->lastName . "&acute;s Photos",
                    'catalog' => $catalog,
                    'uploader' => $this->getPhotoUploader()->getUploaderPath(),
                    'banner' => $this->banner,
                    'banner_message' => $this->banner_message,
                    'user' => $this->user
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
     * @Route("/catalog")
     */
    public function catalogAction(Request $request)
    {

        if ($this->isAuthenticated($request)) {
            return $this->render('/catalog.html.twig',
                [
                    'firstName' => $this->firstName,
                    'lastName' => $this->lastName,
                    'authID' => $this->authID,
                    'authenticated' => 'header',
                    'catalogID' => $this->firstName . ' ' . $this->lastName . "&acute;s Photos",
                    'catalog' => $this->getPhotoManager($request)->getCatalog(),
                    'uploader' => $this->getPhotoUploader()->getUploaderPath(),
                ]

            );
        }
        else
        {
            $response = new Response();
            $response->setStatusCode(Response::HTTP_FORBIDDEN);
            return $response->send();
        }
    }

    /**
     * @Route("/album/{catalog}/{album}", name="album")
     */

    public function albumAction($catalog, $album, Request $request)
    {
        $album = $this->getPhotoManager($request)->getAlbum($album);
        $images = $album->images;

        if ($this->isAuthenticated($request)) {
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
        else
        {
            $response = new Response();
            $response->setStatusCode(Response::HTTP_FORBIDDEN);
            return $response->send();
        }
    }

    /**
     * @Route("/album/{banner}", name="banner")
     */

    public function bannerAction($banner, Request $request)
    {
        $album = $this->getPhotoManager($request)->getAlbum($banner);
        $photos = $album->images;

        if ($this->isAuthenticated($request)) {
            return $this->render(
                '/banner.html.twig',
                [
                    'firstName' => $this->firstName,
                    'lastName' => $this->lastName,
                    'authenticated' => 'header',
                    'album' => $album,
                    'images' => $photos
                ]
            );
        }
        else
        {
            $response = new Response();
            $response->setStatusCode(Response::HTTP_FORBIDDEN);
            return $response->send();
        }
    }

    /**
     * @Route("/account")
     */

    public function accountAction(Request $request)
    {
        if ($this->isAuthenticated($request)) {
            if($this->user == null)
            {
                $user = $this->getUserManager($this->authID)->getUser();
                $this->user = $user;
            }
            if($this->user->getBanner() != null)
            {
                $this->banner = $this->user->getBanner();
                $this->banner_message = "Welcome " . $this->firstName . " " . $this->lastName;
                $this->bannerImages = $this->user->getBannerAlbum()->images;
                $this->bannerAlbumID = $this->user->getBannerAlbum()->id;
                $this->bannerPosterID = $this->user->getBannerAlbum()->poster_image_id;
            }
            return $this->render(
                '/account.html.twig',
                [
                    'name' => $this->user->getName(),
                    'authenticated' => 'header',
                    'email' => $this->user->getEmail(),
                    'userManager' => $this->user->getLocalUserPath() . "/" . $this->user->getUserID(),
                    'uploader' => $this->getPhotoUploader()->getUploaderPath(),
                    'banner' => $this->banner,
                    'banner_message' => $this->banner_message,
                    'bannerImages' => $this->bannerImages,
                    'bannerAlbumID' => $this->bannerAlbumID,
                    'bannerPosterID' => $this->bannerPosterID
                ]
            );
        }
        else
        {
            $response = new Response();
            $response->setStatusCode(Response::HTTP_FORBIDDEN);
            return $response->send();
        }
    }


    /**
     * @return PhotoManager
     */
    private function getPhotoManager($request) {
        if($this->isAuthenticated($request)) {
            if ($this->photoManager == null) {
                $this->photoManager = new PhotoManager($this->authID);
            }

            return $this->photoManager;
        }
        else
        {
            $response = new Response();
            $response->setStatusCode(Response::HTTP_FORBIDDEN);
            return $response->send();
        }
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

    /**
     * @return UserManager
     */
    private function getUserManager($authID) {
        if ($this->userManager == null) {
            $this->userManager = new UserManager($authID);
        }

        return $this->userManager;
    }
}