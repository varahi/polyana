<?php

namespace App\Controller;

use App\Entity\Item;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use App\Repository\ItemRepository;
use Symfony\Component\HttpFoundation\Request;

class ItemController extends AbstractController
{
    #[Route('/', name: 'app_item')]
    public function index(
        Environment $twig,
        Request $request,
        ItemRepository $itemRepository,
        CategoryRepository $categoryRepository
    ): Response {
        $categories = $categoryRepository->findAll();

        //$items = $itemRepository->findAll();
        //dd($items);
        //$locale = $request->getLocale();
        //dd($locale);

        return new Response($twig->render('item/index.html.twig', [
            'items' => $itemRepository->findAll(),
            'categories' => $categories
        ]));
    }

    #[Route('/shiw-item/{slug}', name: 'app_show_item')]
    public function showItem(
        Environment $twig,
        Item $item,
        ItemRepository $itemRepository,
        CategoryRepository $categoryRepository
    ): Response {

        // $slug = $request->query->get('category');
        $categories = $categoryRepository->findAll();
        return new Response($twig->render('item/detail.html.twig', [
            'item' => $item,
            'categories' => $categories
        ]));
    }
}
