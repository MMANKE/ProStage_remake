<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\StageRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\FormationRepository;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;

class ProStageController extends AbstractController
{
    /**
     * @Route("/", name="pro_stage_acceuil")
     */
    public function index()
    {
        return $this->redirectToRoute('pro_stage_stages');
    }

    /**
     * @Route("/entreprises", name="pro_stage_entreprises")
     */
    public function showEntreprises(EntrepriseRepository $entrepriseRepo)
    {
        return $this->render('pro_stage/entreprises.html.twig', ['entreprises' => $entrepriseRepo->findAll()]);
    }

    /**
     * @Route("/formations", name="pro_stage_formations")
     */
    public function showFormations(FormationRepository $formRepo)
    {
        return $this->render('pro_stage/formations.html.twig', ['formations' => $formRepo->findAll()]);
    }

    /**
     * @Route("/stages", name="pro_stage_stages")
     */
    public function showAllStages(StageRepository $stageRepository)
    {
        return $this->render('pro_stage/stages.html.twig', ['stages' => $stageRepository->findAll()]);
    }

    /**
     * @Route("/stages/entreprise/{id}", name="pro_stage_stages_by_entreprise")
     */
    public function showStagesByEntreprise($id)
    {
        $stages = $this->getDoctrine()->getRepository(Entreprise::class)->find($id)->getEntreprise(); // Je me suis trompé lors de la liason des classes cela permet de récupérer les stages

        return $this->render('pro_stage/stages.html.twig', ['stages' => $stages]);
    }

    /**
     * @Route("/stages/{id}", name="pro_stage_details_stage")
     */
    public function showStageDetails(StageRepository $stageRepository, $id)
    {
      $stage = $stageRepository->find($id);
      return $this->render('pro_stage/stageDetails.html.twig', ['stage' => $stage]);
    }

    /**
     * @Route("/entreprise/{id}", name="pro_stage_details_entreprise")
     */
    public function showEntrepriseDetails(EntrepriseRepository $entrepriseRepo, $id)
    {
        $entreprise = $entrepriseRepo->find($id);
        return $this->render('pro_stage/entreprise.html.twig', ['entreprise' => $entreprise]);
    }

}
