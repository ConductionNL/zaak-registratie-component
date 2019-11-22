<?php

namespace App\Controller;

// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Entity\Rol;
use App\Entity\Zaak;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class RolController extends Controller
{
    /**
     * @Route("/rollen/{uuid}", methods={"GET"}, name="getrol")
     */
    public function getRol($uuid)
    {
        $rol = $this->getDoctrine()
            ->getRepository(Rol::class)
            ->find($uuid);
        if (!$rol) {
            throw new BadRequestHttpException("Rol with id $uuid not found.");
        }

        $data = [
            'url' => $rol->getUrl(),
            'uuid' => $rol->getId(),
            'zaak' => $rol->getZaak()->getUrl(),
            'betrokkene' => $rol->getBetrokkene(),
            'betrokkeneType' => $rol->getBetrokkeneType(),
            'roltype' => $rol->getRolType(),
            'omschrijving' => 'omschrijving',
            'omschrijvingGeneriek' => 'generieke omschrijving',
            'roltoelichting' => $rol->getRolToelichting(),
            'registratiedatum' => '',
            'indicatieMachtiging' => $rol->getIndicatieMachtiging(),
            'betrokkeneIdentificatie' => $rol->getBetrokkeneIdentificatie(),
        ];
        return new JsonResponse($data);
    }

    /**
     * @Route("/rollen", methods={"GET"}, name="getrollen")
     */
    public function getRollen()
    {
        $rollen = $this->getDoctrine()
            ->getRepository(Resultaat::class)
            ->findAll();
        if (!$rollen) {
            throw new BadRequestHttpException("No rollen found.");
        }

        $serializer = $this->container->get('jms_serializer');

        $data = [
            'count' => count($rollen),
            'next' => "http://example.com",
            'previous' => "http://example.com",
            'results' => $serializer->serialize($rollen, 'json'),
        ];
        return new JsonResponse($data);
    }

    /**
     * @Route("/rollen", methods={"POST"}, name="createrol")
     */
    public function createRol(Request $request)
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
        $rol = new Rol();
        $rol->setZaak($zaak);
        $rol->setBetrokkene(isset($params['betrokkene']) ? $params['betrokkene'] : null);
        $rol->setBetrokkeneType($params['betrokkeneType']);
        $rol->setRolType($params['roltype']);  
        $rol->setRolToelichting($params['roltoelichting']);
        $rol->setIndicatieMachtiging(isset($params['indicatieMachtiging']) ? $params['indicatieMachtiging']: null);
        $rol->setBetrokkeneIdentificatie(isset($params['betrokkeneIdentificatie']) ? $params['betrokkeneIdentificatie']: null);

        $em->persist($rol);
        $em->flush();

        $data = [
            'url' => $rol->getUrl(),
            'uuid' => $rol->getId(),
            'zaak' => $rol->getZaak()->getUrl(),
            'betrokkene' => $rol->getBetrokkene(),
            'betrokkeneType' => $rol->getBetrokkeneType(),
            'roltype' => $rol->getRolType(),
            'omschrijving' => 'omschrijving',
            'omschrijvingGeneriek' => 'generieke omschrijving',
            'roltoelichting' => $rol->getRolToelichting(),
            'registratiedatum' => '',
            'indicatieMachtiging' => $rol->getIndicatieMachtiging(),
            'betrokkeneIdentificatie' => $rol->getBetrokkeneIdentificatie(),
        ];

        return new JsonResponse($data);
    }

    /**
     * @Route("/rollen/{uuid}", methods={"DELETE"}, name="deleterol")
     */
    public function deleteRol(Request $request)
    {
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();
        
        $rol = $doctrine
            ->getRepository(Rol::class)
            ->find($uuid);
        if (!$rol) {
            throw new BadRequestHttpException("Rol with id $uuid not found.");
        }

        $em->remove($rol);
        $em->flush();

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
