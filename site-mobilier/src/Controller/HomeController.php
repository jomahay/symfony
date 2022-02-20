<?php

namespace App\Controller;

use Twig\Environment;
use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Response;

class HomeController{

    /**
     *  @var environment 
     */
    private $twig;
    public function __construct(Environment $twig){
        $this->twig=$twig;
    }

    public function index(PropertyRepository $repository):Response{
        $properties=$repository->findLastest();
        return new Response($this->twig->render('pages/home.html.twig',[
            "propertis"=>$properties,
        ]));
    }
}