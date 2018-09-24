<?php
namespace App\Controller;

use App\Form\ContactType;
use App\Entity\Contact;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\CaptchaBundle\CaptchaBundle;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
    */
     public function drawContact(Request $request, \Swift_Mailer $mailer) {
        $Contact = new Contact();
        $Form = $this->createForm(ContactType::class, $Contact);

        $Form->handleRequest($request);
        if ($Form->isSubmitted() && $Form->isValid()) {
          $Captcha = new CaptchaBundle();
          $bCaptcha = $Captcha->captchaverify($request->get('g-recaptcha-response'));
          if ($bCaptcha == true) {
            //Save the record
              $entityManager = $this->getDoctrine()->getManager();
              $entityManager->persist($Contact);
              $entityManager->flush();

            //Mail the saved contact
              $message = new \Swift_Message('New Contact');
              $message->setFrom('help@socialplacessample.com');
              $message->setTo($Contact->getEmailAdress());
              $message->setBody("Welcome Email", 'text/plain');
              $mailer->send($message);

            //Mail contact manager
              $message = new \Swift_Message('New Contact');
              $message->setFrom('help@socialplacessample.com');
              $message->setTo('manager@socialplacessample.com');
              $message->setBody("A new person joined: ".$Contact->getName(), 'text/plain');
              $mailer->send($message);

              return $this->redirectToRoute('home');
          } else {
           $this->addFlash(
                'error',
                'Captcha Require'
              );
          }
        }

        return $this->render(
            'contact.html.twig',
            array('form' => $Form->createView())
        );
    }


    //Function to allow API calls
    /**
     * @Route("/api_addContact", name="api_addContact")
    */
    public function api_addContact(Request $request) {
        $arrParameters = json_decode($request->getContent());
        $contact = new Contact();
        $contact->setName($arrParameters->Name);
        $contact->setSurname($arrParameters->Surname);
        $contact->setEmailAdress($arrParameters->EmailAddress);
        $contact->setPhoneNumber($arrParameters->PhoneNumber);
        $em = $this->getDoctrine()->getManager();
        $em->persist($contact);
        $em->flush();


        $response = new Response(
            '{Success:true}',
            Response::HTTP_OK,
            array('content-type' => 'text/plain')
        );
        return $response;



    }

}