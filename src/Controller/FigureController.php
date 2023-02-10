<?php

namespace App\Controller;

use App\Entity\Figure;
use App\Entity\Message;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Video;


use App\Form\FigureType;
use App\Form\MessageType;

use App\Repository\FigureRepository;
use App\Repository\MessageRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\ORM\EntityManagerInterface;

use DateTime;

class FigureController extends AbstractController
{
    #[Route('/figure', name: 'app_figure')]

    /**
     * Creation of figure
     *
     * @return void
     */


    public function index(Request $request, EntityManagerInterface $emi, SluggerInterface $slugger): Response
    {

        $figure = new Figure();
        $formFigure = $this->createForm(FigureType::class, $figure);

        $formFigure->handleRequest($request);

        if ($formFigure->isSubmitted() && $formFigure->isValid()) {
            $figure->setCreatedAt(new \DateTime());
            $figure->setCreator($this->getUser());
            $file = $formFigure->get('file')->getData();

              // This condition is needed because the 'file' field is not required !
              // So the PDF file must be processed only when a file is uploaded !
              if ($file === TRUE) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
              // This is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

                // Move the file to the directory where brochures are stored !
                try {
                  $file->move(
                  $this->getParameter('files_directory'),
                  $newFilename
                  );
                } catch (FileException $e) {
                      // ... Handle exception if something happens during file upload !
                }

                  // Updates the 'Filename' property to store the PDF file name !
                  // Instead of its contents !
                $figure->setFilename($newFilename);
              }

            $emi->persist($figure);
            $emi->flush();
            return $this->redirectToRoute('app_main');
        }

        return $this->render('figure/index.html.twig', ['formFigure' => $formFigure->createView()]);
      }

      #[Route('/figure/{id<\d+>}', name: 'app_figure_show')]
      /**
       * Showing figures
       *
       * @return void
       */


      public function show(Figure $figure, Request $request, EntityManagerInterface $emi): Response
      {

        $message = new Message();
        $messageForm = $this->createForm(MessageType::class, $message);

        $messageForm->handleRequest($request);

        if ($messageForm->isSubmitted() === TRUE) {
            $message->setSentAt(new \DateTime());
            $message->setFigure($figure);
            $message->setUser($this->getUser());

            $emi->persist($message);
            $emi->flush();
            return $this->redirectToRoute('app_main');
          }

          return $this->render('figure/show.html.twig', ['messageForm' => $messageForm->createView(),'figure' => $figure]);
      }

    #[Route('/figure/edit/{id<\d+>}', name: 'app_figure_edit')]
     /**
     * Edit figures
     *
     * @return void
     */


    public function edit(Figure $figure, Request $request, EntityManagerInterface $emi, SluggerInterface $slugger): Response
    {
        $formFigure = $this->createForm(FigureType::class, $figure);
        $formFigure->handleRequest($request);

        if ($formFigure->isSubmitted() && $formFigure->isValid()) {
          $figure->setModifiedAt(new \DateTime());
          $figure->setCreator($this->getUser());
          $file = $formFigure->get('file')->getData();

        if ($file) {
          $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
          $safeFilename = $slugger->slug($originalFilename);
          $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

          try {
            $file->move(
              $this->getParameter('files_directory'),
              $newFilename
              );
            } catch (FileException $e) {
            }

            $figure->setFilename($newFilename);
          }

          $emi->persist($figure);
          $emi->flush();
          return $this->redirectToRoute('app_main');
        }

      return $this->render('figure/edit.html.twig', [
        'formFigure' => $formFigure->createView(),
        'figure' => $figure]);
    }

    /**
     * Delete figures
     *
     * @return void
     */


    #[Route('/figure/delete/{id<\d+>}', name: 'app_figure_delete')]
    public function delete(Figure $figure, EntityManagerInterface $emi)
    {
        $emi->remove($figure);
        $emi->flush();

        return $this->redirectToRoute('app_main');
    }

    #[Route('/add-video', name: 'add_video')]
    public function add_video(Request $request, EntityManagerInterface $emi, FigureRepository $repo, SluggerInterface $slugger)
    {
      //var_dump($request->$request->get('title')); die;
      $video = new Video();
      //  $video->setTitle($request->request->get('title'));

        $videoFile = $request->request->get('title');

        if($videoFile){
          // $originalFilename = $request->request->get('title');
          $safeVideoFile = $slugger->slug($videoFile);
          $newFilename = $safeVideoFile.'-'.uniqid().'.'.$videoFile->guessExtension();

          try {
            $videoFile->move(
              $this->getParameter('files_directory'),
              $newFilename
              );
            } catch (FileException $e) {
          }

          $video->setTitle($newFilename);
        }
      

        $id = $request->request->get('id');

        $figure = $repo->find($id);
        $video->setFigure($figure);
        $video->setContent('abc');

        $emi->persist($video);
        $emi->flush();
      

        return $this->redirectToRoute('app_figure_edit', ['id' => $id]);
    }
}




