<?php


namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Form\CategoryType;

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
     * The controller for the category add form
     *
     * @Route("/new", name="new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request) : Response
    {
        // Create a new Category Object
        $category = new Category();
        // Create the associated Form
        $form = $this->createForm(CategoryType::class, $category);
        // Get data from HTTP request
        $form->handleRequest($request);
        // Was the form submitted ?
        if ($form->isSubmitted()) {
            // Deal with the submitted data
            // Get the Entity Manager
            $entityManager = $this->getDoctrine()->getManager();
            // Persist Category Object
            $entityManager->persist($category);
            // Flush the persisted object
            $entityManager->flush();
            // Finally redirect to categories list
            return $this->redirectToRoute('category_index');
        }
        // Render the form
        return $this->render('category/new.html.twig', ["form" => $form->createView()]);
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