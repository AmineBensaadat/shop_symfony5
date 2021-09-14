<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TelType;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'anter name of your address',
                'attr' => [
                    'placeholder' => 'enter her'
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => 'anter your first name',
                'attr' => [
                    'placeholder' => 'enter her'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'anter your lastname',
                'attr' => [
                    'placeholder' => 'enter her'
                ]
            ])
            ->add('company', TextType::class, [
                'label' => 'anter your company',
                'attr' => [
                    'placeholder' => 'enter her'
                ]
            ])
            ->add('address', TextType::class, [
                'label' => 'anter your address',
                'attr' => [
                    'placeholder' => 'enter her'
                ]
            ])
            ->add('postal', TextType::class, [
                'label' => 'anter  your postal',
                'attr' => [
                    'placeholder' => 'enter her'
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'anter your city',
                'attr' => [
                    'placeholder' => 'enter her'
                ]
            ])
            ->add('country', CountryType::class, [
                'label' => 'anter your country',
                'attr' => [
                    'placeholder' => 'enter her'
                ]
            ])
            ->add('phone', TelType::class, [
                'label' => 'anter your phone',
                'attr' => [
                    'placeholder' => 'enter her'
                ]
            ])
            ->add('submit', SubmitType::class,[
                'label' => 'add address',
                'attr' => [
                    'class' => 'btn-block btn-info'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
