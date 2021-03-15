<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use LivraisonBundle\Entity\Livraison;

class SecurityController extends Controller
{

    public function redirectAction()
    {
        // replace this example code with whatever you need
        $authChecker = $this->container->get('security.authorization_checker');
        if ($authChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('chart_index');
        } else {
            return $this->render('@App/Client/Accueil.html.twig');

        }


    }

}