<?php

namespace VehiculeBundle\Controller;

use AppBundle\Entity\User;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use VehiculeBundle\Entity\MaintenaceVehicule;
use VehiculeBundle\Entity\Vehicule;
use VehiculeBundle\Entity\VehiculeUser;
use VehiculeBundle\Form\updateType;
use VehiculeBundle\Form\VehiculeType;
use Symfony\Component\HttpFoundation\Request;
use VehiculeBundle\Form\VehiculeUserType;
use VehiculeBundle\Form\MaintenaceVehiculeType;

class VehiculeController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Vehicule/frontend/vehicule/indexx.html.twig');
    }

    // Admin
    public function afficheAction(Request $request)
    {
        $Vehicule = $this->getDoctrine()->getRepository(Vehicule::class)->findAll();
        /**
         * @var  $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result= $paginator->paginate(
            $Vehicule,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',5 )

        );
        return $this->render('@Vehicule/backend/AffichageVehicule.html.twig', array('v' => $result));
    }

    // affichage d'une vehicule par son matricule pour l'admin
    public function afficheVehiculeeAction($matricule)
    {
        $Vehicule = $this->getDoctrine()->getRepository(Vehicule::class)->find($matricule);
        return ($this->render("@Vehicule/backend/detailsVehicule.html.twig", array('v' => $Vehicule)));
    }

    public function ajoutVehiculeAction(Request $request)
    {
        $Vehicule = new Vehicule();
        $form = $this->createForm(VehiculeType::class, $Vehicule);
        $form = $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $Vehicule->UploadProfilePicture();
            $em->persist($Vehicule);
            $em->flush();
            $this->addFlash('success', 'something went <a href="/" class="alert-link">well!</a>');
            return $this->redirectToRoute('vehicules_Admin_affiche');

        }
        return
            $this->render("@Vehicule/backend/ajoutvehicule.html.twig",
                array('f' => $form->createView()));
    }

    public function updateAction(Request $request, $matricule)
    {
        $em = $this->getDoctrine()->getManager();
        $Vehicule = $em->getRepository(Vehicule::class)->find($matricule);
        $form = $this->createForm(VehiculeType::class, $Vehicule);
        $form = $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $Vehicule->UploadProfilePicture();
            $em->flush();
            //   $this->addFlash('info', 'update avec succce !');
            return $this->redirectToRoute('vehicules_Admin_affiche');

        }
        return
            $this->render("@Vehicule/backend/updateVehicule.html.twig",
                array('f' => $form->createView()));
    }

    public function deleteAction($matricule)
    {
        $em = $this->getDoctrine()->getManager();
        $Vehicule = $em->getRepository(Vehicule::class)->find($matricule);
        $em->remove($Vehicule);
        $em->flush();

        return $this->redirectToRoute("vehicules_Admin_affiche");
    }


    //client
    // Affichage de vehicules dont l'etat est disponible
    public function readAction(Request $request)
    {
        $Vehicule = $this->getDoctrine()->getRepository(Vehicule::class)->findBy(array('etat' => 'disponible'));

        /**
         * @var  $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result= $paginator->paginate(
            $Vehicule,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',3)

        );

        return $this->render('@Vehicule/frontend/read.html.twig', [
            'v' => $result
        ]);
    }

    // Reserver
    public function afficheCAction(Request $request, $matricule)
    {    $em = $this->getDoctrine()->getManager();
        $Vehicule = $em->getRepository(Vehicule::class)->find($matricule);
        $form = $this->createForm(updateType::class, $Vehicule);
        $form = $form->handleRequest($request);

        $VehiculeUser= new VehiculeUser();
        $contrat_form = $this->createForm(VehiculeUserType::class, $VehiculeUser);
        $contrat_form = $contrat_form->handleRequest($request);

        if ($form->isSubmitted() ) {
            $user=$this->getUser()->getId();
            $userr=$this->getUser();
            $em = $this->getDoctrine()->getManager();



            $Vehicule->setUser($userr);
            $VehiculeUser->setIdUser($userr);
            $VehiculeUser->setMatricule($matricule);

            $em->persist($VehiculeUser);
            $em->flush();
            return $this->redirectToRoute('vehicules_Client_affiche');

        }
        $Vehicule = $this->getDoctrine()->getRepository(Vehicule::class)->find($matricule);

        return ($this->render("@Vehicule/frontend/location.html.twig",
            array('v' => $Vehicule, 'f' => $form->createView(), 'cf' => $contrat_form->createView()  ) ));
    }

    // Mes vehicules
    public function mesVehiculesAction()
    {
        $user=$this->getUser()->getId();
        $Vehicule = $this->getDoctrine()->getRepository(Vehicule::class)->findBy
        (array('User'=>$user));
        return $this->render('@Vehicule/frontend/Mesvehicules.html.twig', array('v' => $Vehicule));
    }
    public function maVehiculeAction($matricule)
    {
        $user=$this->getUser()->getId();
        $Vehicule = $this->getDoctrine()->getRepository(Vehicule::class)->find($matricule);
        $Vehiculeuser = $this->getDoctrine()->getRepository(VehiculeUser::class);
        $d=$Vehiculeuser->getDateFinLocation($user);
        return $this->render('@Vehicule/frontend/Mavehicule.html.twig',
            array('v'=>$Vehicule) );
    }
}
