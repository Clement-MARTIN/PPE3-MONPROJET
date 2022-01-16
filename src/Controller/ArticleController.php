<?php

namespace App\Controller;

use App\Entity\Images;
use App\Entity\Search;
use App\Form\AjoutPanierType;
use App\Form\EditArticleType;
use App\Form\InscriptionType;
use App\Form\NewArticleType;
use App\Form\PropertySearchType;
use App\Repository\ImagesRepository;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\From;
use Doctrine\Persistence\ObjectManager;
use PDO;
use App\Entity\Article;
use App\Entity\Categorie;
use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use phpDocumentor\Reflection\Types\Array_;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\User\UserInterface;

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
     * @Route("/article/search", name="search_article")
     * @param Request $request
     */
    public function base(ArticleRepository $repo, Request $request): Response
    {
        $nom = $request->get('nom');
        $cat = $request->get('cat');
        $arts = $repo->searchArticle($cat, $nom);
        return $this->render('article/search.html.twig', ['arts' => $arts]);
    }

    /**
     * @IsGranted("ROLE_VENDEUR")
     * @Route("/me/article", name="mes_article")
     */
    public function mesArticles(ArticleRepository $repo): Response
    {
        $vendeur = $this->getUser();
        $arts = $repo->mesArticles($vendeur);

        return $this->render('article/meShow.html.twig', [
            'arts' => $arts,
        ]);
    }

    /**
     * @IsGranted("ROLE_VENDEUR")
     * @Route("/article/me/nouveau", name="me_article")
     */
    public function new(Request $request): Response
    {
        $vendeur = $this->getUser();
        $article = new Article();
        $form = $this->createForm(NewArticleType::class, $article);
        $article->setVendeur($vendeur);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //les images
            $images = $form->get('images')->getData();
            //on boucle
            foreach($images as $image){
                //genere un nom aléatoir
                $nameFichier = md5(uniqid()). '.'. $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $nameFichier
                );

                $img = new Images();
                $img->setName($nameFichier);
                $article->addImage($img);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            $this->addFlash(
                'success',
                "L'annonce a bien été enregistré"
            );
            return $this->redirectToRoute('show_art',[
                'slug' => $article->getSlug()
            ]);
        }
        return $this->render('article/newArt.html.twig', [
            'form' => $form->createView()
        ]);

    }
    /**
     * @IsGranted("ROLE_VENDEUR")
     * @Route("/article/me/edit/{id}", name="editArticle")
     */
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(EditArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //les images
            $images = $form->get('images')->getData();
            $route = $form->get('name')->getData();
            $slugify = new Slugify();
            $url = $slugify->slugify($route);
            $article->setSlug($url);
            //on boucle
            foreach($images as $image){
                //genere un nom aléatoir
                $nameFichier = md5(uniqid()). '.'. $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $nameFichier
                );

                $img = new Images();
                $img->setName($nameFichier);
                $article->addImage($img);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            $this->addFlash(
                'success',
                "L'article a bien été modifié"
            );
            return $this->redirectToRoute('mes_article');
        }
        return $this->render('article/edit.html.twig', [
            'form' => $form->createView(),
            'art' => $article
        ]);

    }


    /**
     * @Route("/article/{slug}", name="show_art")
     * 
     */
    public function show(Article $art): Response
    {
        $form = $this->createForm(AjoutPanierType::class);

        return $this->render('article/showArt.html.twig',[
            'art' => $art,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/article/image/{id}", name="annonces_delete_image")
     */
    public function deleteImage($id, EntityManagerInterface $manager, ImagesRepository $repo)
    {
        $image = $repo->findOneById($id);
        $idArticle = $image->getAnnonces()->getId();
        $manager->remove($image);
        $manager->flush();
        $this->addFlash(
            'success',
            "L'article a bien été supprimée"
        );
        return $this->redirectToRoute('editArticle', [
            'id' => $idArticle
        ]);
    }
}
