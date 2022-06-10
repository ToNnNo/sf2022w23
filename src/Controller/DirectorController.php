<?php

namespace App\Controller;

use App\Entity\Director;
use App\Repository\DirectorRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/director", name="director_")
 */
class DirectorController extends AbstractController
{
    /**
     * @Route("", name="index")
     */
    public function index(DirectorRepository $directorRepository): Response
    {
        $directors = $directorRepository->findAll();

        return $this->render('director/index.html.twig', [
            'directors' => $directors
        ]);
    }

    /**
     * @Route("/remove/{id}/{token}", name="remove")
     */
    public function remove(Director $director, string $token, DirectorRepository $directorRepository, LoggerInterface $logger): Response
    {
        if(!$this->isCsrfTokenValid('remove_director_'.$director->getFullname(), $token)) {
            $logger->alert("Attention tentative d'intrusion sans token valide !");
            throw $this->createNotFoundException(); // 404
        }

        $directorRepository->remove($director, true);
        $this->addFlash('success', 'Réalisateur supprimé.');

        return $this->redirectToRoute('director_index');
    }


    /**
     * @Route("/{id}", name="detail")
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
