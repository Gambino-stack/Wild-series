<?php


namespace App\Controller;


use App\Entity\Comment;
use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\CommentType;
use App\Form\ProgramType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class CommentController
 * @package App\Controller
 * @Route ("/Comment", name="comment_")
 */
class CommentController extends AbstractController
{
    /**
     * @Route("/programs/{program<^[0-9]+$>}/seasons/{season<^[0-9]+$>}/episodes/{episode<^[0-9]+$>}/comments/{comment<^[0-9]+$>}", methods={"DELETE"}, name="delete")
     * @IsGranted ("ROLE_ADMIN")
     * @param Request $request
     * @param Comment $comment
     * @param Program $program
     * @param Season $season
     * @param Episode $episode
     * @return Response
     */
    public function delete(Request $request, Comment $comment, Program $program, Season $season, Episode $episode): Response
    {
        if ($this->isCsrfTokenValid('delete' . $comment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('program_index');
    }
}