<?php

namespace VehiculeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use VehiculeBundle\Entity\MaintenaceVehicule;
use VehiculeBundle\Entity\Vehicule;
use VehiculeBundle\Form\MaintenaceVehiculeType;

class MaintenanceController extends Controller
{
    public function indexAction()
    {
        return $this->render('VehiculeBundle:Default:index.html.twig');
    }
    public function maintenirAction(Request $request,$matricule)
    {
        $MaintenaceVehicule =new MaintenaceVehicule();
        $form = $this->createForm(MaintenaceVehiculeType::class,$MaintenaceVehicule);
        $form = $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $Vehicule = $em->getRepository(Vehicule::class)->find($matricule);
            $MaintenaceVehicule->setVehicule($Vehicule);

            $em->persist($MaintenaceVehicule);
            $em->flush();
            return $this->redirectToRoute('vehicules_Admin_affiche');
        }
        return
            $this->render("@Vehicule/backend/maintenirvehicule.html.twig",
                array('f' => $form->createView()));

    }
    public function VehiculeMaintenuesAction()
    {
        $maintenu = $this->getDoctrine()->getRepository(MaintenaceVehicule::class)->findAll();
        return $this->render('@Vehicule/backend/VehiculeMaintenues.html.twig', array('m' => $maintenu));
    }
}
