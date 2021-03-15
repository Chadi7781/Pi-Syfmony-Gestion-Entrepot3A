<?php

namespace ServiceApresVenteBundle\Controller;

use blackknight467\StarRatingBundle\Form\RatingType;
use blackknight467\StarRatingBundle\StarRatingBundle;
use ClassesWithParents\F;
use EmployeBundle\Entity\Employe;
use FOS\UserBundle\Model\User;
use Ob\HighchartsBundle\Highcharts\Highchart;
use ServiceApresVenteBundle\Entity\Feedback;
use ServiceApresVenteBundle\Entity\Rating;
use ServiceApresVenteBundle\Entity\RecFeedCat;
use ServiceApresVenteBundle\Form\FeedbackType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class FeedbackController extends Controller
{

    public function indexAction() {
        return $this->render('@ServiceApresVente/Default/index.html.twig');

    }

    public function readFeedbackAction() {
        $feedbacks=$this->getDoctrine()->getManager()->getRepository(Feedback::class)->findBy([
            'user'=>$this->getUser()
        ]);        $count = $this->getDoctrine()->getRepository(Feedback::class)->calculerTotalFeedback();
        if($count==0)
            $this->addFlash('info', 'Vous n"avez aucun Feedbacks envoyée :) !');

        return $this->render('@ServiceApresVente/Feedback/readFeedback.html.twig',array("feedbacks"=>$feedbacks,"count"=>$count));
    }


    //--------------------------------------------------------
    public function createFeedbackAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $rating = new Rating();

        $feedback = new Feedback();
        $form = $this->createForm(FeedbackType::class, $feedback);
         $liv=$em->getRepository(Employe::class)->find($id);
        $noteCount = count($em->getRepository(Rating::class)->findBy(
            array(
                'livreur'=>$id
            )
        ));

        $noteUser = $em->getRepository(Feedback::class)->findBy(['user'=>$this->getUser(),'livreur'=>$liv]);
        $livreurExist = $em->getRepository(Rating::class)->findBy(['livreur'=>$liv]);


        $countnoteByUser=0;

            foreach ($noteUser as $n)
            {
                $countnoteByUser = $countnoteByUser +$n->getNote();

            }









        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $feedback->upload();


            $feedback->setDatefeedback(new \DateTime('now'));
            $feedback->setLivreur($liv);
            $feedback->setUser($this->getUser());
           $currentFeedRating = $feedback->getNote();
            $em->persist($feedback);
            $em->flush();

            //totale rating user for specific livreur
            $rating->setValue($countnoteByUser+$currentFeedRating);

            $rating->setLivreur($liv);
            $rating->setUser($this->getUser());

            $em->persist($rating);
            $em->flush();
            $this->addFlash('info', 'Création avec succés !');


            return $this->redirectToRoute("read_feedback_me");
        }
        return $this->render("@ServiceApresVente/Feedback/createFeedback.html.twig", array("idLivreur"=>$liv,"form" => $form->createView()));
    }
    //--------------------------------------------------------
    public function updateFeedbackAction(Request $request ,$id)
    {

        $feedback = $this->getDoctrine()->getManager()->getRepository(Feedback::class)->find($id);
        $form = $this->createForm(FeedbackType::class, $feedback);

        $form->handleRequest($request);
        if ($form->isValid()) {

            $file = $feedback->getImage();
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('kernel.project_dir').'/web/uploads/feedback_image',$filename);
            $feedback->setImage($filename);
            $feedback->setDatefeedback(new \DateTime('now'));
            $em=$this->getDoctrine()->getManager();
            $em->persist($feedback);
            $em->flush();

            return $this->redirectToRoute('read_feedback');

        }
        return $this->render("@ServiceApresVente/Feedback/updateFeedback.html.twig", array("form" => $form->createView()));
    }



//    public function deleteFeedbackAction($id) {
//        $el=$this->getDoctrine()->getManager();
//        $em=$el->getRepository(Feedback::class)->find($id);
//        $el->remove($em);
//        $el->flush();
//
//        return $this->redirectToRoute('read_feedback');
//    }

//
//
//    public function AjouterRateAction($idu, $idp, $value)
//    {
//        $rate = new Rate();
//        $em = $this->getDoctrine()->getManager();
//        $user = $em->getRepository(User::class)->find($idu);
//        $produit = $em->getRepository(Produit::class)->find($idp);
//        $rate->setIduser($user->getId());
//        $rate->setIdproduit($produit->getId());
//        $rate->setValue($value);
//        $em->persist($rate);
//        $em->flush();
//        $serializer = new Serializer([new ObjectNormalizer()]);
//        $formatted = $serializer->normalize($rate);
//        return new JsonResponse($formatted);
//
//    }




        public function listFeedbackAction() {
            $feedbacks=$this->getDoctrine()->getManager()->getRepository(Feedback::class)->findAll();
            $count = $this->getDoctrine()->getRepository(Feedback::class)->calculerTotalFeedback();
            if($count==0)
                $this->addFlash('info', 'Vous n"avez aucun Feedbacks recu :) !');




            return $this->render('@ServiceApresVente/Admin/readFeedback.html.twig',array("feedbacks"=>$feedbacks,"count"=>$count));
        }



    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $feedbacks =  $em->getRepository(Feedback::class)->findEntitiesByString($requestString);
        if(!$feedbacks) {
            $result['$feedbacks']['error'] = "Feedback non trouvé :( ";
        } else {
            $result['$feedbacks'] = $this->getRealEntities($feedbacks);
        }
        return new Response(json_encode($result));
    }
    public function getRealEntities($feedbacks){
        foreach ($feedbacks as $feedbacks){
            $realEntities[$feedbacks->getIdFeed()] = [$feedbacks->getImage(),$feedbacks->getDateFeedback()];

        }
        return $realEntities;
    }

    public function showdetailedAction($id)
    {
        $em= $this->getDoctrine()->getManager();
        $f=$em->getRepository(Feedback::class)->find($id);
        return $this->render('@ServiceApresVente/Feedback/showDetaillOne.html.twig', array(
            'date'=>$f->getDateFeedback(),
            'image'=>$f->getImage(),
            'descripion'=>$f->getDescription(),
            'categorie'=>$f->getIdc(),
            'id'=>$f->getIdFeed()
        ));
    }



    public function listTopLivreurAction() {
        $em = $this->getDoctrine()->getManager();
        $boutiquesEvaluees = $em->getRepository(Rating::class)->getLivreurTopNotez();
        $tousLivreurs = $em->getRepository(Rating::class)->getLivreurNotez();
        $totalFeedback = $em->getRepository(Feedback::class)->calculerTotalFeedback();
        $i = 0;
        //var_dump($boutiquesEvaluees);
        //Top 5
        foreach ($boutiquesEvaluees as $b) {
            if($b != null){
                $evaluation = new Feedback();
                $evaluations = $em->getRepository("ServiceApresVenteBundle:Rating")
                    ->findBy(array('livreur' => $b));
                //var_dump($b);
                $note = 0;
                $numberOfReviews = 0;

                foreach ($evaluations as $e) {

                    $numberOfReviews++;
                    $note = $note + $e->getValue();
              }
                try {
                    $noteMoyenne = $note /$totalFeedback;

                }catch (\Exception $ee) {

                }
                $noteMoyenne = round($noteMoyenne);


                $evaluation->setNote($noteMoyenne);
                $boutique = $em->getRepository(Employe::class)->findOneBy(array('idEmp' => $b));
                $boutiques[$i]=$boutique;
                $evaluation->setLivreur($boutique);
                $topTen[$i] = $evaluation;
                $i++;

            }

        }


        //all
        $j=0;
        foreach ($tousLivreurs as $b) {
            if($b != null){
                $evaluationTousLivreur = new Feedback();
                $evaluations = $em->getRepository("ServiceApresVenteBundle:Rating")
                    ->findBy(array('livreur' => $b));
                //var_dump($b);
                $note = 0;
                $numberOfReviews = 0;

                foreach ($evaluations as $e) {

                    $numberOfReviews++;
                    $note = $note + $e->getValue();
                }
                try {
                    $noteMoyenne = $note /$totalFeedback;

                }catch (\Exception $ee) {

                }
                $noteMoyenne = round($noteMoyenne);


                $evaluationTousLivreur->setNote($noteMoyenne);
                $liv = $em->getRepository(Employe::class)->findOneBy(array('idEmp' => $b));
                $livreurs[$j]=$liv;
                $evaluationTousLivreur->setLivreur($liv);
                $all[$j] = $evaluationTousLivreur;
                $j++;

            }


        }

        return $this->render('@ServiceApresVente/Feedback/FeedbackLivreur.html.twig', array(
          "livreurs"=>$livreurs,"tousLivreurs"=>$evaluationTousLivreur, "all"=>$all, "evaluations"=>$topTen , "boutiques" => $boutiques,"noteMoyenne"=>$noteMoyenne
        ));

    }



    public function getLivreurByIdAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $emp = new Employe();
        $livDAta = $em->getRepository(Employe::class)->findBy(['idEmp' => $id]);
        $feedbacks = $em->getRepository(Feedback::class)->findBy(['livreur'=>$id]);


        //count total
        $rating = $em->getRepository(Rating::class)->findBy(['livreur'=>$id]);
        //

        $all = $em->getRepository(Feedback::class)->findAll();


        $rateLivreurTotale =0;
        foreach ($livDAta as $e) {
            $livreur = $e->getImage();
            $username = $e->getUsername();
            $adresse = $e->getAdresse();
            $governat = $e->getGovernat();
            $disponible = $e->getDisponible();
            $telephone = $e->getTelephone();
            $idlivreur = $e->getIdEmp();
            $rateLivreurTotale = $em->getRepository(Feedback::class)->getTotalRateLivreur($idlivreur);
        }

        return $this->render('@ServiceApresVente/Feedback/detailLivreur.html.twig', array(

            "username" => $username,
            "adresse" => $adresse,
            "governat" => $governat,
            "telephone" => $telephone,
            "livreur" => $livreur,
            "idlivreur"=>$idlivreur,
            "all"=>$all,
            "disponible"=>$disponible,
            "total"=>$rateLivreurTotale,
            "feedback" => $feedbacks));
    }


    //display top 5 livrerur by rating



    //





}
