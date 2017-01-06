<?php

namespace Neo\NasaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{

    /**
     * Root route with "Hello world" in json
     *
     * @Route("/")
     */
    public function helloAction()
    {
        return new JsonResponse(array('hello' => 'world!'));
    }
}
