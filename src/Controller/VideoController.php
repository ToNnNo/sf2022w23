<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VideoController extends AbstractController
{
    /**
     * @Route("/video/{slug<[a-z_-]+>}", name="video_index")
     */
    public function index(string $slug = 'jurassic-world'): Response
    {
        $videos = [
            'jurassic-world' => [
                'code' => '4R87S4YCtI8',
                'title' => 'Jurassic World 3'
            ],
            'doctor-strange' => [
                'code' => 'IB0keJtKDvw',
                'title' => 'Doctor Strange 2'
            ],
            'thor' => [
                'code' => 'ACROHRyWVmc',
                'title' => 'Thor 4'
            ]
        ];

        if(!in_array($slug, array_keys($videos))){
            throw $this->createNotFoundException("Cette vidéo n'existe pas");
        }

        return $this->render('video/index.html.twig', $videos[$slug]);
    }
}
