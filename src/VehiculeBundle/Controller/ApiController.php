<?php

namespace VehiculeBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use VehiculeBundle\Entity\Vehicule;
use VehiculeBundle\Entity\VehiculeUser;
use VehiculeBundle\Form\EnvoyermailType;
use Symfony\Component\Validator\Constraints\DateTime ;

class ApiController extends Controller
{
    public function allAction()
    {
        $Vehicule = $this->getDoctrine()->getManager()
            ->getRepository(Vehicule::class)
            ->findBy(array('etat' => 'disponible'));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Vehicule);
        return new JsonResponse($formatted);

    }
    public function allCAction(Request $request)
    { $id_user=$request->get('idUser');
        // $user= new User();
        //  $us=  $this->getDoctrine()->getManager()->getRepository(User::class)->find($id_user);
        //  $user=$this->getUser()->getId();
        $VehiculeUser = $this->getDoctrine()->getManager()
            ->getRepository(VehiculeUser::class)
            ->findBy
            (array('idUser'=>$id_user));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($VehiculeUser);
        return new JsonResponse($formatted);

    }
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $VehiculeUser = new VehiculeUser();
        $id_user=$request->get('idUser');
        $usser= new User();
        $us= $em->getRepository(User::class)->find($id_user);
        $VehiculeUser -> setIdUser($us);
        $VehiculeUser->setMatricule($request->get('matricule'));
        $VehiculeUser->setEtat('nonfini');
        $VehiculeUser->setDateDebut(new \Datetime($request->get('dateDebut')));
        $VehiculeUser->setDateFin(new \Datetime($request->get('dateFin')));



        /* $debut = $request->request->get('dateDebut');
         $fin = $request->request->get('dateFin');
        $VehiculeUser -> setDateDebut(new \Datetime($debut));
       $VehiculeUser -> setDateFin(new \Datetime($fin));*/


        $em ->persist($VehiculeUser);
        $em ->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($VehiculeUser);
        return new JsonResponse($formatted);
    }
    public function deleteAction($matricule)
    {
        $em = $this->getDoctrine()->getManager();
        $VehiculeUser = $em->getRepository(VehiculeUser::class)->findOneBy(array('matricule' => $matricule));
        $em->remove($VehiculeUser);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($VehiculeUser);
        return new JsonResponse($formatted);
        //return $this->redirectToRoute("vehicules_Admin_affiche");
    }
    public function upAction(Request $request, $matricule)
    {
        $em = $this->getDoctrine()->getManager();
        $VehiculeUser = $em->getRepository(VehiculeUser::class)
            ->findOneBy(array('matricule' => $matricule));
        // $VehiculeUser->setEtat('fini');
        $VehiculeUser->setDateDebut(new \Datetime($request->get('dateDebut')));
        $VehiculeUser->setDateFin(new \Datetime($request->get('dateFin')));
        $em ->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($VehiculeUser);
        return new JsonResponse($formatted);


    }

    public function upetatVAction(Request $request, $matricule)
    {
        $em = $this->getDoctrine()->getManager();
        $Vehicule = $em->getRepository(Vehicule::class)->find($matricule);
        $Vehicule->setEtat('indisponible');
        $em ->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Vehicule);
        return new JsonResponse($formatted);
    }
    public function upetatVvAction(Request $request, $matricule)
    {
        $em = $this->getDoctrine()->getManager();
        $Vehicule = $em->getRepository(Vehicule::class)->find($matricule);
        $Vehicule->setEtat('disponible');
        $em ->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Vehicule);
        return new JsonResponse($formatted);
    }
    public function newvAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Vehicule = new Vehicule();
        $Vehicule -> setMatricule($request->get('matricule'));
        $Vehicule -> setType($request->get('type'));
        $Vehicule -> setPuissance($request->get('puissance'));
        $Vehicule -> setMarque($request->get('marque'));
        $Vehicule -> setKilometrage($request->get('kilometrage'));
        $Vehicule -> setNbplace($request->get('nbPlace'));
        $Vehicule->setEtat('disponible');
        $Vehicule -> setPrix($request->get('prix'));
        //  $Vehicule -> setPhoto($request->get('photo'));
        $Vehicule -> setCouleur($request->get('couleur'));
        $Vehicule -> setUser($request->get('User'));
        $em ->persist($Vehicule);
        $em ->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Vehicule);
        return new JsonResponse($formatted);
    }

    ////////////////////////////////////////////////////////////////
    public function loginAction(Request $request)
    {
        $username = $request->query->get("username");
        $password = $request->query->get("password");
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneBy(['username' => $username]);
        // $user->setPlainPassword($user->getPlainPassword());
        if($user==null) {

        }
        if ($user) {
            if (password_verify($password, $user->getPassword())) {
                $serializer = new Serializer([new ObjectNormalizer()]);
                $formatted = $serializer->normalize($user);
                return new JsonResponse($formatted);
            } else {
                return new Response("failed");
            }
        } else {
            return new Response("failed");
        }

    }


    public function GetUserbyIdAction(Request $request)
    {
        $user = $this->getDoctrine()->getManager()->getRepository(\AppBundle\Entity\User::class)
            ->find($request->get('id'));


        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }


    //*********Register***************************//
    public function registerAction(Request $request) {
        $username = $request->query->get("username");
        $password = $request->query->get("password");
        $email = $request->query->get("email");
        $role = $request->query->get("roles");

        $user = new \AppBundle\Entity\User();
        $user->setPlainPassword($password);
        $user->setEmail($email);
        $user->setUsername($username);
        $user->setRoles(array($role));
        $user->setEnabled(true);

        try {

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return new Response("success");
        } catch (Exception $ex) {
            return new Response("fail");
        }
    }



    public function AllUsersAction()
    {
        $user = $this->getDoctrine()->getManager()->getRepository(\AppBundle\Entity\User::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }
    public function EditUserAction(Request $request)
    {
        $id = $request->get("id");
        $username = $request->get("username");
        $password = $request->get("password");
        $email = $request->get("email");

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(\AppBundle\Entity\User::class)->find($id);
        $user->setUsername($username);
        $user->setPlainPassword($password);
        $user->setEmail(urldecode($email));
        $user->setEnabled(true);


        try {

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return new Response("success");

        } catch (\Exception $ex) {
            return new Response("fail");
        }

    }


}