<?php


namespace VenteBundle\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use VenteBundle\Form\CategorieType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use VenteBundle\Entity\Categorie;
use Symfony\Component\HttpFoundation\Response;

class CategorieController extends Controller
{
    public function afficherAction(Request $request)
    {
        $Categorie = $this->getDoctrine()->getRepository(Categorie::class)->findAll();
        /**
         * var $paginator |knp|Component|Pager|Paginator
         */
        $paginator =$this->get('knp_paginator')->paginate(
            $Categorie,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            6/*nbre d'éléments par page*/
        );

        return $this->render('@Vente/Categorie/Afficheradmincate.html.twig',array('paginator'=>$paginator,));
    }
    public function supprimercatAction($id)
    {   $em = $this->getDoctrine()->getManager();
        $Categorie = $this->getDoctrine()->getRepository(Categorie::class)->find($id);
        $em->remove($Categorie);
        $em->flush();

        return $this->redirectToRoute("affichercate");
    }
    public function ajouterAction(Request $request)
    {
        $Categorie= new Categorie();
        $form=$this->createForm( CategorieType::class,$Categorie);
        $form=$form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $uploadedFile = $form['photo']->getData();
            $fileName=md5(uniqid()).'.'.$uploadedFile->guessExtension();
            $uploadedFile->move($this->getParameter('kernel.project_dir').'/web/uploadsProduit/produit_image'
                ,$fileName);

            $Categorie->setPhoto($fileName);
            $em->persist($Categorie);
            $em->flush();
            return $this->redirectToRoute('affichercate');
        }
        return $this->render('@Vente/Categorie/Ajouteradmincate.html.twig',array(
            'Form'=> $form->createView()));
    }
    public function affichercatAdAction()
    {$Categorie = $this->getDoctrine()->getRepository(Categorie::class)->findAll();
        return $this->render('@Vente/Categorie/Affichercate.html.twig',array('categorie'=>$Categorie));
    }

    public function modAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $Categorie =$em-> getRepository(Categorie::class)->find($id);
        $form=$this->createForm( CategorieType::class,$Categorie);
        $form=$form->handleRequest($request);
        if($form->isSubmitted())
        {   $uploadedFile = $form['photo']->getData();
            $fileName=md5(uniqid()).'.'.$uploadedFile->guessExtension();
            $uploadedFile->move($this->getParameter('kernel.project_dir').'/web/uploadsProduit/produit_image'
                ,$fileName);

            $Categorie->setPhoto($fileName);
            $em=$this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('affichercate');
        }
        return $this->render('@Vente/Categorie/Ajouteradmincate.html.twig',array(
            'Form'=> $form->createView()));
    }



    public function allAction()
    {
        $em = $this->getDoctrine()->getManager()->getRepository('VenteBundle:Categorie')->findAll();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($em);
        return new JsonResponse($formatted);

    }
    public function getNbrcAction() {
        $em =$this->getDoctrine()->getManager();
        $nbr = $this->getDoctrine()->getManager()->getRepository(Categorie::class)->calculerTotal();
        return new Response($nbr);

    }

}