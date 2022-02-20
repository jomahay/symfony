<?php

namespace App\Controller;

use App\Entity\Property;
#use Twig\Environment;
use App\Repository\PropertyRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController  extends AbstractController{


     /**
     * @Route("/login", name="login")
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils/*PropertyRepository $repository*/){
        $error=$authenticationUtils->getLastAuthenticationError();
        $lastUserName=$authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig',[
            "last_username"=>$lastUserName,
            "error"=>$error
        ]);
    }
}
    