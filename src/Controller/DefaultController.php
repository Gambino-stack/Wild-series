<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
    public function index(): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('index.html.twig', ['welcome' => 'Bienvenue']);
    }
}