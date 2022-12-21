<?php

namespace App\Controller;

use App\Entity\Event;
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

class EventController extends AbstractController
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

    #[Route('/event', name: 'app_event')]
    public function index(): Response
    {
        return $this->render('event/index.html.twig', [
            'controller_name' => 'EventController',
        ]);
    }

    #[Route('/events', name: 'app_events')]
    public function list(
        Environment $twig,
        LocationRepository $locationRepository,
        ItemRepository $itemRepository,
        EventRepository $eventRepository
    ): Response {
        $locations = $locationRepository->findAll();
        $items = $eventRepository->findAllOrder(['date' => 'DESC']);

        return new Response($twig->render('event/list.html.twig', [
            'category' => null,
            'locations' => $locations,
            'items' => $items,
            'item' => null
        ]));
    }

    #[Route('/event-detail/{slug}', name: 'app_detail_event')]
    public function detailItem(
        Request $request,
        Environment $twig,
        Event $item,
        CategoryRepository $categoryRepository
    ): Response {
        $categoryId = $request->query->get('category');
        $category = $categoryRepository->findOneBy(['id' => $categoryId]);

        // Set coordinates for item
        $this->coordinateService->setCoordinates($item);

        return new Response($twig->render('event/detail.html.twig', [
            'item' => $item,
            'category' => $category,
        ]));
    }
}
