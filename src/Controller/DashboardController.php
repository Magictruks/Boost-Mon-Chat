<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Finder\Finder;
use Symfony\Component\DependencyInjection\EnvVarProcessorInterface;

class DashboardController extends AbstractController
{
    private $auth;

    public function __construct(AuthorizationCheckerInterface $auth)
    {
        $this->auth = $auth;
    }
    /**
     * @Route("/dashboard", name="dashboard")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(TicketRepository $ticketRepository): Response
    {
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
            'totalVisitor' => $visitors,
        ]);
    }
}
