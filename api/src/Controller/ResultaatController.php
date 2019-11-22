<?php

namespace App\Controller;

// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Entity\Resultaat;
use App\Entity\Zaak;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class ResultaatController extends Controller
{
    /**
     * @Route("/resultaten/{uuid}", methods={"GET"}, name="getresultaat")
     */
    public function getResultaat($uuid)
    {
        $resultaat = $this->getDoctrine()
            ->getRepository(Resultaat::class)
            ->find($uuid);
        if (!$resultaat) {
            throw new BadRequestHttpException("Resultaat with id $uuid not found.");
        }

        $data = [
            'url' => $resultaat->getUrl(),
            'uuid' => $resultaat->getId(),
            'zaak' => $resultaat->getZaak()->getUrl(),
            'resultaattype' => $resultaat->getResultaatType(),
            'toelichting' => $resultaat->getToelichting(),
        ];
        return new JsonResponse($data);
    }

    /**
     * @Route("/resultaten", methods={"GET"}, name="getresultaten")
     */
    public function getResultaten()
    {
        $resultaten = $this->getDoctrine()
            ->getRepository(Resultaat::class)
            ->findAll();
        if (!$resultaten) {
            throw new BadRequestHttpException("No Resultaaten found.");
        }

        $serializer = $this->container->get('jms_serializer');

        $data = [
            'count' => count($resultaten),
            'next' => "http://example.com",
            'previous' => "http://example.com",
            'results' => $serializer->serialize($resultaten, 'json'),
        ];
        return new JsonResponse($data);
    }

    /**
     * @Route("/resultaten", methods={"POST"}, name="createresultaat")
     */
    public function createResultaat(Request $request)
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

        $resultaat = new Resultaat();
        $resultaat->setZaak($zaak);
        $resultaat->setUrl("http://example.com");
        $resultaat->setResultaatType($params['resultaattype']);
        $resultaat->setToelichting(isset($params['toelichting']) ? $params['toelichting'] : null);

        $em->persist($resultaat);
        $em->flush();

        $data = [
            'url' => $resultaat->getUrl(),
            'uuid' => $resultaat->getId(),
            'zaak' => $zaak->getUrl(),
            'resultaattype' => $resultaat->getResultaatType(),
            'toelichting' => $resultaat->getToelichting(),
        ];

        return new JsonResponse($data);
    }

    /**
     * @Route("/resultaten/{uuid}", methods={"PUT"}, name="putupdateresultaat")
     */
    public function putUpdateResultaat(Request $request)
    {
        $this->updateResultaat($request, true);
    }

    /**
     * @Route("/resultaten/{uuid}", methods={"PATCH"}, name="patchupdateresultaat")
     */
    public function patchUpdateResultaat(Request $request)
    {
        $this->updateResultaat($request, false);
    }

    /** This function handles both put and patch
     *  updates to keep it dry.
     */
    private function updateResultaat(Request $request, $is_put)
    {
        $params = $request->query->all();

        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();

        $resultaat = $doctrine
            ->getRepository(Resultaat::class)
            ->find($uuid);
        if (!$resultaat) {
            throw new BadRequestHttpException("Resultaat with id $uuid not found.");
        }
        
        $zaak = $doctrine
            ->getRepository(Zaak::class)
            ->findOneBy(['url' => $params['zaak']]);
        if (!$zaak) {
            $url = $params['zaak'];
            throw new BadRequestHttpException("Zaak with url $url not found.");
        }

        if (!isset($params['resultaattype'])) {
            throw new BadRequestHttpException("Resultaattype is required.");
        }

        $resultaat->setZaak($zaak);
        $resultaat->setResultaatType($params['resultaattype']);
        if (isset($params['toelichting']))
            $resultaat->setToelichting($params['toelichting']);
        else if ($is_put) {
            $resultaat->setToelichting(null);
        }

        $em->persist($resultaat);
        $em->flush();

        $data = [
            'url' => $resultaat->getUrl(),
            'uuid' => $resultaat->getId(),
            'zaak' => $zaak->getUrl(),
            'resultaattype' => $resultaat->getResultaatType(),
            'toelichting' => $resultaat->getToelichting(),
        ];

        return new JsonResponse($data);
    }

    /**
     * @Route("/resultaten/{uuid}", methods={"DELETE"}, name="deleteresultaat")
     */
    public function deleteResultaat(Request $request)
    {
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();
        
        $resultaat = $doctrine
            ->getRepository(Resultaat::class)
            ->find($uuid);
        if (!$resultaat) {
            throw new BadRequestHttpException("Resultaat with id $uuid not found.");
        }

        $em->remove($resultaat);
        $em->flush();

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
