<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{

    public function AccueilAction()
    {
        // replace this example code with whatever you need
        return $this->render('@App/Accueil/homepage.html.twig');
    }
   }

