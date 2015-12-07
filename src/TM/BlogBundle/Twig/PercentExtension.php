<?php 

namespace TM\BlogBundle\Twig;

class PercentExtension extends \Twig_Extension {

	public function getFilters() {
      return array(
           new \Twig_SimpleFilter('promo', array($this, 'calculPourcentage')),
      );
    }

    public function calculPourcentage($price, $pourcentage){
    	$price = (int) $price;
    	$pourcentage = (int) $pourcentage;

    	$result = $price * (1 + $pourcentage/100); // Pour une augmentation

    	return $result;
    }

    public function getName()
    {
        return 'app_extension';
    }
}