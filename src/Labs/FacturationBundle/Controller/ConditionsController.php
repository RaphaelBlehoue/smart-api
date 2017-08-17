<?php
namespace Labs\FacturationBundle\Controller;

use Labs\FacturationBundle\Entity\Conditions;
use Labs\FacturationBundle\Form\ConditionsEditType;
use Labs\FacturationBundle\Form\ConditionsType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ConditionsController
 * @package Labs\FacturationBundle\Controller
 * @Route("/condition")
 */
class ConditionsController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/add", name="labs_facturation_condition_add")
     * @Method("POST")
     */
    public function addAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $condition = new Conditions();

        //formulaire declarer dans un services
        $form = $this->createForm(new ConditionsType(), $condition);

        if($form->handleRequest($request)->isValid()){
            $em->persist($condition);
            $em->flush();
            // Enregistrement du message dans la session
            $this->addFlash('success','la condition a été bien créer');
            return $this->redirect($this->generateUrl('labs_facturation_condition_view'));
        }

        return $this->render('LabsFacturationBundle:Condition:add.html.twig',array(
            'form'=>$form->createView()
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/modal/add", name="labs_facturation_condition_modal_add")
     * @Method({"GET", "POST"})
     */
    public function addModalAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $condition = new Conditions();

        //formulaire declarer dans un services
        $form = $this->createForm(new ConditionsType(), $condition);

        if($form->handleRequest($request)->isValid()){
            $em->persist($condition);
            $em->flush();
            // Enregistrement du message dans la session
            $this->addFlash('success','la condition a été bien créer');
            return $this->redirect($this->generateUrl('labs_facturation_proforma_get_create'));
        }

        return $this->render('LabsFacturationBundle:Includes:modal_condition.html.twig',array(
            'form'=>$form->createView()
        ));
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/view", name="labs_facturation_condition_view")
     * @Method("GET")
     */
    public function ViewAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('LabsFacturationBundle:Conditions');
        $list = $repository->findAll();

        return $this->render('LabsFacturationBundle:Condition:list.html.twig',array(
            'list'=>$list
        ));
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/edit/{slug}-{id}", name="labs_facturation_condition_edit")
     * @Method({"GET", "PUT"})
     */
    public function editAction($id, $slug , Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // On recupere l'id du Genre
        $condition = $em->getRepository('LabsFacturationBundle:Conditions')->find($id);

        if(null === $condition){
            throw new NotFoundHttpException("La condition d'id ".$id." n'existe pas");
        }

        $form = $this->createForm(new ConditionsEditType(), $condition);
        if($form->handleRequest($request)->isValid())
        {
            $em->flush();
            $this->addFlash('success','Le contenu a été bien modifier');
            return $this->redirect($this->generateUrl('labs_facturation_condition_view'));
        }

        return $this->render('LabsFacturationBundle:Condition:edit.html.twig',array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/delete/{id}", name="labs_facturation_condition_delete", requirements={"id" : "\d+"})
     * @Method({"GET","DELETE"})
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        // On deja le Genre grace a cette fonction
        $condition = $em->getRepository('LabsFacturationBundle:Conditions')->find($id);
        if( null === $condition)
            throw new NotFoundHttpException('La condition '.$id.' n\'existe pas');
        else
            $em->remove($condition);
        $em->flush();
        $this->addFlash('success','Le contenu a été bien Supprimer');
        return $this->redirect($this->generateUrl('labs_facturation_condition_view'));
    }


}