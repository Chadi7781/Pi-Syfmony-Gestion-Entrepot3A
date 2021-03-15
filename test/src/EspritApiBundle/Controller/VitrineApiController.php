<?php

namespace EspritApiBundle\Controller;

use AchatBundle\Entity\NoteProduit;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use VenteBundle\Entity\Produit;
use Symfony\Component\HttpFoundation\Response;

class VitrineApiController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Achat/Default/index.html.twig');
    }

    public function readProduitAction() {
        $produits = $this->getDoctrine()->getManager()->getRepository(Produit::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($produits);
        return new JsonResponse($formatted);
    }
    public function autocompleteAction(Request $request)
    {
        $names = array();
        $term = trim(strip_tags($request->get('term')));

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository(Produit::class)->createQueryBuilder('c')
            ->where('c.libelle LIKE :libelle')
            ->setParameter('libelle', '%'.$term.'%')
            ->getQuery()
            ->getResult();

        foreach ($entities as $entity)
        {
            $names[] = $entity->getLibelle();
        }

        $response = new JsonResponse();
        $response->setData($names);

        return $response;
    }

    public function detailProduitAction(Request $request)
    {
        $id = $request->get("id");

        $em = $this->getDoctrine()->getManager();
        $reclamation = $em->getRepository("VenteBundle:Produit")->find($id);
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getLibelle();
        });
        $serializer = new Serializer([$normalizer], [$encoder]);
        $formatted = $serializer->normalize($reclamation);
        return new JsonResponse($formatted);
    }



}