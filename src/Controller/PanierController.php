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
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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
     * @Route("/dddd", name="dddd")
     */
    public function ddd(SessionInterface $session): Response
    {
        $panier = $session -> get('panier');

        dd($session);
        return $this->redirectToRoute('panier',[
            'monpanier' => $panier
        ]);
    }

    /**
     * @IsGranted("ROLE_ACHETEUR")
     * @Route("/panier", name="panier")
     */
    public function index(SessionInterface $session, ArticleRepository $repo): Response
    {
        $panier = $session->get('panier', []);

        $monpanier = [];

        if ($panier != null) {
            foreach ($panier as $id => $quantite) {
                $monpanier[] = [
                    'article' => $repo->find($id),
                    'quantite' => $quantite
                ];
            }
        }

        return $this->render("panier/index.html.twig", [
            'monpanier' => $monpanier,
        ]);
    }

    /**
     * @IsGranted("ROLE_ACHETEUR")
     * @Route("/me/panier/ajout/{id}", name="ajout_article")
     */
    public function ajout($id, SessionInterface $session, ArticleRepository $repo, Request $request): Response
    {
        $panier = $session -> get('panier', []);
        $panier[$id] = $request->get('quant');;

        $session->set('panier', $panier);

        $this->addFlash(
            'success',
            "Article ajouté au panier"
        );
        $article = $repo->findOneById($id);
        return $this->redirectToRoute('show_art',[
            'slug' => $article->getSlug()
        ]);
    }

    /**
     * @IsGranted("ROLE_ACHETEUR")
     * @Route("/me/panier/delete/{id}", name="delete_article")
     */
    public function deleteAjout($id, SessionInterface $session): Response
    {
        $panier = $session -> get('panier', []);
        unset($panier[$id]);

        $session->set('panier', $panier);

        $this->addFlash(
            'success',
            "Article surpprimé du panier"
        );

        return $this->redirectToRoute('panier',[
            'monpanier' => $panier
        ]);
    }

    /**
     * @IsGranted("ROLE_ACHETEUR")
     * @Route("/panier/commande", name="passerCommande")
     */
    public function passerCommande(EntityManagerInterface $manager,Request $request, SessionInterface $session): Response
    {
        $user = $this->getUser();
        $commande = new Commande();
        $form = $this->createForm(NewCommandeType::class, $commande);
        $commande->setIsUser($user);
        $date = new \DateTime();
        $commande->setDateCommande($date);
        $panier = $session->get('panier', []);
        $mesId = array();
        $mesQuantity = array();
        foreach ($panier as $id => $quantite){
            array_push($mesId, $id);
            array_push($mesQuantity, $quantite);
        }
        $commande->setArticles($mesId);
        $commande->setQuantite($mesQuantity);
        $form->handleRequest($request);
        $manager->persist($commande);
        $manager->flush();
        $session->set('panier', null);
        $this->addFlash(
            'success',
            "Votre commande a bien été passée"
        );

        return $this->redirectToRoute('commande');
    }

}
