<?php

namespace AchatBundle\Controller;

use AchatBundle\Entity\Commande;
use AchatBundle\Entity\Favorite;
use AchatBundle\Entity\ProduitCommande;
use AchatBundle\Form\CommandeType;
use AppBundle\Entity\User;
use LivraisonBundle\Entity\Livraison;
use LivraisonBundle\Form\LivraisonType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use VenteBundle\Entity\Produit;

class CartController extends Controller
{

        public function indexAction(SessionInterface $session,Request $request) {
//        return $this->render('@Achat/Produit/index.html.twig');
        $panier = $session->get('panier', []);
        $user = $this->getUser()->getUsername();
        $panierWithData= [];
            $itemss = $this->getDoctrine()->getRepository(ProduitCommande::class)->findallCommandesByuSER($user);
        $i = 0;
        $updateQuantite = 0;
        foreach ($panier as $id=> $qunatiteEnStock) {


            $panierWithData[] = [
                'produit'=>$this->getDoctrine()->getManager()->getRepository(Produit::class)->find($id),
                'qunatiteEnStock'=>$qunatiteEnStock,
                'quantite' =>  isset($_POST['_quantity'])

            ];
            $i++;
        }



            $total=0;

        foreach ($panierWithData as $items) {
            $totalItem = $items['produit']->getPrix() * $items['qunatiteEnStock'];
            $total+=$totalItem;


        }

            $commande = new Commande();
            $em=$this->getDoctrine()->getManager();
            $form = $this->createCreateForm( $commande);
            $form->handleRequest($request);


                if($request->isMethod('POST')) {

                    $ligne = new ProduitCommande();
                    $em = $this->getDoctrine()->getManager();

                    foreach ($panierWithData as $value) {
                        $commande->setTotal($total);
                        $commande->setDate(new \DateTime());
                        $commande->setUser($this->getUser());
                        $ligne->setCommande($commande);
                        $ligne->setProduit($value['produit']);
                        $ligne->setQuantite($value['quantite']);

                    }

                    var_dump($value['quantite']);die();

                    $em->persist($ligne);
                    $em->flush();

                    $em->persist($commande);
                    $em->flush();


                    //
                    //  $session->remove('panier');

                    return $this->redirectToRoute('historique');
                }
                else {
                    new Response("there is no method :(");
                }





    //    }


        return $this->render('@Achat/Produit/index.html.twig', array(
            'items'=>$panierWithData,
            'total'=>$total,
            'commande'=>$commande,
            'user'=>$user,
            'form'=>$form->createView(),
        ));

    }

    private function createCreateForm(Commande $entity)
    {
        $form = $this->createForm(CommandeType::class, $entity, array(
            'action' => $this->generateUrl('index'),
            'method' => 'POST',
        ));

        $form->add('Ajouter', SubmitType::class, array('label' => 'Create'));

        return $form;
    }


    public function createCartAction(SessionInterface $session,$id,Request $request) {


            $value = $request->request->get('quantite');
        $panier = $session->get('panier', []);
        if(!empty($panier[$id]) ) {
            $panier[$id]++;
        }
        else
            $panier[$id]=1;


        $session->set('panier',$panier);
        return $this->redirectToRoute('index');

    }

    public function removeCartAction($id,SessionInterface $session) {
        $panier = $session->get('panier', []);

        if(!empty($panier[$id])) {
            unset($panier[$id]);
        }

        //**************
        $session->set('panier',$panier);
        return $this->redirectToRoute('index');
        //        $em = $this->getDoctrine()->getManager();
        //        $em->remove($panier[$id]);
        //        $em->flush();

    }


    public function updateQuantiteAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();


        $idprod = $request->get('id');

        if($request->isMethod('POST')) {

            if ($request->isXmlHttpRequest()) {

                $produit = $em->getRepository(Produit::class)->find($idprod);
                var_dump($produit);
                die();


            }

        }

        return $this->redirectToRoute("index");



        }


            //    Send Sms   //

    public function callAction(Request $request) {
            $twilio = $this->get('twilio.api');
            $us = $this->getUser();
            $id = $request->get('id');
            $em = $this->getDoctrine()->getManager();
            $message = $twilio->account->messages->sendMessage(
                '+12513062685
',
                '+216 90 130 686



',
                'Stock for speed site web: Votre commande numer 68 est confirmée pour la somme de 180Dt, Merci de votre confiance!'
            );
        $otherInstance = $twilio->createInstance('BBBB', 'CCCCC');
        return $this->redirectToRoute("index");
    }



    public function readLigneCommandeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $items = $em->getRepository(Commande::class)->findAll();
        $mesCommande = $em->getRepository(Commande::class)->findBy([
            "user" => $this->getUser(),

        ]);
        return ($this->render('@ServiceApresVente/ProduitCommande/ReadProduitCommande.html.twig',

            array('items'=>$mesCommande)

        ));
    }

}
