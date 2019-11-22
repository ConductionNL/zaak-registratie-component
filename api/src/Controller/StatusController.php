<?php

namespace App\Controller;

// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Entity\Status;
use App\Entity\Zaak;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class StatusController extends Controller
{
    /**
     * @Route("/statussen/{uuid}", methods={"GET"}, name="getstatus")
     */
    public function getStatus($uuid)
    {
        $status = $this->getDoctrine()
            ->getRepository(Status::class)
            ->find($uuid);
        if (!$status) {
            throw new BadRequestHttpException("Status with id $uuid not found.");
        }

        $data = [
            'url' => $status->getUrl(),
            'uuid' => $status->getId(),
            'zaak' => $status->getZaak()->getUrl(),
            'statustype' => $status->getStatusType(),
            'datumStatusGezet' => $status->getDatumStatusGezet(),
            'statustoelichting' => $status->getStatusToelichting(),
        ];
        return new JsonResponse($data);
    }

    /**
     * @Route("/statussen", methods={"GET"}, name="getstatussen")
     */
    public function getStatussen()
    {
        $statussen = $this->getDoctrine()
            ->getRepository(Status::class)
            ->findAll();
        if (!$statussen) {
            throw new BadRequestHttpException("No Statussen found.");
        }

        $serializer = $this->container->get('jms_serializer');

        $data = [
            'count' => count($statussen),
            'next' => "http://example.com",
            'previous' => "http://example.com",
            'results' => $serializer->serialize($statussen, 'json'),
        ];
        return new JsonResponse($data);
    }

    /**
     * @Route("/statussen", methods={"POST"}, name="createstatus")
     */
    public function createStatus(Request $request)
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

        $status = new Status();
        $status->setZaak($zaak);
        $status->setUrl("http://example.com");
        $status->setStatusType($params['statustype']);
        $status->setDatumStatusGezet(new \DateTime($params['datumStatusGezet']));
        $status->setStatusToelichting(isset($params['statustoelichting']) ? $params['statustoelichting'] : null);
        
        $em->persist($status);
        $em->flush();

        $data = [
            'url' => $status->getUrl(),
            'uuid' => $status->getId(),
            'zaak' => $status->getZaak()->getUrl(),
            'statustype' => $status->getStatusType(),
            'datumStatusGezet' => $status->getDatumStatusGezet(),
            'statustoelichting' => $status->getStatusToelichting(),
        ];

        return new JsonResponse($data);
    }
}
