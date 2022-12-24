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
use Doctrine\Persistence\ManagerRegistry;
use App\Service\CoordinateService;

class ItemController extends AbstractController
{
    /**
     * @param ManagerRegistry $doctrine
     * @param CoordinateService $coordinateService
     */
    public function __construct(
        ManagerRegistry $doctrine,
        CoordinateService $coordinateService
    ) {
        $this->doctrine = $doctrine;
        $this->coordinateService = $coordinateService;
    }

    /**
     * @param Environment $twig
     * @param Category $category
     * @param ItemRepository $itemRepository
     * @param CategoryRepository $categoryRepository
     * @param LocationRepository $locationRepository
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    #[Route('/items/{slug}', name: 'app_item_list')]
    public function list(
        Environment $twig,
        Category $category,
        ItemRepository $itemRepository,
        CategoryRepository $categoryRepository,
        LocationRepository $locationRepository
    ): Response {
        if ($category) {
            $items = $itemRepository->findByParams($category, null);
        } else {
            $items = $itemRepository->findLimitOrder('999', '0');
        }
        $categories = $categoryRepository->findAll();
        //$locations = $locationRepository->findAll();
        $locations = $locationRepository->findLimitOrder('999', '0');

        return new Response($twig->render('item/list.html.twig', [
            'items' => $items,
            'categories' => $categories,
            'category' => $category,
            'locations' => $locations,
            'location' => null,
            'locationId' => null
        ]));
    }

    /**
     * @param Request $request
     * @param Environment $twig
     * @param Location $location
     * @param ItemRepository $itemRepository
     * @param CategoryRepository $categoryRepository
     * @param LocationRepository $locationRepository
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    #[Route('/items/location/{slug}', name: 'app_item_location_list')]
    public function listLocation(
        Request $request,
        Environment $twig,
        Location $location,
        ItemRepository $itemRepository,
        CategoryRepository $categoryRepository,
        LocationRepository $locationRepository
    ): Response {
        $categoryId = $request->query->get('category');
        $category = $categoryRepository->findOneBy(['id' => $categoryId]);

        $items = $itemRepository->findByParams($category, $location);
        $categories = $categoryRepository->findAll();
        //$locations = $locationRepository->findAll();
        $locations = $locationRepository->findLimitOrder('999', '0');

        return new Response($twig->render('item/index.html.twig', [
            'items' => $items,
            'categories' => $categories,
            'category' => $category,
            'locations' => $locations,
            'location' => $location,
            'locationId' => $location->getId()
        ]));
    }

    /**
     * @param Request $request
     * @param Environment $twig
     * @param Item $item
     * @param CategoryRepository $categoryRepository
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    #[Route('/item-detail/{slug}', name: 'app_detail_item')]
    public function detailItem(
        Request $request,
        Environment $twig,
        Item $item,
        CategoryRepository $categoryRepository
    ): Response {
        $categoryId = $request->query->get('category');
        $category = $categoryRepository->findOneBy(['id' => $categoryId]);

        // Set coordinates for item
        $this->coordinateService->setCoordinates($item);

        return new Response($twig->render('item/detail.html.twig', [
            'item' => $item,
            'category' => $category,
        ]));
    }
}
