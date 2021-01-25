<?php

namespace App\DataFixtures;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use app\Entity\Company;
use app\Entity\Customer;
use app\Entity\User;
use app\Entity\Ticket;
use Faker;
use App\Repository\UserRepository;
use App\Repository\CompanyRepository;


class AppFixtures extends Fixture
{

    private $passwordEncoder;
    private $userRepository;
    private $companyRepository;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, UserRepository $userRepository, CompanyRepository $companyRepository)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->userRepository = $userRepository;
        $this->companyRepository = $companyRepository;
    }

    public function load(ObjectManager $manager)
    {
        $this->companyFixture($manager, 10);
        $this->customerFixture($manager, 10);
        $this->userFixture($manager, 10);
        $this->ticketFixture($manager, 30);
    }

    public function companyFixture($manager, $nb) {
        $faker = Faker\Factory::create('fr_FR');

        for ($i=0; $i < $nb; $i++) { 
            $company = new Company();
            $company->setName($faker->name);
            $manager->persist($company);
        }
        $manager->flush();
    }

    public function customerFixture($manager, $nb) {
        $faker = Faker\Factory::create('fr_FR');

        $repo = $this->companyRepository->findAll();

        for ($i=0; $i < $nb; $i++) { 
            $customer = new Customer();
            $customer->setName($faker->name);
            $customer->setCompany($repo[$faker->biasedNumberBetween($min = 0, $max = count($repo)-1, $function = 'sqrt')]);

            $manager->persist($customer);
        }

        $manager->flush();
    }

    public function userFixture($manager, $nb) {
        $faker = Faker\Factory::create('fr_FR');

        $user = new User();
        // Admin
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'admin'
        ));
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setEmail('admin@admin.com');
        $user->setStatus(1);
        $manager->persist($user);

        $user = new User();
        // Admin
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'user'
        ));
        $user->setRoles(["ROLE_USER"]);
        $user->setEmail('user@user.com');
        $user->setStatus(1);
        $manager->persist($user);

        for ($i=1; $i < $nb; $i++) { 
            $user = new User();
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'azerty'
            ));
            $user->setRoles(["ROLE_USER"]);
            $user->setEmail($faker->email);
            $user->setStatus($faker->boolean);
            $manager->persist($user);
        }

        $manager->flush();
    }

    public function ticketFixture($manager, $nb) {
        $faker = Faker\Factory::create('fr_FR');

        $status = 'archives';

        $repo = $this->userRepository->findAll();

        for ($i = 0; $i < $nb; $i++) {
            $ticket = new Ticket();
            $ticket->setLabel($faker->sentence($nbWords = 6, $variableNbWords = true));
            $ticket->setDescription($faker->text);
            $ticket->setIsOpen(0);
            $isDemande = $faker->boolean;
            if($isDemande) {
                $ticket->setIsDemande(1);
                $ticket->setStatus($faker->randomElement($array = array ('new','in progress','done','archive')));
            } else {
                $ticket->setIsDemande(0);
                $ticket->setIsOpen($faker->boolean);
            }
            $ticket->setUser($repo[$faker->biasedNumberBetween($min = 0, $max = count($repo)-1, $function = 'sqrt')]);
            $manager->persist($ticket);
        }
        $manager->flush();
    }

}
