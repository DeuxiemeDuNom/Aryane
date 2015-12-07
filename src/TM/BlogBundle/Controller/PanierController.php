<?php

// src/TM/BlogBundle/Controller/PanierController.php

namespace TM\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PanierController extends Controller
{
    public function panierAction()
    {
        $em = $this->getDoctrine()->getManager();


        $session = $this->get('session');

        $panier = $session->get('panier');


        if(is_null($panier)){
            $articles = false;
        }else{
            $sess_id = array_column($panier, 'id');
            $articles = true;
        }

        $autres = $em->getRepository('TMBlogBundle:Article')->newz(4);
        $commentaires = $em->getRepository('TMBlogBundle:Comment')->all(4);
        

        return $this->render('TMBlogBundle:Panier:panier.html.twig', array(
            'commentaires' => $commentaires,
            'articles' => $articles,
            'autres' => $autres,
            'panier' => $panier,
        ));
    }

    public function validationAction()
    {
        $em = $this->getDoctrine()->getManager();

        $session = $this->get('session');

        $panier = $session->get('panier');


        if(empty($panier)){
            $session->getFlashBag()->add('error', array('type'=>'danger', 'msg'=> 'Le panier est vide!!!'));

            return $this->redirect($this->generateUrl('tm_blog_panier'));
        }else{
            $sess_id = array_column($panier, 'id');
            $articles = true;
        }

        $autres = $em->getRepository('TMBlogBundle:Article')->newz(4);
        $commentaires = $em->getRepository('TMBlogBundle:Comment')->all(4);

        return $this->render('TMBlogBundle:Panier:validation.html.twig', array(
            'autres' => $autres,
            'commentaires' => $commentaires,
            'panier' => $panier,
        ));
    }

    /**
     * Récupère et Affiche le contenu des commandes en cours
     */
    public function commandeListAction(Request $request)
    {
        $session = $this->get('session');
        $title = 'Mes commandes';
        $display = false;
        $commande_list = null;

        if(!$session->has('commande')){
             $session->getFlashBag()->add('error', array('type'=>'danger', 'msg'=> 'Aucune commande en cours...'));
        }else{

            $commande_list = $session->get('commande');

            $display = true;
        }

        return $this->render('TMBlogBundle:Panier:commande.html.twig', array(
          'display' => $display,
          'title' => $title,
          'commande_list' => $commande_list,
        ));
    }
}