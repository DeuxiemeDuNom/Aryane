<?php 

// src\TM\BlogBundle\Controller\MerciController.php

namespace TM\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class MerciController extends Controller
{
    /**
     * Enregistre les produits d'un panier dans une session commande
     */
    public function commandeAction(Request $request)
    {
        $session = $this->get('session');
        $panier = $session->get('panier');
        $display = false;
        $commande = null;
        $post = array();

        /*======================= Champs du Formulaire dans un tableau en attaente =======================*/

        $pays = $this->getRequest()->get('pays');
        $prenom = $this->getRequest()->get('prenom');
        $nom = $this->getRequest()->get('nom');
        $entreprise = $this->getRequest()->get('entreprise');
        $adresse = $this->getRequest()->get('adresse');
        $batiment = $this->getRequest()->get('batiment');
        $ville = $this->getRequest()->get('ville');
        $code_postal = $this->getRequest()->get('code_postal');
        $email = $this->getRequest()->get('email');
        $tel = $this->getRequest()->get('tel');
        $comments = $this->getRequest()->get('comments');

        $checkout = $this->getRequest()->get('checkout');

        array_push($post, array(
            'pays' => $pays, /**/
            'prenom' => $prenom, /**/
            'nom' => $nom, /**/
            'entreprise' => $entreprise,
            'adresse' => $adresse, /**/
            'batiment' => $batiment,
            'ville' => $ville, /**/
            'code_postal' => $code_postal, /**/
            'email' => $email, /**/
            'tel' => $tel, /**/
            'comments' => $comments,
        ));

        /*======================= Champs du Formulaire dans un tableau en attaente =======================*/

        if(empty($panier)){
            $session->getFlashBag()->add('error', array('type'=>'danger', 'msg'=> 'Le panier est vide!!!'));

            $referer = $request->headers->get('referer');
            return new RedirectResponse($referer);
        }else{

            if(     ($pays == "") 
                ||  ($prenom == "")
                ||  ($nom == "")
                ||  ($adresse == "")
                ||  ($ville == "")
                ||  ($code_postal == "")
                ||  ($email == "")
                ||  ($tel == "")
            ){
                $session->getFlashBag()->add('error', array('type'=>'danger', 'msg'=> 'Veuillez remplir tous les champs.'));

                if(!$session->has('formulaire')){
                    $session->set('formulaire', array());
                }

                $session->set('formulaire', array());

                $formulaire = $session->get('formulaire');

                $formulaire = $post;

                $session->set('formulaire', $formulaire);
                
                $referer = $request->headers->get('referer');
                return new RedirectResponse($referer);
            }


            /* ====================== Le cas du formulaire est réglé... ====================== */

            $session->set('formulaire', array());

            if(!$session->has('commande')){
                $session->set('commande', array()); 
            }

            $commande = $session->get('commande');

            array_push($commande, array(new \Datetime, $panier, $post));

            $session->set('commande', $commande);
            
            $session->set('panier', array());

            $session->getFlashBag()->add('success', array(
                'type'=>'success', 
                'msg'=> 'Votre commande a été enregistrée avec succès! Vous pouvez la consulter à partir du menu "Mes Commandes".'));

            // |||||||||||||||||||||||||||||||||| REDIRECTION ||||||||||||||||||||||||||||||||||||

            return $this->render('TMBlogBundle:Article:merci.html.twig');
        }
    }
}