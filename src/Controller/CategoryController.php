<?php


namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CategoryController
 * @package App\Controller
 * @Route ("/categories", name="category_")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route ("/", name="index")
     * @return Response
     */
    public function index(): Response
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();
        return $this->render('category/index.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @param string $categoryName
     * @Route ("/{categoryName}", methods={"GET"}, name="show")
     * @return Response
     */
    public function show(string $categoryName): Response
    {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findBy(['name' => $categoryName]);
        if (!$category) {
            throw $this->createNotFoundException(
                'No category with name : ' . $categoryName . ' found in program\'s table.'
            );
        } else {
            $programs = $this->getDoctrine()
                ->getRepository(Program::class)
                ->findBy(['category' => $category],['id' => 'DESC'],3);
        }
        return $this->render('category/show.html.twig', ['name' => $categoryName, 'programs' => $programs]);
    }
}