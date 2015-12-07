<?php 

// src\TM\BlogBundle\Controller\FootSelectController.php

namespace TM\BlogBundle\Controller;

//use TM\BlogBundle\Entity\Article;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException; // [Appeler la methode isGranted]
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class FootSelectController extends Controller
{
	public function SelectAction()
	{
	    $em = $this->getDoctrine()->getManager();

	    $footCats = $em->getRepository('TMBlogBundle:Subcategory')->full();

	    return $this->render('TMBlogBundle:Article:foot_select.html.twig', array(
		  'footCats' => $footCats
		));
	}
}