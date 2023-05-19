<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(
        Request $request, 
        EntityManagerInterface $manager, MailerInterface $mailer): Response
        {
        $contact = new Contact();

        $form=$this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
           
            $manager->persist($contact);
            $manager->flush();

            //Email
            $email = (new Email())
                ->from('hello@example.com')
                ->to('r.deilakshan@gmail.com')
                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                //->replyTo('fabien@example.com')
                //->priority(Email::PRIORITY_HIGH)
                ->subject('Hello Ireland')
                ->text('Sending emails is fun again!')
                ->html('<p>We have won the war against the red coats</p>');

            $mailer->send($email);


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
