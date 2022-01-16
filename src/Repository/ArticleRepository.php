<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }


    /**
     *
     */
    public function articleMoment(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            "SELECT a
                    from App\Entity\Article a  
                    WHERE a.name like :Name"
            )->setParameter('Name', "%Mo%");

        // returns an array of Product objects
        return $query->getResult();
    }


    /**
     *
     */
    public function listDesArticle(UserInterface $user, $id): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            "SELECT MesA
                    from App\Entity\Article a  
                    inner join App\Entity\MesArticles MesA
                    inner join App\Entity\Panier p
                    WHERE MesA.numArticle = a.id
                    AND MesA.achat = 0
                    AND MesA.panier = :IDPANIER
                    AND p.user =  :idUSER"
        )->setParameter('idUSER', $user->getId())
            ->setParameter('IDPANIER', $id);

        // returns an array of Product objects
        return $query->getResult();
    }

    /**
     *
     */
    public function mesArticles(UserInterface $user): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            "SELECT a
                    from App\Entity\Article a  
                    WHERE a.vendeur =  :idUSER"
        )->setParameter('idUSER', $user->getId());

        // returns an array of Product objects
        return $query->getResult();
    }

    public function searchArticle(int $cat, string $name )
    {
        if ($cat == 34 && $name == "") {
            $entityManager = $this->getEntityManager();
            $query = $entityManager->createQuery(
                "select a
                from App\Entity\Article a");
        }

        if ($cat == 34 && $name != "") {
            $entityManager = $this->getEntityManager();
            $query = $entityManager->createQuery(
                "select a
                from App\Entity\Article a
                WHERE a.name like :Name")
                ->setParameter('Name', "%$name%");
        }

        if ($cat < 34 && $name == "") {
            $entityManager = $this->getEntityManager();
            $query = $entityManager->createQuery(
                "select a
                from App\Entity\Article a
                where a.idCat = :idCAT")
                ->setParameter('idCAT', $cat);
        }
        if ($cat < 34 && $name != "") {
            $entityManager = $this->getEntityManager();
            $query = $entityManager->createQuery(
                "select a
                from App\Entity\Article a
                where a.idCat = :idCAT
                AND a.name like :Name")
                ->setParameter('idCAT', $cat)
                ->setParameter('Name', "%$name%");
        }
        return $query->getResult();
    }
}
