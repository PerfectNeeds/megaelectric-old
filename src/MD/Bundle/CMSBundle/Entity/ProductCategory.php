<?php

namespace MD\Bundle\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductCategory
 *
 * @ORM\Table("ProductCategory")
 * @ORM\Entity
 */
class ProductCategory {

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
     * @ORM\ManyToOne(targetEntity="ProductBrand", inversedBy="categories")
     */
    protected $brand;

    /**
     * @ORM\OneToMany(targetEntity="ProductFamily", mappedBy="category")
     */
    protected $families;

    /**
     * Constructor
     */
    public function __construct() {
        $this->families = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * __toString
     */
    public function __toString() {
        return $this->getName();
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
     * @return ProductCategory
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
     * Set brand
     *
     * @param \MD\Bundle\CMSBundle\Entity\ProductBrand $brand
     * @return ProductCategory
     */
    public function setBrand(\MD\Bundle\CMSBundle\Entity\ProductBrand $brand = null) {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return \MD\Bundle\CMSBundle\Entity\ProductBrand 
     */
    public function getBrand() {
        return $this->brand;
    }

    /**
     * Add families
     *
     * @param \MD\Bundle\CMSBundle\Entity\ProductCategory $families
     * @return ProductCategory
     */
    public function addFamilie(\MD\Bundle\CMSBundle\Entity\ProductCategory $families) {
        $this->families[] = $families;

        return $this;
    }

    /**
     * Remove families
     *
     * @param \MD\Bundle\CMSBundle\Entity\ProductCategory $families
     */
    public function removeFamilie(\MD\Bundle\CMSBundle\Entity\ProductCategory $families) {
        $this->families->removeElement($families);
    }

    /**
     * Get families
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFamilies() {
        return $this->families;
    }

    /**
     * Set htmlSlug
     *
     * @param string $htmlSlug
     * @return ProductCategory
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

}
