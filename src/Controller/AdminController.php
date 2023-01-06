<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MessageRepository;
use App\Repository\FigureRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Message;
use Doctrine\ORM\EntityManagerInterface;


class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(MessageRepository $repoMessage, FigureRepository $repoFigure): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'messages' => $repoMessage->findAll(),
            'figures' => $repoFigure->findAll(),
        ]);
    }

    #[Route('/admin/delete/{id<\d+>}', name: 'app_admin_delete')]
    public function delete(Request $request, Message $message, EntityManagerInterface $em)
    {
        $em->remove($message);
        $em->flush();

        // redirige la page
        return $this->redirectToRoute('app_admin');
    }

}


