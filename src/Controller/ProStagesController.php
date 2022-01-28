<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Entreprise;
use App\Entity\Stage;
use App\Entity\Formation;

use App\Repository\StageRepository;
use App\Repository\FormationRepository;
use App\Repository\EntrepriseRepository;


class ProStagesController extends AbstractController
{
    /**
     * @Route("/", name="pro_stages_Accueil")
     */
    public function index(StageRepository $repositoryStage): Response
    {

        //recuperer les stages de l'entité Stage
        $ressources = $repositoryStage->findAll();
    
        return $this->render('pro_stages/index.html.twig', ['stages'=>$ressources]);
    }

        /**
     * @Route("/entreprises", name="entreprise")
     */
    public function afficherEntreprise(EntrepriseRepository $repositoryEntreprise): Response
    {
        
        //recuperer les entreprises de l'entité Entreprise
        $ressources = $repositoryEntreprise->findAll();

        return $this->render('pro_stages/entreprises.html.twig', ['entreprises'=>$ressources]);
    }

        /**
     * @Route("/formations", name="formations")
     */
    public function afficherFormations(FormationRepository $repositoryFormation): Response
    {
        
        //recuperer les formations de l'entité Formation
        $ressources = $repositoryFormation->findAll();
        return $this->render('pro_stages/formations.html.twig', ['formations'=>$ressources
           
        ]);
    }

 
        /**
     * @Route("/stage/{id}", name="afficherStage")
     */
    public function afficherStage(Stage $leStage): Response
    {   
    
        return $this->render('pro_stages/afficherStage.html.twig', [

           'stage'=>$leStage,
        ]);
    }

            /**
     * @Route("/formationStages/{id}", name="formationStages")
     */
    public function formationStages(Formation $laFormation): Response
    {   
        /*
        exemple que je garde
        //recuperer le repository de l'entitée formation
        $repositoryFormation=$this->getDoctrine()->getRepository(Formation::class);
        //recuperer les formations de l'entité 
        $laFormation = $repositoryFormation->find($id);// renvoie la formation
        */
    
        return $this->render('pro_stages/formationStages.html.twig', [

           'formation'=>$laFormation,
        ]);
    }

            /**
     * @Route("/entrepriseStages/{nom}", name="entrepriseStages")
     */
    public function entrepriseStages(StageRepository $repositoryStage , $nom): Response
    {   
    
        //recuperer les ressources de l'entité 

        
        
        $StageDeLentreprise = $repositoryStage->trouverToutLesStagesParEntreprise($nom); 

        // renvoie tous les stage qui ont pour codeEntreprise l'id donner
    
        return $this->render('pro_stages/entrepriseStages.html.twig', [

           'stages'=>$StageDeLentreprise,
        ]);
    }
}
