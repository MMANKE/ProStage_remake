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
use App\Form\StageType;
use App\Form\EntrepriseType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

class ProStageController extends AbstractController
{
    /**
     * @Route("/", name="pro_stage_acceuil")
     */
    public function index()
    {
        return $this->redirectToRoute('stage_index');
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

    /**
     * @Route("/ajout/entreprise", name="pro_stage_ajout_entreprise")
     */
    public function addEntreprise(Request $requetteHttp, ObjectManager $manager) {

        $entreup = new Entreprise();

        $form = $this->createForm(EntrepriseType::class, $entreup);

        $form->handleRequest($requetteHttp);

        if($form->isSubmitted() && $form->isValid()) {
              $manager->persist($entreup);
              $manager->flush();
              return $this->redirectToRoute('pro_stage_acceuil');
        }

        return $this->render('pro_stage/formulaires/ajouterEntreprise.html.twig',
                            ['form' => $form->createView()]
                          );
    }

    /**
     * @Route("/modif/entreprise/{id}", name="pro_stage_modif_entreprise")
     */
    public function modificationEntreprise(EntrepriseRepository $entrepriseRepo, Request $requetteHttp, ObjectManager $manager, $id) {

        $entreup = $entrepriseRepo->find($id);

        $form = $this->createForm(EntrepriseType::class, $entreup);

        $form->handleRequest($requetteHttp);

        if($form->isSubmitted()) {
              $manager->persist($entreup);
              $manager->flush();
              return $this->redirectToRoute('pro_stage_details_entreprise', ['id' => $entreup->getId()]);
        }

        return $this->render('pro_stage/formulaires/modifierEntreprise.html.twig',
                            ['form' => $form->createView()]);
    }

    /**
     * @Route("/ajout/stage", name="pro_stage_ajout_stage")
     */
    public function addStage(Request $requetteHttp, ObjectManager $manager) {

        $stage = new Stage();

        $form = $this->createForm(StageType::class, $stage);
        $form->handleRequest($requetteHttp);

        if($form->isSubmitted() && $form->isValid()) {
              $manager->persist($stage);
              $manager->flush();
              return $this->redirectToRoute('pro_stage_acceuil');
        }

        return $this->render('pro_stage/formulaires/ajouterStage.html.twig',
                            ['form' => $form->createView()]
                          );
    }

}
