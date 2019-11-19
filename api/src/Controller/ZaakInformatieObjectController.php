<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ZaakInformatieObjectController extends AbstractController
{
    /**
     * @Route("/zaak/informatie/object", name="zaak_informatie_object")
     */
    public function index()
    {
        return $this->render('zaak_informatie_object/index.html.twig', [
            'controller_name' => 'ZaakInformatieObjectController',
        ]);
    }
}
