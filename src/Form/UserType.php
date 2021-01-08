<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', null, array(
                'label' => 'Email',
                'attr' => ['class' => 'form-control', 'size' => 16]
            ))
            ->add('roles', ChoiceType::class, array(
                'label' => 'Roles',
                'attr' => ['class' => 'form-control'],
                'choices' => 
                [
                    'User' => 'ROLE_USER',
                    'Client' => 'ROLE_CLIENT',
                    'Admin' => 'ROLE_ADMIN',
                ]
                ,
                'expanded' => false,
                'multiple' => false,
                'required' => true,
                )
            )
            ->add('customer', null, array(
                'label' => 'Client',
                'attr' => ['class' => 'form-control']
            ))
            ->add('status', null, array(
                'label' => 'Status (active/désactive)',
                'attr' => ['class' => 'form-check']
            ))
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();
            if(!$data->getId()){
                $form->add('password', null, array(
                    'label' => 'Password',
                    'attr' => ['class' => 'form-control', 'size' => 16]
                ));
            }
        });

        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                     // transform the array to a string
                     return count($rolesArray)? $rolesArray[0]: null;
                },
                function ($rolesString) {
                     // transform the string back to an array
                     return [$rolesString];
                }
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
