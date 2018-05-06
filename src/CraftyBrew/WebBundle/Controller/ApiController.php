<?php

declare(strict_types=1);

namespace CraftyBrew\WebBundle\Controller;

use CraftyBrew\WebBundle\Entity\Brewery;
use CraftyBrew\WebBundle\Entity\Point;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 */
class ApiController extends Controller
{
    /**
     * @Route(
     *     "/api/locations",
     *     name="api.locations"
     * )
     *
     * @return string
     */
    public function locationsAction(Request $request)
    {
        $latitude = $request->query->get('latitude', 35.227);
        $longitude = $request->query->get('longitude', -80.843);
        $distance = $request->query->get('distance', 1 / 69.172);
        $breweries = $this->getDoctrine()->getRepository(Brewery\Location::class)
            ->findByGeometry(new Point($latitude, $longitude), $distance);

        $serializer = $this->get('jms_serializer');
        $context = SerializationContext::create()
            ->setGroups(['default', 'list'])
            ->setSerializeNull(true);
        return new JsonResponse($serializer->serialize($breweries, 'json', $context), 200, [], true);
    }
}
