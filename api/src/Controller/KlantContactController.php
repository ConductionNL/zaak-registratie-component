<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\KlantContact;
use App\Entity\Zaak;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class KlantContactController extends AbstractController
{
    /**
     * @Route("/klant/contact", name="klant_contact")
     */
    public function index()
    {
        return $this->render('klant_contact/index.html.twig', [
            'controller_name' => 'KlantContactController',
        ]);
    }

    /**
     * @Route("/klantcontacten", methods={"GET"}, name="getklantcontacten")
     */
    public function getKlantContacten()
    {
        $klant_contacten = $this->getDoctrine()
            ->getRepository(KlantContact::class)
            ->findAll();

        
        return $this->respondOk($klant_contacten);
    }

    /**
     * @Route("/klantcontacten", methods={"POST"}, name="createklantcontact")
     */
    public function createKlantContact(Request $request)
    {
        $params = $request->query->all();

        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();

        $zaak = $doctrine->getRepository(Zaak::class)
            ->findOneBy(['url' => $params['zaak']]);

        $kc = new KlantContact();
        $kc->setZaak($zaak);
        $kc->setUrl($params['url']);
        $kc->setId(Uuid::fromString($params['identificatie']));
        $kc->setDatumtijd(new \DateTime($params['datumtijd']));
        $kc->setKanaal($params['kanaal']);
        $kc->setOnderwerp($params['onderwerp']);
        $kc->setToelichting($params['toelichting']);

        $em->persist($kc);
        $em->flush();
        dump($kc);

        return $this->respondOk($kc);
    }

    private function respondOk($data) {
        $r = new JsonResponse($data);
        return $r;
    }
}
