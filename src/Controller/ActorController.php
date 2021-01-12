<?php


namespace App\Controller;


use App\Entity\Actor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ActorController
 * @package App\Controller
 * @Route ("/actors",name="actors_")
 */
class ActorController extends AbstractController
{
    /**
     * @Route("/{id}", methods={"GET"}, name="show")
     * @param Actor $actor
     * @return Response
     */
    public function show(Actor $actor): Response
    {
        if (!$actor) {
            throw $this->createNotFoundException(
                'No actor found in actors table.'
            );
        }
        $programs = $actor->getPrograms();
        return $this->render('Actor/show.html.twig', [
            'actor' => $actor,
            'programs' => $programs,
        ]);
    }
}