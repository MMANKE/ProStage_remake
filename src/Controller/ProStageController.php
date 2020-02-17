<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProStageController extends AbstractController
{
    /**
     * @Route("/", name="pro_stage_acceuil")
     */
    public function index()
    {
        return $this->render('pro_stage/index.html.twig');
    }

    /**
     * @Route("/entreprises", name="pro_stage_entreprises")
     */
    public function showEntreprises()
    {
        return $this->render('pro_stage/entreprises.html.twig');
    }

    /**
     * @Route("/formations", name="pro_stage_formations")
     */
    public function showFormations()
    {
        return $this->render('pro_stage/formations.html.twig');
    }

    /**
     * @Route("/stages/{id}", name="pro_stage_details_stage")
     */
    public function showStageDetails($id)
    {
        return $this->render('pro_stage/stageDetails.html.twig', ['id' => $id]);
    }

}
