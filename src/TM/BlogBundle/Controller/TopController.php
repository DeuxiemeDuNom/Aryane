<?php 

// src\TM\BlogBundle\Controller\FootSelectController.php

namespace TM\BlogBundle\Controller;

//use TM\BlogBundle\Entity\Article;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException; // [Appeler la methode isGranted]
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class TopController extends Controller
{
	public function sellAction()
	{
	    $commentaires = null;
	    $em = $this->getDoctrine()->getManager();

	    $tops = $em->getRepository('TMBlogBundle:Article')->sell(3);

	    return $this->render('TMBlogBundle:Produit:top.html.twig', array(
		  'tops' => $tops,
		  'commentaires' => $commentaires,
		));
	}

	public function recentAction()
	{
	    $tops = null;
	    $em = $this->getDoctrine()->getManager();

	    $commentaires = $em->getRepository('TMBlogBundle:Comment')->all(3);

	    return $this->render('TMBlogBundle:Produit:top.html.twig', array(
		  'tops' => $tops,
		  'commentaires' => $commentaires,
		));
	}

	public function newAction()
	{
	    $commentaires = null;
	    $em = $this->getDoctrine()->getManager();

	    $tops = $em->getRepository('TMBlogBundle:Article')->newz(3);

	    return $this->render('TMBlogBundle:Produit:top.html.twig', array(
		  'tops' => $tops,
		  'commentaires' => $commentaires,
		));
	}

	public function fullSellAction(Request $request)  
  	{

	    $em = $this->getDoctrine()->getManager();
	    $title = 'Top des Ventes';
	    $autres = $em->getRepository('TMBlogBundle:Article')->newz(4);
        $commentaires = $em->getRepository('TMBlogBundle:Comment')->all(4);

	    if(($this->getRequest()->get('prix')) && ($this->getRequest()->get('prix') == 'desc')){
	    	$dql   = "SELECT a FROM TMBlogBundle:Article a ORDER BY a.price DESC";
	    }
	    elseif(($this->getRequest()->get('prix')) && ($this->getRequest()->get('prix') == 'asc')){
	    	$dql   = "SELECT a FROM TMBlogBundle:Article a ORDER BY a.price ASC";
	    }else{
	    	$dql   = "SELECT a FROM TMBlogBundle:Article a ORDER BY a.name DESC";
	    }

	    $query = $em->createQuery($dql);

	    $paginator  = $this->get('knp_paginator');
	    $pagination = $paginator->paginate(
	        $query,
	        $request->query->get('page', 1)/*page number*/,
	        10/*limit per page*/
	    );

	    // parameters to template
	    return $this->render('TMBlogBundle:Article:detail2.html.twig', array(
	      'title' => $title,
	      'pagination' => $pagination,
	      'commentaires' => $commentaires,
          'autres' => $autres,
	    ));
  	}

  	public function fullNewAction(Request $request)  
  	{

	    $em = $this->getDoctrine()->getManager();
	    $title = 'Nouveauté';
	    $autres = $em->getRepository('TMBlogBundle:Article')->newz(4);
        $commentaires = $em->getRepository('TMBlogBundle:Comment')->all(4);

	    if(($this->getRequest()->get('prix')) && ($this->getRequest()->get('prix') == 'desc')){
	    	$dql   = "SELECT a FROM TMBlogBundle:Article a ORDER BY a.price DESC";
	    }
	    elseif(($this->getRequest()->get('prix')) && ($this->getRequest()->get('prix') == 'asc')){
	    	$dql   = "SELECT a FROM TMBlogBundle:Article a ORDER BY a.price ASC";
	    }else{
	    	$dql   = "SELECT a FROM TMBlogBundle:Article a ORDER BY a.id DESC";
	    }

	    $query = $em->createQuery($dql);

	    $paginator  = $this->get('knp_paginator');
	    $pagination = $paginator->paginate(
	        $query,
	        $request->query->get('page', 1)/*page number*/,
	        10/*limit per page*/
	    );

	    // parameters to template
	    return $this->render('TMBlogBundle:Article:detail2.html.twig', array(
	      'title' => $title,
	      'pagination' => $pagination,
	      'commentaires' => $commentaires,
          'autres' => $autres,
	    ));
  	}
}