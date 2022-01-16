<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function recentArticles(ArticleRepository $repo)
    {
        $arts = $repo->articleMoment();
        return $this->render(
            'home.html.twig', ['arts' => $arts]
        );
    }
}
