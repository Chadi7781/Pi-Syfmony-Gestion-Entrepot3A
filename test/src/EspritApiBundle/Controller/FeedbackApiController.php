<?php

namespace EspritApiBundle\Controller;

use AppBundle\Entity\User;
use EmployeBundle\Entity\Employe;
use ServiceApresVenteBundle\Entity\Feedback;
use ServiceApresVenteBundle\Entity\Rating;
use ServiceApresVenteBundle\Entity\RecFeedCat;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class FeedbackApiController extends Controller
{
    public function indexAction()
    {
        return $this->render('EspritApiBundle:Default:index.html.twig');
    }

    public function allLivreurAction() {
        $reclamation = $this->getDoctrine()->getManager()->getRepository(Feedback::class)->findOneByMission();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($reclamation);

        return new JsonResponse($formatted);

    }

    public function allFeedbackAction() {
        $reclamation = $this->getDoctrine()->getManager()->getRepository(Feedback::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($reclamation);

        return new JsonResponse($formatted);

    }


    public function GetIdLivreurAction(Request $request)
    {
        $user = $this->getDoctrine()->getManager()->getRepository(Employe::class)
            ->find($request->get('idEmp'));


        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }





    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id_user = $request->get("iduser");
        $id_liv = $request->get("idlivreur");
        //   $id_u = $request->get("id_cat");
        $user = new \AppBundle\Entity\User();
        $us = $em->getRepository(\AppBundle\Entity\User::class)->find($id_user);
        $livreur = $em->getRepository(Employe::class)->find($id_liv);
        // $i = $em->getRepository(RecFeedCat::class)->find($id_u);
        $description= $request->get("description");
        $note = $request->get("note");
        $image= $request->get("image");
        $idLiv = $request->get("id");

        $date = new \DateTime('now');



        //$f = $this->getDoctrine()->getManager()->getRepository(RecFeedCat::class)->find(8);
        $rec = new Feedback();
        $rec->setDescription(urldecode($description));
        $rec->setDatefeedback($date);
        $rec->setNote($note);
        $rec->setLivreur($livreur);
        // $event->setIdc(urldecode($lieu));

        $rec->setUser($us);
        // $rec->setIdc($i);
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



    public function AjouterRateAction(Request $request)
    {
        $user = $request->query->get("iduser");
        $idl = $request->query->get("ID_emp");
        $not = $request->query->get("note");
        $rate = new Rating();
        $em = $this->getDoctrine()->getManager();
        $user1 = $em->getRepository(User::class)->find($user);
        $idliv = $em->getRepository(Employe::class)->find($idl);
        $rate->setUser($user1);
        $rate->setLivreur($idliv);
        $rate->setValue($not);
        $em->persist($rate);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($rate);
        return new JsonResponse($formatted);

    }



    public function getNbrFeedbackAction() {
        $em =$this->getDoctrine()->getManager();
        $nbr = $this->getDoctrine()->getManager()->getRepository(Feedback::class)->calculerTotalFeedback();
        return new Response($nbr);

    }


    public function allLRatingAction() {
        $reclamation = $this->getDoctrine()->getManager()->getRepository(Rating::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($reclamation);

        return new JsonResponse($formatted);

    }


    public function getNbrRatingAction() {
        $em =$this->getDoctrine()->getManager();
        $nbr = $em->getRepository(Rating::class)->getNbrRating();
        return new Response($nbr);

    }

    public function getRatingByLivreurAction(Request $request) {
        $note = $this->getDoctrine()->getManager()->getRepository(Feedback::class)->findNoteByIdLivreur($request->get('livreur'));
        $count = 0;
        foreach ($note as $notes)
            $count = $count +$notes['note'];


        return new Response($count);

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

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($topTen);

        return new JsonResponse($formatted);

//
//        return $this->render('@ServiceApresVente/Feedback/FeedbackLivreur.html.twig', array(
//            "livreurs"=>$livreurs,"tousLivreurs"=>$evaluationTousLivreur, "all"=>$all, "evaluations"=>$topTen , "boutiques" => $boutiques,"noteMoyenne"=>$noteMoyenne
//        ));

    }



    public function  imageLivreurAction(Request $request) {
        $publicResourcesFolderPath = $this->get('kernel')->getRootDir() . '/../web/uploads/';
        $image = urldecode($request->get('image'));

        return new BinaryFileResponse($publicResourcesFolderPath . $image);    }


    public function getTotalRatingFromUserAction() {
        $reclamation = $this->getDoctrine()->getManager()->getRepository(Rating::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($reclamation);

        return new JsonResponse($formatted);

    }
}
