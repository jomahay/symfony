<?php

namespace App\Controller\admin;

use App\Entity\Property;
#use Twig\Environment;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminPropertyController  extends AbstractController{

     /**
     *  @var PropertyRepository
     */
    private $repository ;
    /**
      *  @var ObjectManager
      */
      private $em ;
    public function __construct(PropertyRepository $repository,ObjectManager $em) {
        $this->repository=$repository;
        $this->em=$em;
    }

     /**
     * @Route("/admin", name="admin.property.index")
     * @return Response
     */
    public function index(/*PropertyRepository $repository*/){
        //$repository=$this->getDoctrine()->getRepository(Property::class);
        $properties=$this->repository->findAll();
        //$property[0]->setSold(true);
        //dump($property);
        //$this->em->flush(); 
        return $this->render('admin/property/index.html.twig',compact('properties'));
    }
    /**
     * @Route("/admin/property/new", name="admin.property.new")
     * 
     */
    public function new(Request $request){
       $property=new Property();
       $form=$this->createForm(PropertyType::class,$property);

       $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()){
           $this->em->persist($property);
           $this->em->flush();

           return $this->redirectToRoute('admin.property.index');
       }
       return $this->render('admin/property/new.html.twig',[
        'property'=>$property,
        'form'=>$form->createView(),
    
    ]);
    }
    /**
     * @Route("/admin/property/{id}", name="admin.property.edit",methods="GET|POST")
     * @return Response
     */
    public function edit(Property $property,Request $request ):Response{
        //$repository=$this->getDoctrine()->getRepository(Property::class);
        $form=$this->createForm(PropertyType::class,$property);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $this->em->flush();

            return $this->redirectToRoute('admin.property.index');
        }
        //$property[0]->setSold(true);
        //dump($property);
        //$this->em->flush(); 
        return $this->render('admin/property/edit.html.twig',[
            'property'=>$property,
            'form'=>$form->createView(),
        
        ]);
    }
     /**
     * @Route("/admin/propertydel/{id}", name="admin.property.delete")
     * 
     */
    public function delete(Property $property,Request $request){

       // return new Response("suppression");

        $this->em->remove($property);
        $this->em->flush();   
        $this->addFlash("success","vogfafafaf");

        return $this->redirectToRoute('admin.property.index');
        
       /* if($this->isCsrfTokenValid('delete',$property->getId(),$request->get('_token'))){
            $this->em->remove($property);
            $this->em->flush();    
            return new Response("suppression");
        }*/
        
       // return new Response("suppression");
        //return $this->redirectToRoute('admin.property.index');
        
    }

}