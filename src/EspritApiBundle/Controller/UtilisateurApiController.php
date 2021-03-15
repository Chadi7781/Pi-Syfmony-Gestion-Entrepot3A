<?php

namespace EspritApiBundle\Controller;

use AppBundle\Entity\User;
use EmployeBundle\Entity\Employe;
use http\Exception;
use ServiceApresVenteBundle\Entity\Feedback;
use ServiceApresVenteBundle\Entity\Rating;
use ServiceApresVenteBundle\Entity\RecFeedCat;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class UtilisateurApiController extends Controller
{

//***********************************

    public function ImagesUserAction(Request $request)
    {
        $publicResourcesFolderPath = $this->get('kernel')->getRootDir() . '/../web/users_photo/ ';
        $image = $request->query->get("photo");
        // This should return the file located in /mySymfonyProject/web/public-resources/TextFile.txt
        // to being viewed in the Browser
        return new BinaryFileResponse($publicResourcesFolderPath . $image);
    }




    public function EditUserAction(Request $request)
    {
        $id = $request->get("id");
        $username = $request->get("username");
        $password = $request->get("password");
        $email = $request->get("email");
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(\AppBundle\Entity\User::class)->find($id);
        if ($request->files->get("photo") != null) {
            $file = $request->files->get("photo");
            $fileName = $file->getClientOriginalName();

            // moves the file to the directory where brochures are stored
            $file->move(
                $fileName
            );
            $user->setPhoto($fileName);
            }



        $user->setUsername($username);
        $user->setPlainPassword($password);
        $user->setEmail(urldecode($email));
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




    public function GetUserbyIdAction(Request $request)
    {
        $user = $this->getDoctrine()->getManager()->getRepository(\AppBundle\Entity\User::class)
            ->find($request->get('id'));


        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }




    public function GetPassbyEmailAction(Request $request)
    {        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository(\AppBundle\Entity\User::class)->findOneBy(['email' => $request->get('email')]);


        if ( $user ==null)
        {


        }
        else {


            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize(            $user->getPassword());
            return new JsonResponse($formatted);
        }
        return new Response("fail");





    }

    //***********Login******************************//
    public function loginAction(Request $request)
    {
        $username = $request->query->get("username");
        $password = $request->query->get("password");
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(\AppBundle\Entity\User::class)->findOneBy(['username' => $username]);
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

    //*********Register***************************//
    public function registerAction(Request $request) {
        $username = $request->query->get("username");
        $password = $request->query->get("password");
        $email = $request->query->get("email");
        $role = $request->query->get("roles");
        $cin = $request->query->get("cin");

        $user = new \AppBundle\Entity\User();
        $user->setPlainPassword($password);
        $user->setEmail($email);
        $user->setUsername($username);
        $user->setCin(26555555);
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
}