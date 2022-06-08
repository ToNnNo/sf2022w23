<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    private $movieRepository;
    private $entityManager;

    public function __construct(ManagerRegistry $doctrine, MovieRepository $movieRepository)
    {
        $this->entityManager = $doctrine->getManager();
        $this->movieRepository = $movieRepository;
    }

    /**
     * @Route("/movie/presentation", name="movie_presentation")
     */
    public function presentation(Request $request): Response
    {
        $movie = new Movie();
        $movie
            ->setTitle('Star Wars: Episode IV - A New Hope')
            ->setSynopsis("Il y a bien longtemps, dans une galaxie très lointaine... La guerre civile fait rage entre l'Empire galactique et l'Alliance rebelle. Capturée par les troupes de choc de l'Empereur menées par le sombre et impitoyable Dark Vador, la princesse Leia Organa dissimule les plans de l'Etoile Noire, une station spatiale invulnérable, à son droïde R2-D2 avec pour mission de les remettre au Jedi Obi-Wan Kenobi. Accompagné de son fidèle compagnon, le droïde de protocole C-3PO, R2-D2 s'échoue sur la planète Tatooine et termine sa quête chez le jeune Luke Skywalker. Rêvant de devenir pilote mais confiné aux travaux de la ferme, ce dernier se lance à la recherche de ce mystérieux Obi-Wan Kenobi, devenu ermite au coeur des montagnes désertiques de Tatooine... ")
            ->setReleaseDate(new \DateTime('1977-03-12'))
            ->setDuration(new \DateTime('0000-00-00 02:01:00'))
            ->setPoster('new-hope.jpg');

        if( $request->query->has('save') ) {

            $this->entityManager->persist($movie);
            $this->entityManager->flush();

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
        $movies = $this->movieRepository->findAll();

        return $this->render('movie/index.html.twig', [
            'movies' => $movies
        ]);
    }

    /**
     * @Route("/movie/add", name="movie_add")
     */
    public function add(Request $request): Response
    {
        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie);

        $form->handleRequest($request);
        if( $form->isSubmitted() && $form->isValid() ) {
            $this->movieRepository->add($movie, true);

            $this->addFlash('success', 'Le film a bien été ajouté');
            return $this->redirectToRoute('movie_add'); // POST-redirect-GET
        }

        /*return $this->render('movie/edit.html.twig', [
            'form' => $form->createView()
        ]);*/

        return $this->renderForm('movie/edit.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * @Route("/movie/edit/{id}", name="movie_edit")
     */
    public function edit(Request $request, Movie $movie): Response
    {
        // $movie = $this->movieRepository->find($id);
        // dump($movie);

        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ) {
            $this->entityManager->flush();

            $this->addFlash('success', 'Le film a bien été modifié');

            return $this->redirectToRoute('movie_edit', ['id' => $movie->getId()]);
        }

        return $this->renderForm('movie/edit.html.twig', [
            'form' => $form
        ]);
    }
}
