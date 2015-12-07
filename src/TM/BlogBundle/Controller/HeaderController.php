<?php 

// src\TM\BlogBundle\Controller\HeaderController.php

namespace TM\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HeaderController extends Controller
{
	public function panierAction()
	{

	 	$session = $this->get('session');

        $panier = $session->get('panier');


	    return $this->render('TMBlogBundle:Article:header_cart.html.twig', array(
		  'panier' => $panier,
		));
	}

	public function merciAction()
	{
	    $session = $this->get('session');

	    if(!$session->has('commande')){
	    	$session->getFlashBag()->add('error', array('type'=>'warning', 'msg'=> 'Spoiler alert!!! Je peux pas vous laisser faire ça. Passez commande d\'abord. ;)'));
           	return $this->redirect($this->generateUrl('tm_blog_home'));
        }

	    return $this->render('TMBlogBundle:Article:merci.html.twig');
	}
}