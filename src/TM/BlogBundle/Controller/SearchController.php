<?php 

// src\TM\BlogBundle\Controller\SearchController.php

namespace TM\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SearchController extends Controller
{
  public function searchAction(Request $request)
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

    $keyword = $this->getRequest()->query->get('keyword');
    $new_search = true;

    $title = 'Resultat de votre recherche';

    $em = $this->getDoctrine()->getManager();

    $dql = "SELECT a FROM TMBlogBundle:Article a WHERE a.name LIKE '%". $keyword ."%'";
    $query = $em->createQuery($dql);

    if(empty($query->getResult())){
        $dql = "SELECT a FROM TMBlogBundle:Article a WHERE a.description LIKE '%". $keyword ."%'";
        $query = $em->createQuery($dql);
    }

    $paginator  = $this->get('knp_paginator');
    $pagination = $paginator->paginate(
        $query,
        $request->query->get('page', 1)/*page number*/,
        12/*limit per page*/
    );

    // parameters to template
    return $this->render('TMBlogBundle:Article:detail.html.twig', array(
      'title' => $title,
      'pagination' => $pagination,
      'incart' => $incart,
      'new_search' => $new_search,
    ));
  }
}
