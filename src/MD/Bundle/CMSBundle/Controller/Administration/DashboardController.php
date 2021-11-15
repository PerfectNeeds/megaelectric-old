<?php

namespace MD\Bundle\CMSBundle\Controller\Administration;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

/**
 * Faq controller.
 *
 * @Route("/")
 */
class DashboardController extends Controller {

    /**
     * Lists all Faq entities.
     *
     * @Route("/", name="dashboard")
     * @Method("GET")
     * @Template()
     */
    public function DashboardAction() {
        $em = $this->getDoctrine()->getManager();

        $bannerCount = $em->createQuery('SELECT COUNT(b) FROM CMSBundle:Banner b')
                ->getSingleScalarResult();
        $productBrandCount = $em->createQuery('SELECT COUNT(pb) FROM CMSBundle:ProductBrand pb')
                ->getSingleScalarResult();
        $productFamilyCount = $em->createQuery('SELECT COUNT(pf) FROM CMSBundle:ProductFamily pf')
                ->getSingleScalarResult();
        $dynamicPageCount = $em->createQuery('SELECT COUNT(dp) FROM CMSBundle:DynamicPage dp')
                ->getSingleScalarResult();

        return array(
            'bannerCount' => $bannerCount,
            'productBrandCount' => $productBrandCount,
            'productFamilyCount' => $productFamilyCount,
            'dynamicPageCount' => $dynamicPageCount,
        );
    }

}
