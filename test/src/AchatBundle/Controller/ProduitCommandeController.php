<?php

namespace AchatBundle\Controller;

use AchatBundle\Entity\Commande;
use AchatBundle\Entity\ProduitCommande;
use AchatBundle\Form\CommandeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class ProduitCommandeController extends Controller
{
    public function indexAction()
    {
        return $this->render('AchatBundle:Default:index.html.twig');
    }


}