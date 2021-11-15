<?php

namespace MD\Bundle\CMSBundle\Controller\FrontEnd;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MD\Bundle\CMSBundle\Entity\Product;

/**
 * Product controller.
 *
 * @Route("/product")
 */
class ProductController extends Controller {

    /**
     * Lists all Product entities.
     *
     * @Route("/{name}", name="fe_product_brand")
     * @Method("GET")
     * @Template()
     */
    public function productAction($name) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CMSBundle:ProductCategory')->findOneBY(array('htmlSlug' => $name));
        return array(
            'entity' => $entity,
        );
    }

    /**
     * Lists all Product entities.
     *
     * @Route("/{brand_name}/{category_name}/{family_name}", name="fe_product_family")
     * @Method("GET")
     * @Template()
     */
    public function productDetailsAction($brand_name, $category_name, $family_name) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CMSBundle:ProductFamily')->getOneByBrandSlugAndFamilySlug($brand_name, $category_name, $family_name);
        $productFamiliesRand = $em->getRepository('CMSBundle:ProductFamily')->getRandByCategorySlugAndFamilySlug($category_name, $family_name);
//        \Doctrine\Common\Util\Debug::dump($entity);
        return array(
            'entity' => $entity,
            'productFamiliesRand' => $productFamiliesRand,
        );
    }

}
