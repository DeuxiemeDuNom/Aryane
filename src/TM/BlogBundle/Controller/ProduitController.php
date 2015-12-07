<?php

// src/TM/BlogBundle/Controller/ProduitController.php

namespace TM\BlogBundle\Controller;

use TM\BlogBundle\Entity\Article;
use TM\BlogBundle\Entity\Comment;

use TM\BlogBundle\Entity\ArticleRepository;
use TM\UserBundle\Entity\UserRepository;

use TM\BlogBundle\Form\CommentType; 

use Symfony\Bundle\FrameworkBundle\Controller\Controller; // [!!!]
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProduitController extends Controller
{
    public function produitAction()
    {
        return $this->render('TMBlogBundle:Produit:produit.html.twig');
    }

    public function presentationAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

	    // On récupère L'article $id
	    $article = $em->getRepository('TMBlogBundle:Article')->find($id);
	    $userId = $this->get('security.token_storage')->getToken()->getUser();
	    $user = $em->getRepository('TMUserBundle:User')->findOneById($userId);
	    $commentaires = $em->getRepository('TMBlogBundle:Comment')->last($id, 4);

	    $autres = $em->getRepository('TMBlogBundle:Article')->newz(4);

	    if (null === $article) {
	      throw new NotFoundHttpException("L'article d'id ".$id." n'existe pas.");
	    }

	    $comment = new Comment();
	    $comment->setUser($user);
	    $comment->setArticle($article);

	    $form = $this->createForm(new CommentType(), $comment);

	    if ($form->handleRequest($request)->isValid()) {
	      $em = $this->getDoctrine()->getManager();
	      $em->persist($comment);
	      $em->flush();

	      $request->getSession()->getFlashBag()->add('success', array('type'=>'success', 'msg'=> 'Votre avis compte. Merci!'));

	      return $this->redirect($this->generateUrl('tm_blog_presentation', array('id' => $article->getId())));
	    }

	    return $this->render('TMBlogBundle:Produit:presentation.html.twig', array(
	    	'article'=>$article,
	    	'autres'=>$autres,
	    	'commentaires'=>$commentaires,
	    	'form' => $form->createView(),
		));
	}
}