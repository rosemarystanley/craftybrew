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
        return $this->render('default/index.html.twig');
    }
}
