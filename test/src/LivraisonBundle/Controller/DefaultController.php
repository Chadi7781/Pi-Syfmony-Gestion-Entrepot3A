<?php

namespace LivraisonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Livraison/Default/index.html.twig');
    }
}
