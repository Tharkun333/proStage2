<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Entreprise;
use App\Entity\Stage;
use App\Entity\Formation;

class ProStagesController extends AbstractController
{
    /**
     * @Route("/", name="pro_stages_Aceuil")
     */
    public function index(): Response
    {
        //recuperer le repository de l'entitée Stage
        $repositoryStage=$this->getDoctrine()->getRepository(Stage::class);
        //recuperer les ressources de l'entité Ressource
        $ressources = $repositoryStage->findAll();
    
        return $this->render('pro_stages/index.html.twig', ['stages'=>$ressources]);
    }

        /**
     * @Route("/entreprises", name="entreprise")
     */
    public function afficherEntreprise(): Response
    {
        //recuperer le repository de l'entitée Stage
        $repositoryEntreprise=$this->getDoctrine()->getRepository(Entreprise::class);
        //recuperer les ressources de l'entité Ressource
        $ressources = $repositoryEntreprise->findAll();
        return $this->render('pro_stages/entreprises.html.twig', ['entreprises'=>$ressources]);
    }

        /**
     * @Route("/formations", name="formations")
     */
    public function afficherFormations(): Response
    {
        //recuperer le repository de l'entitée Stage
        $repositoryFormation=$this->getDoctrine()->getRepository(Formation::class);
        //recuperer les ressources de l'entité Ressource
        $ressources = $repositoryFormation->findAll();
        return $this->render('pro_stages/formations.html.twig', ['formations'=>$ressources
           
        ]);
    }

 
        /**
     * @Route("/stage/{id}", name="afficherStage")
     */
    public function afficherStage($id): Response
    {   
        //recuperer le repository de l'entitée Stage
        $repositoryStage=$this->getDoctrine()->getRepository(Stage::class);
        //recuperer les ressources de l'entité Ressource
        $leStage = $repositoryStage->find($id);
    
        return $this->render('pro_stages/afficherStage.html.twig', [

           'stage'=>$leStage,
        ]);
    }

            /**
     * @Route("/formationStages/{id}", name="formationStages")
     */
    public function formationStages($id): Response
    {   
        //recuperer le repository de l'entitée Stage
        $repositoryFormation=$this->getDoctrine()->getRepository(Formation::class);
        //recuperer les ressources de l'entité 
        $laFormation = $repositoryFormation->find($id);// renvoie la formation
    
        return $this->render('pro_stages/formationStages.html.twig', [

           'formation'=>$laFormation,
        ]);
    }

            /**
     * @Route("/entrepriseStages/{id}", name="entrepriseStages")
     */
    public function entrepriseStages($id): Response
    {   
        //recuperer le repository de l'entitée Stage
        $repositoryStage=$this->getDoctrine()->getRepository(Stage::class);
        //recuperer les ressources de l'entité 
        
        $StageDeLentreprise = $repositoryStage->findBy(['codeEntreprise'=>$id]); 
        // renvoie tous les stage qui ont pour codeEntreprise l'id donner
    
        return $this->render('pro_stages/entrepriseStages.html.twig', [

           'stages'=>$StageDeLentreprise,
        ]);
    }
}
