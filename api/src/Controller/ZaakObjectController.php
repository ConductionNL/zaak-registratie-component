<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ZaakObjectController extends AbstractController
{
    /**
     * @Route("/zaak/object", name="zaak_object")
     */
    public function index()
    {
        return $this->render('zaak_object/index.html.twig', [
            'controller_name' => 'ZaakObjectController',
        ]);
    }
}
