<?php

namespace App\Form;

use App\Entity\Part;
use App\Entity\Report;
use App\Entity\ReportPart;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReportPartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('damage')
            ->add('damageImage')
            ->add('report', EntityType::class, [
                'class' => Report::class,
                'choice_label' => 'id',
            ])
            ->add('part', EntityType::class, [
                'class' => Part::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReportPart::class,
        ]);
    }
}
