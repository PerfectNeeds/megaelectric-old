<?php

namespace MD\Bundle\CMSBundle\Controller\Administration;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MD\Bundle\CMSBundle\Entity\Admin;
use MD\Bundle\CMSBundle\Form\AdminType;

/**
 * Admin controller.
 *
 * @Route("/moderators")
 */
class AdminController extends Controller {

    /**
     * Lists all Admin entities.
     *
     * @Route("/", name="admin")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CMSBundle:Admin')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Admin entity.
     *
     * @Route("/", name="admin_create")
     * @Method("POST")
     * @Template("CMSBundle:Admin:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new Admin();
        $form = $this->createForm(new AdminType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Admin entity.
     *
     * @Route("/new", name="admin_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new Admin();
        $form = $this->createForm(new AdminType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Admin entity.
     *
     * @Route("/{id}/edit", name="admin_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CMSBundle:Admin')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Admin entity.');
        }

        $editForm = $this->createForm(new AdminType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Admin entity.
     *
     * @Route("/{id}", name="admin_update")
     * @Method("PUT")
     * @Template("CMSBundle:Admin:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CMSBundle:Admin')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Admin entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new AdminType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Admin entity.
     *
     * @Route("delete/{id}", name="admin_delete")
     * @Method("POST")
     */
    public function deleteAction($id) {
        $id = $this->getRequest()->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CMSBundle:Admin')->find($id);

        if ($entity) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CMSBundle:Admin')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Admin entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin'));
    }

    /**
     * Creates a form to delete a Admin entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder(array('id' => $id))
                        ->add('id', 'hidden')
                        ->getForm()
        ;
    }

}
