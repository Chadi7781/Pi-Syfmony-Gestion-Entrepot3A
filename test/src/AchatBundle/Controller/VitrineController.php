<?php

namespace AchatBundle\Controller;

use AchatBundle\Entity\Favorite;
use AchatBundle\Entity\NoteProduit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use VenteBundle\Entity\Produit;

class VitrineController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Achat/Default/index.html.twig');
    }

    public function readProduitAction()
    {
        $em = $this->getDoctrine()->getManager();


        $listfav = $em->getRepository(Favorite::class)->findBy(
            array(
                'user' => $this->getUser()
            )
        );
        $note = count($em->getRepository(NoteProduit::class)->findBy(
            array(
                'idClient' => $this->getUser()
            )
        ));
        if($note == 0) {


        }
        else
        {

        }



        $produits = $em->getRepository('VenteBundle:Produit')->findAll();


        return $this->render("@Achat/Vitrine/vitrine.html.twig", array( "notePro" => $note, "listfav" => $listfav, "produits" => $produits));

    }

    public function showdetailedAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $f = $em->getRepository(Produit::class)->find($id);
        $note = $em->getRepository(NoteProduit::class)->find($id);

        return $this->render('@Achat/Vitrine/detail.html.twig', array(
            'libelle' => $f->getLibelle(),
            'photo' => $f->getPhoto(),
            'description' => $f->getDesription(),
            'poids' => $f->getPoids(),
            'prix' => $f->getPrix(),
            'etat' => $f->getEtat(),
            'user' => $f->getIdUser(),
            'cat' => $f->getIdCat(),
            'id' => $f->getId(),
            //   'note'=>$note,
            'quantite' => $f->getQuantite(),

        ));
    }

public function getRealEntities($entities){

    foreach ($entities as $entity){
        $realEntities[$entity->getId()] = [$entity->getPhoto(),$entity->getLibelle()];
    }

    return $realEntities;
}


    public function favorisAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();


        if ($request->isMethod('POST')) {
            if ($request->isXmlHttpRequest()) {
                $idprod = $request->get('id');
                $produit = $em->getRepository(Produit::class)->find($idprod);
                $favoris = new Favorite();
                $favoris->setProduit($produit);
                $favoris->setUser($this->getUser());
                $em->persist($favoris);
                $em->flush();
            }

        }
        return $this->render("AchatBundle:Vitrine:vitrine.html.twig",
            array(
                'produits' => $produit
            ));
    }

    public function NonfavorisAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if ($request->isMethod("POST")) {
            if ($request->isXmlHttpRequest()) {
                $idProduit = $em->getRepository(Favorite::class)->findBy(array(

                    'produit' => 'id'));
                $idProduit = $request->get('id');
                $produit = $em->getRepository("AchatBundle:Favorite")
                    ->find($idProduit);
                $favoris = $em->getRepository("AchatBundle:Favorite")->findOneBy(
                    array(
                        'produits' => $produit,
                        'id' => $this->getUser()
                    )
                );


                $em->remove($favoris);
                $em->flush();
            }
        }

        return $this->render("@Achat/Vitrine/vitrine.html.twig",
            array(
                'produits' => $produit, 'id' => $idProduit
            ));


    }

    public function mesfavorisAction(Request $request)
    {

        //créer une instance de notre entity  manager
        $em = $this->getDoctrine()->getManager();

        $listfav = $em->getRepository(Favorite::class)->findBy(
            array(
                'user' => $this->getUser()
            )
        );


        return $this->render("@Achat/Produit/mesFavoris.html.twig",
            array(
                'listfav' => $listfav

            ));

    }


    public function retirerFromListeFavorisAction(Request $request)
    {
        $id = $request->get("idFavorite");

        $em = $this->getDoctrine()->getManager();
        $Produit = $em->getRepository(Favorite::class)->find($id);
        $em->remove($Produit);
        $em->flush();
        return $this->redirectToRoute("mes_favoris");
    }


    //******************* Note Produit *********************//

    public function ajouterNoteProduitAction($note, $idProduit)
    {
        $em = $this->getDoctrine()->getManager();

        $ev = $em->getRepository(NoteProduit::class)
            ->findOneBy(array('idProduit' => $idProduit,
                'idClient' => $this->getUser()));
        if ($ev) {
            $ev->setNote($note);
            $em->persist($ev);
            $em->flush();
        } else {
            $evaluation = new NoteProduit();
            $p = $em->getRepository(Produit::class)->find($idProduit);
            $evaluation->setIdClient($this->container->get('security.token_storage')->getToken()->getUser());
            $evaluation->setNote($note);
            $evaluation->setIdProduit($p);
            $em->persist($evaluation);
            $em->flush();

        }


        return $this->redirectToRoute("vitrine_read_produit", array('idProduit' => $idProduit));
    }




    //*******************Search product*********************//

    public function searchAction(Request $request){
        $em=$this->getDoctrine()->getManager();

        if ($request->isMethod("POST")){
            if ($request->isXmlHttpRequest()) {
                $serializer = new Serializer(
                    array(
                        new ObjectNormalizer()
                    )
                );
                $produits = $em->getRepository(Produit::class)
                    ->findProduit($request->get('prixx'),$request->get('prixx'));


                $data = $serializer->normalize($produits);
                return new JsonResponse($data);
            }
        }
        return new Response();
    }


}




