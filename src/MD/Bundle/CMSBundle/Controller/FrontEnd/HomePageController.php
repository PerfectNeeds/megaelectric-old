<?php

namespace MD\Bundle\CMSBundle\Controller\FrontEnd;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * HomePage controller.
 *
 * @Route("/")
 */
class HomePageController extends Controller {

    /**
     * Lists all Home entities.
     *
     * @Route("/", name="fe_home")
     * @Method("GET")
     * @Template()
     */
    public function homeAction() {
        $em = $this->getDoctrine()->getManager();
        $productBrands = $em->getRepository('CMSBundle:ProductBrand')->findAll();
        return array(
            'productBrands' => $productBrands,
        );
    }

    /**
     * Lists all Home entities.
     *
     * @Route("/menu-solution", name="fe_dynamicpage_menu-solution")
     * @Method("GET")
     * @Template()
     */
    public function menuOurSolutionAction() {
        $em = $this->getDoctrine()->getManager();
        $solutions = $em->getRepository('CMSBundle:OurSolution')->findAll();
        $brands = $em->getRepository('CMSBundle:ProductCategory')->findAll();

        return array(
            'solutions' => $solutions,
            'brands' => $brands,
        );
    }

}
