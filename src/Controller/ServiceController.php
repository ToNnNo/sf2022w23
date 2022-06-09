<?php

namespace App\Controller;

use App\Service\CasearCipher;
use App\Service\HashPassword;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    /**
     * @Route("/service", name="service_index")
     */
    public function index(CasearCipher $casearCipher, HashPassword $password, string $salt, SessionInterface $session): Response
    {
        $message = "Ceci est un message secret ...";
        $crypted = $casearCipher->encode($message);

        return $this->render('service/index.html.twig', [
            'crypted' => $crypted,
            'hash' => $password->hash('P4ssw0rd'),
            'salt' => $salt
        ]);
    }
}
