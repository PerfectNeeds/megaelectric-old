<?php

namespace MD\Bundle\CMSBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * DynamicPage
 * @ORM\Table()
 * @ORM\Entity
 */
class DynamicPage {

    const Flaged = 1;
    const NotFlaged = 0;

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
     * @ORM\Column(name="title", type="string", length=45)
     */
    private $title;

    /**
     * @var object
     * 
     * @ORM\Column(name="content", type="object")
     */
    private $content;

    /**
     * @var string
     * @ORM\Column(name="htmlSlug", type="string", length=255, unique=true)
     */
    protected $htmlSlug;

    /**
     * @var string
     * 
     * @ORM\Column(name="htmlTitle", type="string", length=45)
     */
    protected $htmlTitle;

    /**
     *
     * @ORM\Column(name="flag", type="boolean", options={"default" = 0}))
     */
    private $flag = false;

    /**
     * @var string
     * 
     * @ORM\Column(name="htmlMeta", type="string" , nullable=true)
     */
    protected $htmlMeta;

    /**
     * @ORM\ManyToMany(targetEntity="\MD\Bundle\MediaBundle\Entity\Image")
     */
    protected $images;

    public function __construct() {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return DynamicPage
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param \stdClass $content
     * @return DynamicPage
     */
    public function setContent($content) {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return \stdClass 
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * Set htmlSlug
     *
     * @param string $htmlSlug
     * @return DynamicPage
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
     * Set htmlTitle
     *
     * @param string $htmlTitle
     * @return DynamicPage
     */
    public function setHtmlTitle($htmlTitle) {
        $this->htmlTitle = $htmlTitle;

        return $this;
    }

    /**
     * Get htmlTitle
     *
     * @return string 
     */
    public function getHtmlTitle() {
        return $this->htmlTitle;
    }

    /**
     * Set htmlMeta
     *
     * @param string $htmlMeta
     * @return DynamicPage
     */
    public function setHtmlMeta($htmlMeta) {
        $this->htmlMeta = $htmlMeta;

        return $this;
    }

    /**
     * Get htmlMeta
     *
     * @return string 
     */
    public function getHtmlMeta() {
        return $this->htmlMeta;
    }

    /**
     * Set flag
     *
     * @param boolean $flag
     * @return DynamicPage
     */
    public function setFlag($flag) {
        $this->flag = $flag;

        return $this;
    }

    /**
     * Get flag
     *
     * @return boolean 
     */
    public function getFlag() {
        return $this->flag;
    }

    /**
      /**
     * Set image
     *
     * @param \MD\Bundle\MediaBundle\Entity\Image $image
     * @return DynamicPage
     */
    public function setImage(\MD\Bundle\MediaBundle\Entity\Image $image = null) {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \MD\Bundle\MediaBundle\Entity\Image 
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * Get Main Image
     *
     * @return MD\Bundle\MediaBundle\Entity\Image
     */
    public function getMainImage() {
        return $this->getImages(array(\MD\Bundle\MediaBundle\Entity\Image::TYPE_MAIN))->first();
    }

    /**
     * Add images
     *
     * @param \MD\Bundle\MediaBundle\Entity\Image $images
     * @return DynamicPage
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
    public function getImages() {
        return $this->images;
    }

}
