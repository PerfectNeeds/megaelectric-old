<?php

namespace MD\Bundle\CMSBundle\Controller\FrontEnd;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * contactus controller.
 *
 * @Route("contactus")
 */
class ContactusController extends Controller {

    /**
     * Contactus form.
     *
     * @Route("/", name="fe_contact")
     * @Method("GET")
     * @Template()
     */
    public function contactAction() {
        return array(
        );
    }

    /**
     * Lists all Package entities.
     *
     * @Route("/thanks", name="fe_contact_submit")
     * @Method("POST")
     * @Template()
     */
    public function thankAction() {
		$reCaptcha = new \MD\Utils\ReCaptcha();
        $reCaptchaValidate = $reCaptcha->verifyResponse();
        
        if ($reCaptchaValidate->success == False) {
             $this->getRequest()->getSession()->getFlashBag()->add('error', 'Invalid Captcha');
             return $this->redirect($this->generateUrl('fe_contact'));
        }
		
        $name = $this->getRequest()->get('first_name') . ' ' . $this->getRequest()->get('last_name');
        $email = $this->getRequest()->get('email');
        $mobile = $this->getRequest()->get('mobile');
        $msg = $this->getRequest()->get('message');
		
        // send to Admin
        $messageAdmin = \Swift_Message::newInstance()
                ->setSubject('Megalectric Contact us from ' . $name)
                ->setFrom($email)
                ->setTo('info@megalectric.com')
                ->setBody(
                $this->renderView(
                        'CMSBundle:FrontEnd/Contactus:adminEmail.html.twig', array(
                    'name' => $name,
                    'email' => $email,
                    'mobile' => $mobile,
                    'message' => $msg,
                        )
                )
                , 'text/html');
        $this->get('mailer')->send($messageAdmin);

        return array(
            'name' => $name,
            'email' => $email
        );
    }

}
