<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Finder\Finder;
use Symfony\Component\DependencyInjection\EnvVarProcessorInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DashboardController extends AbstractController
{
    private $urlGenerator;
    private $auth;

    public function __construct(UrlGeneratorInterface $urlGenerator, AuthorizationCheckerInterface $auth)
    {
        $this->urlGenerator = $urlGenerator;
        $this->auth = $auth;
    }
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index(TicketRepository $ticketRepository): Response
    {
        if(!$this->auth->isGranted('ROLE_ADMIN')) {
            return new RedirectResponse($this->urlGenerator->generate('demande_index'));
        }

        $visitors = 0;
        $finder = new Finder();
        // find all files in the current directory
        $finder->files()->in($_SERVER['DIR_URL'] . 'var\sessions');

        // check if there are any search results
        if ($finder->hasResults()) {
            // ...
            foreach ($finder as $file) {
                // $absoluteFilePath = $file->getRealPath();
                // $fileNameWithExtension = $file->getRelativePathname();
                $visitors += 1;
            }
        }

        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'newTickets' => $ticketRepository->count(['status' => 'new' ]),
            'inProgressTickets' => $ticketRepository->count(['status' => 'in progress' ]),
            'openTickets' => $ticketRepository->count(['isOpen' => 1 ]),
            'closeTickets' => $ticketRepository->count(['isOpen' => 0 ]),
            'totalVisitor' => $visitors,
            'tickets' => $ticketRepository->findBy(['status' => 'new']),
        ]);
    }

    
}
