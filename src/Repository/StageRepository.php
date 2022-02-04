<?php

namespace App\Repository;

use App\Entity\Stage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Stage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stage[]    findAll()
 * @method Stage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stage::class);
    }

    // /**
    //  * @return Stage[] Returns an array of Stage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Stage
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function trouverToutLesStagesParEntreprise($nom)
    {
        return $this->createQueryBuilder('s')
            ->select('s,e,f') // pour récuperer les stages et leur entreprise
            // si on le met pas ca aurai par default mi le s et on aurai donc eu les stages par entreprise 
            ->join('s.codeEntreprise', 'e')
            ->join('s.codeFormation','f')
            ->where('e.nom = :nomEntreprise')
            ->setParameter('nomEntreprise', $nom)
            ->getQuery()
            ->getResult()
            ;
    }

    public function trouverToutLesStagesParFormation($nom)
    {
        $gestionnaireEntite = $this->getEntityManager();
        $requete = $gestionnaireEntite->createQuery(
        'SELECT s,f,e 
        From App\Entity\Stage s Join s.codeFormation f Join s.codeEntreprise e
        WHERE f.nom= :nomFormation
        ');
        $requete->setParameter('nomFormation', $nom);
        return $requete->execute();
    }

    public function touverToutLesStages(){

        $gestionnaireEntite = $this->getEntityManager();
        $requete = $gestionnaireEntite->createQuery(
        'SELECT s,e,f 
        From App\Entity\Stage s Join s.codeEntreprise e Join s.codeFormation f');

        return $requete->execute();

    }

    public function trouverCaracteristiqueStage($id){

        return $this->createQueryBuilder('s')
            ->select('s,e,f') // pour récuperer les stages et leur entreprise
            // si on le met pas ca aurai par default mi le s et on aurai donc eu les stages par entreprise 
            ->join('s.codeEntreprise', 'e')
            ->join('s.codeFormation','f')
            ->where('s.id = :identifiant')
            ->setParameter('identifiant', $id)
            ->getQuery()
            ->getSingleResult()
            ;
    }
}
