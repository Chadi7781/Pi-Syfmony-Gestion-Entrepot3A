<?php

namespace ServiceApresVenteBundle\Controller;

use ServiceApresVenteBundle\Entity\Feedback;
use ServiceApresVenteBundle\Entity\RecFeedCat;
use ServiceApresVenteBundle\Entity\Reclamation;
use ServiceApresVenteBundle\Form\FeedbackType;
use ServiceApresVenteBundle\Form\RecFeedCatType;
use ServiceApresVenteBundle\Form\ReclamationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use VenteBundle\Entity\Categorie;

class RecFeedCatController extends Controller
{

    private function createCreateForm(RecFeedCat $entity)
    {
        $form = $this->createForm(RecFeedCatType::class, $entity, array(
            'action' => $this->generateUrl('admin_add_categorie'),
            'method' => 'POST',
        ));



        return $form;
    }

    /**
     * Displays a form to create a new cat entity.
     *
     */
    public function newAction()
    {
        $entity = new RecFeedCat();
        $form   = $this->createCreateForm($entity);

        return $this->render('@ServiceApresVente/Admin/createCategorie.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a cat entity.
     */

    public function createCategorieAction(Request $request)
    {
        $entity = new RecFeedCat();

       // $form = $this->createForm(RecFeedCatType::class, $recfeedcat);
        $form = $this->createCreateForm($entity);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            //$entity->upload();
            $entity->upload();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('succes'," bien ajouter Catégorie !");


            return $this->redirectToRoute("admin_read_categorie");
        }
        return $this->render("@ServiceApresVente/Admin/createCategorie.html.twig", array("form" => $form->createView() ,"entity"=>$entity));
    }


    public function readCategorieAction() {
        $categories=$this->getDoctrine()->getManager()->getRepository(RecFeedCat::class)->findAll();
        return $this->render("@ServiceApresVente/Admin/readCategorie.html.twig",array("categories"=>$categories));

    }
    public function getDetailCategorieAction() {
        $categories=$this->getDoctrine()->getManager()->getRepository(RecFeedCat::class)->findAll();
        return $this->render("@ServiceApresVente/Admin/readCategorie.html.twig",array("categories"=>$categories));

    }
    public function nameAction($nom,SessionInterface $session,Request $request) {
        $idpc = $request->get('idpc');
        $idp = $request->get('idp');
        $categories=$this->getDoctrine()->getManager()->getRepository(RecFeedCat::class)->findAll();

        $type=$session->get('type',[]);
        if(!empty($type[$nom])) {
            new Response('empty nom');
        }
        if($nom == "Feedback")
        {

        $session->set('type',$nom);
        dump($session->get('type'));die();
        }
        else {
            $session->set('type',"Reclamation");
            dump($session->get('type'));
        }
        return $this->render('@ServiceApresVente/Categorie/showCategorie.html.twig',array("idp"=>$idp,"idpc"=>$idpc,"categories"=>$categories,'type'=>$nom));


    }  private function createEditForm(RecFeedCat $entity)
{
    $form = $this->createForm(RecFeedCatType::class, $entity, array(
        'action' => $this->generateUrl('admin_update_categorie', array('id' => $entity->getIdCat())),
        'method' => 'PUT',
    ));
    $form->add('submit', SubmitType::class, array('label' => 'Edit Categorie'));

    return $form;
}

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_categorie_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, array('label' => 'Delete'))
            ->getForm()
            ;
    }


    public function updateCategorieAction(Request $request ,$id)
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository(RecFeedCat::class)->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find category entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
          $entity->upload();
            $em=$this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirect($this->generateUrl('admin_read_categorie'));
        }

        return $this->render('@ServiceApresVente/Admin/updateCategorie.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    public function deleteCategorieAction($id) {
        $em=$this->getDoctrine()->getManager();
        $i= $em->getRepository(RecFeedCat::class)->find($id);
        $em->remove($i);
        $em->flush();
            return $this->redirectToRoute('admin_read_categorie');
        }



}
