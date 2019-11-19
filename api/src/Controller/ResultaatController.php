<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ResultaatController extends AbstractController
{
    /**
     * @Route("/resultaat", name="resultaat")
     */
    public function index()
    {
        return $this->render('resultaat/index.html.twig', [
            'controller_name' => 'ResultaatController',
        ]);
    }
}
