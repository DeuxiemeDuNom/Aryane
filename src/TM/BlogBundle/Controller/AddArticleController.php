<?php 

// src\TM\BlogBundle\Controller\AddArticleController.php

namespace TM\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AddArticleController extends Controller
{
	/**
     * Ajoute un produit unique au panier
     */
    public function ajouterAction(Request $request)
	{
	    $session = $this->get('session');

        if(!$session->has('panier')){
            
            $session->set('panier', array()); 
        }

        $panier = $session->get('panier');

        $id = $this->getRequest()->query->get('id');
        $price = $this->getRequest()->query->get('price');
        $name = $this->getRequest()->query->get('name');
        if(is_null($this->getRequest()->query->get('qte'))){
            $qte = 1;
        }else{
            $qte = $this->getRequest()->query->get('qte');
        }

        $pusha = array('id' => $id,'qte' => $qte,'price' => $price,'name' => $name);

        $verif = array();
        $check = null; 
       

        if(empty($panier)){
            array_push($panier, $pusha);
        }else{
            foreach ($panier as $key => $value) {
                if(isset($panier[$key]['id']) && $panier[$key]['id'] == $id){
                    $panier[$key]['qte'] = $qte;
                    array_push($verif, 'STOP');
                }
                elseif($panier[$key]['id'] !== $id){
                    array_push($verif, 'RAS');
                }
            }
        }

        while ($verif_state = current($verif)) {
            if ($verif_state == 'RAS') {
                 $check = 'RAS';
            }else{
                $check = 'STOP';
                break;
            }
            next($verif);
        }

        if($check == 'RAS'){
            array_push($panier, $pusha);
        }

        $session->set('panier', $panier);

        // |||||||||||||||||||||||||||||||||| REDIRECTION ||||||||||||||||||||||||||||||||||||

        $referer = $request->headers->get('referer');
        return new RedirectResponse($referer);
	}

    /**
     * Vide entierement le panier
     */
    public function viderAction(Request $request)
    {
        $session = $this->get('session');

            
        $session->set('panier', array());

        $referer = $request->headers->get('referer');
        return new RedirectResponse($referer);
    }

    /**
     * Retire un produit unique du panier
     */
    public function removeAction(Request $request)
    {
        $session = $this->get('session');
        $panier = $session->get('panier');
        $id = $this->getRequest()->query->get('id');

        if(is_null($panier)){
            $session->getFlashBag()->add('error', array('type'=>'danger', 'msg'=> 'Le panier est vide!!!'));
        }else{
            
            foreach ($panier as $key => $value) {
                if($panier[$key]['id'] == $id){
                    unset($panier[$key]);
                }
            }

            $session->set('panier', $panier);
        }

        $referer = $request->headers->get('referer');
        return new RedirectResponse($referer);
    }
}