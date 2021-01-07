<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketType;
use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("/demande")
 */
class DemandeController extends AbstractController
{
    private $auth;

    public function __construct(AuthorizationCheckerInterface $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @Route("/", name="demande_index")
     */
    public function index(TicketRepository $ticketRepository): Response
    {
        if($this->auth->isGranted('ROLE_ADMIN')) {
            return $this->render('ticket/index.html.twig', [
                'tickets' => $ticketRepository->findBy(['isDemande' => 1]),
                'controller_name' => 'Demandes',
            ]);
        }

        return $this->render('ticket/index.html.twig', [
            'tickets' => $ticketRepository->findBy(['user' => $this->getUser(), 'isDemande' => 1]),
            'controller_name' => 'Demandes',
        ]);
    }

    /**
     * @Route("/new", name="demande_new")
     */
    public function new(Request $request): Response
    {
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $ticket->setStatus('new');
            $ticket->setIsOpen(0);
            $ticket->setIsDemande(1);
            $ticket->setUser($this->getUser());
            $entityManager->persist($ticket);
            
            $entityManager->flush();

            return $this->redirectToRoute('ticket_email');
            // return new RedirectResponse($this->urlGenerator->generate(''));
        }

        return $this->render('ticket/new.html.twig', [
            'ticket' => $ticket,
            'form' => $form->createView(),
            'controller_name' => 'Demandes',
        ]);
    }

    /**
     * @Route("/{id}/edit", name="demande_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Ticket $ticket): Response
    {
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('demande_index');
        }

        return $this->render('ticket/edit.html.twig', [
            'ticket' => $ticket,
            'form' => $form->createView(),
            'controller_name' => 'Demandes',
        ]);
    }

    /**
     * @Route("/{id}", name="demande_show", methods={"GET"})
     */
    public function show(Ticket $ticket): Response
    {
        return $this->render('ticket/show.html.twig', [
            'ticket' => $ticket,
            'controller_name' => 'Demandes',
        ]);
    }
}
