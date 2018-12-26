<?php
// src/HomeBundle/HomeController.php

namespace App\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{

    public function index()
    {
        return $this->render('@HomeBundle/homepage.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
