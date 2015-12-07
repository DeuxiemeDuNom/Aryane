<?php 

// src/TM/BlogBundle/DataFixtures/ORM/LoadSubcategory.php

namespace TM\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use TM\BlogBundle\Entity\Subcategory;

class LoadSubcategory extends AbstractFixture implements OrderedFixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de catégorie à ajouter

    //=================================================

    $sub1 = new Subcategory;
    $sub1->setName('Bagues');
    $sub1->setCategory($this->getReference('category1'));
    $manager->persist($sub1);

    $sub2 = new Subcategory;
    $sub2->setName('Bracelets');
    $sub2->setCategory($this->getReference('category1'));
    $manager->persist($sub2);
    
    $sub3 = new Subcategory;
    $sub3->setName('Boucles d\'oreilles');
    $sub3->setCategory($this->getReference('category1'));
    $manager->persist($sub3);

    $sub4 = new Subcategory;
    $sub4->setName('Colliers');
    $sub4->setCategory($this->getReference('category1'));
    $manager->persist($sub4);

    //=================================================

    $sub5 = new Subcategory;
    $sub5->setName('Compagnon de sac');
    $sub5->setCategory($this->getReference('category2'));
    $manager->persist($sub5);

    $sub6 = new Subcategory;
    $sub6->setName('Organiseur de sac');
    $sub6->setCategory($this->getReference('category2'));
    $manager->persist($sub6);
    
    $sub7 = new Subcategory;
    $sub7->setName('Porte-monnaie');
    $sub7->setCategory($this->getReference('category2'));
    $manager->persist($sub7);
    
    $sub8 = new Subcategory;
    $sub8->setName('Trousses');
    $sub8->setCategory($this->getReference('category2'));
    $manager->persist($sub8);

    //=================================================

    $sub9 = new Subcategory;
    $sub9->setName('Animaux');
    $sub9->setCategory($this->getReference('category3'));
    $manager->persist($sub9);

    $sub10 = new Subcategory;
    $sub10->setName('Figurines');
    $sub10->setCategory($this->getReference('category3'));
    $manager->persist($sub10);

    $manager->flush();

    // ALTER TABLE subcategory AUTO_INCREMENT = 1;
  }

  public function getOrder()
  {
    return 2; // l'ordre dans lequel les fichiers sont chargés
  }
}