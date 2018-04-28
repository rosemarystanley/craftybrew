<?php

declare(strict_types=1);

namespace CraftyBrew\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 */
class DefaultController extends Controller
{
    /**
     * @Route(
     *     "/",
     *     name="web.default.index"
     * )
     *
     * @return string
     */
    public function indexAction()
    {
        return $this->render(
            'default/index.html.twig',
            [
                'mapbox_access_token' => $this->getParameter('mapbox_access_token')
            ]
        );
    }

    /**
     * @Route(
     *     "/terms-of-service",
     *     name="web.default.terms"
     * )
     *
     * @return string
     */
    public function termsAction()
    {
        return $this->render('default/terms.html.twig');
    }

    /**
     * @Route(
     *     "/privacy-policy",
     *     name="web.default.privacy"
     * )
     *
     * @return string
     */
    public function privacyAction()
    {
        return $this->render('default/privacy.html.twig');
    }
}
