<?php

namespace EspritApiBundle\Controller;

use AppBundle\Entity\User;
use ServiceApresVenteBundle\Entity\RecFeedCat;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class RecFeedApiController extends Controller
{
    public function indexAction()
    {
        return $this->render('EspritApiBundle:Default:index.html.twig');
    }


    public function allCatAction() {

        $reclamation = $this->getDoctrine()->getManager()->getRepository(RecFeedCat::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($reclamation);
        return new JsonResponse($formatted);
    }

//************************************
    public function ImageAction(Request $request) {

        $publicResourcesFolderPath = $this->get('kernel')->getRootDir() . '/../web/uploads/catRecFeed_image/';
        $image = urldecode($request->get('image'));

        return new BinaryFileResponse($publicResourcesFolderPath.$image);
    }


    public function catByIdAction(Request $request)
    {
        $id = $request->query->get("id_cat");
        $em = $this->getDoctrine()->getEntityManager();
        $categorie = $em->getRepository(RecFeedCat::class)->find($id);

        if ($categorie) {
            $encoder = new JsonEncoder();
            $normalizer = new ObjectNormalizer();
            $normalizer->setCircularReferenceHandler(function ($object) {
                return $object->getIdCat();
            });
            $serializer = new Serializer([$normalizer], [$encoder]);
            $formatted = $serializer->normalize($categorie);
            return new JsonResponse($formatted);
        } else {
            return new Response("no data");
        }

    }

    //***********************************
    public function editRecFeedAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $request->get("id");
        $nom = $request->get("nom");


        $cat = $em->getRepository(RecFeedCat::class)->find($id);

        if ($request->files->get("image") != null) {
            $file = $request->files->get("image");
            $fileName = $file->getClientOriginalName();

            // moves the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('event_photo'),
                $fileName
            );
            $request->setImage(urldecode($fileName));
            $file = $request->files->get("image");

        }


        $cat->setNom(urldecode($nom));

        try {
            $em->persist($cat);
            $em->flush();
            return new Response("success");

        } catch (Exception $ex) {
            return new Response("fail");
        }
    }


}
