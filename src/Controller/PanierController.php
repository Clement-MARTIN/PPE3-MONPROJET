<?php

namespace App\Controller;

use App\Entity\Achat;
use App\Entity\Commande;
use App\Entity\MesArticles;
use App\Entity\Panier;
use App\Form\AjoutPanierType;
use App\Form\NewAchatType;
use App\Form\NewCommandeType;
use App\Repository\ArticleRepository;
use App\Repository\MesArticlesRepository;
use App\Repository\PanierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/me/panier/ajout/{id}", name="ajout_article")
     */
    public function ajout($id, ArticleRepository $repoA, Request $request, EntityManagerInterface $manager, PanierRepository $repo): Response
    {
        $user = $this->getUser();
        $article = $repoA->findOneById($id);
        $liste = new MesArticles();
        $form = $this->createForm(AjoutPanierType::class, $liste);
        $pani = $repo->findOneBy(['user' =>  $user->getId()]);
        $liste->setPanier($pani);
        $liste->setQuantite($article->getQuantite());
        $liste->setNumArticle($article);
        $liste->setAchat(0);
        $form->handleRequest($request);
        $manager->persist($liste);

        $manager->flush();
        $this->addFlash(
            'success',
            "Article ajouté au panier"
        );

        return $this->redirectToRoute('show_art',[
            'slug' => $article->getSlug()
        ]);
    }

    /**
     * @IsGranted("ROLE_ACHETEUR")
     * @Route("/me/panier/delete/{id}", name="delete_article")
     */
    public function deleteAjout($id, Request $request, EntityManagerInterface $manager, MesArticlesRepository $repo): Response
    {
        $liste = $repo->findOneById($id);
        $liste->setAchat(-1);
        $manager->persist($liste);

        $manager->flush();
        $this->addFlash(
            'success',
            "Article surpprimé du panier"
        );

        $user = $this->getUser();
        $panier = $repo->listPanier($user);

        return $this->redirectToRoute('panier',[
            'panier' => $panier
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
            $idArticle = $repo->findOneById($pan->getNumArticle());
            $achat->setNumArticle($idArticle);
            $achat->setQuantite( $listeArticle[$i]->getQuantite());
            $form->handleRequest($request);
            $manager->persist($achat);
            $i++;
        }
        foreach ($article as $pan){
            $Articlepanier = $repoA->findOneById($pan->getId());
            $Articlepanier->setAchat(1);
            $manager->persist($Articlepanier);
        }

        $manager->flush();

        $this->addFlash(
            'success',
            "Votre commande a bien été passée"
        );

        return $this->redirectToRoute('commande');
    }

}
