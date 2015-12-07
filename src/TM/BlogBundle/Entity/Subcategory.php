<?php

namespace TM\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Subcategory
 *
 * @ORM\Table(name="subcategory")
 * @ORM\Entity(repositoryClass="TM\BlogBundle\Entity\SubcategoryRepository")
 */
class Subcategory
{
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     *  @ORM\ManyToOne(targetEntity="TM\BlogBundle\Entity\Category")
     *  @ORM\JoinColumn(nullable=false)
     */
    protected $category;

    // ==================================================================================================================


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Subcategory
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set category
     *
     * @param \TM\BlogBundle\Entity\Category $category
     *
     * @return Subcategory
     */
    public function setCategory(\TM\BlogBundle\Entity\Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \TM\BlogBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }
}
