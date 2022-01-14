<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin", name="admin")
     */
    public function listUser(UserRepository $repo): Response
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous n\'avez pas accès à cette partie du site ! ');

        $users = $repo->findAll();

        return $this->render('admin/index.html.twig', ['users' => $users]);
    }

    /**
     * @Route("/admin/{id}", name="user_delete")
     *
     */
    public function deleteUSER($id, EntityManagerInterface $entityManager, UserRepository $repo)
    {
        $user = $repo->findOneById($id);
        $em = $user->getEmail();
        $entityManager->remove($user);
        $entityManager->flush();
        $this->addFlash(
            'success',
            "L'utilisateur <strong>{$em}</strong> a bien été supprimé "
        );
        return $this->redirectToRoute('admin');
    }
}
