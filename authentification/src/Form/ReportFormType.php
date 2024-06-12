<?php

namespace App\Form;

use App\Entity\Model;
use App\Entity\Report;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class ReportFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('registrationNumber', TextType::class)
            ->add('previousRegistration', TextType::class)
            ->add('firstRegistration', null, [
                'widget' => 'single_text',
            ])
            ->add('MC_maroc', null, [
                'widget' => 'single_text',
            ])
            ->add('usage', TextType::class)
            ->add('owner', TextType::class)
            ->add('address', TextType::class)
            ->add('validity_end', null, [
                'widget' => 'single_text',
            ])
            ->add('type', TextType::class)
            ->add('genre', TextType::class)
            ->add('fuel_type', TextType::class)
            ->add('chassis_nbr', TextType::class)
            ->add('cylinder_nbr', TextType::class)
            ->add('fiscal_power', TextType::class)
            ->add('model', EntityType::class, [
                'class' => Model::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('m')
                        ->orderBy('m.name', 'ASC'); 
                },
                'choice_label' => 'name', 
                'placeholder' => 'Select a Model', 
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Report::class,
        ]);
    }
}
