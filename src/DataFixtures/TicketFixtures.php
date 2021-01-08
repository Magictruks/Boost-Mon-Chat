<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use app\Entity\Ticket;
use app\Entity\User;

class TicketFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $ticket = new Ticket();
        $ticket->setLabel('Label Test');
        $ticket->setDescription('Description Test');
        $ticket->setStatus('new');
        $ticket->setIsDemande(1);
        $ticket->setIsOpen(0);
        // $ticket->setUser(10);
        $manager->persist($ticket);
        $manager->flush();
    }
}
