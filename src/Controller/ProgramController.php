<?php

namespace App\Controller;


use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\ProgramType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class ProgramController
 * @package App\Controller
 * @Route ("/Programs", name="program_")
 */
class ProgramController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @return Response
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();
        return $this->render('program/index.html.twig', [
            'programs' => $programs
        ]);
    }

    /**
     * The controller for the program add form
     *
     * @Route("/new", name="new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request) : Response
    {
        // Create a new program Object
        $program = new Program();
        // Create the associated Form
        $form = $this->createForm(ProgramType::class, $program);
        // Get data from HTTP request
        $form->handleRequest($request);
        // Was the form submitted ?
        if ($form->isSubmitted()) {
            // Deal with the submitted data
            // Get the Entity Manager
            $entityManager = $this->getDoctrine()->getManager();
            // Persist program Object
            $entityManager->persist($program);
            // Flush the persisted object
            $entityManager->flush();
            // Finally redirect to programs list
            return $this->redirectToRoute('program_index');
        }
        // Render the form
        return $this->render('program/new.html.twig', ["form" => $form->createView()]);
    }

    /**
     * @Route("/show/{id}", requirements={"id"="\d+"}, name="show")
     * @param Program $program
     * @return Response
     */
    public function show(Program $program): Response
    {
        $seasons = $program->getSeasons();

        if(!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$id.' found in program\'s table.'
            );
        }

        return $this->render('program/show.html.twig', ['program' => $program, 'seasons' => $seasons
        ]);
    }

    /**
     * @Route ("/{program}/seasons/{season}", name="season_show")
     * @param Program $program
     * @param Season $season
     * @return Response
     */
    public function showSeason(Program $program, Season $season): Response
    {
        if(!$program) {
            throw $this->createNotFoundException(
                'No program  found in program\'s table.'
            );
        }
        if(!$season) {
            throw $this->createNotFoundException(
                'No season  found in program\'s table.'
            );
        }
        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season'=> $season
        ]);
    }

    /**
     * @Route ("/programs/{program}/seasons/{season}/episodes/{episode}", name="episode_show")
     * @param Program $program
     * @param Season $season
     * @param Episode $episode
     */
    public function showEpisode(Program $program, Season $season, Episode $episode)
    {
        return $this->render('program/episode_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode,
        ]);
    }
}