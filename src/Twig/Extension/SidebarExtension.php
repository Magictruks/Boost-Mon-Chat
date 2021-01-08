<?php

namespace App\Twig\Extension;

use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SidebarExtension extends AbstractExtension
{
    /**
     * @var Environment
     */
    private $twig;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var TicketRepository
     */
    private $ticketRepository;


    /**
     * SidebarExtension constructor.
     * @param Environment $twig
     * @param EntityManagerInterface $entityManager
     * @param TicketRepository $articleCategoryRepository
     */
    public function __construct(Environment $twig,
                                EntityManagerInterface $entityManager,
                                TicketRepository $ticketRepository

    )
    {
        $this->twig = $twig;
        $this->entityManager = $entityManager;
        $this->ticketRepository = $ticketRepository;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('backend_sidebar', [$this, 'backendSidebar'], ['is_safe' => ['html']]),
        ];
    }

    public function backendSidebar()
    {
        $newDemande = $this->ticketRepository->count(['status' => 'new' ]);
        $ticketOpen = $this->ticketRepository->count(['isOpen' => 1 ]);

        return $this->twig->render('partials/sidebar.html.twig', [
           "newDemande" => $newDemande,
           "ticketOpen" => $ticketOpen
        ]);
    }
}