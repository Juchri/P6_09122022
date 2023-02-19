<?php

namespace App\Controller;

use App\Entity\Figure;
use App\Entity\Message;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Video;


use App\Form\FigureType;
use App\Form\MessageType;
use App\Form\VideoType;
use App\Form\ImageType;



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
        $video = new Video();
        $formVideo = $this->createForm(VideoType::class, $video);
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

        $image = new Image();
        $formImage = $this->createForm(ImageType::class, $image);
        $formFigure->handleRequest($request);

        if ($formImage->isSubmitted() && $formFigure->isValid()) {
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

        return $this->render('figure/index.html.twig', [
          'formFigure' => $formFigure->createView(),
          'formVideo' => $formVideo->createView(),
          'formImage' => $formImage->createView()

        ]);
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

        $video = new Video();
        $formVideo = $this->createForm(VideoType::class, $video);

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
          $id = $figure->getId();
          return $this->redirectToRoute('app_figure_edit', ['id' => $id]);

        }

        $image = new Image();
        $formImage = $this->createForm(ImageType::class, $image);

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
          $id = $figure->getId();
          return $this->redirectToRoute('app_figure_edit', ['id' => $id]);

        }

      return $this->render('figure/edit.html.twig', [
        'formFigure' => $formFigure->createView(),
        'formVideo' => $formVideo->createView(),
        'formImage' => $formImage->createView(),
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
        $video = new Video();
        $formVideo = $this->createForm(VideoType::class, $video);
        $formVideo->handleRequest($request);

          $file = $formVideo->get('content')->getData();
          $video->setContent('');
            // This condition is needed because the 'file' field is not required !
            // So the PDF file must be processed only when a file is uploaded !
            if ($file) {
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
              $video->setContent($newFilename);
            }

        $id = $request->request->get('id');
        $figure = $repo->find($id);
        $video->setFigure($figure);

        $emi->persist($video);
        $emi->flush();

        return $this->redirectToRoute('app_figure_edit', ['id' => $id]);
    }


    /**
     * Delete videos
     *
     * @return void
     */


      #[Route('/video/delete/{id<\d+>}', name: 'app_video_delete')]
     public function delete_video(Video $video, EntityManagerInterface $emi)
     {
         $emi->remove($video);
         $emi->flush();

         return $this->redirectToRoute('app_main');
      }

    /**
     * Add images
     *
     * @return void
     */


    #[Route('/add-image', name: 'add_image')]
    public function add_image(Request $request, EntityManagerInterface $emi, FigureRepository $repo, SluggerInterface $slugger)
    {
        $image = new Image();
        $formImage = $this->createForm(ImageType::class, $image);
        $formImage->handleRequest($request);

          $file = $formImage->get('content')->getData();
          $image->setContent('');
            // This condition is needed because the 'file' field is not required !
            // So the PDF file must be processed only when a file is uploaded !
            if ($file) {
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
              $image->setContent($newFilename);
            }

        $id = $request->request->get('id');
        $figure = $repo->find($id);
        $image->setFigure($figure);

        $emi->persist($image);
        $emi->flush();

        return $this->redirectToRoute('app_figure_edit', ['id' => $id]);
    }

/*
    #[Route('/add-image-different-forms', name: 'add_image')]
    public function add_image(Request $request, EntityManagerInterface $emi, FigureRepository $repo, SluggerInterface $slugger)
    {

      $formAddImage = $this->createForm(ImageType::class, null, ['attr' => ['id' => 'formAddImage']]);
      $formAddImage->handleRequest($request);

      if ($formAddImage->isSubmitted() && $formAddImage->isValid()) {

        $image = new Image();
        $formAddImage = $this->createForm(ImageType::class, $image);
        $formAddImage->handleRequest($request);

          $file = $formAddImage->get('content')->getData();
          $image->setContent('');
            // This condition is needed because the 'file' field is not required !
            // So the PDF file must be processed only when a file is uploaded !
            if ($file) {
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
              $image->setContent($newFilename);
            }

        $id = $request->request->get('id');
        $figure = $repo->find($id);
        $image->setFigure($figure);

        $emi->persist($image);
        $emi->flush();

        return $this->redirectToRoute('app_figure_edit', ['id' => $id]);

      }

      $formEdit = $this->createForm(FooFormType::class, null, ['attr' => ['id' => 'formEdit']]);
      $formEdit->handleRequest($request);
      if (($formEdit->isSubmitted() && $form2->isValid())) {
          // ...
      }

        return $this->render('figure/edit.html.twig', [
          'formAddImage' => $formAddImage->createView(),
          'formEditImage' => $formEdit->createView(),
        ]);
    }

*/
     /**
     * Delete images
     *
     * @return void
     */


    #[Route('/image/delete/{id<\d+>}', name: 'app_image_delete')]
    public function delete_image(Image $image, Figure $figure, EntityManagerInterface $emi)
    {
        $emi->remove($image);
        $emi->flush();

        return $this->redirectToRoute('app_main');

      }
}




