<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StatusController extends AbstractController
{
    /**
     * @Route("/status", name="status")
     */
    public function index()
    {
        return $this->render('status/index.html.twig', [
            'controller_name' => 'StatusController',
        ]);
    }
}
