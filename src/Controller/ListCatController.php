<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Search;
use App\Form\NewArticleType;
use App\Form\PropertySearchType;
use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListCatController extends AbstractController
{
    public function recentArticles(CategorieRepository $repo, Request $request, ArticleRepository $repoArticle): Response
    {
        $search = new Search();
        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $nom = $search->getNom();
            $catOb = $search->getCategory();
            $cat =  $catOb->getId();
            return $this->redirectToRoute('search_article', ['nom'=>$nom, 'cat'=>$cat]);
        }
        $cats = $repo->findAll();
        return $this->render('partials/header.html.twig', ['cats'=> $cats,
            'form' => $form->createView()]);
    }
}
