<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TwigController extends AbstractController
{
    /**
     * @Route("/twig", name="twig_index", priority="0")
     */
    public function index(): Response
    {
        $html = '<p>Lorem ipsum dolor sit amet, <b>consectetur adipisicing elit</b>. Aliquid animi atque dignissimos enim, 
            laudantium libero nisi obcaecati ratione sapiente. <i>Adipisci consequuntur eos excepturi explicabo</i> 
            laboriosam laudantium nulla perferendis quas, sapiente.</p><script>console.log("coucou")</script>';


        return $this->render('twig/index.html.twig', [
            'users' => ['Maxime', 'Franck', 'Pierre-louis', 'Stéphane'],
            'admins' => [],
            'product' => ['name' => 'Pomme', 'price' => 12.99],
            'shopIsOpen' => false,
            'html' => $html,
            'person' => ['name' => '', 'email' => '']
        ]);
    }

    public function image(): Response
    {
        return $this->render('twig/image.html.twig', [
            'image' => 'grogu.jpg'
        ]);
    }

    /**
     * @Route("/twig/message", name="twig_message")
     */
    public function message(): Response
    {

        $message = "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid animi atque dignissimos enim, 
            laudantium libero nisi obcaecati ratione sapiente.";

        return $this->render('twig/message.txt.twig', [
            'name' => 'Admin',
            'message' => $message
        ]);
    }
}
