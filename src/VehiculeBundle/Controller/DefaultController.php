<?php

namespace VehiculeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('VehiculeBundle:Default:index.html.twig');
    }
}
