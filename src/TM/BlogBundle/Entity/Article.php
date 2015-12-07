<?php

namespace TM\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert; // [Valider les données]

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="TM\BlogBundle\Entity\ArticleRepository")
 */
class Article
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
     * @var integer
     *
     * @ORM\Column(name="ref", type="integer")
     */
    private $ref;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @ORM\OneToOne(targetEntity="TM\BlogBundle\Entity\Image", cascade={"persist"})
     */
    private $image;
    
    /**
     * @ORM\ManyToOne(targetEntity="TM\BlogBundle\Entity\Subcategory")
     * @ORM\JoinColumn(nullable=false)
     */
    private $subcategory;

    /**
     * @ORM\OneToMany(targetEntity="TM\BlogBundle\Entity\Comment", mappedBy="article", cascade={"remove"})
     */
    protected $comments;

    /**
     * @var integer
     *
     * @ORM\Column(name="price", type="integer")
     * @Assert\Type(
     *     type="integer",
     *     message="C'est un {{ type }} que je veux et {{ value }} n'en est pas un !"
     * )
     */
    private $price;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     * @Assert\DateTime()
     */
    private $date;

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
     * @return Article
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
     * Set ref
     *
     * @param integer $ref
     *
     * @return Article
     */
    public function setRef($ref)
    {
        $this->ref = $ref;

        return $this;
    }

    /**
     * Get ref
     *
     * @return integer
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Article
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set image
     *
     * @param \TM\BlogBundle\Entity\Image $image
     *
     * @return Article
     */
    public function setImage(\TM\BlogBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \TM\BlogBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set subcategory
     *
     * @param \TM\BlogBundle\Entity\Subcategory $subcategory
     *
     * @return Article
     */
    public function setSubcategory(\TM\BlogBundle\Entity\Subcategory $subcategory)
    {
        $this->subcategory = $subcategory;

        return $this;
    }

    /**
     * Get subcategory
     *
     * @return \TM\BlogBundle\Entity\Subcategory
     */
    public function getSubcategory()
    {
        return $this->subcategory;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->date = new \DateTime();
    }

    /**
     * Add comment
     *
     * @param \TM\BlogBundle\Entity\Comment $comment
     *
     * @return Article
     */
    public function addComment(\TM\BlogBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \TM\BlogBundle\Entity\Comment $comment
     */
    public function removeComment(\TM\BlogBundle\Entity\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Article
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Article
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}
