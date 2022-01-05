<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProStagesController extends AbstractController
{
    /**
     * @Route("/", name="pro_stages_Aceuil")
     */
    public function index(): Response
    {
        return $this->render('pro_stages/index.html.twig', [
           
        ]);
    }

        /**
     * @Route("/entreprises", name="entreprise")
     */
    public function afficherEntreprise(): Response
    {
        return $this->render('pro_stages/entreprises.html.twig', [''
           
        ]);
    }

        /**
     * @Route("/formations", name="formations")
     */
    public function afficherFormations(): Response
    {
        return $this->render('pro_stages/formations.html.twig', [
           
        ]);
    }

 
        /**
     * @Route("/stage/{id}", name="afficherStage")
     */
    public function afficherStage($id): Response
    {
        return $this->render('pro_stages/afficherStage.html.twig', [
           'idStage'=>$id,
        ]);
    }
}
