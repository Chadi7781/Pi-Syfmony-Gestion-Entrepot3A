<?php

namespace VehiculeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use VehiculeBundle\Entity\VehiculeUser;


class ContratController extends Controller
{
    public function indexAction()
    {
        return $this->render('VehiculeBundle:Default:index.html.twig');
    }
  public function afficheContratAction()
  {
        $VehiculeUser = $this->getDoctrine()->getRepository(VehiculeUser::class)->findAll();
      return $this->render('@Vehicule/backend/Vehiculeslouées.html.twig', array('c' => $VehiculeUser));
  }
}
