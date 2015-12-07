<?php
// src/TM/UserBundle/Entity/User.php

/*
Plus besoin d'implémenter UserInterface, car on hérite de l'entité User du bundle FOSUB, 
qui, elle, implémente cette interface. 
Pas besoin non plus d'écrire tous les setters et getters, 
ils sont tous hérités, même le getter getId !
*/

namespace TM\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @ORM\OneToMany(targetEntity="TM\BlogBundle\Entity\Comment", mappedBy="user")
   */
  protected $comments;

    /**
     * Add comment
     *
     * @param \TM\BlogBundle\Entity\Comment $comment
     *
     * @return User
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
}
