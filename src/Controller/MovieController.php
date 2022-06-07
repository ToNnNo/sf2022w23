<?php

namespace App\Controller;

use App\Entity\Movie;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    /**
     * @Route("/movie/presentation", name="movie_presentation")
     */
    public function presentation(Request $request, ManagerRegistry $doctrine): Response
    {
        $movie = new Movie();
        $movie
            ->setTitle('Star Wars: Episode IV - A New Hope')
            ->setSynopsis("Il y a bien longtemps, dans une galaxie très lointaine... La guerre civile fait rage entre l'Empire galactique et l'Alliance rebelle. Capturée par les troupes de choc de l'Empereur menées par le sombre et impitoyable Dark Vador, la princesse Leia Organa dissimule les plans de l'Etoile Noire, une station spatiale invulnérable, à son droïde R2-D2 avec pour mission de les remettre au Jedi Obi-Wan Kenobi. Accompagné de son fidèle compagnon, le droïde de protocole C-3PO, R2-D2 s'échoue sur la planète Tatooine et termine sa quête chez le jeune Luke Skywalker. Rêvant de devenir pilote mais confiné aux travaux de la ferme, ce dernier se lance à la recherche de ce mystérieux Obi-Wan Kenobi, devenu ermite au coeur des montagnes désertiques de Tatooine... ")
            ->setReleaseDate(new \DateTime('1977-03-12'))
            ->setDuration(new \DateTime('0000-00-00 02:01:00'))
            ->setPoster('new-hope.jpg');

        if( $request->query->has('save') ) {

            $em = $doctrine->getManager();
            $em->persist($movie);
            $em->flush();

            $this->addFlash('success', 'Le film a bien été enregistré');

            return $this->redirectToRoute('movie_presentation');
        }

        return $this->render('movie/presentation.html.twig', [
            'movie' => $movie
        ]);
    }

    /**
     * @Route("/movie", name="movie_index")
     */
    public function index(): Response
    {
        return $this->render('movie/index.html.twig', [

        ]);
    }
}
