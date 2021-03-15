<?php

namespace LivraisonBundle\Controller;


use LivraisonBundle\Entity\Livraison;
use LivraisonBundle\Form\LivraisonType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LivraisonController extends Controller
{
    public function addAction(Request $request)
    {    $user = $this->getUser()->getId();
        $livraison = new Livraison();
        $livraison->setEtat('En Cours');
        $livraison->setIdUser($user);



        $form = $this->createForm('LivraisonBundle\Form\LivraisonType', $livraison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var UploadedFile $file
             */
            $file=$livraison->getPhotoProduit();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('images_directory'),$fileName
            );
            $Governatd=$form["GovernatD"]->getData();
            $Governata=$form["GovernatA"]->getData();
            $adrd=$form["adresseDepart"]->getData();
            $adra=$form["adresseArrive"]->getData();

            $livraison->setAdresseArrive($adra.'.'.$Governata);
            $livraison->setAdresseDepart($adrd.'.'.$Governatd);
            $test=$form["idMagasin"]->getData();
            if($test==Null){
                $date1 = new \DateTime('now+7 days');
                $date1=$date1->format('d/m/Y');
                $livraison->setDateReception($date1);}
                else {
                    $date2 = new \DateTime('now+4 days');
                    $date2=$date2->format('d/m/Y');
                    $livraison->setDateReception($date2);

                }
            $poid=$form["poids"]->getData();
                if($poid==1){
                    $livraison->setPrix(10000);}
                else if ($poid==2){
                    $livraison->setPrix(20000);}
                else if ($poid==3){
                    $livraison->setPrix(30000);

                }






            $livraison->setPhotoProduit($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($livraison);
            $em->flush();
            $this->addFlash('info', 'Votre Demande a ètè enregister avec succès !');
            return $this->redirectToRoute('livraison_afficher');

        }

        return $this->render('@Livraison/Default/add.html.twig', array(
            'livraison' => $livraison,
            'form' => $form->createView(),
        ));
    }
    public function meslivraisonAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser()->getId();
        $livraison = $em->getRepository('LivraisonBundle:Livraison')->findLivraisonByUser($user);
        if($request->isMethod('POST')){
            $etat=$request->get('etat');
            if($etat=='All'){
                $livraison = $em->getRepository('LivraisonBundle:Livraison')->findLivraisonByUser($user);

            }
            else {
                $livraison = $em->getRepository("LivraisonBundle:Livraison")->findBy(array("etat" => $etat));
            }

        }


        return $this->render('@Livraison/Default/afficherLivraison.html.twig', array(
            'livraison' => $livraison,
        ));
    }
    public function deleteLivraisonAction($idLivraison) {
        $m=$this->getDoctrine()->getManager();
        $mod = $this->getDoctrine()
            ->getRepository('LivraisonBundle:Livraison')
            ->find($idLivraison);

        $m->remove($mod);
        $m->flush();

        return $this->redirectToRoute('livraison_afficher');
    }
    public function modifierLivraisonAction($idLivraison, Request $request)

    {
        $livraison = $this->getDoctrine()->getRepository(Livraison::class)->find($idLivraison);
        $form = $this->createForm(LivraisonType::class,$livraison);
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()){
            $em =$this->getDoctrine()->getManager();
            /**
             * @var UploadedFile $file
             */
            $file=$livraison->getPhotoProduit();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('images_directory'),$fileName
            );
            $livraison->setPhotoProduit($fileName);
            $em->flush();
            return $this->redirectToRoute('livraison_afficher');}
        return $this ->render('@Livraison/Default/add.html.twig',array('form'=>$form->createView()));
    }
    public function AfficherLivraisonAdminAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $livraison = $em->getRepository('LivraisonBundle:Livraison')->findAll();
        if($request->isMethod('POST')){
            $etat=$request->get('etat');
            if($etat=='All'){
                $livraison = $em->getRepository('LivraisonBundle:Livraison')->findAll();

            }
            else {
                $livraison = $em->getRepository("LivraisonBundle:Livraison")->findBy(array("etat" => $etat));
            }

        }
        return $this->render('@Livraison/Admin/afficherLivraisonAdmin.html.twig', array(
            'livraison' => $livraison,
        ));
    }

    public function plusdinfoAction(Request $request,$idLivraison)
    {
        $livraison = $this->getDoctrine()->getRepository(Livraison::class)->find($idLivraison);
        if($livraison->getPoids()==1){
            $livraison->setPoids('10 < Poids < 20');
        }

        else if($livraison->getPoids()==2){
            $livraison->setPoids('10 < Poids < 20');
        }
        else if ($livraison->getPoids()==3){
            $livraison->setPoids('20< Poids < 30');}
            else { $livraison->setPoids('+ 30');}



        return $this->render('@Livraison/Default/info.html.twig', array(
            'livraison' => $livraison,
        ));
    }

    public function TraiterLivraisonAction(Request $request,$idLivraison)
    {
        $livraison = $this->getDoctrine()->getRepository(Livraison::class)->find($idLivraison);
        if($livraison->getPoids()==1){
            $livraison->setPoids('10 < Poids < 20');
        }

        else if($livraison->getPoids()==2){
            $livraison->setPoids('10 < Poids < 20');
        }
        else if ($livraison->getPoids()==3){
            $livraison->setPoids('20< Poids < 30');}
        else { $livraison->setPoids('+ 30');}



        return $this->render('@Livraison/Admin/TraiterLivraison.html.twig', array(
            'livraison' => $livraison,
        ));
    }
    public function ConfirmerAdminAction(Request $request,$idLivraison)
    {
        $idliv = $this->getDoctrine()->getRepository(Livraison::class)->find($idLivraison);
        $livraison=$this->getDoctrine()->getRepository(Livraison::class)->Confirmeretat($idliv);


        return $this->redirectToRoute('livraison_afficherAdmin');
    }
    public function pdfAction(Request $request,$idLivraison)

    {
        $livraison = $this->getDoctrine()->getRepository(Livraison::class)->find($idLivraison);
        if($livraison->getPoids()==1){
            $livraison->setPoids('10 < Poids < 20');
        }

        else if($livraison->getPoids()==2){
            $livraison->setPoids('10 < Poids < 20');
        }
        else if ($livraison->getPoids()==3){
            $livraison->setPoids('20< Poids < 30');}
        else { $livraison->setPoids('+ 30');}
        $snappy = $this->get('knp_snappy.pdf');

        $html = $this->renderView('LivraisonBundle:Default:pdf.html.twig', array(
            'livraison' => $livraison,

        ));



        $filename = 'myFirstSnappyPDF';

        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
            )
        );
    }







    }
