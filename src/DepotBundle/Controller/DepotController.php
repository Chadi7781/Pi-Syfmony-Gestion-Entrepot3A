<?php

namespace DepotBundle\Controller;

use DepotBundle\Entity\Depot;
use DepotBundle\Entity\DepotUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Depot controller.
 *
 * @Route("depot")
 */
class DepotController extends Controller
{
    /**
     * Lists all depot entities.
     *
     * @Route("/", name="depot_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $depots = $em->getRepository('DepotBundle:Depot')->findAll();


        return $this->render('@Depot/index.html.twig',array(
            'depots' => $depots,
        ));
    }

    /**
     *
     * @Route("/new", name="depot_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $depot = new Depot();

        $form = $this->createFormBuilder($depot)

            ->add('adresse', TextType::class,[
                'attr' => [
                    'placeholder' => 'Entrer Votre Adresse',

                ],
            ])
                ->add('surface', TextType::class,[
                'attr' => [
                    'placeholder' => 'Entrer Votre Surface',

                ],
            ])
            ->add('prix', TextType::class,[
                'attr' => [
                    'error_bubbling' => true,
                    'placeholder' => 'Entrer Votre Prix',

                ],
            ])


            ->add('etat',ChoiceType::class, [
                'choices'  => [
                    'Disponible' => 'dispo',
                    'Non Disponible' => 'indispo',

                ],
            ])
//            ->add('dueDate')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($depot);
            $em->flush();

            return $this->redirectToRoute('depot_index');
        }

        return $this->render('@Depot/new.html.twig', array(
            'depot' => $depot,
            'form' => $form->createView(),
        ));
    }


    /**
     *
     * @Route("/{id}/edit", name="depot_edit")
     * @Method({"GET", "POST"})
     */

    public function editAction(Request $request, Depot $depot)
    {
//        $deleteForm = $this->createDeleteForm($employee);
        $editForm = $this->createFormBuilder($depot)

            ->add('adresse', TextType::class,[
                'attr' => [
                    'placeholder' => 'Entrer Votre Adresse',

                ],
            ])
            ->add('surface', TextType::class,[
                'attr' => [
                    'placeholder' => 'Entrer Votre Surface',

                ],
            ])
            ->add('prix', TextType::class,[
                'attr' => [
                    'error_bubbling' => true,
                    'placeholder' => 'Entrer Votre Prix',

                ],
            ])


            ->add('etat',ChoiceType::class, [
                'choices'  => [
                    'Disponible' => 'dispo',
                    'Non Disponible' => 'indispo',

                ],
            ])
//            ->add('dueDate')
            ->getForm();
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('depot_index');
        }

        return $this->render('@Depot/edit.html.twig', array(
            'depot' => $depot,
            'edit_form' => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @Route("/delete/{id}", name="depot_delete", methods={"GET"})
     */
    public function delete(Request $request, Depot $depot, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $depots = $entityManager->getRepository('DepotBundle:Depot')->find($id);
        $entityManager->remove($depots);
        $entityManager->flush();





        return $this->redirectToRoute('depot_index');
    }

    /**
     * @Route("/location",name="location_index")
     * @Method("GET")
     */
    public function indexFrontOfficeDepot(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

//        $depots = $em->getRepository('DepotBundle:Depot')->findAll();
        $sql = "SELECT depot FROM DepotBundle:Depot depot";
        $query = $em->createQuery($sql);
        $paginate  = $this->get('knp_paginator')->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 2)
        );



        return $this->render('@Depot/frontOffice/index.html.twig',array(
            'depots' => $paginate,
        ));
    }

    /**
     * @Route("/location/{id}", name="location_show")
     * @Method({"GET", "POST"})
     */
    public function showFrontOfficeLocation(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $depots = $em->getRepository('DepotBundle:Depot')->find($id);
        $depUser = new DepotUser();

        $showForm = $this->createFormBuilder($depUser)
        ->add('datedebut',DateType::class,[
        'widget' => 'single_text',
    ])
        ->add('datefin',DateType::class,[
            'widget' => 'single_text',
        ])
        ->getForm();
        $showForm->handleRequest($request);
//        dump($request);
        if ($showForm->isSubmitted() && $showForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $depUser->setIdDepot($depots->getId());
            $depUser->setIdUser(1);
            $depUser->setEtat("fini");
            $depots->setEtat('indispo');

            $em->persist($depUser);
            $em->flush();
        }


        return $this->render('@Depot/frontOffice/singlePage.html.twig', [
            'location' => $depots,
            'show_form' => $showForm->createView(),
        ]);
    }




}