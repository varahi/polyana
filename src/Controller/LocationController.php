<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Event;
use App\Entity\Location;
use App\Repository\CategoryRepository;
use App\Repository\EventRepository;
use App\Repository\ItemRepository;
use App\Repository\LocationRepository;
use App\Service\CoordinateService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class LocationController extends AbstractController
{
    /**
     * @param CoordinateService $coordinateService
     */
    public function __construct(
        CoordinateService $coordinateService
    ) {
        $this->coordinateService = $coordinateService;
    }

    /**
     * @return Response
     */
    #[Route('/map', name: 'app_map')]
    public function map(
        Request $request,
        LocationRepository $locationRepository,
        CategoryRepository $categoryRepository,
        ItemRepository $itemRepository,
        EventRepository $eventRepository
    ): Response {
        $locations = $locationRepository->findAll();
        $categories = $categoryRepository->findAll();

        $isEvent = $request->query->get('isEvent');
        if ($isEvent == 1) {
            $items = $eventRepository->findAll();
        } else {
            $items = $itemRepository->findAll();
        }
        return $this->render('location/swipe_map.html.twig', [
            'category' => null,
            'categories' => $categories,
            'locations' => $locations,
            'items' => $items,
            'location' => null,
            'locationId' => null,
            'lat' => $this->coordinateService->getLatArr($items),
            'lng' => $this->coordinateService->getLngArr($items),
        ]);
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
    #[Route('/map/{slug}', name: 'app_category_map')]
    public function categoryMap(
        Environment $twig,
        Category $category,
        ItemRepository $itemRepository,
        CategoryRepository $categoryRepository,
        LocationRepository $locationRepository
    ): Response {
        if ($category) {
            $items = $itemRepository->findByParams($category, null);
        } else {
            $items = $itemRepository->findAll();
        }
        $categories = $categoryRepository->findAll();
        $locations = $locationRepository->findAll();

        return new Response($twig->render('location/map.html.twig', [
            'items' => $items,
            'categories' => $categories,
            'category' => $category,
            'locations' => $locations,
            'location' => null,
            'locationId' => null,
            'lat' => $this->coordinateService->getLatArr($items),
            'lng' => $this->coordinateService->getLngArr($items),
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
    #[Route('/map/location/{slug}', name: 'app_map_location_list')]
    public function mapLocation(
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
        $locations = $locationRepository->findAll();

        return new Response($twig->render('location/map.html.twig', [
            'items' => $items,
            'categories' => $categories,
            'category' => $category,
            'locations' => $locations,
            'location' => $location,
            'locationId' => $location->getId(),
            'lat' => $this->coordinateService->getLatArr($items),
            'lng' => $this->coordinateService->getLngArr($items),
        ]));
    }

    #[Route('/map/event/{slug}', name: 'app_detail_object_map')]
    public function detailObjectMap(
        Request $request,
        Environment $twig,
        Event $item,
        EventRepository $eventRepository,
        CategoryRepository $categoryRepository,
        LocationRepository $locationRepository
    ): Response {
        $items = $eventRepository->findAll();
        $categories = $categoryRepository->findAll();
        $locations = $locationRepository->findAll();

        return new Response($twig->render('location/map_detail.html.twig', [
            'category' => null,
            'categories' => $categories,
            'locations' => $locations,
            'items' => $items,
            'item' => $item,
            'location' => null,
            'locationId' => null,
            'isEvent' => 1,
            'lat' => $this->coordinateService->getLatArr($items),
            'lng' => $this->coordinateService->getLngArr($items),
        ]));
    }
}
