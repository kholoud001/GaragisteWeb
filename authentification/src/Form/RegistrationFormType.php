<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;


class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter an email',
                    ]),
                    new Email([
                        'message' => 'Please enter a valid email address',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'Email',
                    'autocomplete' => 'email',
                    'class' => 'outline-none w-full rounded-lg p-2 text-black'
                ],
            ])
            ->add('username', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a username',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Your username should be at least {{ limit }} characters',
                        'max' => 50,
                    ]),
                    // Uncomment and customize the regex pattern according to your requirements
                    // new Regex([
                    //     'pattern' => '/^[a-zA-Z0-9_]+$/',
                    //     'message' => 'Your username can only contain letters, numbers, and underscores',
                    // ]),
                ],
                'attr' => [
                    'placeholder' => 'Username',
                    'autocomplete' => 'username',
                    'class' => 'outline-none w-full rounded-lg p-2 text-black'
                ],
            ])
            ->add('cell', TelType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a cell number',
                    ]),
                    new Regex([
                        // 'pattern' => '/^\+?[0-9]{10,15}$/',
                         'pattern' => '/^\+212[0-9]{9}$/',
                         'message' => 'Please enter a valid cell number of this format "+212xxxxxxxxx"',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'Cell number',
                    'autocomplete' => 'tel',
                    'class' => 'outline-none w-full rounded-lg p-2 text-black'
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'placeholder' => 'Password',
                    'class' => 'outline-none w-full rounded-lg p-2 text-black'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        'max' => 4096,
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
