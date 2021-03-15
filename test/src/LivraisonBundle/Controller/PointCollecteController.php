<?php

namespace LivraisonBundle\Controller;

use LivraisonBundle\Entity\PointCollecte;
use LivraisonBundle\Form\PointCollecteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PointCollecteController extends Controller
{
    public function addMagasinAction(Request $request)

    {
        $PointCollecte = new PointCollecte();

        $form = $this->createForm(PointCollecteType::class,$PointCollecte);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($PointCollecte);
            $em->flush();
            $this->addFlash('info', 'Point De collecte Ajoutè !');
            return $this->redirectToRoute('PointCollecte_affichage');


        }
        return $this->render('@Livraison/Admin/addMagasin.html.twig', array(

            'form'=>$form->createView()
        ));
    }
    public function AffichageAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $PointCollecte = $em->getRepository('LivraisonBundle:PointCollecte')->findAll();
        if($request->isMethod('POST')){
            $pays=$request->get('pays');
            $PointCollecte=$em->getRepository("LivraisonBundle:PointCollecte")->findBy(array("pays"=>$pays));


        }

        return $this->render('@Livraison/Admin/afficherMagasin.html.twig', array(
            'PointCollecte' => $PointCollecte,
        ));
    }
    public function deleteMagasinAction($idMagasin) {
        $m=$this->getDoctrine()->getManager();
        $mod = $this->getDoctrine()
            ->getRepository('LivraisonBundle:PointCollecte')
            ->find($idMagasin);

        $m->remove($mod);
        $m->flush();

        return $this->redirectToRoute('PointCollecte_affichage');
    }
    public function modifierAction($idMagasin, Request $request)

    { $em = $this->getDoctrine()->getManager();
        $PointCollecte = $this->getDoctrine()->getRepository(PointCollecte::class)->find($idMagasin);
        $form = $this->createForm(PointCollecteType::class,$PointCollecte);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $em =$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('PointCollecte_affichage');}
        return $this ->render('@Livraison/Admin/addMagasin.html.twig',array('form'=>$form->createView()));
    }

     public function pointcollecteAction(){


         return $this ->render('@Livraison/Admin/Magasin.html.twig');

     }
}
