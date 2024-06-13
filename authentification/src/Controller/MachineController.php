<?php

namespace App\Controller;

use App\Entity\Report;
use App\Form\MachineType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class MachineController extends AbstractController
{
    #[Route('/machine', name: 'machine')]
    public function index(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $report = new Report();
        $form = $this->createForm(MachineType::class, $report);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Handle file uploads for cart recto and verso
            $cartRectoFile = $form->get('cartegrise_recto')->getData();
            $cartVersoFile = $form->get('cartegrise_verso')->getData();

            if ($cartRectoFile) {
                $newFilename = $this->uploadFile($cartRectoFile, $slugger);
                $report->setCartegriseRecto($newFilename);
            }

            if ($cartVersoFile) {
                $newFilename = $this->uploadFile($cartVersoFile, $slugger);
                $report->setCartegriseVerso($newFilename);
            }

            // Handle parts and their associated damages
            foreach ($report->getReportParts() as $reportPart) {
                $damagePictureFile = $reportPart->getDamageImage();
                if ($damagePictureFile) {
                    $newFilename = $this->uploadFile($damagePictureFile, $slugger);
                    $reportPart->setDamageImage($newFilename);
                }
                $reportPart->setReport($report); // Link report part to report
                $entityManager->persist($reportPart);
            }

            $entityManager->persist($report);
            $entityManager->flush();

            $this->addFlash('success', 'Form successfully submitted!');

            return $this->redirectToRoute('machine');
        }

        return $this->render('machine/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function uploadFile($file, $slugger)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $slugger->slug($originalFilename);
        $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
    
        try {
            $file->move(
                $this->getParameter('upload_directory'),
                $newFilename
            );
        } catch (FileException $e) {
            // Handle exception if something happens during file upload
        }
    
        return $newFilename;
    }
}
