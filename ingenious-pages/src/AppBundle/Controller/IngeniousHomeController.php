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

    private $authID = null;
    private $banner = null;
    private $banner_message = "Upload an image for your banner.";
    private $bannerAlbumID = null;
    private $bannerImages = null;
    private $bannerPosterID = null;
    private $contentManager = null;
    private $coverPicturesID = null;
    private $firstName;
    private $lastName;
    private $name;
    private $photoManager = null;
    private $photoUploader = null;
    private $profilePicture = "null";
    private $profilePicturesID = null;
    private $articlePicturesID = null;

    /**
     * @var UserManager
     */
    private $user = null;

    /**
     * @var UserManager
     */
    private $userManager = null;


    /**
     * Verifies whether the request has been authenticated by any of the
     * providers
     *
     * @param Request $request the Symfony Request object
     * @return bool
     */
    public function isAuthenticated(Request $request) {

        // get the Auth-ID request header
        $this->authID = $request->headers->get('Auth-ID');

        // check whether the header is set
        if ($this->authID != "") {
            // get the Auth-Name header
            if ($request->headers->get('Auth-Name')) {
                // set the name fields if the header is set
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
     * Handles the request for the index "/"
     *
     * @Route("/") Specify the index path. This is compiled in to the routing
     * class when the code is built in the Dockerfile
     */
    public function indexAction() {

        // get all the articles
        $articles = $this->getContentManager()->getArticles();

        // render the index.html.twig page with the articles and the
        // isAuthenticated parameter
        return $this->render(
            '/index.html.twig',
            [
                'uploader' => $this->getPhotoUploader()->getUploaderPath(),
                'authenticated' => isset($_COOKIE["auth_token"]) && ($_COOKIE["expires_at"]) > time(),
                'articles' => $articles,
                'contentManager' => $this->getContentManager()->getContentPath()
            ]
        );
    }

    /**
     * Handles the request for the "/myphotos" path by loading the albums and
     * photos for the authenticated
     *
     * @Route("/myphotos")
     * @param Request $request The Symfony Request object
     * @return Response either by rendering the home.html.twig page or by sending
     * a 403 response
     */
    public function myphotosAction(Request $request) {

        // verify whether the user has been authenticated
        $isAuthenticated = $this->isAuthenticated($request);
        if($isAuthenticated) {

            // check whether the user object is set
            if ($this->user == null) {

                // if the user is not set, then retrieve the user
                // from the UserManager
                $user = $this->getUserManager($this->authID)->getUser();
                $this->user = $user;
            }

            // set the profilePicture variable from the local user object, if it is not set
            if($this->user->getProfilePicture() != null) {
                $this->profilePicture = $this->user->getProfilePicture();
            }

            // set the profilePictureID from the local user object, if it is not set
            if($this->user->getProfilePicturesID() != null) {
                $this->profilePicturesID = $this->user->getProfilePicturesID();
            }

            // set the articlePicturesID from the local user object, if it is not set
            if($this->user->getArticlePicturesID() != null) {
                $this->articlePicturesID = $this->user->getArticlePicturesID();
            }

            // set the coverPictureID from the local user, if it is not set
            if($this->user->getCoverPicturesID() != null) {
                $this->coverPicturesID = $this->user->getCoverPicturesID();
            }

            // retrieve all the images for the current user
            $allImages = $this->getPhotoManager($request)->getAllImages();

            // retrieve all the albums from the current user
            $catalog = $this->getPhotoManager($request)->getCatalog();

            // render the home.html.twig file
            return $this->render(
                '/home.html.twig',
                [
                    'firstName' => $this->firstName,
                    'lastName' => $this->lastName,
                    'authenticated' => $isAuthenticated,
                    'catalogID' => $this->firstName . ' ' . $this->lastName . "&acute;s Photos",
                    'catalog' => $catalog,
                    'uploader' => $this->getPhotoUploader()->getUploaderPath(),
                    'banner' => $this->user->getBanner(),
                    'banner_message' => $this->banner_message,
                    'user' => $this->user,
                    'allImages' => $allImages,
                    'coverPicturesID' => $this->coverPicturesID,
                    'profilePicturesID' => $this->profilePicturesID,
                    'profilePicture' => $this->profilePicture,
                    'articlePicturesID' => $this->articlePicturesID,
                    'userManager' => trim( $this->user->getLocalUserPath() ) . "/" . $this->user->getUserID(),
                    'contentManager' => $this->getContentManager()->getContentPath()
                ]
            );
        } else {
            // send the 403 error if the user is not authenticated
            return $this->_send_forbidden_status_response();
        }
    }

    /**
     * Handles the /stories path and returns a single article with the ID from the
     * ContentManager using the articleID parameter, only if an article exists
     * with the specified ID
     *
     * @Route("/stories/{articleID}") the path
     * @param $articleID string the ID of the article in the content database
     * @return Response A symfony response object
     */
    public function storiesAction($articleID) {

        // get the article with the specified ID
        $article = (array) $this->getContentManager()->getArticle($articleID);

        // render the post-article.html.twig file with the specified parameters
        return $this->render(
            '/post-article.html.twig',
            [
                'uploader' => $this->getPhotoUploader()->getUploaderPath(),
                'authenticated' => isset($_COOKIE["auth_token"]) && ($_COOKIE["expires_at"]) > time(),
                'article' => empty($article) ? [] : $article[0],
                'contentManager' => $this->getContentManager()->getContentPath()
            ]
        );
    }
    
    /**
     * Handle the "/login" route with the GET method. Renders the login page
     *
     * @Route ("/login")
     * @Method ("GET")
     */
    public function loginAction() {

        // check whether the request has previously been authenticated
        if(isset($_COOKIE["auth_token"]) && ($_COOKIE["expires_at"]) > time()) {
            $isAuthenticated = true;
        } else {
            $isAuthenticated = false;
            unset($_COOKIE['auth_provider']);
        }

        // render the login page. Note this page will be rendered even
        // when the user is authenticated
        return $this->render(
            '/login.html.twig',
            [
                'uploader' => $this->getPhotoUploader()->getUploaderPath(),
                'authenticated' => $isAuthenticated,
                'contentManager' => $this->getContentManager()->getContentPath()
            ]
        );
    }

    /**
     * Handle the "/login" path for the POST method when a user authenticates
     * locally
     *
     * @Route ("/login")
     * @Method ("POST")
     */
    public function loginPostAction(Request $request) {

        // check whether the user is already authenticated
        if ($this->isAuthenticated($request)) {
            // if the user is null, call the userManager to get the user by
            // using the email address in the post body
            if ($this->user == null) {
                $this->user = $this->getUserManager($this->authID, $request->request->get('email'))->getUser();
            }
        } else {
            $this->user = $this->getUserManager($this->authID, $request->request->get('email'))->getUserByEmail();
        }

        // if the user was not found, then create a new user with the specified
        // email address and password
        if ($this->user == null) {
            // create a new user and log them in
            $body['email'] = $request->request->get('email');
            $body['password'] = $request->request->get('password');
            $this->user = $this->getUserManager($this->authID,
                $request->request->get('email'))->createLocalUser(['json' => $body]);

            $this->authID = $this->user->getUserID();
            $isAuthenticated = true;
        } else {
            // compare the password with existing password
            $isAuthenticated = $this->user->authUser($request->request->get('password'));
        }

        // user authenticated? redirect to the account page
        if ($isAuthenticated) {
            $this->authID = $this->user->getUserID();
            $response = $this->redirectToRoute('account');
            $response->headers->setCookie(new Cookie('expires_at', time() + 604800, time() + 604800, "/", null, false, false));
            $response->headers->setCookie(new Cookie('auth_token', $this->user->getLocalId(), time() + 604800, "/", null, false, false));
            $response->headers->setCookie(new Cookie('auth_provider', 'local', time() + 604800, "/", null, false, false));
            $response->headers->set('Auth-ID', $this->authID);
            return $response;
        } else {

            // when the user is not authenticated, render the login page again
            // TODO: add banner message
            return $this->render(
                '/login.html.twig',
                [
                    'uploader' => $this->getPhotoUploader()->getUploaderPath(),
                    'authenticated' => $isAuthenticated,
                    'contentManager' => $this->getContentManager()->getContentPath()
                ]
            );
        }
    }

    /**
     * Handle the request for the "/about" page
     *
     * If the user is not authenticated, the about page will still render, but
     * the authenticated parameter will be false
     *
     * @Route ("/about")
     */
    public function aboutAction() {

        return $this->render(
            '/about.html.twig',
            [
                'uploader' => $this->getPhotoUploader()->getUploaderPath(),
                'authenticated' => isset($_COOKIE["auth_token"]) && ($_COOKIE["expires_at"]) > time(),
                'contentManager' => $this->getContentManager()->getContentPath()
            ]
        );
    }

    /**
     * Handle a request to retrieve an image and all the photos
     *
     * @Route("/photos/{catalogID}/{albumName}/{albumID}")
     * @param $catalogID string the catalog ID
     * @param $albumName string the album name
     * @param $albumID string the album ID: used to retrieve the album from the
     *          PhotoManager
     * @param Request $request the Symfony Request object
     * @return Response the Symfony Response object
     */
    public function photosAction($catalogID, $albumName, $albumID, Request $request) {

        // get the catalog, which is a special case of an album that is
        // created by default when the user registers
        $catalog = $this->getPhotoManager($request)->getCatalog();

        // retrieve the album and the images from the PhotoManager
        $album = $this->getPhotoManager( $request )->getAlbum( $albumID );
        $images = $album->images;
        $isAuthenticated = $this->isAuthenticated($request);
        // ensure that the request has been authenticated
        if($isAuthenticated) {

            // retrieve the user from the UserManager if it has not been set
            if ($this->user == null) {
                $user = $this->getUserManager($this->authID)->getUser();
                $this->user = $user;
            }

            // set the profilePicture variable if it is not set
            if($this->user->getProfilePicture() != null) {
                $this->profilePicture = $this->user->getProfilePicture();
            }

            // set the profilePictureID variable if it is not set
            if($this->user->getProfilePicturesID() != null) {
                $this->profilePicturesID = $this->user->getProfilePicturesID();
            }

            // set the articlePicturesID from the local user object, if it is not set
            if($this->user->getArticlePicturesID() != null) {
                $this->articlePicturesID = $this->user->getArticlePicturesID();
            }

            // set the coverPicturesID variable if it is not set
            if($this->user->getCoverPicturesID() != null) {
                $this->coverPicturesID = $this->user->getCoverPicturesID();
            }

            // render the photos.html.twig template
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
                    'articlePicturesID' => $this->articlePicturesID,
                    'uploader' => $this->getPhotoUploader()->getUploaderPath(),
                    'images' => $images,
                    'contentManager' => $this->getContentManager()->getContentPath()
                ]
            );
        } else {
            return $this->_send_forbidden_status_response();
        }
    }

    /**
     * Handle the named route "/account". The named parameter in the Route
     * annotation is used by the loginPostAction function when the user is
     * redirected to their account page
     *
     * @Route("/account", name="account")
     * @param Request $request
     * @return Response
     */
    public function accountAction(Request $request) {

        $isAuthenticated = $this->isAuthenticated($request);
        if ($isAuthenticated) {

            // set the user variable if it has not been set
            if($this->user == null) {
                $user = $this->getUserManager($this->authID)->getUser();
                $this->user = $user;
            }

            // set the banner variable if it has not been set
            if($this->user->getBanner() != null) {
                $this->banner = $this->user->getBanner();
            }

            // set the profilePicture variable if it has not been set
            if($this->user->getProfilePicture() != null) {
                $this->profilePicture = $this->user->getProfilePicture();
            }

            // set the profilePictureID variable if it has not been set
            if($this->user->getProfilePicturesID() != null) {
                $this->profilePicturesID = $this->user->getProfilePicturesID();
            }

            // set the articlePicturesID from the local user object, if it is not set
            if($this->user->getArticlePicturesID() != null) {
                $this->articlePicturesID = $this->user->getArticlePicturesID();
            }

            // set the converPicturesID variable if it has not been set
            if($this->user->getCoverPicturesID() != null) {
                $this->coverPicturesID = $this->user->getCoverPicturesID();
            }

            // retrieve the catalog for the user
            $catalog = $this->getPhotoManager($request)->getCatalog();

            // get all the articles
            $articles = $this->getContentManager()->getArticles();

            // render the account.html.twig template with the specified
            // parameters
            return $this->render(
                '/account.html.twig',
                [
                    'name' => $this->user->getName(),
                    'authenticated' => $isAuthenticated,
                    'email' => $this->user->getEmail(),
                    'userManager' => trim( $this->user->getLocalUserPath() ) . "/" . $this->user->getUserID(),
                    'uploader' => $this->getPhotoUploader()->getUploaderPath(),
                    'contentManager' => $this->getContentManager()->getContentPath(),
                    'banner' => $this->banner,
                    'banner_message' => $this->banner_message,
                    'bannerImages' => $this->bannerImages,
                    'bannerAlbumID' => $this->bannerAlbumID,
                    'bannerPosterID' => $this->bannerPosterID,
                    'catalog' => $catalog,
                    'articles' => $articles,
                    'profilePicturesID' => $this->profilePicturesID,
                    'coverPicturesID' => $this->coverPicturesID,
                    'articlePicturesID' => $this->articlePicturesID,
                    'profilePicture' => $this->profilePicture
                ]
            );
        } else {
            return $this->_send_forbidden_status_response();
        }
    }


    /**
     * Helper method which gets the PhotoManager component if one does not exist.
     * If one does exist, a new PhotoManager is created using the authID variable
     *
     * @param $request Request
     * @return PhotoManager
     */
    private function getPhotoManager($request) {

        // ensure that the request has been authenticated
        if($this->isAuthenticated($request)) {

            // check whether there is a PhotoManager object
            if($this->photoManager == null) {
                $photoManagerClass = $this->getParameter('photo_manager_class');
                $this->photoManager = new $photoManagerClass($this->authID);
            }
            return $this->photoManager;
        } else {
            $this->_send_forbidden_status_response();
        }
    }

    /**
     * Helper function which gets or create a ContentManager object
     *
     * @return ContentManager
     */
    private function getContentManager() {

        // if the contentManager variable is null, instantiate a new
        // ContentManager
        if($this->contentManager == null) {
            $contentManagerClass = $this->getParameter('content_manager_class');
            $this->contentManager = new $contentManagerClass();
        }
        return $this->contentManager;
    }

    /**
     * Helper function which returns a 403 forbidden response or the specified
     * status code
     *
     * @param null $statusCode
     * @return Response Status response
     */
    private function _send_forbidden_status_response($statusCode = null) {

        // create a new response
        $response = new Response();

        // set the status code
        $response->setStatusCode(isset($statusCode) ? $statusCode : Response::HTTP_FORBIDDEN);

        // send the response
        return $response->send();
    }

    /**
     * Helper function which gets a PhotoUploader component. If one does not
     * already exist, a new PhotoUploader class will be created
     *
     * @return PhotoUploader
     */
    private function getPhotoUploader() {

        // check whether the photoUploader is null
        if($this->photoUploader == null) {
            $photoUploaderClass = $this->getParameter('photo_uploader_class');
            // create a new PhotoUploader object
            $this->photoUploader = new $photoUploaderClass();
        }
        return $this->photoUploader;
    }

    /**
     * Helper function which retrieves the UserManager component, or creates
     * a new one if it doesn't exist
     *
     * @param $authID string the ID of the authenticated user
     * @param $email string optionally null
     * @return UserManager
     */
    private function getUserManager($authID, $email = null) {

        // if the UserManager is null, create a new one using one or both
        // parameters
        if($this->userManager == null) {
            $userManagerClass = $this->getParameter('user_manager_class');
            $this->userManager = new $userManagerClass($authID, $email);
        }
        return $this->userManager;
    }
}