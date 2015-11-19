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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\HeaderBag;


class InginiousHomeController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        if ($request->headers->has('Auth-ID'))
        {
            $Name = $request->headers->get('Auth-Name');
            $Names = explode(" ", $Name);
            return $this->redirectToRoute('hello', array('firstName' => $Names[0], 'lastName' => $Names[1]),301);
        }
        else
        {
            return $this->render('/base.html.twig', array(
                'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            ));
        }



    }

    /**
     * @Route("/hello/{firstName}/{lastName}", name="hello")
     */
    public function homeAction($firstName, $lastName, Request $request)
    {
        $cookies = $request->cookies;
        $authID = $request->headers->get('Auth-ID');

        if ($authID != "")
        {
            return $this->render(
                '/home.html.twig',
                array('firstName' => $firstName,
                    'lastName' => $lastName,
                    'authenticated' => 'header')
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