<?php 

// src\TM\BlogBundle\Controller\NavController.php

namespace TM\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException; // [Appeler la methode isGranted]
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class NavController extends Controller
{
	public function menuAction()
	{
	    $em = $this->getDoctrine()->getManager();

	    $cat1 = 'Bijoux';
	    $cat2 = 'Couture';
	    $cat3 = 'Fimo & Porcelaine';

	    $bijoux = $em->getRepository('TMBlogBundle:Subcategory')->nav($cat1);
	    $coutures = $em->getRepository('TMBlogBundle:Subcategory')->nav($cat2);
	    $fimos = $em->getRepository('TMBlogBundle:Subcategory')->nav($cat3);

	    return $this->render('TMBlogBundle:Article:menu.html.twig', array(
		  'bijoux' => $bijoux,
		  'coutures' => $coutures,
		  'fimos' => $fimos,
		  'cat1' => $cat1,
		  'cat2' => $cat2,
		  'cat3' => $cat3,
		));
	}
}