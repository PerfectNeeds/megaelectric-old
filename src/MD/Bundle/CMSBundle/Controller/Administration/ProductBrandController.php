<?php

namespace MD\Bundle\CMSBundle\Controller\Administration;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MD\Bundle\CMSBundle\Entity\ProductBrand;
use MD\Bundle\CMSBundle\Form\ProductBrandType;
use Symfony\Component\HttpFoundation\Response;
use \MD\Bundle\MediaBundle\Entity\Image as Image;

/**
 * ProductBrand controller.
 *
 * @Route("/product-brand")
 */
class ProductBrandController extends Controller {

    /**
     * Lists all ProductBrand entities.
     *
     * @Route("/", name="product-brand")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CMSBundle:ProductBrand')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new ProductBrand entity.
     *
     * @Route("/", name="product-brand_create")
     * @Method("POST")
     * @Template("CMSBundle:ProductBrand:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new ProductBrand();
        $form = $this->createForm(new ProductBrandType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('product-brand'));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new ProductBrand entity.
     *
     * @Route("/new", name="product-brand_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new ProductBrand();
        $form = $this->createForm(new ProductBrandType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ProductBrand entity.
     *
     * @Route("/{id}/edit", name="product-brand_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CMSBundle:ProductBrand')->find($id);
        $logoImage = $entity->getLogoImage();
        $mainImage = $entity->getMainImage();
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductBrand entity.');
        }

        $uploadForm = $this->createForm(new \MD\Bundle\MediaBundle\Form\SingleImageType());
        $formView = $uploadForm->createView();
        $editForm = $this->createForm(new ProductBrandType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'logoImage' => $logoImage,
            'mainImage' => $mainImage,
            'mainType' => Image::TYPE_MAIN,
            'logoType' => Image::TYPE_LOGO,
            'edit_form' => $editForm->createView(),
            'upload_form' => $formView,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a ProductBrand entity.
     *
     * @param ProductBrand $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(ProductBrand $entity) {
        $form = $this->createForm(new ProductBrandType(), $entity, array(
            'action' => $this->generateUrl('product-brand_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }

    /**
     * Edits an existing ProductBrand entity.
     *
     * @Route("/{id}", name="product-brand_update")
     * @Method("PUT")
     * @Template("CMSBundle:ProductBrand:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CMSBundle:ProductBrand')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductBrand entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('product-brand_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a ProductBrand entity.
     *
     * @Route("/delete", name="product-brand_delete")
     * @Method("POST")
     */
    public function deleteAction() {
        $id = $this->getRequest()->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CMSBundle:ProductBrand')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductBrand entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('product-brand'));
    }

    /**
     * Creates a form to delete a ProductBrand entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('product-brand_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

    /**
     * Set Images to Property.
     *
     * @Route("/gallery/{id}" , name="product-brand_create_images")
     * @Method("POST")
     */
    public function SetImageAction(Request $request, $id) {
        $form = $this->createForm(new \MD\Bundle\MediaBundle\Form\ImageType());
        $formView = $form->createView();
        $form->bind($request);

        $data = $form->getData();
        $files = $data["files"];

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CMSBundle:ProductBrand')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Landmark entity.');
        }

        $imageType = $request->get("type");
        foreach ($files as $file) {
            if ($file != NULL) {
                $image = new \MD\Bundle\MediaBundle\Entity\Image();
                $em->persist($image);
                $em->flush();
                $image->setFile($file);
                $mainImages = $entity->getImages(array(\MD\Bundle\MediaBundle\Entity\Image::TYPE_MAIN));
                $logoImages = $entity->getImages(array(\MD\Bundle\MediaBundle\Entity\Image::TYPE_LOGO));
                if ($imageType == Image::TYPE_MAIN && count($mainImages) > 0) {
                    foreach ($mainImages As $mainImage) {
                        $entity->removeImage($mainImage);
                        $em->persist($entity);
                        $em->flush();
                        $image->storeFilenameForRemove("product-brands/" . $entity->getId());
                        $image->removeUpload();
//                        $image->storeFilenameForResizeRemove("suppliers/" . $entity->getId());
//                        $image->removeResizeUpload();
                        $em->persist($mainImage);
                        $em->flush();
                        $em->remove($mainImage);
                        $em->flush();
                        $image->setImageType(Image::TYPE_MAIN);
                    }
                } else if ($imageType == Image::TYPE_LOGO && count($logoImages) > 0) {
                    foreach ($logoImages As $logoImage) {
                        $entity->removeImage($logoImage);
                        $em->persist($entity);
                        $em->flush();
                        $image->storeFilenameForRemove("product-brands/" . $entity->getId());
                        $image->removeUpload();
//                        $image->storeFilenameForResizeRemove("suppliers/" . $entity->getId());
//                        $image->removeResizeUpload();
                        $em->persist($logoImage);
                        $em->flush();
                        $em->remove($logoImage);
                        $em->flush();
                        $image->setImageType(Image::TYPE_MAIN);
                    }
                } else {
                    $image->setImageType($imageType);
                }
                $image->preUpload();
                $image->upload("product-brands/" . $id);
                $entity->addImage($image);
                $imageUrl = $this->get('kernel')->projectRoot . "web/uploads/product-brands/" . $id . "/" . $image->getId();
                $imageId = $image->getId();
            }
            $em->persist($entity);
            $em->flush();
            $files = '{"files":[{"url":"' . $imageUrl . '","thumbnailUrl":"http://lh6.ggpht.com/0GmazPJ8DqFO09TGp-OVK_LUKtQh0BQnTFXNdqN-5bCeVSULfEkCAifm6p9V_FXyYHgmQvkJoeONZmuxkTBqZANbc94xp-Av=s80","name":"test","id":"' . $imageId . '","type":"image/jpeg","size":620888,"deleteUrl":"http://localhost/packagat/web/uploads/packages/1/th71?delete=true","deleteType":"DELETE"}]}';
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
     * Deletes a PropertyGallery entity.
     *
     * @Route("/deleteimage/{h_id}/{redirect_id}", name="product-brandimages_delete")
     * @Method("POST")
     */
    public function deleteImageAction($h_id, $redirect_id) {
        $image_id = $this->getRequest()->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CMSBundle:ProductBrand')->find($h_id);
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
        $image->storeFilenameForRemove("product-brands/" . $h_id);
        $image->removeUpload();
//        $image->storeFilenameForResizeRemove("product-brands/" . $h_id);
//        $image->removeResizeUpload();
        $em->persist($image);
        $em->flush();
        $em->remove($image);
        $em->flush();

        if ($redirect_id == 1) {
            return $this->redirect($this->generateUrl('product-brand_edit', array('id' => $h_id)));
        } else if ($redirect_id == 2) {
            return $this->redirect($this->generateUrl('product-brand_edit', array('id' => $h_id)));
        }
    }

}
