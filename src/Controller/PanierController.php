<?php

namespace App\Controller;

use App\Entity\Achat;
use App\Entity\Article;
use App\Entity\Commande;
use App\Entity\MesArticles;
use App\Form\NewAchatType;
use App\Form\NewArticleType;
use App\Form\NewCommandeType;
use App\Repository\ArticleRepository;
use App\Repository\CommandeRepository;
use App\Repository\MesArticlesRepository;
use App\Repository\PanierRepository;
use Cassandra\Date;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

class PanierController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ACHETEUR")
     * @Route("/panier", name="panier")
     */
    public function index(PanierRepository $repo): Response
    {
        $user = $this->getUser();
        $panier = $repo->listPanier($user);


        return $this->render("panier/index.html.twig", [
            'panier' => $panier,
        ]);
    }

    /**
     * @IsGranted("ROLE_ACHETEUR")
     * @Route("/panier/commande/{id}", name="passerCommande")
     */
    public function passerCommande($id, EntityManagerInterface $manager,Request $request, ArticleRepository $repo, MesArticlesRepository $repoA): Response
    {
        $user = $this->getUser();
        $article = $repo->listDesArticle($user, $id);
        $commande = new Commande();
        $form = $this->createForm(NewCommandeType::class, $commande);
        $commande->setIsUser($user);
        $date = new \DateTime();
        $commande->setDateCommande($date);
        $form->handleRequest($request);
        $manager->persist($commande);
        $listeArticle = $repoA->listPanier($user);
        $i = 0;
        foreach ($article as $pan){
            $achat = new Achat();
            $form = $this->createForm(NewAchatType::class, $achat);
            $achat->setCommande($commande);
            $achat->setNumArticle($pan);
            $achat->setQuantite( $listeArticle[$i]->getQuantite());
            $form->handleRequest($request);
            $manager->persist($achat);
            $i++;
        }

        $manager->flush();

        $this->addFlash(
            'success',
            "Votre commande a bien été passée"
        );

        return $this->render("panier/index.html.twig", ['panier' => $panier = null]);
    }

}