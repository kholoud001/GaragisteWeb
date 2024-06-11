<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new Users();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
    
            // Set the role of the user to "garagiste"
            $user->setRoles(['ROLE_GARAGISTE']);
    
            // The createdAt date will be set automatically by the PrePersist lifecycle callback
    
            $entityManager->persist($user);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_dashboard');
        }
    
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
    
}
