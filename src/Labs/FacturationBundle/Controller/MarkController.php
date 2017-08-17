<?php
namespace Labs\FacturationBundle\Controller;

use Labs\FacturationBundle\Entity\Mark;
use Labs\FacturationBundle\Form\MarkEditType;
use Labs\FacturationBundle\Form\MarkType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 * Class MarkController
 * @package Labs\FacturationBundle\Controller
 * @Route("/brand")
 */
class MarkController extends Controller
{

    /**
     * Admin action for color
     */

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/add", name="labs_facturation_mark_add")
     * @Method("POST")
     */
    public function addAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $mark = new Mark();

        //formulaire declarer dans un services
        $form = $this->createForm(new MarkType(), $mark);

        if($form->handleRequest($request)->isValid()){
            $em->persist($mark);
            $em->flush();
            // Enregistrement du message dans la session
            $this->addFlash('success','le contenu a été bien enregistré');
            return $this->redirect($this->generateUrl('labs_facturation_mark_list'));
        }

        return $this->render('LabsFacturationBundle:Marks:add.html.twig',array(
            'form'=>$form->createView()
        ));

    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/modal/add", name="labs_facturation_mark_modal_add")
     * @Method({"GET", "POST"})
     */
    public function addModalAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $mark = new Mark();

        //formulaire declarer dans un services
        $form = $this->createForm(new MarkType(), $mark);

        if($form->handleRequest($request)->isValid()){
            $em->persist($mark);
            $em->flush();
            // Enregistrement du message dans la session
            $this->addFlash('success','le contenu a été bien enregistré');
            return $this->redirect($this->generateUrl('labs_facturation_product_add'));
        }

        return $this->render('LabsFacturationBundle:Includes:modal_mark.html.twig',array(
            'form'=>$form->createView()
        ));

    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/list", name="labs_facturation_mark_list")
     * @Method("GET")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('LabsFacturationBundle:Mark');
        $list = $repository->findAll();

        return $this->render('LabsFacturationBundle:Marks:list.html.twig',array(
            'list'=>$list
        ));
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/edit/{id}", name="labs_facturation_mark_edit")
     * @Method("PUT")
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $mark = $em->getRepository('LabsFacturationBundle:Mark')->find($id);

        if(null === $mark){
            throw new NotFoundHttpException("La marque d'id ".$id." n'existe pas");
        }

        $form = $this->createForm(new MarkEditType(), $mark);
        if($form->handleRequest($request)->isValid())
        {
            $em->flush();
            $this->addFlash('success','Le contenu a été bien modifier');
            return $this->redirect($this->generateUrl('labs_facturation_mark_list'));
        }

        return $this->render('LabsFacturationBundle:Marks:edit.html.twig',array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/delete/{id}", name="labs_facturation_mark_delete")
     * @Method({"DELETE", "GET"})
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        // On deja le Couleur grace a cette fonction
        $mark = $em->getRepository('LabsFacturationBundle:Mark')->find($id);
        if( null === $mark)
            throw new NotFoundHttpException('La Marque '.$id.' n\'existe pas');
        else
            $em->remove($mark);
            $em->flush();
        $this->addFlash('success','Le contenu a été bien Supprimer');
        return $this->redirect($this->generateUrl('labs_facturation_mark_list'));

    }

}