<?php

namespace App\Repository;

use App\Entity\MesArticles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method MesArticles|null find($id, $lockMode = null, $lockVersion = null)
 * @method MesArticles|null findOneBy(array $criteria, array $orderBy = null)
 * @method MesArticles[]    findAll()
 * @method MesArticles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MesArticlesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MesArticles::class);
    }


    /**
     *
     */
    public function listPanier(UserInterface $user): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            "SELECT a
                    from App\Entity\MesArticles a
                    inner join App\Entity\Panier p
                    WHERE p.id = a.panier
                    AND p.user =  :idUSER
                    ORDER BY a.numArticle"
        )->setParameter('idUSER', $user->getId());

        // returns an array of Product objects
        return $query->getResult();
    }

    // /**
    //  * @return Achat[] Returns an array of Achat objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Achat
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
