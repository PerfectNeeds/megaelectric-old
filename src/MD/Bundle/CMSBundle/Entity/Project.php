<?php

namespace MD\Bundle\CMSBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Project
 *
 * @ORM\Table("project")
 * @ORM\Entity()
 */
class Project {

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
     * @Assert\NotBlank()
     * @ORM\Column(name="title", type="string", length=100)
     */

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="title", type="string", length=100)
     */
    private $title;

    /**
     *
     * @ORM\Column(name="hidden", type="boolean", options={"default" = 0}))
     */
    private $hidden = false;

    /**
     * @ORM\ManyToOne(targetEntity="OurSolution", inversedBy="projects")
     */
    protected $project;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set hidden
     *
     * @param boolean $hidden
     * @return Project
     */
    public function setHidden($hidden) {
        $this->hidden = $hidden;

        return $this;
    }

    /**
     * Get hidden
     *
     * @return boolean 
     */
    public function getHidden() {
        return $this->hidden;
    }

    /**
     * Set project
     *
     * @param \MD\Bundle\CMSBundle\Entity\OurSolution $project
     * @return Project
     */
    public function setProject(\MD\Bundle\CMSBundle\Entity\OurSolution $project = null) {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return \MD\Bundle\CMSBundle\Entity\OurSolution 
     */
    public function getProject() {
        return $this->project;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Project
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

}
