<?php

namespace MD\Bundle\CMSBundle\Controller\Administration;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MD\Bundle\CMSBundle\Entity\Project;
use MD\Bundle\CMSBundle\Form\ProjectType;

/**
 * Project controller.
 *
 * @Route("/project")
 */
class ProjectController extends Controller {

    /**
     * Lists all Project entities.
     *
     * @Route("/{sId}", name="project")
     * @Method("GET")
     * @Template()
     */
    public function indexAction($sId) {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CMSBundle:Project')->findAll();
        $ourSolution = $em->getRepository('CMSBundle:OurSolution')->find($sId);

        return array(
            'entities' => $entities,
            'ourSolution' => $ourSolution,
        );
    }

    /**
     * Creates a new Project entity.
     *
     * @Route("/new/{sId}", name="project_create")
     * @Method("POST")
     * @Template("CMSBundle:Project:new.html.twig")
     */
    public function createAction(Request $request, $sId) {
        $entity = new Project();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $mainOurSolution = $em->getRepository('CMSBundle:OurSolution')->find($sId);
        if (!$mainOurSolution) {
            throw $this->createNotFoundException('Unable to find Our Solution entity.');
        }
        $entity->setProject($mainOurSolution);

        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('project', array('sId' => $mainOurSolution->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Project entity.
     *
     * @param Project $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Project $entity) {
        $form = $this->createForm(new ProjectType(), $entity, array(
//            'action' => $this->generateUrl('project_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Project entity.
     *
     * @Route("/new/{sId}", name="project_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($sId) {
        $entity = new Project();
        $form = $this->createCreateForm($entity);
        $em = $this->getDoctrine()->getManager();
        $ourSolution = $em->getRepository('CMSBundle:OurSolution')->find($sId);
        return array(
            'entity' => $entity,
            'ourSolution' => $ourSolution,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Project entity.
     *
     * @Route("/{id}/edit/{sId}", name="project_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id, $sId) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CMSBundle:Project')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Project entity.');
        }
        $ourSolution = $em->getRepository('CMSBundle:OurSolution')->find($sId);

        $editForm = $this->createEditForm($entity);
        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'ourSolution' => $ourSolution,
        );
    }

    /**
     * Creates a form to edit a Project entity.
     *
     * @param Project $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Project $entity) {
        $form = $this->createForm(new ProjectType(), $entity, array(
//            'action' => $this->generateUrl('project_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }

    /**
     * Edits an existing Project entity.
     *
     * @Route("/update/{id}/{sId}", name="project_update")
     * @Method("POST")
     * @Template("CMSBundle:Project:edit.html.twig")
     */
    public function updateAction(Request $request, $id, $sId) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CMSBundle:Project')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Project entity.');
        }
        $mainOurSolution = $em->getRepository('CMSBundle:OurSolution')->find($sId);
        if (!$mainOurSolution) {
            throw $this->createNotFoundException('Unable to find Our Solution entity.');
        }
        $entity->setProject($mainOurSolution);

        $editForm = $this->createForm(new ProjectType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $entity->setProject($mainOurSolution);
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('project', array('sId' => $mainOurSolution->getId())));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a Project entity.
     *
     * @Route("/delete/{sId}", name="project_delete")
     * @Method("POST")
     */
    public function deleteAction($sId) {
        $id = $this->getRequest()->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CMSBundle:Project')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Project entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('project', array('sId' => $sId)));
    }

    /**
     * Creates a form to delete a Project entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
//                        ->setAction($this->generateUrl('project_delete', array('id' => $id)))
                        ->setMethod('POST')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
