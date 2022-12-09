<?php

namespace App\Controller;

use App\Entity\Figure;
use App\Form\FigureType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use DateTime;

use Doctrine\ORM\EntityManagerInterface;

class FigureController extends AbstractController
{
    #[Route('/figure', name: 'app_figure')]
    public function index(Request $request, EntityManagerInterface $em): Response //Injection de dépendance
    {

        $figure = new Figure();
        $formFigure = $this->createForm(FigureType::class, $figure); //création formulaire + association entité

        $formFigure->handleRequest($request); //associer ce qui est envoyé

        if($formFigure->isSubmitted()){
            $figure->setCreatedAt(new \DateTime());
            $em->persist($figure);
            $em->flush();
            return $this->redirectToRoute('app_main');
         }

        return $this->render('figure/index.html.twig', array(
            'formFigure' => $formFigure->createView(),
        ));
    }


    #[Route('/figure/edit/{id<\d+>}', name: 'app_figure_edit')]
    public function edit(Request $request, Figure $figure, EntityManagerInterface $em)
    {
        $formFigure = $this->createForm(FigureType::class, $figure);
        $formFigure->handleRequest($request);

        if ($formFigure->isSubmitted() && $formFigure->isValid()) {
            // va effectuer la requête d'UPDATE en base de données
            $em->flush();
            return $this->redirectToRoute('app_main');
        }

        return $this->render('figure/index.html.twig', array(
            'formFigure' => $formFigure->createView(),
        ));
    }


    #[Route('/figure/delete/{id<\d+>}', name: 'app_figure_delete')]
    public function delete(Request $request,  Figure $figure, EntityManagerInterface $em)
    {
        $em->remove($figure);
        $em->flush();

        // redirige la page
        return $this->redirectToRoute('app_main');
    }

}




