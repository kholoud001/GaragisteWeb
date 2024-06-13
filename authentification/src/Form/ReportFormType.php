<?php
namespace App\Form;

use App\Entity\Part;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType; 
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;


class ReportFormType extends AbstractType // Renamed the class
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('part', EntityType::class, [
                'class' => Part::class,
                'choice_label' => 'name',
                'label' => 'Part'
            ])
            ->add('damageDescription', TextType::class, ['label' => 'Description du dommage'])
            ->add('damagePicture', FileType::class, [
                'label' => 'Photo du dommage',
                'constraints' => [
                    new File(['maxSize' => '2048k'])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
