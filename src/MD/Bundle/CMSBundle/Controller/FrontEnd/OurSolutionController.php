<?php

namespace MD\Bundle\CMSBundle\Controller\FrontEnd;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MD\Bundle\CMSBundle\Entity\OurSolution;
use MD\Bundle\CMSBundle\Form\OurSolutionType;

/**
 * OurSolution controller.
 *
 * @Route("/our-solution")
 */
class OurSolutionController extends Controller {

    /**
     * Lists all Home entities.
     *
     * @Route("/{name}", name="fe_our-solution")
     * @Method("GET")
     * @Template()
     */
    public function solutionAction($name) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CMSBundle:OurSolution')->findOneByHtmlSlug($name);
        if ($entity->getYoutubeUrl() != '' AND $entity->getYoutubeUrl() != '#') {
            $params = array();
            $queryString = parse_url($entity->getYoutubeUrl(), PHP_URL_QUERY);
            parse_str($queryString, $params);
            $youtubeV = $params['v'];
        } else {
            $youtubeV = '';
        }


        return array(
            'entity' => $entity,
            'youtubeV' => $youtubeV,
        );
    }

}
