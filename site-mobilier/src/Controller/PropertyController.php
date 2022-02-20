<?php

namespace App\Controller;

use App\Entity\Property;
#use Twig\Environment;
use App\Repository\PropertyRepository;
use Doctrine\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropertyController  extends AbstractController{
    
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
     * @Route("/biens", name="property.index")
     * @return Response
     */
    public function index(/*PropertyRepository $repository*/PaginatorInterface $paginator,Request $request):Response{
        //$repository=$this->getDoctrine()->getRepository(Property::class);
        $property=$paginator->paginate($this->repository->findAllVisible()
    ,$request->query->getInt('page', 1), /*page number*/
    10);
        //$property[0]->setSold(true);
        //dump($property);
        $this->em->flush(); 
        /*$property=new Property();
        $property->setTitle("voloany hahah")
                 ->setPrice(200000)
                 ->setDescription("lololo lololo")
                 ->setSurface(300)
                 ->setRooms(5)
                 ->setBedrooms(30)
                 ->setFloor(6)
                 ->setHeat(1)
                 ->setCity("tana")
                 ->setAddress("lolo lolo")
                 ->setPostalCode("tyty");
        
       $manag= $this->getDoctrine()->getManager();
       $manag->persist($property);
       $manag->flush(); */
                // ->setCreatedAt(new \DateTime());
        return $this->render('property/index.html.twig',[
            'current_menu'=>'properties',
            "properties"=>$property
        ]);
    }

    /**
     * @Route("/biens/{slug}-{id}", name="property.show",requirements={"slug":"[a-z0-9\-]*"})
     * @return Response
     */
    public function show(/*PropertyRepository $repository*//*$slug,$id*/Property $property,string $slug):Response{
        //$repository=$this->getDoctrine()->getRepository(Property::class);
        
        if($property->getSlug()!==$slug){

            return $this->redirectToRoute("property.show",[
               "id"=>$property->getId(),
               "slug"=>$property->getSlug()
            ],301);
        }
       
                // ->setCreatedAt(new \DateTime());
        //$property=$this->repository->find($id);
        return $this->render('property/show.html.twig',[
            'property'=>$property,
            'current_menu'=>'properties'
        ]);
    }
}