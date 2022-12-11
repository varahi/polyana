<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    /*public function index(): Response
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }*/

    #[Route('/', name: 'app_home')]
    public function index(
        Environment $twig,
        Request $request,
        ItemRepository $itemRepository,
        CategoryRepository $categoryRepository
    ): Response {
        $categoryId = $request->query->get('category');
        $categories = $categoryRepository->findAll();

        if ($categoryId !== '') {
            $category = $categoryRepository->findOneBy(['id' => $categoryId]);
            $items = $itemRepository->findByParams($category, null);
        } else {
            $category = null;
            $items = $itemRepository->findAll();
        }

        //$items = $itemRepository->findAll();
        //dd($items);
        //$locale = $request->getLocale();
        //dd($locale);

        return new Response($twig->render('category/index.html.twig', [
            'items' => $items,
            'category' => $category,
            'categories' => $categories
        ]));
    }
}
