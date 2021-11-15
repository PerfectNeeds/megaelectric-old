<?php

namespace MD\Bundle\MediaBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="MD\Bundle\MediaBundle\Repository\ImageRepository")

 */
class Image {

    const TYPE_MCE = 100;
    const TYPE_GALLERY = 200;
    const TYPE_MAIN = 201;
    const TYPE_THUMBNAIL = 202;
    const TYPE_FLOORPLAN = 203;
    const TYPE_LOGO = 204;

    private $filenameForRemove;
    private $filenameForRemoveResize;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $extension;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    protected $imageType;

    /**
     * @ORM\OneToOne(targetEntity="\MD\Bundle\CMSBundle\Entity\Banner", mappedBy="image")
     */
    protected $banner;

    /**
     *
     * @Assert\NotBlank()

     */
    Protected $file;

    public function __construct() {
        
    }

    public function getWebExtension($directory) {
        return null === $this->extension ? null : $this->getUploadDir($directory) . '/' . $this->extension;
    }

    protected function getUploadRootDir($directory) {
        // the absolute directory extension where uploaded
        // documents should be saved
        return __DIR__ . '/../../../../../public_html/' . $this->getUploadDir($directory);
    }

    public function getUploadDirForResize($directory) {
        // the absolute directory extension where uploaded
        // documents should be saved
        return __DIR__ . '/../../../../../public_html/' . $this->getUploadDir($directory);
    }

    public function preUpload() {
        if (null !== $this->file) {
            $this->extension = $this->file->guessExtension();
        }
    }

    public function upload($directory) {

        if (null === $this->file) {
            return;
        }

        // you must throw an exception here if the file cannot be moved
        // so that the entity is not persisted to the database
        // which the UploadedFile move() method does
        $this->file->move(
                $this->getUploadRootDir($directory), $this->id
        );

        unset($this->file);
    }

    public function storeFilenameForRemove($directory) {

        $this->filenameForRemove = $this->getAbsoluteExtension($directory);
    }

    public function removeUpload() {
        if ($this->filenameForRemove) {
            unlink($this->filenameForRemove);
        }
    }

    public function getAbsoluteExtension($directory) {
        return null === $this->extension ? null : $this->getUploadRootDir($directory) . '/' . $this->id;
        ;
    }

    public function storeFilenameForResizeRemove($directory) {
        $this->filenameForRemoveResize = $this->getAbsoluteResizeExtension($directory);
    }

    public function removeResizeUpload() {
        if ($this->filenameForRemoveResize) {
            unlink($this->filenameForRemoveResize);
        }
    }

    public function getAbsoluteResizeExtension($directory) {
        return null === $this->extension ? null : $this->getUploadRootDir($directory) . '/' . "th" . $this->id;
        ;
    }

    protected function getUploadDir($directory) {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/' . $directory;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set extension
     *
     * @param string $extension
     * @return Image
     */
    public function setExtension($extension) {

        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension
     *
     * @return string 
     */
    public function getExtension() {
        return $this->extension;
    }

    //PETER???????
    public function setFile($file) {
        $this->file = $file;

        return $this;
    }

    //PETER???????
    public function getFile() {
        return $this->file;
    }

    /**
     * Set imageType
     *
     * @param integer $imageType
     * @return Image
     */
    public function setImageType($imageType) {
        $this->imageType = $imageType;

        return $this;
    }

    /**
     * Get imageType
     *
     * @return integer 
     */
    public function getImageType() {
        return $this->imageType;
    }

    /**
     * Set banner
     *
     * @param \MD\Bundle\CMSBundle\Entity\Banner $banner
     * @return Image
     */
    public function setBanner(\MD\Bundle\CMSBundle\Entity\Banner $banner = null) {
        $this->banner = $banner;

        return $this;
    }

    /**
     * Get banner
     *
     * @return \MD\Bundle\CMSBundle\Entity\Banner 
     */
    public function getBanner() {
        return $this->banner;
    }

    /**
     * Set dynamicpage
     *
     * @param \MD\Bundle\CMSBundle\Entity\DynamicPage $dynamicpage
     * @return Image
     */
    public function setDynamicpage(\MD\Bundle\CMSBundle\Entity\DynamicPage $dynamicpage = null) {
        $this->dynamicpage = $dynamicpage;

        return $this;
    }

    /**
     * Get dynamicpage
     *
     * @return \MD\Bundle\CMSBundle\Entity\DynamicPage 
     */
    public function getDynamicpage() {
        return $this->dynamicpage;
    }

    /**
     * Set productFamily
     *
     * @param \MD\Bundle\CMSBundle\Entity\ProductFamily $productFamily
     * @return Image
     */
    public function setProductFamily(\MD\Bundle\CMSBundle\Entity\ProductFamily $productFamily = null) {
        $this->productFamily = $productFamily;

        return $this;
    }

    /**
     * Get productFamily
     *
     * @return \MD\Bundle\CMSBundle\Entity\ProductFamily 
     */
    public function getProductFamily() {
        return $this->productFamily;
    }

}
