<?php

namespace MD\Bundle\CMSBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use MD\Bundle\MediaBundle\Entity\Image as Image;
use Doctrine\ORM\Mapping as ORM;

/**
 * ProductFamily
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MD\Bundle\CMSBundle\Repository\ProductFamilyRepository")
 */
class ProductFamily {

    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="name", type="string", length=45)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="htmlSlug", type="string", length=255, unique=true)
     */
    protected $htmlSlug;

    /**
     * @var object
     * @Assert\NotBlank()
     * @ORM\Column(name="content", type="object")
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="youtube_url", type="string", length=255, nullable=true)
     */
    private $youtubeUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="android_url", type="string", length=255, nullable=true)
     */
    private $androidUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="iphone_url", type="string", length=255, nullable=true)
     */
    private $iphoneUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="computer_app_url", type="string", length=255, nullable=true)
     */
    private $computerAppUrl;

    /**
     * @ORM\ManyToMany(targetEntity="\MD\Bundle\MediaBundle\Entity\Image")
     */
    protected $images;

    /**
     * @ORM\ManyToMany(targetEntity="\MD\Bundle\MediaBundle\Entity\Document")
     */
    protected $documents;

    /**
     * @ORM\ManyToOne(targetEntity="ProductCategory", inversedBy="families")
     */
    protected $category;

    /**
     * @ORM\Column(type = "datetime")
     */
    private $created;

    /**
     * Constructor
     */
    public function __construct() {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * __toString
     */
    public function __toString() {
        return $this->getName();
    }

    /**
     * Now we tell doctrine that before we persist or update we call the updatedTimestamps() function.
     *
     * @ORM\PrePersist
     */
    public function updatedTimestamps() {
        $this->setCreated(new \DateTime(date('Y-m-d H:i:s')));

        if ($this->getCreated() == null) {
            $this->setCreated(new \DateTime(date('Y-m-d H:i:s')));
        }
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
     * @return ProductFamily
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
     * Set content
     *
     * @param \stdClass $content
     * @return ProductFamily
     */
    public function setContent($content) {
        $this->content = json_encode($content);

        return $this;
    }

    /**
     * Get content
     *
     * @return \stdClass
     */
    public function getContent() {
        return json_decode($this->content);
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return ProductFamily
     */
    public function setCreated($created) {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated() {
        return $this->created;
    }

    /**
     * Add images
     *
     * @param \MD\Bundle\MediaBundle\Entity\Image $images
     * @return ProductFamily
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
     * Get mainImage
     *
     * @return MD\Bundle\MediaBundle\Entity\Image
     */
    public function getMainImage() {
        return $this->getImages(array(Image::TYPE_MAIN))->first();
    }

    /**
     * Set brand
     *
     * @param \MD\Bundle\CMSBundle\Entity\ProductBrand $brand
     * @return ProductFamily
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
     * Add documents
     *
     * @param \MD\Bundle\MediaBundle\Entity\Document $documents
     * @return ProductFamily
     */
    public function addDocument(\MD\Bundle\MediaBundle\Entity\Document $documents) {
        $this->documents[] = $documents;

        return $this;
    }

    /**
     * Remove documents
     *
     * @param \MD\Bundle\MediaBundle\Entity\Document $documents
     */
    public function removeDocument(\MD\Bundle\MediaBundle\Entity\Document $documents) {
        $this->documents->removeElement($documents);
    }

    /**
     * Get documents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDocuments() {
        return $this->documents;
    }

    /**
     * Set htmlSlug
     *
     * @param string $htmlSlug
     * @return ProductFamily
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
     * Set youtubeUrl
     *
     * @param string $youtubeUrl
     * @return ProductFamily
     */
    public function setYoutubeUrl($youtubeUrl) {
        $this->youtubeUrl = $youtubeUrl;

        return $this;
    }

    /**
     * Get youtubeUrl
     *
     * @return string
     */
    public function getYoutubeUrl() {
        return $this->youtubeUrl;
    }

    /**
     * Get youtuebThumbnail
     *
     * @return MD\Bundle\MediaBundle\Entity\Image
     */
    public function getYoutuebThumbnail() {
        return \MD\Utils\Url::youtubeThumbnail($this->getYoutubeUrl());
    }

    /**
     * Set androidUrl
     *
     * @param string $androidUrl
     * @return ProductFamily
     */
    public function setAndroidUrl($androidUrl) {
        $this->androidUrl = $androidUrl;

        return $this;
    }

    /**
     * Get androidUrl
     *
     * @return string
     */
    public function getAndroidUrl() {
        return $this->androidUrl;
    }

    /**
     * Set iphoneUrl
     *
     * @param string $iphoneUrl
     * @return ProductFamily
     */
    public function setIphoneUrl($iphoneUrl) {
        $this->iphoneUrl = $iphoneUrl;

        return $this;
    }

    /**
     * Get iphoneUrl
     *
     * @return string
     */
    public function getIphoneUrl() {
        return $this->iphoneUrl;
    }

    /**
     * Set computerAppUrl
     *
     * @param string $computerAppUrl
     * @return ProductFamily
     */
    public function setComputerAppUrl($computerAppUrl) {
        $this->computerAppUrl = $computerAppUrl;

        return $this;
    }

    /**
     * Get computerAppUrl
     *
     * @return string
     */
    public function getComputerAppUrl() {
        return $this->computerAppUrl;
    }

    /**
     * Set category
     *
     * @param \MD\Bundle\CMSBundle\Entity\ProductCategory $category
     * @return ProductFamily
     */
    public function setCategory(\MD\Bundle\CMSBundle\Entity\ProductCategory $category = null) {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \MD\Bundle\CMSBundle\Entity\ProductCategory
     */
    public function getCategory() {
        return $this->category;
    }

}
