<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_default')]
    public function index(): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'Toto qui se lève tot tantot parce qu il arrive bientot pour manger des carbos au milieu d un bateau sur leau. Il fait beau, sur ce paquebot naviguant sur un cachalot',
        ]);
    }
}
