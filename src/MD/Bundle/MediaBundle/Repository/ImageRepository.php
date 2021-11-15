<?php

namespace MD\Bundle\MediaBundle\Repository;

use MD\Bundle\MediaBundle\Entity\Image as Image;
use Doctrine\ORM\EntityRepository;

class ImageRepository extends EntityRepository {

    public function setMainImage($entityType, $entityId, $entityImageId) {

        $this->clearMain($entityType, $entityId);
        $em = $this->getEntityManager();
        $image = $em->getRepository('MediaBundle:Image')->find($entityImageId);
        $image->setImageType(Image::TYPE_MAIN);
        $em->persist($image);
        $em->flush();
        exit("done");
    }

    public function clearMain($entityType, $entityId) {
        /*
         * $entityType  :: bundle
         * ex           :: TravelBundle:Package
         */

        switch ($entityType) {
            case("CMSBundle:Blog"):
                $SQLTable = "blog_image";
                $SQLColumn = "t.blog_id";
                break;
            case("CMSBundle:ProductFamily"):
                $SQLTable = "productfamily_image";
                $SQLColumn = "t.productfamily_id";
                break;
            case("CMSBundle:OurSolution"):
                $SQLTable = "oursolution_image";
                $SQLColumn = "t.oursolution_id";
                break;
        }
        $sql = "UPDATE Image i JOIN $SQLTable t on i.id = t.image_id SET i.imageType = " . Image::TYPE_GALLERY . " where i.imageType = " . Image::TYPE_MAIN . " and $SQLColumn = ?  ";
        $this->getEntityManager()->getConnection()
                ->executeQuery($sql, array($entityId));
    }

}
