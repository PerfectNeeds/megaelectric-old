<?php

namespace MD\Bundle\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MD\Bundle\MediaBundle\Entity\Image as Image;
use MD\Utils as Utils;

/**
 * OurSolution
 *
 * @ORM\Table("our_solution")
 * @ORM\Entity()
 */
class OurSolution {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=45)
     */
    protected $title;

    /**
     * @var string
     * @ORM\Column(name="htmlSlug", type="string", length=255, unique=true)
     */
    protected $htmlSlug;

    /**
     * @var string
     *
     * @ORM\Column(name="youtube_url", type="string", length=255)
     */
    private $youtubeUrl;

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
     * @ORM\ManyToMany(targetEntity="\MD\Bundle\MediaBundle\Entity\Document")
     */
    protected $documents;

    /**
     * @ORM\OneToMany(targetEntity="Project", mappedBy="project", cascade={"remove"})
     */
    protected $projects;

    /**
     * Constructor
     */
    public function __construct() {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
        $this->documents = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString() {
        return $this->title;
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
     * @return OurSolution
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
     * Set htmlSlug
     *
     * @param string $htmlSlug
     * @return OurSolution
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
     * @return OurSolution
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
     * Set content
     *
     * @param string $content
     * @return OurSolution
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
     * @return OurSolution
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
     * Add documents
     *
     * @param \MD\Bundle\MediaBundle\Entity\Document $documents
     * @return OurSolution
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
     * Add projects
     *
     * @param \MD\Bundle\CMSBundle\Entity\Project $projects
     * @return OurSolution
     */
    public function addProject(\MD\Bundle\CMSBundle\Entity\Project $projects) {
        $this->projects[] = $projects;

        return $this;
    }

    /**
     * Remove projects
     *
     * @param \MD\Bundle\CMSBundle\Entity\Project $projects
     */
    public function removeProject(\MD\Bundle\CMSBundle\Entity\Project $projects) {
        $this->projects->removeElement($projects);
    }

    /**
     * Get projects
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProjects() {
        return $this->projects;
    }

}
