<?php 

// src/TM/BlogBundle/DataFixtures/ORM/LoadCategory.php

namespace TM\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use TM\BlogBundle\Entity\Category;

class LoadCategory extends AbstractFixture implements OrderedFixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de catégorie à ajouter

    $category1 = new Category;
    $category1->setName('Bijoux');
    $manager->persist($category1);

    $category2 = new Category;
    $category2->setName('Couture');
    $manager->persist($category2);

    $category3 = new Category;
    $category3->setName('Fimo & Porcelaine');
    $manager->persist($category3);

    $manager->flush();

    $this->addReference('category1', $category1);
    $this->addReference('category2', $category2);
    $this->addReference('category3', $category3); 
  }

  public function getOrder()
  {
      return 1; // l'ordre dans lequel les fichiers sont chargés
  }
}