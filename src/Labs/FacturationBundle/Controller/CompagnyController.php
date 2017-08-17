<?php

namespace Labs\FacturationBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Labs\FacturationBundle\Entity\Compagny;
use Labs\FacturationBundle\Form\CompagnyType;
use Labs\FacturationBundle\Form\CompagnyEditType;

/**
 * Compagny controller.
 * @Route("/compagny")
 */
class CompagnyController extends Controller
{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/add", name="labs_facturation_compagny_add")
     * @Method("POST")
     */
    public function addAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $compagny = new Compagny();

        //formulaire declarer dans un services
        $form = $this->createForm(new CompagnyType(), $compagny);

        if($form->handleRequest($request)->isValid()){
            //chargement de la base de donnée
            $em->persist($compagny);
            $em->flush();
            // Enregistrement du message dans la session
            $this->addFlash('success','le contenu à est bien enregistré');
            return $this->redirect($this->generateUrl('labs_facturation_compagny_list'));
        }

        return $this->render('LabsFacturationBundle:Compagny:add.html.twig',array(
            'form'=>$form->createView()
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/view", name="labs_facturation_compagny_list")
     * @Method("GET")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('LabsFacturationBundle:Compagny');
        $list = $repository->findAll();

        return $this->render('LabsFacturationBundle:Compagny:list.html.twig',array(
            'list'=>$list
        ));
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/edit/{id}", name="labs_facturation_compagny_edit", requirements={"id" : "\d+"})
     * @Method("PUT")
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $compagny = $em->getRepository('LabsFacturationBundle:Compagny')->find($id);
        if(null === $compagny){
            throw new NotFoundHttpException("La Compagnie n'existe pas");
        }
        $form = $this->createForm(new CompagnyEditType(),$compagny);
        if($form->handleRequest($request)->isValid())
        {
            $em->flush();
            $this->addFlash('success','Le contenu à été bien modifier');
            return $this->redirect($this->generateUrl('labs_facturation_compagny_list'));
        }
        return $this->render('LabsFacturationBundle:Compagny:edit.html.twig',array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/delete/{id}", name="labs_facturation_compagny_delete", requirements={ "id" : "\d+" })
     * @Method({"GET", "DELETE"})
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $compagny = $em->getRepository('LabsFacturationBundle:Compagny')->find($id);
        if( null === $compagny)
            throw new NotFoundHttpException('la compagnie n\'existe pas');
        else
            $em->remove($compagny);
        $em->flush();
        $this->addFlash('success','Le contenu à été bien Supprimer');
        return $this->redirect($this->generateUrl('labs_facturation_compagny_list'));
    }
}
