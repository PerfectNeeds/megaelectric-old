<?php

namespace MD\Bundle\CMSBundle\Controller\FrontEnd;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MD\Bundle\CMSBundle\Entity\Banner;

/**
 * Banner controller.
 *
 * @Route("/banner")
 */
class BannerController extends Controller {

    /**
     * Lists all Banner entities.
     *
     * @Route("/{placment}", name="fe_banner")
     * @Method("GET")
     * @Template()
     */
    public function BannerAction($placment) {
        $em = $this->getDoctrine()->getManager();
        $Banners = $em->getRepository('CMSBundle:Banner')->getRandBanner($placment);

        return array(
            'Banners' => $Banners,
        );
    }

}
