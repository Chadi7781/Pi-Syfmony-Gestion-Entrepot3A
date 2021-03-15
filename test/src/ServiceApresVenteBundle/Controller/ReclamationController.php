<?php

namespace ServiceApresVenteBundle\Controller;
use Mgilet\NotificationBundle\Entity\Notification;

use AchatBundle\Entity\Commande;
use AchatBundle\Entity\ProduitCommande;
use DateTime;
use http\Client\Curl\User;
use LivraisonBundle\Entity\Facture;
use Ob\HighchartsBundle\Highcharts\Highchart;
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
use VenteBundle\Entity\Produit;

class ReclamationController extends Controller
{
    public function indexAction()
    {
        return $this->render('ServiceApresVenteBundle:Default:index.html.twig');
    }

    public function afficher1Action(Request $request)
    { $user = $this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $listproduit= $em->getRepository('VenteBundle:Produit')->findReclamation($user);
        return ($this->render('@Vente/Produit/Afficher.html.twig',array('listproduit'=>$listproduit)));
    }



    //Reclamer produit commandé

    public function reclmaerProduitAction() {

        $em =$this->getDoctrine()->getManager();
        $mesCommande  = $em->getRepository(Commande::class)->findBy([
            "user"=>$this->getUser(),]);

        $mesproduit  = $em->getRepository(Produit::class)->findBy([
            "idUser"=>$this->getUser(),]);
        $cmd  = $em->getRepository(ProduitCommande::class)->findBy([
              "commandes"=>$mesCommande,
            "produits"=>$mesproduit]);
        $i=0;


        if (!$cmd ) {
            return $this->render('@ServiceApresVente/ProduitCommande/ReadProduitCommande.html.twig',
                array('items'=>$cmd));


        }
        else {
            foreach ($cmd as $c) {

                $p = new ProduitCommande();
                $p2 = new ProduitCommande();
                $p3 = new ProduitCommande();


                $p->setCommande($c->getCommande()->getId());
                $p3->setProduit($c->getProduit()->getId());
                $b[$i] = $p3;

                $p2->setProduit($c->getProduit()->getPhoto());
                $a[$i] = $p2;
                $p->setProduit($c->getProduit()->getLibelle());
                $p->setQuantite($c->getQuantite());
                $produitCommandes[$i] = $p;
                    $i++;


            }


            return $this->render('@ServiceApresVente/ProduitCommande/ReadProduitCommande.html.twig', array('imageProd' => $a,'idproduit'=> $b,'produitCmd' => $produitCommandes, "items" => $cmd));
        }
        return $this->redirectToRoute('read_reclamation');
    }









    //---------Traiter Avance reclamation en mettre a jours le facture---------


    public function ajouterFactureAvoireAction() {


    }


    //-----------------------Read Reclamations---------------------------------
    public function readReclamationAction()
    {



        $reclamations = $this->getDoctrine()->getManager()->getRepository(Reclamation::class)->findAll();
        $user= $this->getUser()->getId();

        $reclamationsetat = $this->getDoctrine()->getManager()->getRepository(Reclamation::class)  ->confirmer($user);

        $count = $this->getDoctrine()->getRepository(Reclamation::class)->calculerTotalReclamation();

        if ($count == 0)
            $this->addFlash('info', 'Vous n"avez aucun Réclamation envoyée :) !');
        if($reclamationsetat==1)
            $this->addFlash('info', 'Nous avons traiter votre réclamation vous avez satisifer si oui clicker sur button cloturé :) !');


        return $this->render('@ServiceApresVente/Reclamation/readReclamation.html.twig',
            array("reclamations" => $reclamations,

                "count" => $count));
    }

    //-----------------------Create Reclamations---------------------------------
    public function createReclamationAction(Request $request, RecFeedCat $id,$idp,$idpc)
    {
        $currentUserName= $this->getUser()->getUsername();
        $currentUserEmail= $this->getUser()->getEmail();

        $idd=$request->get('id');
        $idpc=$request->get('idpc');
        $idp=$request->get('idp');
        //$currentUserNaissance= $this->getUser()->getDateNaissance();
      //  var_dump($idpc);die();
        $currentUser= $this->getUser();

        $id = $this->getDoctrine()->getManager()->getRepository(RecFeedCat::class)->find($id);
        $idpcs = $this->getDoctrine()->getManager()->getRepository(Commande::class)->find($idpc);
        $idproduit = $this->getDoctrine()->getManager()->getRepository(Produit::class)->find($idp);


//        var_dump($idpcc);die();

        $reclamations = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamations);
        $user = $this->getUser();
        $form->handleRequest($request);
        $manager = $this->get('mgilet.notification');

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $reclamations->upload();

            $reclamations->setIdc($id);
            $reclamations->setCommandeproduits($idpcs);
            $reclamations->setProduit($idproduit);
            $reclamations->setDate(new \DateTime('now'));
            $reclamations->setUser($currentUser);

            $reclamations->setEtat(0);
            $em->persist($reclamations);
            $em->flush();

            $notif = $manager->createNotification(
            $this->getUser()->getUsername());
            $notif->setMessage($reclamations->getObjet());
            $notif->setLink($this->redirectToRoute('read_reclamation'));
            // or the one-line method :

            // you can add a notification to a list of entities
            // the third parameter `$flush` allows you to directly flush the entities
            $manager->addNotification(array($this->getUser()), $notif, true);






            $this->addFlash('info', 'Envoyer réclamation avec succés !');


            return $this->redirectToRoute("envoyer_reclamation");
        }

        return $this->render("@ServiceApresVente/Reclamation/createReclamation.html.twig", array(
            "username"=>$currentUserName,
            "email"=>$currentUserEmail,
           "id"=>$idd,
            "user"=>$currentUser,
            "manager"=>$manager,
            "form" => $form->createView()));

    }

    //--------------------------------------------------------

    public function updateReclamationAction(Request $request, $id)
    {
        $reclamation = $this->getDoctrine()->getManager()->getRepository(Reclamation::class)->find($id);
        $form = $this->createForm(ReclamationType::class, $reclamation);

//        if($reclamation->getEtat()==1) {
//            $this->addFlash('info', 'Réclamation etait traiter par admin vous n"avez pas le droit de le modifier :) !');
//
//        }

        $form->handleRequest($request);
        if ($form->isValid()) {


            $reclamation->upload();
            $reclamation->setDate(new \DateTime('now'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($reclamation);
            $em->flush();

            return $this->redirectToRoute('read_reclamation');

        }
        return $this->render("@ServiceApresVente/Reclamation/updateReclamation.html.twig", array("form" => $form->createView()));
    }

    public function listReclamationAction()
    {
        $reclamations = $this->getDoctrine()->getManager()->getRepository(Reclamation::class)->findAll();
        $notifiableRepo = $this->get('doctrine.orm.entity_manager')->getRepository('MgiletNotificationBundle:NotifiableNotification');
        $manager = $this->get('mgilet.notification');
        $all=$notifiableRepo->findAllForNotifiableId($manager->getNotifiableEntity($this->getUser()));

        $count = $this->getDoctrine()->getRepository(Reclamation::class)->calculerTotalReclamation();
        if ($count == 0)
            $this->addFlash('info', 'Vous n"avez aucun Reclamation recu :) !');


         return $this->render('@ServiceApresVente/Admin/readReclamation.html.twig', array(
             "reclamations"=>$reclamations,
             "notifiableEntity"=>$this->getUser(),
             "notifiableNotifications"=>$all,
             "reclamations" => $reclamations, "count" => $count));
    }


    public function showdetailedAction($id,$cat)
    {
        $em = $this->getDoctrine()->getManager();
        $f = $em->getRepository(Reclamation::class)->find($id);
        $idCat = $em->getRepository(RecFeedCat::class)->find($cat);
        $reclamationCat = $em->getRepository(Reclamation::class)->findBy(['idc'=>$idCat]);
        $currentRecCat = $em->getRepository(Reclamation::class)->findOneBy(['idc'=>$idCat]);

        //var_dump($reclamationCat);f();
        $i = 0;
        foreach ($reclamationCat as $rec) {
            if($rec->getIdc()->getNom() == $currentRecCat->getIdc()->getNom()) {
                $newRec  = new Reclamation();
                $newRec->setObjet($rec->getObjet());
                $newRec->setDescription($rec->getDescription());
                $newRec->setObjet($rec->getEtat());

            }
        }
        return $this->render('@ServiceApresVente/Reclamation/showDetaillOne.html.twig', array(
            'date' => $f->getDate(),
            'image' => $f->getImage(),
            'objet' => $f->getObjet(),
            'descripion' => $f->getDescription(),
            'categorie' => $f->getIdc(),
            'autres'=>$newRec,

            'id' => $f->getIdRec()
        ));
    }


    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $requestString = $request->get('q');

        $entities =  $em->getRepository('ServiceApresVenteBundle:Reclamation')->findEntitiesByString($requestString);

        if(!$entities) {
            $result['entities'] = "Réclamation n'existe pas";
        } else {
            $result['entities'] = $this->getRealEntities($entities);
        }

        return new Response(json_encode($result));
    }

    public function getRealEntities($entities){

        foreach ($entities as $entity){
            $realEntities[$entity->getIdRec()] = [$entity->getImage(),$entity->getObjet()];
        }

        return $realEntities;
    }


    public function envoyerReclamationAction() {
        $user = $this->getUser()->getUsername();

        return $this->render('@ServiceApresVente/Reclamation/SuccessReclamation.html.twig', array("user" => $user));

    }


    public function reponseAdminReclamationAction($id) {
        $em = $this->getDoctrine()->getManager();
        $f = $em->getRepository(Reclamation::class)->find($id);

        //


        $em = $this->getDoctrine()->getManager();
        $etat = $em
            ->getRepository(Reclamation::class)
            ->confirmer($id);
        $em->flush();

//        return $this->redirectToRoute('admin_read_reclamation');

        //



        //------Add response Admin about notification

        $manager = $this->get('mgilet.notification');

        if(isset($_POST['desc'])) {
            $notif = $manager->createNotification($_POST['desc']);

            $notif->setMessage($_POST['desc']);
            // $notif->setLink($this->redirectToRoute('read_reclamation'));
            // or the one-line method :


            // you can add a notification to a list of entities
            // the third parameter `$flush` allows you to directly flush the entities
            $manager->addNotification(array($f), $notif, true);
            //return $this->redirectToRoute("admin_dashboard");

        }
        $commandeFacture = $this->getDoctrine()->getRepository(Facture::class)->findBy(['idCommande'=>
            $f->getCommandeproduits()->getId()]);


        //var_dump($reclamationCat);die();
        return $this->render('@ServiceApresVente/Admin/reponseReclamation.html.twig',array(
            'date' => $f->getDate(),
            'image' => $f->getImage(),
            'objet' => $f->getObjet(),
            'descripion' => $f->getDescription(),
            'prodCmd' => $f->getCommandeproduits()->getId(),
            'prodCmdQuantite' => $f->getCommandeproduits()->getTotal(),
            'categorie' => $f->getIdc(),
            'produit' => $f->getProduit()->getLibelle(),
            'produitImage' => $f->getProduit()->getPhoto(),
            'username' => $f->getUser()->getUsername(),
            'etat'=>$etat,"maCommandeFacture"=>$commandeFacture,

            'id' => $f->getIdRec()
        ));

    }


    public function autocompleteAction(Request $request)
    {
        $names = array();
        $term = trim(strip_tags($request->get('term')));

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ServiceApresVenteBundle:Reclamation')->createQueryBuilder('c')
            ->where('c.objet LIKE :objet')
            ->setParameter('objet', '%'.$term.'%')
            ->getQuery()
            ->getResult();

        foreach ($entities as $entity)
        {
            $names[] = $entity->getObjet();
        }

        $response = new JsonResponse();
        $response->setData($names);

        return $response;
    }


    public function markAllAsSeenAction($notifiable)
    {
        $manager = $this->get('mgilet.notification');
        $manager->markAllAsSeen(
            $manager->getNotifiableInterface($manager->getNotifiableEntityById($notifiable)),
            true
        );

        return ($this->render('@ServiceApresVente/Admin/readReclamation.html.twig', array("notifiable" => $notifiable)));
    }





        //Chercher
        public function ChercherAction(Request $request){
        $em=$this->getDoctrine()->getManager();

        if ($request->isMethod("POST")){
            if ($request->isXmlHttpRequest()) {
                $serializer = new Serializer(
                    array(
                        new ObjectNormalizer()
                    )
                );
                $covoiturages = $em->getRepository(Reclamation::class)->findCustom($request->get('input'),
                    $request->get('date'));
                $data = $serializer->normalize($covoiturages);
                return new JsonResponse($data);
            }
        }
        return new Response();
    }











    //






}
