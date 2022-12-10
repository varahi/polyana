<?php

namespace App\Controller;

use App\Entity\Item;
use App\Entity\Category;
use App\Entity\Location;
use App\Repository\CategoryRepository;
use App\Repository\LocationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use App\Repository\ItemRepository;
use Symfony\Component\HttpFoundation\Request;

class ItemController extends AbstractController
{
    #[Route('/items/{slug}', name: 'app_item_list')]
    public function list(
        Environment $twig,
        Category $category,
        ItemRepository $itemRepository,
        CategoryRepository $categoryRepository,
        LocationRepository $locationRepository
    ): Response {
        // $slug = $request->query->get('category');

        if ($category) {
            $items = $itemRepository->findByCategory($category, '999');
        } else {
            $items = $itemRepository->findAll();
        }
        $categories = $categoryRepository->findAll();
        $locations = $locationRepository->findAll();

        return new Response($twig->render('item/index.html.twig', [
            'items' => $items,
            'categories' => $categories,
            'category' => $category,
            'locations' => $locations
        ]));
    }

    #[Route('/items/location/{id}', name: 'app_item_location_list')]
    public function listLocation(
        Environment $twig,
        Location $location,
        ItemRepository $itemRepository,
        CategoryRepository $categoryRepository,
        LocationRepository $locationRepository
    ): Response {
        //dd($location);
    }

    #[Route('/item-detail/{slug}', name: 'app_detail_item')]
    public function detailItem(
        Environment $twig,
        Location $location,
        ItemRepository $itemRepository,
        CategoryRepository $categoryRepository,
        LocationRepository $locationRepository
    ): Response {
        //dd($location);
    }
}
