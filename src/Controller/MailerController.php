<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use \App\Entity\User;

class MailerController extends AbstractController
{

    private $urlGenerator;
    private $auth;

    public function __construct(UrlGeneratorInterface $urlGenerator, AuthorizationCheckerInterface $auth)
    {
        $this->urlGenerator = $urlGenerator;
        $this->auth = $auth;
    }

    /**
     * @Route("/mailer", name="mailer")
     */
    // public function index(): Response
    // {
    //     return $this->render('mailer/index.html.twig', [
    //         'controller_name' => 'MailerController',
    //     ]);
    // }

    /**
     * @Route("/ticket/email", name="ticket_email")
     * @IsGranted("ROLE_USER")
     */
    public function sendEmail(MailerInterface $mailer): Response
    {

        $email = (new Email())
            ->from($this->getUser()->getEmail())
            ->to('turchini.axel@gmail.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Boostmacom - Vous avez un nouveau ticket ! - ' . $this->getUser()->getEmail())
            // ->text('Vous avez un nouveau ticket ! SUPER ! Du travail.')
            ->html('<p>Vous avez un nouveau ticket ! SUPER ! Du travail.</p>');

        $mailer->send($email);

        // return true;

        return new RedirectResponse($this->urlGenerator->generate('ticket_index'));
    }
}
