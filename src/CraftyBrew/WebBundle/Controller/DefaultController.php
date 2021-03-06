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
     *     "/about",
     *     name="web.default.about"
     * )
     *
     * @return string
     */
    public function aboutAction()
    {
        return $this->render('default/about.html.twig');
    }

    /**
     * @Route(
     *     "/contact",
     *     name="web.default.contact"
     * )
     *
     * @return string
     */
    public function contactAction()
    {
        return $this->render('default/contact.html.twig');
    }

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
     *     "/privacy-policy",
     *     name="web.default.privacy"
     * )
     *
     * @return string
     */
    public function privacyAction()
    {
        return $this->render(
            'default/privacy.html.twig',
            [
                'last_updated' => '2018-04-28 00:00:00-0500',
                'site_name' => 'CraftyBrew'
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
        return $this->render(
            'default/terms.html.twig',
            [
                'last_updated' => '2018-04-28 00:00:00-0500',
                'site_name' => 'CraftyBrew'
            ]
        );
    }
}
