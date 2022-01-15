<?php

namespace App\Repository;

use App\Entity\Panier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method Panier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Panier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Panier[]    findAll()
 * @method Panier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PanierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Panier::class);
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

    /*
    public function findOneBySomeField($value): ?Commande
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
