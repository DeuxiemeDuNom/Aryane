<?php 

// src\TM\BlogBundle\Controller\AutreController.php

namespace TM\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException; // [Appeler la methode isGranted]
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AutreController extends Controller
{
	public function alsoAction($subcat, Request $request, $limit = 3)
	{
	    /* ======================== Comparaison ids ======================== */

	    $incart = array();
	    if(!is_null($this->get('session'))){
	      $session = $this->get('session');
	      $panier = $session->get('panier');
	      if(!empty($panier)){
	          foreach ($panier as $key => $value) {
	              array_push($incart, $panier[$key]['id']);
	          }
	      }
	    }

	    /* ======================== Comparaison ids ======================== */

	    $em = $this->getDoctrine()->getManager();

	    $autres = $em->getRepository('TMBlogBundle:Article')->also($subcat);

	    return $this->render('TMBlogBundle:Article:also.html.twig', array(
	      'autres' => $autres,
		  'incart' => $incart,
		));
	}

	public function interestAction(Request $request, $limit = 2)
	{
	    /* ======================== Comparaison ids ======================== */

	    $incart = array();
	    if(!is_null($this->get('session'))){
	      $session = $this->get('session');
	      $panier = $session->get('panier');
	      if(!empty($panier)){
	          foreach ($panier as $key => $value) {
	              array_push($incart, $panier[$key]['id']);
	          }
	      }
	    }

	    /* ======================== Comparaison ids ======================== */

	    $em = $this->getDoctrine()->getManager();

	    $max = $em->getRepository('TMBlogBundle:Article')->compte();

	    $id1 = rand(0, $max);
	    $id2 = rand(0, $max);

	    while($id1 == $id2){
	    	$id2 = rand(0, $max);
	    	break;
	    }

	    $list = array($id1, $id2);
	    $autres = $em->getRepository('TMBlogBundle:Article')->findById($list);

	    return $this->render('TMBlogBundle:Article:interest.html.twig', array(
		  'autres' => $autres,
		  'incart' => $incart,
		  'list' => $list,
		));
	}
}