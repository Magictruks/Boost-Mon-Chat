<?php

namespace App\Form;

use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class TicketType extends AbstractType
{
    public function __construct(AuthorizationCheckerInterface $auth) {
        $this->auth = $auth;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
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
        $builder->add('status', ChoiceType::class, array(
            'label' => 'Status',
            'attr' => ['class' => 'form-control'],
            'choices' => 
            [
                'Nouveau' => 'new',
                'En cours' => 'in progress',
                'Terminé' => 'done',
            ]
            ,
            'expanded' => false,
            'multiple' => false,
            'required' => true,
            ))
            ->add('user', null, array(
                'label' => 'Utilisateur',
                'attr' => ['class' => 'form-control']
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
