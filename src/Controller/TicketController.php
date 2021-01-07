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
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("/ticket")
 */
class TicketController extends AbstractController
{
    private $urlGenerator;
    private $auth;

    public function __construct(UrlGeneratorInterface $urlGenerator, AuthorizationCheckerInterface $auth)
    {
        $this->urlGenerator = $urlGenerator;
        $this->auth = $auth;
    }

    /**
     * @Route("/", name="ticket_index", methods={"GET"})
     */
    public function index(TicketRepository $ticketRepository): Response
    {
        if($this->auth->isGranted('ROLE_ADMIN')) {
            return $this->render('ticket/index.html.twig', [
                'controller_name' => 'Tickets',
                'tickets' => $ticketRepository->findBy(['isDemande' => 0])
            ]);
        }

        return $this->render('ticket/archive.html.twig', [
            'tickets' => $ticketRepository->findBy(['user' => $this->getUser()]),
            'controller_name' => 'Tickets',
        ]);
    }

    /**
     * @Route("/archive", name="ticket_archive", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function archive(TicketRepository $ticketRepository): Response
    {
        return $this->render('ticket/archive.html.twig', [
            'tickets' => $ticketRepository->findBy(['status' => 'archive']),
            'controller_name' => 'Tickets',
        ]);
    }

    /**
     * @Route("/new", name="ticket_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            // $ticket->setStatus(null);
            $ticket->setIsOpen(0);
            $ticket->setIsDemande(0);
            $ticket->setUser($this->getUser());
            $entityManager->persist($ticket);
            
            $entityManager->flush();

            return $this->redirectToRoute('ticket_email');
            // return new RedirectResponse($this->urlGenerator->generate(''));
        }

        return $this->render('ticket/new.html.twig', [
            'ticket' => $ticket,
            'form' => $form->createView(),
            'controller_name' => 'ticket',
        ]);
    }

    /**
     * @Route("/{id}", name="ticket_show", methods={"GET"})
     */
    public function show(Ticket $ticket): Response
    {
        // dd($ticket);    
        return $this->render('ticket/show.html.twig', [
            'ticket' => $ticket,
            'controller_name' => 'ticket',
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ticket_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Ticket $ticket): Response
    {
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ticket_index');
        }

        return $this->render('ticket/edit.html.twig', [
            'ticket' => $ticket,
            'form' => $form->createView(),
            'controller_name' => 'ticket',
        ]);
    }

    /**
     * @Route("/{id}", name="ticket_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Ticket $ticket): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ticket->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ticket);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ticket_index');
    }
}
