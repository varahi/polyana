<?php

namespace App\Controller;

use App\Entity\Item;
use App\Repository\CategoryRepository;
use App\Repository\EventRepository;
use App\Repository\ItemRepository;
use App\Repository\LocationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class EventController extends AbstractController
{
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
        $items = $eventRepository->findAll();

        return new Response($twig->render('event/list.html.twig', [
            'category' => null,
            'locations' => $locations,
            'items' => $items,
        ]));
    }

    #[Route('/event-detail/{slug}', name: 'app_detail_event')]
    public function detailItem(
        Request $request,
        Environment $twig,
        Item $item,
        CategoryRepository $categoryRepository
    ): Response {
        $categoryId = $request->query->get('category');
        $category = $categoryRepository->findOneBy(['id' => $categoryId]);
        return new Response($twig->render('item/detail.html.twig', [
            'item' => $item,
            'category' => $category,
        ]));
    }
}
