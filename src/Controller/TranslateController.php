<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route({
 *     "fr": "/{_locale}/traduction",
 *     "en": "/{_locale}/translate",
 * }, name="translate_")
 */
class TranslateController extends AbstractController
{
    /**
     * @Route("", name="index")
     */
    public function index(TranslatorInterface $translator): Response
    {
        $message = $translator->trans('translate.welcome');

        return $this->render('translate/index.html.twig', [
            'message' => $message
        ]);
    }
}
