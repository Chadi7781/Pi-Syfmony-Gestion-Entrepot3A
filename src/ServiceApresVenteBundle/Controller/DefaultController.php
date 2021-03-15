<?php

namespace ServiceApresVenteBundle\Controller;

use EmployeBundle\Entity\Employe;
use Ob\HighchartsBundle\Highcharts\Highchart;
use ServiceApresVenteBundle\Entity\Feedback;
use ServiceApresVenteBundle\Entity\Rating;
use ServiceApresVenteBundle\Entity\Reclamation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Validator\Constraints\DateTime;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@ServiceApresVente/Default/index.html.twig');


    }
    public function mapAction()
    {
        return $this->render('@ServiceApresVente/Admin/map.html.twig');


    }




    public function afficherStatitstiqueAdminLAction() {
        $em = $this->getDoctrine()->getManager();


        //begin reclamation_feedback statics//
        $count = $em->getRepository(Feedback::class)->calculerTotalFeedback();
        $livreursEvaluees = $em->getRepository(Rating::class)->getLivreurTopNotez();

        $nbrRec=$this->getDoctrine()->getManager()->getRepository(Reclamation::class)->calculerTotalReclamation();
        $reclamations = $this->getDoctrine()->getManager()->getRepository(Reclamation::class)->findAll();
        $now = new \DateTime();
        $data = $this->getDoctrine()->getManager()->getRepository(Reclamation::class)->getByDate($now);
        $total = $count +$nbrRec;
        $nbrFeedParRapportRec = ($count / $total)*100;
        $nbrRecParRapportFeed = ($nbrRec / $total)*100;

        $tousLivreurs = $em->getRepository(Rating::class)->getNbrRating();


        $ob2 = new Highchart();
        $ob2->chart->renderTo('chartFeedbackReclamaation');
        $ob2->plotOptions->pie(array(
            'allowPointSelect' => true,
            'cursor' => 'pointer',
            'dataLabels' => array('enabled' => false),
            'showInLegend' => true
        ));
        $ob2->chart->type('bar');
        $ob2->chart->height('400');
        $ob2->chart->width('400');
        $ob2->title->text('Nombres');


        $data = array(
            array(
                'name' => 'Reclamations',
                'y' => (int)$nbrRec,
                'color' => 'pink',
                'visible' => true
            ),
            array(
                'name' => 'Feedback',
                'y' => (int)$count,
                'color' => 'green',
                'visible' => true
            ),
            array(
                'name' => 'Livreurs',
                'y' => (int)$tousLivreurs,
                'color' => 'orange',
                'visible' => true
            )
        );

        $feed_recChart2 = array(
            array(
                "name" => "Nombre",
                "data" => $data
            ),
        );

        $ob2->series($feed_recChart2);



        $i = 0;
        foreach ($livreursEvaluees as $b) {
            $evaluation = new Feedback();
            $evaluations = $em->getRepository("ServiceApresVenteBundle:Rating")
                ->findBy(array('livreur' => $b));
            //var_dump($b);//var_dump($b);
            $note = 0;
            foreach ($evaluations as $e) {
                $note = $note + $e->getValue();
            }
            $noteMoyenne = $note / $count;
            $noteMoyenne = round($noteMoyenne);
            $evaluation->setNote($noteMoyenne);
            $liv = $em->getRepository(Employe::class)->findOneBy(array('idEmp' => $b));
            $evaluation->setLivreur($liv);

            $topTen[$i] = $evaluation;
            $namesB[$i] = $liv->getUsername();

            $noteB[$i] = $noteMoyenne;
            $i++;
        }



        $boutiqueChart = array(
            array(
                "name" => "Note",
                "data" => $noteB
            ),
        );

        $ob = new Highchart();
        $ob->chart->renderTo('chartLiv');
        $ob->title->text('Top 5 Livreurs');
        $ob->chart->type('column');
        $ob->yAxis->title(array('text' => "Avis"));
        $ob->xAxis->title(array('text' => "Nom Livreur"));
        $ob->xAxis->categories($namesB);

        $ob->series($boutiqueChart);




        return $this->render('@ServiceApresVente/Admin/index.html.twig', array('nbFeed'=>$count,'now'=>$now,
            'nbRec'=>$nbrRec,"nbrFeedParRapportRec"=>$nbrFeedParRapportRec,'reclamation'=>$reclamations,'data'=>$data,
            "nbrRecParRapportFeed"=>$nbrRecParRapportFeed,
            "evaluations" => $topTen, "chart" => $ob,"chart2"=>$ob2,

        ));
    }







//    public function AjouterCommandeAction(Request $request)
//    {
//        $em = $this->getDoctrine()->getManager();
//
//        $session = $request->getSession();
//        $panier = $session->get('panier');
//
//        $iduser = $request->get('userid');
//        $user = $em->getRepository(User::class)->find($iduser);
//        $total = $request->get('total');
//        $date = new \DateTime();
//
//        $commande = new Commande();
//
//
//        $commande->setUser($user);
//        $commande->setPrixTotal($total);
//        $commande->setDateCommande($date);
//        $commande->setEtatCommande(0);
//        $em->persist($commande);
//        $em->flush();
//        $em->clear();
//
//        $produits = $em->getRepository('ProduitBundle:Produit')->findArray(array_keys($panier));
//
//        for ($i = 0; $i < Count($produits); $i++) {
//
//            $ligneCmd = new LignesCommande();
//            $commande1= $em->getRepository(Commande::class)->find($commande->getIdCommande());
//            $ligneCmd->setIdCommande($commande);
//            $ligneCmd->setIdProduit($produits[$i]);
//            $ligneCmd->setQte($panier[$produits[$i]->getIdProduit()]);
//            $em->persist($ligneCmd);
//            $em->flush();
//        }
//
//        return $this->redirect($this->generateUrl('AjouterPaiement', array('id_commande' => $commande->getIdCommande())));
//
//
//
//    }
//


}