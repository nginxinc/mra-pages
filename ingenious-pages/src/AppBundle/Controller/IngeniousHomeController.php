<?php
/**
//  IngeniousHomeController.php
//  Pages
//
//  Copyright © 2017 NGINX Inc. All rights reserved.
 */

namespace AppBundle\Controller;

use AppBundle\Services\ContentManager;
use AppBundle\Services\PhotoManager;
use AppBundle\Services\PhotoUploader;
use AppBundle\Services\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;



class IngeniousHomeController extends Controller {

    private $name;
    private $firstName;
    private $lastName;
    private $photoManager = null;
    private $contentManager = null;
    private $photoUploader = null;
    private $userManager = null;
    private $authID = null;
    private $user = null;
    private $banner = null;
    private $banner_message = "Upload an image for your banner.";
    private $bannerImages = null;
    private $bannerAlbumID = null;
    private $bannerPosterID = null;
    private $profilePicture = "null";
    private $profilePicturesID = null;
    private $coverPicturesID = null;


    public function isAuthenticated(Request $request) {
        $this->authID = $request->headers->get('Auth-ID');
        if ($this->authID != "") {

            if ($request->headers->get('Auth-Name')) {
                $this->name = $request->headers->get('Auth-Name');
                $names = explode(' ', $this->name);
                $this->firstName = $names[0];
                $this->lastName = $names[1];
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @Route("/")
     */
    public function indexAction() {
        if(isset($_COOKIE["auth_token"]) && ($_COOKIE["expires_at"]) > time()) {
            $isAuthenticated = true;
        } else {
            $isAuthenticated = false;
        }
        $articles = $this->getContentManager()->getArticles();
        return $this->render(
            '/index.html.twig',
            [
                'uploader' => $this->getPhotoUploader()->getUploaderPath(),
                'authenticated' => $isAuthenticated,
                'articles' => $articles
            ]
        );
    }

    /**
     * @Route("/myphotos")
     * @param Request $request
     * @return Response
     */
    public function myphotosAction(Request $request) {
        if($this->isAuthenticated($request)) {
            $isAuthenticated = true;
            if ($this->user == null) {
                $user = $this->getUserManager($this->authID)->getUser();
                $this->user = $user;
            }
            if($this->user->getProfilePicture() != null) {
                $this->profilePicture = $user->getProfilePicture();
            }
            if($this->user->getProfilePicturesID() != null) {
                $this->profilePicturesID = $user->getProfilePicturesID();
            }
            if($this->user->getCoverPicturesID() != null) {
                $this->coverPicturesID = $user->getCoverPicturesID();
            }
            $allImages = $this->getPhotoManager($request)->getAllImages();
            $catalog = $this->getPhotoManager($request)->getCatalog();
            return $this->render(
                '/home.html.twig',
                [
                    'firstName' => $this->firstName,
                    'lastName' => $this->lastName,
                    'authenticated' => $isAuthenticated,
                    'catalogID' => $this->firstName . ' ' . $this->lastName . "&acute;s Photos",
                    'catalog' => $catalog,
                    'uploader' => $this->getPhotoUploader()->getUploaderPath(),
                    'banner' => $user->getBanner(),
                    'banner_message' => $this->banner_message,
                    'user' => $this->user,
                    'allImages' => $allImages,
                    'coverPicturesID' => $this->coverPicturesID,
                    'profilePicturesID' => $this->profilePicturesID,
                    'profilePicture' => $this->profilePicture,
                    'userManager' => trim( $this->user->getLocalUserPath() ) . "/" . $this->user->getUserID()
                ]
            );
        } else {
            $this->_send_forbidden_status_response();
        }
    }

    /**
     * @Route("/stories/{articleID}/{slug}")
     * @param $articleID
     * @return Response
     */
    public function storiesAction($articleID) {
        if(isset($_COOKIE["auth_token"]) && ($_COOKIE["expires_at"]) > time()) {
            $isAuthenticated = true;
        } else {
            $isAuthenticated = false;
        }
        $article = $this->getContentManager()->getArticle($articleID);
        return $this->render(
            '/post-article.html.twig',
            [
                'uploader' => $this->getPhotoUploader()->getUploaderPath(),
                'authenticated' => $isAuthenticated,
                'article' => $article
            ]
        );
    }
    
    /**
     * @Route ("/login")
     * @Method ("GET")
     */
    public function loginAction() {
        if(isset($_COOKIE["auth_token"]) && ($_COOKIE["expires_at"]) > time()) {
            $isAuthenticated = true;
        } else {
            $isAuthenticated = false;
            unset($_COOKIE['auth_provider']);
        }
        return $this->render(
            '/login.html.twig',
            [
                'uploader' => $this->getPhotoUploader()->getUploaderPath(),
                'authenticated' => $isAuthenticated
            ]
        );
    }

    /**
     * @Route ("/login")
     * @Method ("POST")
     */
    public function loginPostAction(Request $request) {
        
        if ($this->isAuthenticated($request)) {
            if ($this->user == null) {
                $this->user = $this->getUserManager($this->authID, $request->request->get('email'))->getUser();
            }
        } else {
            $this->user = $this->getUserManager($this->authID, $request->request->get('email'))->getUserByEmail();
        }

        if ($this->user == null) {
            // create a new user and log them in
            $body['email'] = $request->request->get('email');
            $body['password'] = $request->request->get('password');
            $this->user = $this->getUserManager($this->authID, $request->request->get('email'))->createLocalUser(['json' => $body]);

            $this->authID = $this->user->getUserID();
            $isAuthenticated = true;
        } else {
            // compare the password with existing password
            $isAuthenticated = $this->user->authUser($request->request->get('password'));
        }

        if ($isAuthenticated) {
            $response = $this->redirectToRoute('account');
            $response->headers->setCookie(new Cookie('expires_at', microtime()+86400000), microtime()+86400000);
            $response->headers->setCookie(new Cookie('auth_token', $this->user->getLocalId()), microtime()+86400000);
            $response->headers->setCookie(new Cookie('auth_provider', 'local'), microtime()+86400000);
            $response->headers->set('Auth-ID', $this->authID);
            return $response;
        } else {
            return $this->render(
                '/login.html.twig',
                [
                    'uploader' => $this->getPhotoUploader()->getUploaderPath(),
                    'authenticated' => $isAuthenticated
                ]
            );
        }
    }

    /**
     * @Route ("/about")
     */
    public function aboutAction() {
        if(isset($_COOKIE["auth_token"]) && ($_COOKIE["expires_at"]) > time()) {
            $isAuthenticated = true;
        } else {
            $isAuthenticated = false;
        }
        return $this->render(
            '/about.html.twig',
            [
                'uploader' => $this->getPhotoUploader()->getUploaderPath(),
                'authenticated' => $isAuthenticated
            ]
        );
    }

    /**
     * @Route("/photos/{catalogID}/{albumName}/{albumID}")
     * @param $catalogID
     * @param $albumName
     * @param $albumID
     * @param Request $request
     * @return Response
     */
    public function photosAction($catalogID, $albumName, $albumID, Request $request) {
        $catalog = $this->getPhotoManager($request)->getCatalog();
        $album = $this->getPhotoManager( $request )->getAlbum( $albumID );
        $images = $album->images;
        if($this->isAuthenticated($request)) {
            $isAuthenticated = true;
            if ($this->user == null) {
                $user = $this->getUserManager($this->authID)->getUser();
                $this->user = $user;
            }
            if($this->user->getProfilePicture() != null) {
                $this->profilePicture = $user->getProfilePicture();
            }
            if($this->user->getProfilePicturesID() != null) {
                $this->profilePicturesID = $user->getProfilePicturesID();
            }
            if($this->user->getCoverPicturesID() != null) {
                $this->coverPicturesID = $user->getCoverPicturesID();
            }
            return $this->render(
                '/photos.html.twig',
                [
                    'firstName' => $this->firstName,
                    'lastName' => $this->lastName,
                    'authenticated' => $isAuthenticated,
                    'catalogID' => $catalogID,
                    'catalog' => $catalog,
                    'album' => $album,
                    'albumName' => $albumName,
                    'coverPicturesID' => $this->coverPicturesID,
                    'profilePicturesID' => $this->profilePicturesID,
                    'profilePicture' => $this->profilePicture,
                    'uploader' => $this->getPhotoUploader()->getUploaderPath(),
                    'images' => $images
                ]
            );
        } else {
            $this->_send_forbidden_status_response();
        }
    }

    /**
     * @Route("/account", name="account")
     * @param Request $request
     * @return Response
     */
    public function accountAction(Request $request) {
        if ($this->isAuthenticated($request)) {
            $isAuthenticated = true;
            if($this->user == null) {
                $user = $this->getUserManager($this->authID)->getUser();
                $this->user = $user;
            }
            if($this->user->getBanner() != null) {
                $this->banner = $user->getBanner();
            }
            if($this->user->getProfilePicture() != null) {
                $this->profilePicture = $this->user->getProfilePicture();
            }
            if($this->user->getProfilePicturesID() != null) {
                $this->profilePicturesID = $this->user->getProfilePicturesID();
            }
            if($this->user->getCoverPicturesID() != null) {
                $this->coverPicturesID = $this->user->getCoverPicturesID();
            }
            $catalog = $this->getPhotoManager($request)->getCatalog();
            
            return $this->render(
                '/account.html.twig',
                [
                    'name' => $this->user->getName(),
                    'authenticated' => $isAuthenticated,
                    'email' => $this->user->getEmail(),
                    'userManager' => trim( $this->user->getLocalUserPath() ) . "/" . $this->user->getUserID(),
                    'uploader' => $this->getPhotoUploader()->getUploaderPath(),
                    'banner' => $this->banner,
                    'banner_message' => $this->banner_message,
                    'bannerImages' => $this->bannerImages,
                    'bannerAlbumID' => $this->bannerAlbumID,
                    'bannerPosterID' => $this->bannerPosterID,
                    'catalog' => $catalog,
                    'profilePicturesID' => $this->profilePicturesID,
                    'coverPicturesID' => $this->coverPicturesID,
                    'profilePicture' => $this->profilePicture
                ]
            );
        } else {
            $this->_send_forbidden_status_response();
        }
    }


    /**
     * @param $request
     * @return PhotoManager
     */
    private function getPhotoManager($request) {
        if($this->isAuthenticated($request)) {
            if($this->photoManager == null) {
                $this->photoManager = new PhotoManager($this->authID);
            }
            return $this->photoManager;
        } else {
            $this->_send_forbidden_status_response();
        }
    }

    /**
     * @return ContentManager
     */
    private function getContentManager() {
        if($this->contentManager == null) {
            $this->contentManager = new ContentManager();
        }
        return $this->contentManager;
    }

    /**
     * @param null $statusCode
     * @return Forbidden Status response
     */
    private function _send_forbidden_status_response($statusCode = null) {
        $response = new Response();
        $response->setStatusCode($statusCode ?? Response::HTTP_FORBIDDEN);
        return $response->send();
    }

    /**
     * @return PhotoUploader
     */
    private function getPhotoUploader() {
        if($this->photoUploader == null) {
            $this->photoUploader = new PhotoUploader();
        }
        return $this->photoUploader;
    }

    /**
     * @param $authID
     * @param $email
     * @return UserManager
     */
    private function getUserManager($authID, $email = null) {
        if($this->userManager == null) {
            $this->userManager = new UserManager($authID, $email);
        }
        return $this->userManager;
    }
}