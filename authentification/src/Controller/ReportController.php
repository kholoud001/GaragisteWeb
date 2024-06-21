<?php

namespace App\Controller;

use App\Entity\Mark;
use App\Entity\Model;
use App\Entity\Part;
use App\Entity\Report;
use App\Entity\ReportPart;
use App\Form\ReportFormType;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ReportController extends AbstractController
{
    #[Route('/reports', name: 'app_report')]
    public function index(EntityManagerInterface $entitymanager): Response
    {
        $reports = $entitymanager->getRepository(Report::class)->findAll();
        return $this->render('report/index.html.twig', array('reports' => $reports));
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

    public function newPart(Request $request, EntityManagerInterface $entitymanager, SluggerInterface $slugger): Response
    {
        $formData = $request->request->all();
        $fileData = $request->files->all();
        $reportData = $formData["data"]["Machine"];
        $reports = [];

        $dossier = new Report();
        $model = new Model();
        $model->setName($reportData['modele']);
        $mark = new Mark();
        $mark->setName($reportData['marque']);
        $model->setMark($mark);
        $dossier->setModel($model);
        $dossier->setRegistrationNumber($reportData['num_imma']);
        $dossier->setPreviousRegistration($reportData['num_imma_ante']);
        $dossier->setUsage($reportData['v_usage']);
        $dossier->setAddress($reportData['adresse']);
        $dossier->setType($reportData['type_carburant']);
        $dossier->setChassisNbr($reportData['n_chassis']);
        $dossier->setCylinderNbr($reportData['n_cylindres']);
        $dossier->setFiscalPower($reportData['puissance']);
        $dossier->setFirstRegistration(new DateTime($reportData['date_mc']));
        $dossier->setMCMaroc(new DateTime($reportData['date_mc_maroc']));
        $dossier->setValidityEnd(new DateTime($reportData['fin_valide']));
        $dossier->setGenre($reportData['genre']);
        $dossier->setOwner('placeholder, change later');
        $dossier->setFuelType($reportData['type_carburant']);
        $entitymanager->persist($model);
        $entitymanager->persist($mark);
        $entitymanager->persist($dossier);

        foreach ($formData as $key => $value) {
            if (strpos($key, '_report') !== false) {
                $id = explode('_', $key)[0];
                if ($id !== 'null' && $formData[$id . '_damage'] !== '') {
                    $originalFilename = pathinfo($fileData['frontCard_' . $id]->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename . '-' . uniqid() . '.' . $fileData['frontCard_' . $id]->getClientOriginalExtension();

                    $reporta = $entitymanager->getRepository(Report::class)->find($dossier->getId());
                    $damage = $formData[$id . '_damage'];

                    try {
                        $fileData['frontCard_' . $id]->move(
                            $this->getParameter('upload_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // Handle exception if something happens during file upload
                    }
    
                    $report = new ReportPart();
                    $report->setReport($reporta);
                    $part = $entitymanager->getRepository(Part::class)->find($id);
                    $report->setPart($part);
                    $report->setDamage($damage);
                    $report->setDamageImage($newFilename);
    
                    $entitymanager->persist($report);
    
                    $reports[] = $report;
                }
            }
        }

        $entitymanager->flush();
        return $this->redirect('/reports');
    }

    public function showDetail(string $slug, EntityManagerInterface $entityManager): Response
    {
        $report = $entityManager->getRepository(Report::class)->find($slug);
        return $this->render('report/rapportDetail.html.twig', ['newReport' => $report]);
    }

}
