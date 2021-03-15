<?php

namespace EspritApiBundle\Controller;

use ServiceApresVenteBundle\ServiceApresVenteBundle;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Tests\BinaryFileResponseTest;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use AchatBundle\Entity\Commande;
use AchatBundle\Entity\ProduitCommande;
use AppBundle\AppBundle;
use http\Client\Curl\User;
use ServiceApresVenteBundle\Entity\RecFeedCat;
use ServiceApresVenteBundle\Entity\Reclamation;
use ServiceApresVenteBundle\Form\FeedbackType;
use ServiceApresVenteBundle\Form\ReclamationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ReclamationApiController extends Controller
{
    public function indexAction()
    {
        return $this->render('ServiceApresVenteBundle:Default:index.html.twig');
    }

    //Reclamer produit commandé

    public function allRecAction()
    {

        $reclamation = $this->getDoctrine()->getManager()->getRepository(Reclamation::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($reclamation);

        return new JsonResponse($formatted);

    }



    //Produit commande a reclamer

    public function reclamerProduitAction(Request $request) {
        $em =$this->getDoctrine()->getManager();
        $id_user = $request->get("iduser");
        $us = $em->getRepository(\AppBundle\Entity\User::class)->find($id_user);

        $mesCommande  = $em->getRepository(Commande::class)->findBy([
            "user"=>$us,]);
        $cmd  = $em->getRepository(ProduitCommande::class)->findBy([
            "commandes"=>$mesCommande]);
        $i=0;


        $produitCommandes=[];
            foreach ($cmd as $c) {

                $p = new ProduitCommande();
                $p2 = new ProduitCommande();


                $p->setCommande($c->getCommande()->getId());
                $prooduitEntity=$c->getProduit();


                //Pointer to produit and get Data

                //var_dump($produitItem);die();


                //

                    $a[$i] = $p2;
                $p->setProduit($c->getProduit()->getPhoto());
                $p->setQuantite($c->getQuantite());
                $produitCommandes[$i] = $p;
                $i++;



            }
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($produitCommandes);

            return new JsonResponse($formatted);
    }



    //Detail Reclamation
    public function detailReclamationAction(Request $request)
    {
        $id = $request->get("idRec");

        $em = $this->getDoctrine()->getManager();
        $reclamation = $em->getRepository("ServiceApresVenteBundle:Reclamation")->find($id);
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getDescription();
        });
        $serializer = new Serializer([$normalizer], [$encoder]);
        $formatted = $serializer->normalize($reclamation);
        return new JsonResponse($formatted);
    }


    //************************************
    public function ImageAction(Request $request)
    {

        $publicResourcesFolderPath = $this->get('kernel')->getRootDir() . '/../web/uploads/reclamation_image/';
        $image = urldecode($request->get('image'));

        return new BinaryFileResponse($publicResourcesFolderPath . $image);
    }


    //****************Traiter Etat******************************************


    //-----------------------Create Reclamations---------------------------------


    public function addReclamationAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id_user = $request->get("iduser");
        $id_u = $request->get("cat");
        $user = new \AppBundle\Entity\User();
        $us = $em->getRepository(\AppBundle\Entity\User::class)->find($id_user);
        $i = $em->getRepository(RecFeedCat::class)->find($id_u);
        $nom = $request->get("objet");
        $description = $request->get("description");
        $image = $request->get("image");

        $date = new \DateTime('now');


        //$f = $this->getDoctrine()->getManager()->getRepository(RecFeedCat::class)->find(8);
        $rec = new Reclamation();
        $rec->setObjet(urldecode($nom));
        $rec->setDescription(urldecode($description));
        $rec->setEtat(0);
        $rec->setDate($date);
        // $event->setIdc(urldecode($lieu));
        $rec->setUser($us);
        $rec->setIdc($i);
        $rec->setImage($image);

        if ($request->files->get("image") != null) {
            $file = $request->files->get("image");
            $fileName = $file->getClientOriginalName();

            // moves the file to the directory where brochures are stored
            $file->move(
                $rec->getUploadRootDir(),
                $fileName
            );
            $rec->setImage($file);

        }


        try {
            $em->persist($rec);
            $em->flush();
            return new Response("success");

        } catch (Exception $ex) {
            return new Response("fail");
        }
    }


    public function autocompleteAction(Request $request)
    {
        $names = array();
        $term = trim(strip_tags($request->get('term')));

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ServiceApresVenteBundle:Reclamation')->createQueryBuilder('c')
            ->where('c.objet LIKE :objet')
            ->setParameter('objet', '%' . $term . '%')
            ->getQuery()
            ->getResult();

        foreach ($entities as $entity) {
            $names[] = $entity->getObjet();
        }

        $response = new JsonResponse();
        $response->setData($names);

        return $response;
    }


    public function confirmerReclamationAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        //$id = $request->get("id");
        $idRe = $request->get("idRec");
//
//        $user = $em->getRepository(\AppBundle\Entity\User::class)->find($id);
        $rec = $em->getRepository(Reclamation::class)->find($idRe);
        $reclamation = $em->getRepository(Reclamation::class)->findOneBy(["idRec"=>$rec]);


        try {
            $reclamation->setEtat(1);
            $em->persist($reclamation);
            $em->flush();
            return new Response("success");

        } catch (Exception $ex) {
            return new Response("fail");
        }

    }

    public
    function getReclamationByIdUserAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $idrec = $this->getDoctrine()->getManager()->getRepository(Reclamation::class)
            ->find($request->get('idRec'));

        //  $user = $this->getDoctrine()->getManager()->getRepository(\AppBundle\Entity\User::class)
        //    ->find($request->get('id'));


        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($idrec);
        return new JsonResponse($formatted);
    }


    public function getNbrReclamationAction()
    {
        $em = $this->getDoctrine()->getManager();
        $nbr = $this->getDoctrine()->getManager()->getRepository(Reclamation::class)->calculerTotalReclamation();
        return new Response($nbr);

    }


    public function mesReclamationAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(\AppBundle\Entity\User::class)->find($request->get('id'));
        $rec = $em->getRepository(Reclamation::class)->findBy(["user" => $user]);


        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($rec);
        return new JsonResponse($formatted);
    }

    public function modifierReclamationAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $objet = $request->get("objet");
        $description = $request->get("description");
        $image = $request->get("image");
        $user = $request->get("iduser");
        $date = new \DateTime('now');
        $cat = $request->get('cat');


        $id = $request->get("idRec");


        $idCat = $em->getRepository(RecFeedCat::class)->find($cat);
        $iduser = $em->getRepository(\AppBundle\Entity\User::class)->find($user);

        $reclamation = $em->getRepository(Reclamation::class)->find($id);





            $reclamation->setObjet($objet);
            $reclamation->setDescription($description);
            $reclamation->setDate($date);
            $reclamation->setIdc($idCat);
            $reclamation->setUser($iduser);

        if ($request->files->get("image") !== null) {
            $file = $request->files->get("image");
            var_dump($file);die();

            $fileName = $file->getClientOriginalName();
            // moves the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('reclamation_image'),
                $fileName
            );
            $reclamation->setImage(urldecode($fileName));
            $file = $request->files->get("image");
        }

            try {
                $em->persist($reclamation);
                $em->flush();
                return new Response("success");

            } catch (Exception $ex) {
                return new Response("fail");
            }


    }




    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $requestString = $request->get('q');

        $entities =  $em->getRepository('ServiceApresVenteBundle:Reclamation')->findEntitiesByString($requestString);
        if(!$entities) {
            return new Response("fail");
        } else {
            $result = $this->getRealEntities($entities);
        }

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($result);
        return new JsonResponse($formatted);    }



    public function getRealEntities($entities){

        foreach ($entities as $entity){
            $item = array();
            $item['idRec'] = $entity->getIdRec();
            $item['objet'] = $entity->getObjet();
            $item['image'] = $entity->getImage();
            //$item['categories'] = $entity->getCategories();


            $res[] = $item;        }

        return $res;
    }


}
