<?php

declare(strict_types=1);

namespace CraftyBrew\WebBundle\Controller;

use CraftyBrew\WebBundle\Entity\Brewery;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 */
class ApiController extends Controller
{
    /**
     * @Route(
     *     "/api/breweries",
     *     name="api.breweries"
     * )

     * @return string
     */
    public function breweriesAction()
    {
        $breweries = $this->getDoctrine()->getRepository(Brewery::class)
            ->findAll();

        $serializer = $this->get('jms_serializer');
        return new JsonResponse($serializer->serialize($breweries, 'json'), 200, [], true);
    }
}
