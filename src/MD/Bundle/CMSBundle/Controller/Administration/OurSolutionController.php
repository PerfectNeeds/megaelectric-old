<?php

namespace MD\Bundle\CMSBundle\Controller\Administration;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MD\Bundle\CMSBundle\Entity\OurSolution;
use MD\Bundle\CMSBundle\Form\OurSolutionType;
use \MD\Bundle\MediaBundle\Entity\Image as Image;

/**
 * OurSolution controller.
 *
 * @Route("/our-partners")
 */
class OurSolutionController extends Controller {

    /**
     * Lists all OurSolution entities.
     *
     * @Route("/", name="our-solution")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CMSBundle:OurSolution')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new OurSolution entity.
     *
     * @Route("/", name="our-solution_create")
     * @Method("POST")
     * @Template("CMSBundle:OurSolution:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new OurSolution();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('our-solution', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a OurSolution entity.
     *
     * @param OurSolution $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(OurSolution $entity) {
        $form = $this->createForm(new OurSolutionType(), $entity, array(
            'action' => $this->generateUrl('our-solution_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new OurSolution entity.
     *
     * @Route("/new", name="our-solution_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new OurSolution();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing OurSolution entity.
     *
     * @Route("/{id}/edit", name="our-solution_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CMSBundle:OurSolution')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OurSolution entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a OurSolution entity.
     *
     * @param OurSolution $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(OurSolution $entity) {
        $form = $this->createForm(new OurSolutionType(), $entity, array(
            'action' => $this->generateUrl('our-solution_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        return $form;
    }

    /**
     * Edits an existing OurSolution entity.
     *
     * @Route("/{id}", name="our-solution_update")
     * @Method("PUT")
     * @Template("CMSBundle:OurSolution:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CMSBundle:OurSolution')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OurSolution entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('our-solution_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a OurSolution entity.
     *
     * @Route("/delete", name="our-solution_delete")
     * @Method("POST")
     */
    public function deleteAction() {

        $id = $this->getRequest()->request->get('id');

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CMSBundle:OurSolution')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OurSolution entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('our-solution'));
    }

    /**
     * Creates a form to delete a OurSolution entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('our-solution_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

    /**
     * Displays a form to create a new PropertyGallery entity.
     *
     * @Route("/gallery/{id}", name="our-solution_set_images")
     * @Method("GET")
     * @Template()
     */
    public function GetImagesAction($id, $imageTypes = NULL) {
        $form = $this->createForm(new \MD\Bundle\MediaBundle\Form\ImageType());
        $formView = $form->createView();
//        $formView->getChild('files')->set('full_name', 'files[]');
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CMSBundle:OurSolution')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product Family entity...');
        }
        $productFamily = $em->getRepository('CMSBundle:OurSolution')->find($id);

        $gallerImages = $productFamily->getImages();
        return array(
            'entity' => $entity,
            'form' => $formView,
            'id' => $id,
            'images' => $gallerImages
        );
    }

    /**
     * Deletes a PropertyGallery entity.
     *
     * @Route("/deleteimage/{h_id}/{redirect_id}", name="our-solutionimages_delete")
     * @Method("POST")
     */
    public function deleteImageAction($h_id, $redirect_id) {
        $image_id = $this->getRequest()->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CMSBundle:OurSolution')->find($h_id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TourGallery entity.');
        }
        $image = $em->getRepository('MediaBundle:Image')->find($image_id);
        if (!$image) {
            throw $this->createNotFoundException('Unable to find TourGallery entity.');
        }
        $entity->removeImage($image);
        $em->persist($entity);
        $em->flush();
        $image->storeFilenameForRemove("our-solution/" . $h_id);
        $image->removeUpload();
        $image->storeFilenameForResizeRemove("our-solution/" . $h_id);
//        $image->removeResizeUpload();
        $em->persist($image);
        $em->flush();
        $em->remove($image);
        $em->flush();

        if ($redirect_id == 1) {
            return $this->redirect($this->generateUrl('our-solution_set_images', array('id' => $h_id)));
        } else if ($redirect_id == 2) {
            return $this->redirect($this->generateUrl('our-solution_edit', array('id' => $h_id)));
        }
    }

    /**
     * Displays a form to create a new PropertyGallery entity.
     *
     * @Route("/gallery/ajax/", name="our-solution_ajax")
     * @Method("POST")
     */
    public function SetimageMainAction() {
        $id = $this->getRequest()->request->get('id');
        $image_id = $this->getRequest()->request->get('image_id');
        $em = $this->getDoctrine()->getManager();
        $em->getRepository('MediaBundle:Image')->setMainImage('CMSBundle:OurSolution', $id, $image_id);
    }

    // upload single Image
    /**
     * Set Images to Property.
     *
     * @Route("/gallery/{id}" , name="our-solution_create_images")
     * @Method("POST")
     */
    public function SetImageAction(Request $request, $id) {
        $form = $this->createForm(new \MD\Bundle\MediaBundle\Form\ImageType());
        $formView = $form->createView();
        $form->bind($request);

        $data = $form->getData();
        $files = $data["files"];

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CMSBundle:OurSolution')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Landmark entity.');
        }
        foreach ($files as $file) {
            if ($file != NULL) {
                $image = new Image();
                $em->persist($image);
                $em->flush();
                $image->setFile($file);
                $image->preUpload();
                $image->upload("our-solution/" . $id);
                $image->setImageType(Image::TYPE_GALLERY);
                /*      list($width, $height) = getimagesize($image->getUploadDirForResize("propertiers/" . $id) . "/" . $image->getId());
                  $oPath = $image->getUploadDirForResize("propertiers/" . $id) . "/" . $image->getId();
                  if ($width != 870 || $height != 420) {
                  $resize_1 = $image->getUploadDirForResize("compound/" . $id) . "/" . $image->getId();
                  \MD\Bundle\MediaBundle\Utils\SimpleImage::saveNewResizedImage($oPath, $resize_1, 870, 420);
                  }
                  $resize_2 = $image->getUploadDirForResize("compound/" . $id) . "/" . "th" . $image->getId();
                  \MD\Bundle\MediaBundle\Utils\SimpleImage::saveNewResizedImage($oPath, $resize_2, 270, 203); */
                $entity->addImage($image);
                $imageUrl = $this->get('kernel')->projectRoot . "web/uploads/our-solution/" . $id . "/" . $image->getId();
                $imageId = $image->getId();
            }
            $em->persist($entity);
            $em->flush();
            $files = '{"files":[{"url":"' . $imageUrl . '","thumbnailUrl":"' . $imageUrl . '","name":"test","id":"' . $imageId . '","type":"image/jpeg","size":620888,"deleteUrl":"http://localhost/packagat/web/uploads/packages/1/th71?delete=true","deleteType":"DELETE"}]}';
            $response = new Response();
            $response->setContent($files);
            $response->setStatusCode(200);
            return $response;
        }

        return array(
            'form' => $formView,
            'id' => $id,
        );
    }

    /**
     * Displays a form to create a new PropertyGallery entity.
     *
     * @Route("/document/{id}", name="our-solution_set_documents")
     * @Method("GET")
     * @Template()
     */
    public function GetDocumentsAction($id, $documentTypes = NULL) {
        $form = $this->createForm(new \MD\Bundle\MediaBundle\Form\DocumentType());
        $formView = $form->createView();
//        $formView->getChild('files')->set('full_name', 'files[]');
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CMSBundle:OurSolution')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product Family entity...');
        }
        $productFamily = $em->getRepository('CMSBundle:OurSolution')->find($id);
        $documents = $productFamily->getDocuments();
        return array(
            'entity' => $entity,
            'form' => $formView,
            'id' => $id,
            'documents' => $documents
        );
    }

    /**
     * Deletes a PropertyGallery entity.
     *
     * @Route("/deletedocument/{h_id}/{redirect_id}", name="our-solutiondocuments_delete")
     * @Method("POST")
     */
    public function deleteDocumentAction($h_id, $redirect_id) {
        $document_id = $this->getRequest()->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CMSBundle:OurSolution')->find($h_id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OurSolution entity.');
        }
        $document = $em->getRepository('MediaBundle:Document')->find($document_id);
        if (!$document) {
            throw $this->createNotFoundException('Unable to find OurSolution entity.');
        }
        $entity->removeDocument($document);
        $em->persist($entity);
        $em->flush();
        $document->storeFilenameForRemove("our-solution/document/" . $h_id);
        $document->removeUpload();
//        $document->storeFilenameForResizeRemove("our-solution/document/" . $h_id);
        $em->persist($document);
        $em->flush();
        $em->remove($document);
        $em->flush();

        if ($redirect_id == 1) {
            return $this->redirect($this->generateUrl('our-solution_set_documents', array('id' => $h_id)));
        } else if ($redirect_id == 2) {
            return $this->redirect($this->generateUrl('our-solution_edit', array('id' => $h_id)));
        }
    }

    /**
     * Set Documents to Property.
     *
     * @Route("/document/{id}" , name="our-solution_create_documents")
     * @Method("POST")
     */
    public function SetDocumentAction(Request $request, $id) {
        $form = $this->createForm(new \MD\Bundle\MediaBundle\Form\DocumentType());
        $formView = $form->createView();
        $form->bind($request);

        $data = $form->getData();
        $files = $data["files"];
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CMSBundle:OurSolution')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Landmark entity.');
        }
        foreach ($files as $file) {
            if ($file != NULL) {
                $document = new \MD\Bundle\MediaBundle\Entity\Document($file);
                $em->persist($document);
                $em->flush();
//                $document->setFile($file);
                $document->preUpload();
                $document->upload("our-solution/document/" . $id);
                $entity->addDocument($document);
                $documentUrl = $this->get('kernel')->projectRoot . "web/uploads/our-solution/document/" . $id . "/" . $document->getId();
                $documentId = $document->getId();
                $documentName = $document->getName();
            }
            $em->persist($entity);
            $em->flush();
            $files = '{"files":[{"url":"' . $documentUrl . '","thumbnailUrl":"' . $documentUrl . '","name":"' . $documentName . '","id":"' . $documentId . '","type":"document/jpeg","size":620888,"deleteUrl":"http://localhost/packagat/web/uploads/packages/1/th71?delete=true","deleteType":"DELETE"}]}';
            $response = new Response();
            $response->setContent($files);
            $response->setStatusCode(200);
            return $response;
        }

        return array(
            'form' => $formView,
            'id' => $id,
        );
    }

}
