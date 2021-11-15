<?php

namespace MD\Bundle\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MD\Bundle\MediaBundle\Entity\Image as Image;

/**
 * ProductBrand
 *
 * @ORM\Table("ProductBrand")
 * @ORM\Entity
 */
class ProductBrand {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="htmlSlug", type="string", length=255, unique=true)
     */
    protected $htmlSlug;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @ORM\ManyToMany(targetEntity="\MD\Bundle\MediaBundle\Entity\Image")
     */
    protected $images;

    /**
     * @ORM\OneToMany(targetEntity="ProductCategory", mappedBy="brand")
     */
    protected $categories;

    /**
     * Constructor
     */
    public function __construct() {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString() {
        return $this->name;
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
     * Set name
     *
     * @param string $name
     * @return ProductBrand
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set htmlSlug
     *
     * @param string $htmlSlug
     * @return ProductBrand
     */
    public function setHtmlSlug($htmlSlug) {
        $this->htmlSlug = $htmlSlug;

        return $this;
    }

    /**
     * Get htmlSlug
     *
     * @return string 
     */
    public function getHtmlSlug() {
        return $this->htmlSlug;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return ProductBrand
     */
    public function setContent($content) {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * Add images
     *
     * @param \MD\Bundle\MediaBundle\Entity\Image $images
     * @return ProductBrand
     */
    public function addImage(\MD\Bundle\MediaBundle\Entity\Image $images) {
        $this->images[] = $images;

        return $this;
    }

    /**
     * Remove images
     *
     * @param \MD\Bundle\MediaBundle\Entity\Image $images
     */
    public function removeImage(\MD\Bundle\MediaBundle\Entity\Image $images) {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages($types = null) {
        if ($types) {
            return $this->images->filter(function(\MD\Bundle\MediaBundle\Entity\Image $image) use ($types) {
                        return in_array($image->getImageType(), $types);
                    });
        } else {
            return $this->images;
        }
    }

    /**
     * Get logoImage
     *
     * @return MD\Bundle\MediaBundle\Entity\Image
     */
    public function getLogoImage() {
        return $this->getImages(array(Image::TYPE_LOGO))->first();
    }

    /**
     * Get mainImage
     *
     * @return MD\Bundle\MediaBundle\Entity\Image
     */
    public function getMainImage() {
        return $this->getImages(array(Image::TYPE_MAIN))->first();
    }

    /**
     * Add categories
     *
     * @param \MD\Bundle\CMSBundle\Entity\ProductCategory $categories
     * @return ProductBrand
     */
    public function addCategorie(\MD\Bundle\CMSBundle\Entity\ProductCategory $categories) {
        $this->categories[] = $categories;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param \MD\Bundle\CMSBundle\Entity\ProductCategory $categories
     */
    public function removeCategorie(\MD\Bundle\CMSBundle\Entity\ProductCategory $categories) {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategories() {
        return $this->categories;
    }

}
