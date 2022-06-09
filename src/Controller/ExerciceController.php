<?php

namespace App\Controller;

use App\Service\TaxCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExerciceController extends AbstractController
{
    /**
     * @Route("/exercice/tax-calculator", name="exercice_tax")
     */
    public function tax(Request $request, TaxCalculator $calculator): Response
    {
        $form = $this->createFormBuilder()
            ->add('ttc', TextType::class, ['label' => 'TTC'])
            ->getForm();

        $form->handleRequest($request);
        if( $form->isSubmitted() && $form->isValid() ) {
            $data = $form->getData();

            $calculator
                ->setInclTax($data['ttc'])
                // ->setExclTax(1000)
                ->calculate();
        }

        return $this->render('exercice/tax.html.twig', [
            'calculator' => $calculator,
            'form' => $form->createView()
        ]);
    }
}
