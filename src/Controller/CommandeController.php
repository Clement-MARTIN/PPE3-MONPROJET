<?php

namespace App\Controller;

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
    public function index(CommandeRepository $repo): Response
    {
        $user = $this->getUser();
        $coms = $repo->listCommande($user);


        return $this->render("commande/index.html.twig", [
            'coms' => $coms,
        ]);
    }


}
