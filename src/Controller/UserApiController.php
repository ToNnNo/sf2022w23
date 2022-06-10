<?php

namespace App\Controller;

use App\Service\API\User\ListUser;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/users", name="user_api_")
 */
class UserApiController extends AbstractController
{
    private $listUser;
    private $logger;

    public function __construct(ListUser $listUser, LoggerInterface $logger)
    {
        $this->listUser = $listUser;
        $this->logger = $logger;
    }

    /**
     * @Route("", name="index")
     */
    public function index(): Response
    {
        $users = [];

        try {
            $users = $this->listUser->findAll();
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage(), [$e]);
        }

        return $this->render('user_api/index.html.twig', [
            'users' => $users
        ]);
    }
}
