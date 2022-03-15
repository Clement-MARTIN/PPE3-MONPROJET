<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CommandeRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ACHETEUR")
     * @Route("/commande", name="commande")
     */
    public function index(CommandeRepository $repo, ArticleRepository $repoA): Response
    {
        $user = $this->getUser();
        $coms = $repo->findByisUser($user);

        $monpanier = [];

        if ($coms != null) {
            foreach ($coms as $com) {
                $mes_quantity = [];
                $mes_article = [];
                $articles = $com->getArticles();
                foreach ($articles as $article){
                    $mes_article[] = $repoA->find($article);
                }
                $quantites = $com->getQuantite();
                foreach ($quantites as $quantite){
                    $mes_quantity[] = $quantite;
                }
                $monpanier[] = [
                    'date' => $com->getDateCommande()->format('Y-m-d'),
                    'article' => $mes_article,
                    'quantite' => $mes_quantity
                ];
            }
        }
        return $this->render("commande/index.html.twig", [
            'coms' => $monpanier,
        ]);
    }


}
