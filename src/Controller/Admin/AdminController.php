<?php

namespace App\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("", name="index")
     * @IsGranted("ROLE_SUPER_ADMIN")
     * @Security("is_granted('ROLE_SUPER_ADMIN')")
     */
    public function index(): Response
    {
        // @IsGranted ou @Security
        // @Security est plus flexible

        return $this->render('admin/index.html.twig', [
        ]);
    }

    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboard(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');


        return $this->render('admin/index.html.twig', [
        ]);
    }

    /**
     * @Route("/rapport", name="rapport")
     */
    public function rapport(): Response
    {
        if( $this->isGranted('ROLE_SUPER_ADMIN') ) {
            $message = "Vous pouvez imprimer les rapports d'activités ...";
        }

        return $this->render('admin/index.html.twig', [
            'message' => $message ?? null
        ]);
    }
}
