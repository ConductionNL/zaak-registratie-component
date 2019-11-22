<?php

namespace App\Controller;

// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Entity\KlantContact;
use App\Entity\Zaak;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class KlantContactController extends Controller
{
    /**
     * @Route("/klantcontacten/{uuid}", methods={"GET"}, name="getklantcontact")
     */
    public function getKlantContact($uuid)
    {
        $kc = $this->getDoctrine()
            ->getRepository(KlantContact::class)
            ->find($uuid);
        if (!$kc) {
            throw new BadRequestHttpException("KlantContact with id $uuid not found.");
        }

        $data = [
            'url' => $kc->getUrl(),
            'uuid' => $kc->getId(),
            'zaak' => $kc->getZaak()->getUrl(),
            'identificatie' => $kc->getIdentificatie(),
            'datumtijd' => $kc->getDatumtijd(),
            'kanaal' => $kc->getKanaal(),
            'onderwerp' => $kc->getOnderwerp(),
            'toelichting' => $kc->getToelichting(),
        ];
        return new JsonResponse($data);
    }

    /**
     * @Route("/klantcontacten", methods={"GET"}, name="getklantcontacten")
     */
    public function getKlantContacten()
    {
        $klant_contacten = $this->getDoctrine()
            ->getRepository(KlantContact::class)
            ->findAll();
        if (!$klant_contacten) {
            throw new BadRequestHttpException("No KlantContacten found.");
        }

        $serializer = $this->container->get('jms_serializer');

        $data = [
            'count' => count($klant_contacten),
            'next' => "http://example.com",
            'previous' => "http://example.com",
            'results' => $serializer->serialize($klant_contacten, 'json'),
        ];
        return new JsonResponse($data);
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
        if (!$zaak) {
            $url = $params['zaak'];
            throw new BadRequestHttpException("Zaak with url $url not found.");
        }

        $kc = new KlantContact();
        $kc->setZaak($zaak);
        $kc->setUrl("http://example.com");
        $kc->setIdentificatie(isset($params['identificatie']) ? $params['identificatie'] : null);
        $kc->setDatumtijd(new \DateTime($params['datumtijd']));
        $kc->setKanaal(isset($params['kanaal']) ? $params['kanaal'] : null);
        $kc->setOnderwerp(isset($params['onderwerp']) ? $params['onderwerp'] : null);
        $kc->setToelichting(isset($params['toelichting']) ? $params['toelichting'] : null);

        $em->persist($kc);
        $em->flush();

        $data = [
            'url' => $kc->getUrl(),
            'uuid' => $kc->getId(),
            'zaak' => $zaak->getUrl(),
            'identificatie' => $kc->getIdentificatie(),
            'datumtijd' => $kc->getDatumtijd(),
            'kanaal' => $kc->getKanaal(),
            'onderwerp' => $kc->getOnderwerp(),
            'toelichting' => $kc->getToelichting(),
        ];

        return new JsonResponse($data);
    }
}
