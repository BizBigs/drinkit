<?php
// src/AverageBundle/AverageController.php

namespace App\AverageBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Psr\Log\LoggerInterface;

class AverageController extends AbstractController
{
    public function index()
    {
        return new Response('
            <html>
                <body>
                    <h1>Hello Symfony 4 bitches !</h1>
                </body>
            </html>
        ');
    }
}