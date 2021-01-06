<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

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
                'multiple' => true,
                'required' => true,
                )
            )
            ->add('password', null, array(
                'label' => 'Password',
                'attr' => ['class' => 'form-control', 'size' => 16]
            ))
            ->add('customer', null, array(
                'label' => 'Client',
                'attr' => ['class' => 'form-control']
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
