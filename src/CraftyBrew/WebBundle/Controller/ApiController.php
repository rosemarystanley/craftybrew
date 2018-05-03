<?php

declare(strict_types=1);

namespace CraftyBrew\WebBundle\Controller;

use CraftyBrew\WebBundle\Entity\Brewery;
use CraftyBrew\WebBundle\Entity\Point;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function locationsAction()
    {
        $breweries = $this->getDoctrine()->getRepository(Brewery\Location::class)
            ->findByGeometry(new Point(35.227, -80.843), 0.25);

        $serializer = $this->get('jms_serializer');
        $context = SerializationContext::create()
            ->setGroups(['default', 'list'])
            ->setSerializeNull(true);
        return new JsonResponse($serializer->serialize($breweries, 'json', $context), 200, [], true);
    }
}
