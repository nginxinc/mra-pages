<?php
/**
 * Created by IntelliJ IDEA.
 * User: chrisstetson
 * Date: 11/16/15
 * Time: 9:58 AM
 */

// src/AppBundle/Controller/LuckyController.php
namespace AppBundle\Controller;

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

    public function getPhotoManager()
    {
        $photoManagerURL = getenv("PHOTOMANAGER_ENDPOINT_URL");
        $photoCatalogPath = getenv("PHOTOMANAGER_CATALOG_PATH");
        $photoAlbumPath = getenv("PHOTOMANAGER_ALBUM_PATH");
        //print $photoManagerURL . " | " . $photoCatalogPath . " | " . $photoAlbumPath;
        return $photoManager = array(
            //'url' => isset($_ENV["PHOTOMANAGER_ENDPOINT_URL"]) ? $_ENV["PHOTOMANAGER_ENDPOINT_URL"]: "metadogs.com";
            //'catalog-path' => $_ENV["PHOTOMANAGER_CATALOG_PATH"],
            //'album-path' => $_ENV["PHOTOMANAGER_ALBUM_PATH"]);
            'url' => $photoManagerURL,
            'catalog-path' => $photoCatalogPath,
            'album-path' => $photoAlbumPath);
    }

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
            return $this->render('/index.html.twig', array(
                'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            ));
    }

    /**
     * @Route("/hello", name="hello")
     */
    public function homeAction(Request $request)
    {
        $cookies = $request->cookies;
        $authID = $request->headers->get('Auth-ID');

        if ($authID != "")
        {
            $Name = $request->headers->get('Auth-Name');
            $Names = explode(" ",$Name);
            $firstName = $Names[0];
            $lastName = $Names[1];
            $photoManager = $this->getPhotoManager();

            try
            {
                $client = new Client(['base_uri' => 'http://' . $photoManager["url"]]);
                $myJsonResponse = $client->request('GET', $photoManager["catalog-path"], [
                    'query' => ['catalog' => 'orchids',
                        'title' => 'Orchids']
                ]);
                $body = $myJsonResponse->getBody();
                // Explicitly cast the body to a string
                $stringBody = (string)$body;
                $catalogDecoder = new JsonDecode();
                $catalog = $catalogDecoder->decode($stringBody, 'json');
            }
            catch (RequestException $e)
            {
                echo $e->getRequest();
                if ($e->hasResponse()) { echo $e->getResponse();}
            }
            return $this->render(
                '/home.html.twig',
                array('firstName' => $firstName,
                    'lastName' => $lastName,
                    'authenticated' => 'header',
                    'catalogID' => 'orchids',
                    'catalog' => $catalog)
            );
            return new Response($html);
        }
        else
        {
            return $this->redirectToRoute('homepage');
        }

    }

    /**
     * @Route("/album/{catalog}/{album}", name="album")
     */

    public function albumAction($catalog, $album, Request $request)
    {
        $cookies = $request->cookies;
        $authID = $request->headers->get('Auth-ID');

        if ($authID != "")
        {
            $Name = $request->headers->get('Auth-Name');
            $Names = explode(" ",$Name);
            $firstName = $Names[0];
            $lastName = $Names[1];
            $photoManager = $this->getPhotoManager();

            try
            {
                $client = new Client(['base_uri' => 'http://' . $photoManager["url"]]);
                $myJsonResponse = $client->request('GET', $photoManager["album-path"], [
                    'query' => ['folder' => $catalog,
                                'title' => $album,
                                'photoSet' => $album]
                ]);
                $body = $myJsonResponse->getBody();
                // Explicitly cast the body to a string
                $stringBody = (string)$body;
                $albumDecoder = new JsonDecode();
                $albumMap = $albumDecoder->decode($stringBody, 'json');
                $images = $albumMap[0]->images;
            }
            catch (RequestException $e)
            {
                echo $e->getRequest();
                if ($e->hasResponse()) { echo $e->getResponse();}
            }
            return $this->render(
                '/album.html.twig',
                array('firstName' => $firstName,
                    'lastName' => $lastName,
                    'authenticated' => 'header',
                    'catalogID' => $catalog,
                    'album' => $albumMap[0],
                    'images' => $images)
            );
            return new Response($html);
        }
        else
        {
            return $this->redirectToRoute('homepage');
        }
    }

    /**
     * @Route("/lucky/number/{count}")
     */
    public function numberAction($count)
    {
        $numbers = array();
        for ($i = 0; $i < $count; $i++) {
            $numbers[] = rand(0, 100);
        }
        $numbersList = implode(', ', $numbers);

        return $this->render(
            '/home.html.twig',
            array('luckyNumberList' => $numbersList)
        );

        return new Response($html);
    }

    /**
     * @Route("/api/lucky/number")
     */
    public function apiNumberAction()
    {
        $data = array(
            'lucky_number' => rand(0, 100),
        );

        // calls json_encode and sets the Content-Type header
        return new JsonResponse($data);
    }
}