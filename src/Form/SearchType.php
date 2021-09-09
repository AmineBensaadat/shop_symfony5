<?php

namespace App\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Classes\Search;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Category;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('string', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'your search her ...',
                    'class' => 'form-control-sm'
                ]
            ])
            ->add('categories', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Category::class,
                'multiple' => true,
                'expanded' => true

                
            ])->add('submit', SubmitType::class, [
                'label' => 'Search',
                'attr' => [
                    'class' => 'btn-info btn-sm'
                ]
            ] );
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'method' => 'GET',
            'crsf_protection' => false 
        ]);
    }

    public function getBlockPrefix(){
        return '';
    }

}