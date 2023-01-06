<?php

namespace App\Controller;

use App\Entity\Figure;
use App\Form\FigureType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use DateTime;

use App\Repository\FigureRepository;
use App\Repository\MessageRepository;


use Doctrine\ORM\EntityManagerInterface;


class FigureController extends AbstractController
{
    #[Route('/figure', name: 'app_figure')]
    public function index(Request $request, EntityManagerInterface $em, MessageRepository $repoMessage, SluggerInterface $slugger): Response //Injection de dépendance
    {

        $figure = new Figure();
        $formFigure = $this->createForm(FigureType::class, $figure); //création formulaire + association entité

        $formFigure->handleRequest($request); //associer ce qui est envoyé

        if($formFigure->isSubmitted() && $formFigure->isValid()){
            $figure->setCreatedAt(new \DateTime());
            $figure->setCreator($this->getUser());
            $file = $formFigure->get('file')->getData();

            // this condition is needed because the 'file' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $file->move(
                        $this->getParameter('files_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'Filename' property to store the PDF file name
                // instead of its contents
                $figure->setFilename($newFilename);
            }


            $em->persist($figure);
            $em->flush();
            return $this->redirectToRoute('app_main');
         }

        return $this->render('figure/index.html.twig', [
            'formFigure' => $formFigure->createView(),
        ]);
    }


    #[Route('/figure/{id<\d+>}', name: 'app_figure_show')]
    public function show(Figure $figure): Response
    {
        return $this->render('figure/show.html.twig', [
            'figure' => $figure,
        ]);
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




