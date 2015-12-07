<?php

// src/TM/BlogBundle/Controller/ArticleController.php

namespace TM\BlogBundle\Controller;

use TM\BlogBundle\Entity\Article;
use TM\BlogBundle\Entity\Image;
use TM\BlogBundle\Entity\Category;
use TM\BlogBundle\Entity\Subcategory;
use TM\BlogBundle\Entity\Contact;

use TM\BlogBundle\Form\ArticleType; // [Charger ArticleType]
use TM\BlogBundle\Form\ArticleEditType; // [Charger ArticleType]
use TM\BlogBundle\Form\ImageType; 
use TM\BlogBundle\Form\ContactType; 

use Symfony\Bundle\FrameworkBundle\Controller\Controller; // [!!!]
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException; // [Appeler la methode isGranted]
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security; // [Securiser accès par annotation]


class ArticleController extends Controller
{
  protected $siteName = "Aryane.net";
  
  public function indexAction()
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
    $lasts = $em->getRepository('TMBlogBundle:Article')->last(5);

    return $this->render('TMBlogBundle:Article:index.html.twig', array(
      'lasts' => $lasts,
      'incart' => $incart,
    ));
  }

  /**
   * @Security("has_role('ROLE_ADMIN')")
   */
  public function addAction(Request $request)
  {
    $article = new Article();
    $form = $this->createForm(new ArticleType(), $article);

    if ($form->handleRequest($request)->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($article);
      $em->flush();

      $request->getSession()->getFlashBag()->add('info', 'Article bien enregistré.');

      return $this->redirect($this->generateUrl('tm_blog_presentation', array('id' => $article->getId())));
    }

    return $this->render('TMBlogBundle:Article:add.html.twig', array(
      'form' => $form->createView(),
    ));
  }

  /**
   * @Security("has_role('ROLE_ADMIN')")
   */
  public function editAction($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    // On récupère L'article $id
    $article = $em->getRepository('TMBlogBundle:Article')->find($id);

    if (null === $article) {
      throw new NotFoundHttpException("L'article d'id ".$id." n'existe pas.");
    }

    $form = $this->createForm(new ArticleEditType(), $article);

    if ($form->handleRequest($request)->isValid()) {
      $em->flush();

      $request->getSession()->getFlashBag()->add('error', array(
        'type'=>'success', 
        'msg'=> 'Bien modifié !'));

      return $this->redirect($this->generateUrl('tm_blog_presentation', array('id' => $article->getId())));
    }else{
      $request->getSession()->getFlashBag()->add('error', array(
        'type'=>'danger', 
        'msg'=> 'Non modifié...'));
    }

    return $this->render('TMBlogBundle:Article:edit.html.twig', array(
      'form'   => $form->createView(),
      'article' => $article
    ));
  }

  /**
   * @Security("has_role('ROLE_ADMIN')")
   */
  public function deleteAction($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    // On récupère L'article $id
    $article = $em->getRepository('TMBlogBundle:Article')->find($id);

    if (null === $article) {
      throw new NotFoundHttpException("L'article d'id ".$id." n'existe pas.");
    }

    $form = $this->createFormBuilder()->getForm();

    if ($form->handleRequest($request)->isValid()) {
      $em->remove($article);
      $em->flush();

      $request->getSession()->getFlashBag()->add('info', "L'article a bien été supprimé.");

      return $this->redirect($this->generateUrl('tm_blog_home'));
    }

    return $this->render('TMBlogBundle:Article:delete.html.twig', array(
      'article' => $article,
      'form'   => $form->createView()
    ));
  }

  public function subcatsAction($cat, Request $request)
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

    $title = $cat;

    $new_search = true;

    $em = $this->getDoctrine()->getManager();

    $subcategory = $em->getRepository('TMBlogBundle:Subcategory')->findByCat($cat);

    if($subcategory == null){
      return $this->redirect($this->generateUrl('tm_blog_cats'));
    }

    $query = $em->getRepository('TMBlogBundle:Article')->filter($cat);
    ////////////////////////////////////////////////
    // PAGINATOR

    $paginator  = $this->get('knp_paginator');
    $pagination = $paginator->paginate(
        $query,
        $request->query->get('page', 1)/*page number*/,
        4/*limit per page*/
    );

    ////////////////////////////////////////////////
    // parameters to template
    return $this->render('TMBlogBundle:Article:detail.html.twig', array(
      'subcategory' => $subcategory,
      'pagination' => $pagination,
      'title' => $title,
      'incart' => $incart,
      'new_search' => $new_search,
    ));
  }

  public function detailAction($subcat, Request $request)
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

    $title = $subcat;

    $new_search = true;

    $em = $this->getDoctrine()->getManager();

    $verif = $em->getRepository('TMBlogBundle:Subcategory')->findByName($subcat);

    if($verif == null){
      return $this->redirect($this->generateUrl('tm_blog_cats'));
    }

    $query = $em->getRepository('TMBlogBundle:Article')->detail($subcat);
    ////////////////////////////////////////////////
    // PAGINATOR

    $paginator  = $this->get('knp_paginator');
    $pagination = $paginator->paginate(
        $query,
        $request->query->get('page', 1)/*page number*/,
        4/*limit per page*/
    );

    ////////////////////////////////////////////////
    // parameters to template
    return $this->render('TMBlogBundle:Article:detail.html.twig', array(
      'pagination' => $pagination,
      'title' => $title,
      'incart' => $incart,
      'new_search' => $new_search,
    ));
  }

  public function globalAction(Request $request)  // Completer requete dql... et afficher le nom de la table/sous-categorie
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

    $title = 'Collection';

    $em = $this->getDoctrine()->getManager();

    $dql   = "SELECT a FROM TMBlogBundle:Article a";
    $query = $em->createQuery($dql);

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
    ));
  }

  public function contactAction(Request $request)
  {
    $contact = new Contact();
    $form = $this->createForm(new ContactType(), $contact);

    if ($form->handleRequest($request)->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($contact);
      $em->flush();

      $request->getSession()->getFlashBag()->add('info', 'Votre message a bien enregistré.');

      return $this->redirect($this->generateUrl('tm_blog_home'));
    }

    return $this->render('TMBlogBundle:Article:contact.html.twig', array(
      'form' => $form->createView(),
    ));
  }

  /**
   * @Security("has_role('ROLE_ADMIN')")
   */
  public function viewContactAction(Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    $dql   = "SELECT c FROM TMBlogBundle:Contact c ORDER BY c.date DESC";
    $query = $em->createQuery($dql);

    $paginator  = $this->get('knp_paginator');
    $pagination = $paginator->paginate(
        $query,
        $request->query->get('page', 1)/*page number*/,
        4/*limit per page*/
    );

    if (null === $pagination) {
      throw new NotFoundHttpException("Etrange mais je ne trouve aucun commentaire.");
    }

    return $this->render('TMBlogBundle:Article:voir_contact.html.twig', array(
      'pagination' => $pagination,
    ));
  }

  public function legalAction()
  {
    return $this->render('TMBlogBundle:Article:legal.html.twig');
  }

  public function aboutAction()
  {
    return $this->render('TMBlogBundle:Article:about.html.twig');
  }

  public function ciaoAction(Request $request)
  {
    $active = 'delete';
    $user = $this->getUser();
     
    if($user == null)
    {
        return $this->redirect($this->generateUrl('tm_blog_home'));
    }
     
    $form = $this->createFormBuilder()->getForm();
     
    if($form->handleRequest($request)->isValid())
    {
        $em = $this->getDoctrine()
                   ->getManager()
                   ;
                    
        $em->remove($user);
        $em->flush();
         
        $this->get('security.context')->setToken(null);
        $this->get('request')->getSession()->invalidate();
        
        
        $request->getSession()->getFlashBag()->add('error', array(
        'type'=>'info', 
        'msg'=> 'Votre profil a bien été supprimé... Vous nous manquez déja!'));
     
        return $this->redirect($this->generateUrl('tm_blog_home'));
    }
     
    return $this->render('TMBlogBundle:Article:delete_user.html.twig', array(
      'form'   => $form->createView()
    ));
  }

  /**
   * @Security("has_role('ROLE_ADMIN')")
   */
  public function shutUpAction(Request $request)
  {
    
    $em = $this->getDoctrine()->getManager();
    $form = null;
    $list = $em->getRepository('TMBlogBundle:Comment')->findAll();
    

    if(!is_null($this->getRequest()->get('id'))){
      $id = $this->getRequest()->get('id');

      $request->getSession()->getFlashBag()->add('error', array(
          'type'=>'info', 
          'msg'=> 'ID = '.$id));

      $comment = $em->getRepository('TMBlogBundle:Comment')->find($id); // Clear
       
      if($comment == null)
      {
          $request->getSession()->getFlashBag()->add('error', array(
          'type'=>'danger', 
          'msg'=> 'ID non trouvé...'));
          return $this->redirect($this->generateUrl('tm_blog_home'));
      }
       
      $form = $this->createFormBuilder()->getForm();
       
      if($comment != null)
      {            
          $em->remove($comment);
          $em->flush();
          
          $request->getSession()->getFlashBag()->add('error', array(
          'type'=>'info', 
          'msg'=> 'Post effacé!'));
       
          return $this->redirect($this->generateUrl('tm_blog_home'));
      }else{
         $request->getSession()->getFlashBag()->add('error', array(
          'type'=>'danger', 
          'msg'=> 'Requete non valide...')); // non valide
        return $this->render('TMBlogBundle:Article:delete_comment.html.twig', array(
            'form'   => $form->createView(),
            'list'   => $list,
          ));
      }
    }else{
      return $this->render('TMBlogBundle:Article:delete_comment.html.twig', array(
            'form'   => $form,
            'list'   => $list,
          ));
    }
  }
}