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

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Doctrine\ORM\EntityManagerInterface;



class ProStagesController extends AbstractController
{
    /**
     * @Route("/", name="pro_stages_Accueil")
     */
    public function index(StageRepository $repositoryStage): Response
    {

        //recuperer les stages de l'entité Stage
        $ressources = $repositoryStage->touverToutLesStages();
    
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
    public function afficherStage(StageRepository $repositoryStage,$id): Response
    {   
        
       $infoStage=$repositoryStage->trouverCaracteristiqueStage($id);
        return $this->render('pro_stages/afficherStage.html.twig', [

           'stage'=>$infoStage
        ]);
    }

            /**
     * @Route("/formationStages/{nom}", name="formationStages")
     */
    public function formationStages(StageRepository $repositoryStage, $nom): Response
    {   
        /*
        exemple que je garde
        //recuperer le repository de l'entitée formation
        $repositoryFormation=$this->getDoctrine()->getRepository(Formation::class);
        //recuperer les formations de l'entité 
        $laFormation = $repositoryFormation->find($id);// renvoie la formation
        */
        
        $StageDeLaFormation = $repositoryStage->trouverToutLesStagesParFormation($nom);
        return $this->render('pro_stages/formationStages.html.twig', [
            'nomFormation'=>$nom,
           'stages'=>$StageDeLaFormation,

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

                /**
     * @Route("/formulaire/", name="formulaireEntreprise")
     */
    public function formulaire(Request $requeteHttp,EntityManagerInterface $I): Response
    {   
    
        //creation d'une entreprise vierge qui se remplie par le formulaire
        $entreprise = new Entreprise();

       

        //creation du formulaire 
        $formulaireEntreprise=$this->createFormBuilder($entreprise)
                                    ->add('nom',TextType::class)
                                    ->add('adresse',TextType::class)
                                    ->add('activite',TextareaType::class)
                                    ->add('urlSite',UrlType::class)
                                    ->add('Enregistrer',SubmitType::class)
                                    ->getForm();

        //Création de la représentation graphique
        $formulaireEntreprise->handleRequest($requeteHttp);

        if($formulaireEntreprise->isSubmitted()&&$formulaireEntreprise->isValid()){
            
            $I->persist($entreprise);
            $I->flush();
            return $this->redirectToRoute('entreprise');

        }


    
        return $this->render('pro_stages/formulaireEntreprise.html.twig', [
            'formulaire'=>$formulaireEntreprise->createView(),
            'action'=>"ajouter"
        
        
        ]);

           
    }


    
                /**
     * @Route("/formulaireModification/{id}", name="formulaireEntrepriseModification")
     */


    public function formulaireModification(EntrepriseRepository $repositoryEntreprise,Request $requeteHttp,EntityManagerInterface $I,$id): Response
    {   
    
        //creation d'une entreprise vierge qui se remplie par le formulaire
        
        //recupère l'entreprise
        $requete=$repositoryEntreprise->trouverCaracteristiqueEntreprise($id);


        // $entreprise->setNom($requete->getNom());
        // $entreprise->setAdresse($requete->getAdresse());
        // $entreprise->setActivite($requete->getActivite());
        // $entreprise->setUrlSite($requete->getUrlSite());


        //creation du formulaire 
        $formulaireEntreprise=$this->createFormBuilder($requete)
                                    ->add('nom',TextType::class)
                                    ->add('adresse',TextType::class)
                                    ->add('activite',TextareaType::class)
                                    ->add('urlSite',UrlType::class)
                                    ->add('Enregistrer',SubmitType::class)
                                    ->getForm();

        //Création de la représentation graphique
        $formulaireEntreprise->handleRequest($requeteHttp);

        if($formulaireEntreprise->isSubmitted()&&$formulaireEntreprise->isValid()){
            
            $I->persist($requete);
            $I->flush();
            return $this->redirectToRoute('entreprise');

        }


    
        return $this->render('pro_stages/formulaireEntreprise.html.twig', [
            'formulaire'=>$formulaireEntreprise->createView(),
            'action'=>"modifier"
        
        
        ]);

           
    }
}
