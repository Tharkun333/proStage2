<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Entreprise;
use App\Entity\Stage;
use App\Entity\Formation;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //création d'un generateur de données faker
        $faker = \Faker\Factory::create('fr_FR');
  


        // Création des entreprises///////////////////
        $tabEntreprise=array();
        
        for ($i=1; $i <= 5;$i++)
        {
            $nomCompanie = $faker->company;
            $entreprise = new Entreprise();
            $entreprise->setNom($nomCompanie);
            $entreprise->setAdresse($faker->address);
            $entreprise->setActivite($faker->realText($maxNbChars =50, $indexSize = 2));
            $entreprise->setUrlSite("http://$nomCompanie.com");
            //"Création de jeux video""Volinir""https://Volinir.com""6 rue des ballons, Bordeaux"
            $manager->persist($entreprise);

            $tabEntreprise[$i]=$entreprise;
        }
        //////////////////////////////////////////////

        
        //creation des formation

        $tabNomFormations =array(
            "DUT Informatique" => "Diplôme Universitaire Thechnologique Informatique",
            "LAES" => "Licence Administration économique et sociale",
            "LCAA" =>   "Licence Cinéma - Audiovisuel - Arts",
            "DUT GIM" =>    "Génie Industriel et Maintenance",

        );

        $tabFormations=array();

        foreach ($tabNomFormations as $nomCourt => $nomLong)
        {
            $formation= new Formation();
            $formation->setNom($nomLong);
            $formation->setNomCourt($nomCourt);
            
            $tabFormations[]=$formation;
                
            $manager->persist($formation);

        }
        
        $nbformation=count($tabFormations);
            

            foreach($tabEntreprise as $uneEntreprise)
            {
                $nbAleatoire=$faker->numberBetween($min = 1 , $max = 5);  // nombre de stage alétoire
                for ($i = 0; $i<$nbAleatoire; $i++){
                    $stage = new Stage();
                    $stage->setTitre($faker->word );
                    $stage->setMissions($faker->realText($maxNbChars =200, $indexSize = 2));
                    $nom=$uneEntreprise->getNom();
                    $stage->setContact("$nom@gmail.com");

                    //nombres aléatoires 
                    $nbAleaFormation=$faker->numberBetween($min = 0 , $max = $nbformation-1);
                    $nbAleaFormation2=$faker->numberBetween($min = 0 , $max = $nbformation-1);
                    $nbAleaFormation3=$faker->numberBetween($min = 0 , $max = $nbformation-1);
                    $nbAleaFormation4=$faker->numberBetween($min = 0 , $max = $nbformation-1);  
                    //LES LIAISONS//

                    //ajout de formation(s) dans le stage et inversement
                    $stage->addCodeFormation($tabFormations[$nbAleaFormation]); //add car le stage peut etre lier a plusieurs entreprises 
                    if($nbAleaFormation!=$nbAleaFormation2){
                        $stage->addCodeFormation($tabFormations[$nbAleaFormation2]);
                        $tabFormations[$nbAleaFormation2]->addStage($stage);
                    }
                    if($nbAleaFormation!=$nbAleaFormation3 && $nbAleaFormation2!=$nbAleaFormation3){
                        $stage->addCodeFormation($tabFormations[$nbAleaFormation3]);
                        $tabFormations[$nbAleaFormation3]->addStage($stage);
                    }
                    if($nbAleaFormation!=$nbAleaFormation4 && $nbAleaFormation2!=$nbAleaFormation4 && $nbAleaFormation3!=$nbAleaFormation4){
                        $stage->addCodeFormation($tabFormations[$nbAleaFormation4]);
                        $tabFormations[$nbAleaFormation4]->addStage($stage);
                    }
                    
                    



                    /////////////////////:::::
                    $tabFormations[$nbAleaFormation]->addStage($stage);
                    //ajout d'une entreprise pour le stage
                    $stage->setCodeEntreprise($uneEntreprise);//set car le stage ne peut avoir qu'une entreprise
                    
                    //ajout du stage pour l'entreprise
                    $uneEntreprise->addStage($stage);

                    $manager->persist($tabFormations[$nbAleaFormation]);
                    $manager->persist($stage);
                    $manager->persist($uneEntreprise);
                    
                    

                }




            }
            

           


            $manager->flush();
      


        
       

    }
}
