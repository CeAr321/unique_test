<?php
// src/Controller/DefaultController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class DefaultController extends AbstractController
{
    public function index(): Response
    {
        $data = 'test';
        return $this->render('testUniq/welcometest.html.twig', [
            'data' => $data
        ]);
    }
}