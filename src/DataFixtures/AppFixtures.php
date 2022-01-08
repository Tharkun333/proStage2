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
        $tabEntreprise[5];
        
        for ($i=1; $i <= 5;$i++){
            $nomCompanie = $faker->company;
        $Entreprise = new Entreprise();
        $Entreprise->setNom($nomCompanie);
        $Entreprise->setAdresse($faker->address);
        $Entreprise->setActivite($faker->realText($maxNbChars =50, $indexSize = 2));
        $Entreprise->setUrlSite("http://$nomCompanie.com");
        //"Création de jeux video""Volinir""https://Volinir.com""6 rue des ballons, Bordeaux"
        $manager->persist($Entreprise);

        $tabEntreprise[$i]=$Entreprise;
        }
        //////////////////////////////////////////////

        //creation des formation

        $tabFormation =array(
            "DUT Informatique" => "Diplôme Universitaire et Thechnologique Informatique",
            "LAES" => "Licence Administration économique et sociale",
            "LCAA" =>   "Licence Cinéma - Audiovisuel - Arts",
            "DUT GIM" =>    "Diplôme Universitaire et Thechnologique Génie Industriel et Maintenance",

        );


        foreach ($tabFormation as $nomLong => $nomCourt){
        $formation= new Formation();
        $formation->setNom($nomLong);
        $formation->setNomCourt($nomCourt);
        $manager->persist($formation);

        }
        



        foreach($tabEntreprise as $uneEntreprise)
        {
            $nbAleatoire=$faker->numberBetween($min = 1 , $max = 5);  // nombre de stage alétoire
            for ($i = 0; $i<$nbAleatoire; $i++){
                $stage = new Stage();
                $stage->setTitre($faker->jobTitle );
                $stage->setMissions($faker->realText($maxNbChars =200, $indexSize = 2));
                $nom=$uneEntreprise->getNom();
                $stage->setContact("$nom@gmail.com");
                
            }





        }









































        $manager->flush();


        


    }
}
