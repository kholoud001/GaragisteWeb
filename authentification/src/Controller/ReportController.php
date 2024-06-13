<?php

namespace App\Controller;

use App\Entity\Report;
use App\Form\ReportFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReportController extends AbstractController
{
    #[Route('/reports', name: 'app_report')]
    public function index(): Response
    {
        return $this->render('report/index.html.twig');

    }

    #[Route('/report/test', name: 'report_test')]
    public function test(): Response
    {
        return $this->render('report/form_test.html.twig');

    }

     /**
     * @Route("/report/new", name="report_new", methods={"GET", "POST"})
     */
     /**
     * @Route("/report/new", name="report_new")
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $report = new Report();
        $form = $this->createForm(ReportFormType::class, $report);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($report);
            $entityManager->flush();

            return $this->redirectToRoute('report_new');
        }

        return $this->render('report/report_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
