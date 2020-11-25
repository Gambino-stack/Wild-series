<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/program", name="program_")
 * Class ProgramController
 * @package App\Controller
 */
class ProgramController extends AbstractController
{
    /**
     * @Route("/index/", name="index")
     */
    public function index(): Response
    {
        return $this->render('program/index.html.twig', [
            'website' => 'Wild Séries',
        ]);
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="show", requirements={"id"="^[0-9]*[1-9][0-9]*$"})
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        return $this->render('program/show.html.twig', ['id' => $id
        ]);
    }
}