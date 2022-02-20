<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleType;
//use Doctrine\Common\Persistence\ObjectManager;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType; 
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $repo): Response
    {
        //$repo=$this->getDoctrine()->getRepository(Article::class);

        $articles=$repo->findAll();
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles'=>$articles,
        ]);

    }
     /**
     * @Route("/", name="home")
     */
    public function home(){
        return $this->render('blog/home.html.twig',[
            'title' =>"Bienvenu ici les amis !",
            'age' =>31
        ]);
    }

    /**
     * @Route("/blog/new", name="blog_create")
     * @Route("/blog/{id}/edit", name="blog_edit")
     */
    public function form(Article $article=null,Request $request , ObjectManager $manager){
        //dump($request);

       /* if($request->request->count()>0){
            $article= new Article();
            $article->setTitle($request->request->get('title'))
                    ->setContent($request->request->get('content'))
                    ->setImage($request->request->get('image'))
                    ->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('blog_show', ['id'=>$article->getId()]);
        }*/
        if(!$article){
            $article= new Article();
        }
        
        
       /* $article->setTitle("andrannana")
                ->setContent("Le contenuuu "); */

       /* $form=$this->createFormBuilder($article)
                   ->add('title')
                   ->add('content')
                   ->add('image')
                   ->getForm(); */
        $form=$this->createForm(ArticleType::class,$article);

        $form->handleRequest($request);

        dump($article);
        if($form->isSubmitted() && $form->isValid()){
            if(!$article->getId()){
                $article->setCreatedAt(new \DateTimeImmutable());
            }
           
            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('blog_show', ['id'=>$article->getId()]);
        }
        return $this->render('blog/create.html.twig',[
            'formArticle'=>$form->createView(),
            "editMode"=>$article->getId() !==null
        ]);
    }
     /**
     * @Route("/blog/{id}", name="blog_show")
     */
    public function show(/*ArticleRepository $repo , $id*/ Article $article,Request $request , ObjectManager $manager){
        $comment=new Comment();
        //$repo=$this->getDoctrine()->getRepository(Article::class);
        //$article=$repo->find($id);

        
        $form=$this->createForm(CommentType::class,$comment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
           
                $comment->setCreateAt(new \DateTimeImmutable())
                        ->setArticle($article);
            
           
            $manager->persist($comment);
            $manager->flush();

           // return $this->redirectToRoute('blog_show', ['id'=>$article->getId()]);
        }
        return $this->render('blog/show.html.twig',[
            "article"=>$article,
            "commentForm"=> $form->createView()
        ]);
    }

    
}
