<?php
namespace App\Form;

use App\Entity\Model;
use App\Entity\Part;
use App\Entity\ReportPart;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\DateType;



class MachineType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('registrationNumber', TextType::class, ['label' => 'Numéro d\'immatriculation'])
            ->add('previousRegistration', TextType::class, ['label' => 'Immatriculation antérieure'])
            ->add('firstRegistration', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Première mise en circulation',
            ])
            ->add('MC_maroc', DateType::class, [
                'widget' => 'single_text',
                'label' => 'M.C. au Maroc',
            ])
            ->add('usage', TextType::class, ['label' => 'Usage'])
            ->add('owner', TextType::class, ['label' => 'Propriétaire'])
            ->add('address', TextType::class, ['label' => 'Adresse'])
            ->add('validity_end', DateType::class, ['label' => 'Fin de validité'])
            ->add('model', EntityType::class, [
                'class' => Model::class,
                'choice_label' => 'name',
                'placeholder' => 'Select a Model',
            ])
            ->add('type', TextType::class, ['label' => 'Type'])
            ->add('genre', TextType::class, ['label' => 'Genre'])
            ->add('fuel_type', TextType::class, ['label' => 'Type carburant'])
            ->add('chassis_nbr', TextType::class, ['label' => 'N° de châssis'])
            ->add('cylinder_nbr', TextType::class, ['label' => 'Nombre de cylindres'])
            ->add('fiscal_power', TextType::class, ['label' => 'Puissance fiscale'])
            ->add('cartegrise_recto', FileType::class, [
                'label' => 'Carte grise recto',
                'required' => false,
                'constraints' => [
                    new File(['maxSize' => '2048k'])
                ]
            ])
            ->add('cartegrise_verso', FileType::class, [
                'label' => 'Carte grise verso',
                'required' => false,
                'constraints' => [
                    new File(['maxSize' => '2048k'])
                ]
            ])
            ->add('reportParts', CollectionType::class, [
                'entry_type' => ReportPartType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => 'Parts'
            ]);
    }
    

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
        ]);
    }
}
