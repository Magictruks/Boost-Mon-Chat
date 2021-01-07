<?php

namespace App\Form;

use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\Request;

class TicketType extends AbstractType
{
    public function __construct(AuthorizationCheckerInterface $auth) {
        $this->auth = $auth;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $context = new RequestContext($_SERVER['REQUEST_URI']);

        $isTicket = strpos($context->getBaseUrl(), 'ticket');

        $builder
            ->add('label', null, array(
                'label' => 'Titre',
                'attr' => ['class' => 'form-control']
            ))
            ->add('description', null, array(
                'label' => 'Description',
                'attr' => ['class' => 'form-control']
            ))
        ;

        if ($this->auth->isGranted('ROLE_ADMIN')) {
            $builder->add('user', null, array(
                'label' => 'Utilisateur',
                'attr' => ['class' => 'form-control']
            ));
            }

            if ($isTicket) {
                $builder->add('isOpen', null, array(
                    'label' => 'Etat du ticket (ouvert/fermé)',
                    'attr' => ['class' => 'form-check']
                ));
            } else if ($this->auth->isGranted('ROLE_ADMIN') and !$isTicket) {
                $builder->add('status', ChoiceType::class, array(
                    'label' => 'Status',
                    'attr' => ['class' => 'form-control'],
                    'choices' => 
                    [
                        'Nouvelle' => 'new',
                        'En cours de traitement' => 'in progress',
                        'Traitée' => 'done',
                        'Archivé' => 'archive'
                    ]
                    ,
                    'expanded' => false,
                    'multiple' => false,
                    'required' => true,
                    ));
            }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
