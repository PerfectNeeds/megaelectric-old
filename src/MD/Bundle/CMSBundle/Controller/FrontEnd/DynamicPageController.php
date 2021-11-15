<?php

namespace MD\Bundle\CMSBundle\Controller\FrontEnd;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MD\Bundle\CMSBundle\Entity\DynamicPage;

/**
 * DynamicPage controller.
 *
 * @Route("/page")
 */
class DynamicPageController extends Controller {

    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/{name}", name="fe_dynamicpage")
     * @Method("GET")
     * @Template()
     */
    public function aboutAction($name) {
        $em = $this->getDoctrine()->getManager();
        $flaged = \MD\Bundle\CMSBundle\Entity\DynamicPage::Flaged;
        $page = $em->getRepository('CMSBundle:DynamicPage')->findOneBY(array('htmlSlug' => $name));
        $content = $page->getContent();
        $images = $page->getImages(array(\MD\Bundle\MediaBundle\Entity\Image::TYPE_MCE));
        //   var_dump(json_decode($content));exit();
        $nContent = stripslashes(json_decode($content));
        return array(
            'page' => $page,
            'images' => $images,
            'content' => $nContent,
            'Flaged' => $flaged,
        );
    }

    /**
     * Lists all DynamicPage entities.
     *
     * @Route("/menu", name="fe_dynamicpage_menu")
     * @Method("GET")
     * @Template()
     */
    public function menuAction() {

        return array(
        );
    }

}
