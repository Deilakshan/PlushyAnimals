<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Entity\Contact;
use App\Service\Mailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(
        Request $request, Mailer $mailer, 
        EntityManagerInterface $manager): Response
        {
        $contact = new Contact();

        $form=$this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            // $email=$contact['email'];
            $mailer->sendEmail();

            $manager->persist($contact);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre demande a été envoyée avec succès !'
            );
            return $this->redirectToRoute('app_contact');
        }else{

            return $this->renderForm('contact/index.html.twig', [
                'controller_name' => 'ContactController',
                'formulaire' => $form
            ]);

        }
       
    }
}
