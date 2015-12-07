<?php 

// src\TM\BlogBundle\Controller\TestController.php

namespace TM\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class TestController extends Controller
{
	/**
     * Enregistre les produits d'un panier dans une session commande
     */
    public function testAction(Request $request)
    {
        $title = 'Test';

        $em = $this->getDoctrine()->getManager();

        //$rows = $em->getRepository('TMBlogBundle:Article')->compte();
        $compte = $em->getRepository('TMBlogBundle:Article')->compte();

        return $this->render('TMBlogBundle:Article:test.html.twig', array(
            'title' => $title,
        ));
    }
}
