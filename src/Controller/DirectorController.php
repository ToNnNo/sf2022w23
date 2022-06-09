<?php

namespace App\Controller;

use App\Repository\DirectorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DirectorController extends AbstractController
{
    /**
     * @Route("/director/{id}", name="director_detail")
     */
    public function detail(int $id, DirectorRepository $directorRepository): Response
    {
        // $this->isCsrfTokenValid();
        /*$token = new CsrfToken('tokenId', 'delete-movie');
        dump($token->getValue());*/

        $director = $directorRepository->findDirectorWithMovies($id);

        return $this->render('director/detail.html.twig', [
            'director' => $director
        ]);
    }
}
