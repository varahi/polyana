<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    #[Route('/page-1', name: 'app_page_1')]
    public function pageOne(): Response
    {
        return $this->render('page/page1.html.twig', [
            //'controller_name' => 'PageController',
        ]);
    }

    #[Route('/page-2', name: 'app_page_2')]
    public function pageTwo(): Response
    {
        return $this->render('page/page2.html.twig', [
            //'controller_name' => 'PageController',
        ]);
    }
}
