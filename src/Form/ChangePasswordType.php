<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'disabled' => true
            ])
            ->add('firstname', TextType::class, [
                'label' => 'firstname',
                'disabled' => true
            ])
            ->add('lastname', TextType::class, [
                'label' => 'firstname',
                'disabled' => true
            ])
            ->add('old_password', PasswordType::class, [
                'label' => 'password',
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'plase enter your password'
                ] 
            ])
            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'password must be the same',
                'required' => true,
                'mapped' => false,
                'label' => '    ',
                'first_options' => [
                    'label' => 'new password',
                    'attr' => [
                        'placeholder' => 'plase entre your new  password'
                    ]
                ],
                'second_options' => [
                    'label' => ' Confirm password',
                    'attr' => [
                        'placeholder' => 'plase confirm  password'
                    ]
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'signe in'
            ] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
