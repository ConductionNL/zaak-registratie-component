<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ZaakController extends AbstractController
{
    /**
     * @Route("/zaak", name="zaak")
     */
    public function index()
    {
        return $this->render('zaak/index.html.twig', [
            'controller_name' => 'ZaakController',
        ]);
    }
}
