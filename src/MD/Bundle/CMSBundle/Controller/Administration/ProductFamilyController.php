<?php

namespace MD\Bundle\CMSBundle\Controller\Administration;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MD\Bundle\CMSBundle\Entity\ProductFamily;
use MD\Bundle\CMSBundle\Form\ProductFamilyType;
use \MD\Bundle\MediaBundle\Entity\Image as Image;

/**
 * ProductFamily controller.
 *
 * @Route("/product-family")
 */
class ProductFamilyController extends Controller {

    /**
     * Lists all ProductFamily entities.
     *
     * @Route("/", name="product-family")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CMSBundle:ProductFamily')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new ProductFamily entity.
     *
     * @Route("/", name="product-family_create")
     * @Method("POST")
     * @Template("CMSBundle:ProductFamily:new.html.twig")
     */
    public function createAction(Request $request) {

        $entity = new ProductFamily();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $description = $this->getRequest()->request->get('description');
        $brief = $this->getRequest()->request->get('brief');
        $contentArray = array("description" => $description, "brief" => $brief);
        $categoryId = $this->getRequest()->request->get('category');

//        if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('CMSBundle:ProductCategory')->find($categoryId);
        $entity->setCategory($category);
        $entity->setContent($contentArray);
        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('product-family_edit', array('id' => $entity->getId())));
//        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a ProductFamily entity.
     *
     * @param ProductFamily $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ProductFamily $entity) {
        $form = $this->createForm(new ProductFamilyType(), $entity, array(
            'action' => $this->generateUrl('product-family_create'),
            'method' => 'POST',
        ));


        return $form;
    }

    /**
     * Displays a form to create a new ProductFamily entity.
     *
     * @Route("/new", name="product-family_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new ProductFamily();
        $form = $this->createCreateForm($entity);

        $em = $this->getDoctrine()->getManager();
        $barnds = $em->getRepository('CMSBundle:ProductBrand')->findAll();

        return array(
            'barnds' => $barnds,
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ProductFamily entity.
     *
     * @Route("/{id}/edit", name="product-family_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CMSBundle:ProductFamily')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductFamily entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        $barnds = $em->getRepository('CMSBundle:ProductBrand')->findAll();

        return array(
            'barnds' => $barnds,
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a ProductFamily entity.
     *
     * @param ProductFamily $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(ProductFamily $entity) {
        $form = $this->createForm(new ProductFamilyType(), $entity, array(
            'action' => $this->generateUrl('product-family_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));


        return $form;
    }

    /**
     * Edits an existing ProductFamily entity.
     *
     * @Route("/{id}", name="product-family_update")
     * @Method("PUT")
     * @Template("CMSBundle:ProductFamily:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CMSBundle:ProductFamily')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductFamily entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
        $description = $this->getRequest()->request->get('description');
        $brief = $this->getRequest()->request->get('brief');
        $contentArray = array("description" => $description, "brief" => $brief);
        $categoryId = $this->getRequest()->request->get('category');
        $category = $em->getRepository('CMSBundle:ProductCategory')->find($categoryId);
        $entity->setCategory($category);

        if ($editForm->isValid()) {
            $entity->setContent($contentArray);
            $em->flush();

            return $this->redirect($this->generateUrl('product-family_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a ProductFamily entity.
     *
     * @Route("/delete", name="product-family_delete")
     * @Method("POST")
     */
    public function deleteAction() {
        $id = $this->getRequest()->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CMSBundle:ProductFamily')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductFamily entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('product-family'));
    }

    /**
     * Creates a form to delete a ProductFamily entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('product-family_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

    /**
     * Displays a form to create a new PropertyGallery entity.
     *
     * @Route("/gallery/{id}", name="product-family_set_images")
     * @Method("GET")
     * @Template()
     */
    public function GetImagesAction($id, $imageTypes = NULL) {
        $form = $this->createForm(new \MD\Bundle\MediaBundle\Form\ImageType());
        $formView = $form->createView();
//        $formView->getChild('files')->set('full_name', 'files[]');
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CMSBundle:ProductFamily')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product Family entity...');
        }
        $productFamily = $em->getRepository('CMSBundle:ProductFamily')->find($id);
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
     * @Route("/deleteimage/{h_id}/{redirect_id}", name="product-familyimages_delete")
     * @Method("POST")
     */
    public function deleteImageAction($h_id, $redirect_id) {
        $image_id = $this->getRequest()->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CMSBundle:ProductFamily')->find($h_id);
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
        $image->storeFilenameForRemove("product-family/" . $h_id);
        $image->removeUpload();
        $image->storeFilenameForResizeRemove("product-family/" . $h_id);
//        $image->removeResizeUpload();
        $em->persist($image);
        $em->flush();
        $em->remove($image);
        $em->flush();

        if ($redirect_id == 1) {
            return $this->redirect($this->generateUrl('product-family_set_images', array('id' => $h_id)));
        } else if ($redirect_id == 2) {
            return $this->redirect($this->generateUrl('product-family_edit', array('id' => $h_id)));
        }
    }

    /**
     * Displays a form to create a new PropertyGallery entity.
     *
     * @Route("/gallery/ajax/", name="product-family_ajax")
     * @Method("POST")
     */
    public function SetimageMainAction() {
        $id = $this->getRequest()->request->get('id');
        $image_id = $this->getRequest()->request->get('image_id');
        $em = $this->getDoctrine()->getManager();
        $em->getRepository('MediaBundle:Image')->setMainImage('CMSBundle:ProductFamily', $id, $image_id);
    }

    // upload single Image 
    /**
     * Set Images to Property.
     *
     * @Route("/gallery/{id}" , name="product-family_create_images")
     * @Method("POST")
     */
    public function SetImageAction(Request $request, $id) {
        $form = $this->createForm(new \MD\Bundle\MediaBundle\Form\ImageType());
        $formView = $form->createView();
        $form->bind($request);

        $data = $form->getData();
        $files = $data["files"];

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CMSBundle:ProductFamily')->find($id);
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
                $image->upload("product-family/" . $id);
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
                $imageUrl = $this->get('kernel')->projectRoot . "web/uploads/product-family/" . $id . "/" . $image->getId();
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
     * @Route("/document/{id}", name="product-family_set_documents")
     * @Method("GET")
     * @Template()
     */
    public function GetDocumentsAction($id, $documentTypes = NULL) {
        $form = $this->createForm(new \MD\Bundle\MediaBundle\Form\DocumentType());
        $formView = $form->createView();
//        $formView->getChild('files')->set('full_name', 'files[]');
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CMSBundle:ProductFamily')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product Family entity...');
        }
        $productFamily = $em->getRepository('CMSBundle:ProductFamily')->find($id);
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
     * @Route("/deletedocument/{h_id}/{redirect_id}", name="product-familydocuments_delete")
     * @Method("POST")
     */
    public function deleteDocumentAction($h_id, $redirect_id) {
        $document_id = $this->getRequest()->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CMSBundle:ProductFamily')->find($h_id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductFamily entity.');
        }
        $document = $em->getRepository('MediaBundle:Document')->find($document_id);
        if (!$document) {
            throw $this->createNotFoundException('Unable to find ProductFamily entity.');
        }
        $entity->removeDocument($document);
        $em->persist($entity);
        $em->flush();
        $document->storeFilenameForRemove("product-family/document/" . $h_id);
        $document->removeUpload();
//        $document->storeFilenameForResizeRemove("product-family/document/" . $h_id);
        $em->persist($document);
        $em->flush();
        $em->remove($document);
        $em->flush();

        if ($redirect_id == 1) {
            return $this->redirect($this->generateUrl('product-family_set_documents', array('id' => $h_id)));
        } else if ($redirect_id == 2) {
            return $this->redirect($this->generateUrl('product-family_edit', array('id' => $h_id)));
        }
    }

    /**
     * Set Documents to Property.
     *
     * @Route("/document/{id}" , name="product-family_create_documents")
     * @Method("POST")
     */
    public function SetDocumentAction(Request $request, $id) {
        $form = $this->createForm(new \MD\Bundle\MediaBundle\Form\DocumentType());
        $formView = $form->createView();
        $form->bind($request);

        $data = $form->getData();
        $files = $data["files"];
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CMSBundle:ProductFamily')->find($id);
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
                $document->upload("product-family/document/" . $id);
                $entity->addDocument($document);
                $documentUrl = $this->get('kernel')->projectRoot . "web/uploads/product-family/document/" . $id . "/" . $document->getId();
                $documentId = $document->getId();
            }
            $em->persist($entity);
            $em->flush();
            $files = '{"files":[{"url":"' . $documentUrl . '","thumbnailUrl":"' . $documentUrl . '","name":"test","id":"' . $documentId . '","type":"document/jpeg","size":620888,"deleteUrl":"http://localhost/packagat/web/uploads/packages/1/th71?delete=true","deleteType":"DELETE"}]}';
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
