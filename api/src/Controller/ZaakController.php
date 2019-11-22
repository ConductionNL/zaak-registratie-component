<?php

namespace App\Controller;

// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
// use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use GBProd\UuidNormalizer\UuidDenormalizer;
use GBProd\UuidNormalizer\UuidNormalizer;
use App\Entity\KlantContact;
use App\Entity\Zaak;
use Ramsey\Uuid\Uuid;

class ZaakController extends Controller
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

    /**
     * @Route("/zaken", methods={"POST"}, name="createzaak")
     */
    public function createZaak(Request $request)
    {
        $params = $request->query->all();

        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();
        
        $serializer = $this->container->get('jms_serializer');

        /* For each required value we simply assume it exists and
         * set it on the new zaak. For optional fields we check if
         * it isset and set to null otherwise.
         * 
         * This is not clean at all but for lack of time.
         */
        $zaak = new Zaak();
        $zaak->setUrl("henk.com");
        $zaak->setIdentificatie(isset($params['identificatie']) ? $params['identificatie'] : null);
        $zaak->setBronorganisatie($params['bronorganisatie']);
        $zaak->setOmschrijving(isset($params['omschrijving']) ? $params['omschrijving'] : null);
        $zaak->setToelichting(isset($params['toelichting']) ? $params['toelichting'] : null);
        $zaak->setZaakType($params['zaaktype']);
        $zaak->setRegistratieDatum(isset($params['registratiedatum']) ? new \DateTime($params['registratiedatum']) : null);
        $zaak->setVerantwoordelijkeOrganisatie($params['verantwoordelijkeOrganisatie']);
        $zaak->setStartDatum(new \DateTime($params['startdatum']));
        $zaak->setEinddatumGepland(isset($params['einddatumGepland']) ? new \DateTime($params['einddatumGepland']) : null);
        $zaak->setUiterlijkeEinddatumAfdoening(isset($params['uiterlijkeEinddatumAfdoening']) ? new \DateTime($params['uiterlijkeEinddatumAfdoening']) : null);
        $zaak->setPublicatieDatum(isset($params['publicatieDatum']) ? new \DateTime($params['publicatieDatum']) : null);
        $zaak->setCommunicatieKanaal(isset($params['communicatiekanaal']) ? $params['communicatiekanaal'] : null);
        $zaak->setProductenOfDiensten(isset($params['productenOfDiensten']) ? $params['productenOfDiensten'] : null);
        $zaak->setVertrouwelijkheidAanduiding(isset($params['vertrouwelijkheidaanduiding']) ? $params['vertrouwelijkheidaanduiding'] : null);
        $zaak->setBetalingsindicatie(isset($params['betalingsindicatie']) ? $params['betalingsindicatie'] : null);
        $zaak->setLaatsteBetaaldatum(isset($params['laatsteBetaaldatum']) ? new \DateTime($params['laatsteBetaaldatum']) : null);
        $zaak->setZaakGeometrie(isset($params['zaakgeometrie']) ? $params['zaakgeometrie'] : null);
        $zaak->setVerlenging(isset($params['verlenging']) ? $params['verlenging'] : null);
        $zaak->setOpschorting(isset($params['opschorting']) ? $params['opschorting'] : null);
        $zaak->setSelectielijstklasse(isset($params['selectielijstklasse']) ? $params['selectielijstklasse'] : null);
        $zaak->setHoofdzaak(isset($params['hoofdzaak']) ? $params['hoofdzaak'] : null);
        $zaak->setRelevanteAndereZaken(isset($params['relevanteAndereZaken']) ? $params['relevanteAndereZaken'] : null);
        $zaak->setKenmerken(isset($params['kenmerken']) ? $params['kenmerken'] : null);
        $zaak->setArchiefNominatie(isset($params['archiefnominatie']) ? $params['archiefnominatie'] : null);
        $zaak->setArchiefStatus(isset($params['archiefstatus']) ? $params['archiefstatus'] : null);
        $zaak->setArchiefActiedatum(isset($params['archiefactiedatum']) ? $params['archiefactiedatum'] : null);

        $em->persist($zaak);
        $em->flush();

        return new JsonResponse($serializer->serialize($zaak, 'json'));
    }
}
