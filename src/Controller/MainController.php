<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\FigureRepository;


class MainController extends AbstractController
{
    #[Route('/main', name: 'app_main')]
    public function index(FigureRepository $repoFigure): Response
    {
        return $this->render('main/index.html.twig', [
            'figures' => $repoFigure->findAll(),
        ]);

    }
}
