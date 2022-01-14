<?php

namespace App\Controller;

use PDO;
use App\Entity\Article;
use App\Entity\Categorie;
use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="base_article")
     */
    public function index(ArticleRepository $repo): Response
    {
        $arts = $repo->findAll();

        return $this->render('article/base.html.twig', [
            'arts' => $arts, 
        ]);
    }

    /**
     * @Route("/article/{slug}", name="show_art")
     * 
     */
    public function show(Article $art): Response
    {
        return $this->render('article/showArt.html.twig',[
            'art' => $art
        ]);
    }
}
