<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RolController extends AbstractController
{
    /**
     * @Route("/rol", name="rol")
     */
    public function index()
    {
        return $this->render('rol/index.html.twig', [
            'controller_name' => 'RolController',
        ]);
    }
}
