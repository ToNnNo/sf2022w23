<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGenerator;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_index")
     */
    public function index(Request $request): Response
    {
        //$homeUrl = $this->generateUrl('home_index', [], UrlGenerator::ABSOLUTE_URL);
        //dump($request); // ne jamais garder de dump en production !

        $name = ucfirst( $request->query->get('name', 'world') );

        return $this->render('home/index.html.twig', [
            'name' => $name,
        ]);
    }

    /**
     * @Route("/parameter/{name<[A-Za-z_]+>}", name="home_parameter")
     */
    // , requirements={"name"="[a-z_]+"}, defaults={"name": "john"}
    public function parameter(string $name = "stéphane"): Response
    {
        if("erreur" === $name) {
            throw $this->createNotFoundException(sprintf("La ressource %s n'existe pas", $name));
        }

        if("redirect" === $name) {
            return $this->redirectToRoute('home_index');
        }

        if("forward" === $name) {
            return $this->forward('App\\Controller\\HomeController::index');
        }

        $name = strtoupper($name);

        return $this->render('home/parameter.html.twig', [
            'name' => $name
        ]);
    }

    /**
     * @Route("/flash", name="home_flash")
     */
    public function flashMessage(Request $request): Response
    {
        if($request->query->has('flash')) {
            $this->addFlash('success', 'Le message a bien été enregistré');
            $this->addFlash('warning', 'Attention quelque chose ne fontionne pas correctement');
            $this->addFlash('danger', 'Une erreur grave est survenue');

            return $this->redirectToRoute('home_flash');
        }

        return $this->render('home/flash.html.twig', []);
    }

    /**
     * @Route("/response", name="home_response")
     */
    public function redirectResponse(): RedirectResponse
    {
        return new RedirectResponse($this->generateUrl('home_response_simple'));
    }

    /**
     * @Route("/response/simple", name="home_response_simple")
     */
    public function simpleResponse(): Response
    {
        $content = "La page a bien été trouvé";

        return new Response(<<<END
<html lang="fr">
    <body>
        <p>$content</p>
        <script>console.log('before end body')</script>
    </body>
</html>
END);
    }

    /**
     * @Route("/response/json/helper", name="home_response_json_helper")
     */
    public function jsonResponseHelper(): Response
    {
        $users = [
            ['firstname' => 'John', 'lastname' => 'Doe'],
            ['firstname' => 'Jane', 'lastname' => 'Doe'],
            ['firstname' => 'Eduard', 'lastname' => 'Doe'],
        ];

        return $this->json($users);
    }

    /**
     * @Route("/response/json", name="home_response_json")
     */
    public function jsonResponse(): JsonResponse
    {
        $users = [
            ['firstname' => 'John', 'lastname' => 'Doe'],
            ['firstname' => 'Jane', 'lastname' => 'Doe'],
            ['firstname' => 'Eduard', 'lastname' => 'Doe'],
        ];

        return new JsonResponse($users);
    }

    /**
     * @Route("/response/download", name="home_response_download")
     */
    public function binaryResponse(): Response
    {
        $file = $this->getParameter('kernel.project_dir').'/public/download/facture001.pdf';
        return $this->file($file, 'Facture001.pdf');
    }

    /**
     * @Route("/verb-http", name="home_verb_http", methods={"POST"})
     */
    public function verbHttp(): Response
    {

        return $this->render('home/index.html.twig', [
            'name' => 'Verb HTTP'
        ]);
    }

    /**
     * @Route("/host", name="home_host", host="mobile.dawan.fr")
     */
    public function host(): Response
    {

        return $this->render('home/index.html.twig', [
            'name' => 'Verb HTTP'
        ]);
    }

}
