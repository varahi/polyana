<?php

namespace App\Controller;

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
        ItemRepository $itemRepository
    ): Response
    {
        /*return $this->render('item/index.html.twig', [
            'controller_name' => 'ItemController',
        ]);*/

        //$items = $itemRepository->findAll();
        //dd($items);
        //$locale = $request->getLocale();
        //dd($locale);


        return new Response($twig->render('item/index.html.twig', [
            'items' => $itemRepository->findAll(),
        ]));
    }
}
