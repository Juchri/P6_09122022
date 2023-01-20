<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use App\Entity\User;
use App\Entity\Figure;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use DateTime;

use App\Repository\MessageRepository;

use Doctrine\ORM\EntityManagerInterface;


class MessageController extends AbstractController
{

    #[Route('/message/{id<\d+>}', name: 'app_message')]
    public function index(Figure $figure, Request $request, EntityManagerInterface $em): Response
    {
        $message = new Message();
        $messageForm = $this->createForm(MessageType::class, $message); //création formulaire + association entité

        $messageForm->handleRequest($request); //associer ce qui est envoyé

        if($messageForm->isSubmitted()){
            $message->setSentAt(new \DateTime());
            $message->setFigure($figure);
            $message->setUser($this->getUser());
    
            $em->persist($message);
            $em->flush();
            return $this->redirectToRoute('app_main');
         }

        return $this->render('message/index.html.twig', array(
            'messageForm' => $messageForm->createView(),
        ));
    }

}
