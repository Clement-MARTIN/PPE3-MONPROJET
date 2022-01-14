<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListCatController extends AbstractController
{
    public function recentArticles(CategorieRepository $repo): Response
    {
        $cats = $repo->findAll();
        return $this->render('partials/header.html.twig', ['cats'=> $cats,]);
    }
}
