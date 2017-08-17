<?php
namespace Labs\FacturationBundle\Controller;

use Labs\FacturationBundle\Entity\Entrepot;
use Labs\FacturationBundle\Form\EntrepotType;
use Labs\FacturationBundle\Form\EntrepotEditType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class EntrepotController
 * @package Labs\FacturationBundle\Controller
 * @Route("/entrepot")
 */
class EntrepotController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/add", name="labs_facturation_entrepot_add")
     */
    public function addAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $entrepot = new Entrepot();

        //formulaire declarer dans un services
        $form = $this->createForm(new EntrepotType(), $entrepot);

        if($form->handleRequest($request)->isValid()){
            //chargement de la base de donnée
            $em->persist($entrepot);
            $em->flush();
            // Enregistrement du message dans la session
            $this->addFlash('success','le contenu a été bien enregistré');
            return $this->redirect($this->generateUrl('labs_facturation_entrepot_view'));
        }

        return $this->render('LabsFacturationBundle:Entrepots:add.html.twig',array(
            'form'=>$form->createView()
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/view", name="labs_facturation_entrepot_view")
     * @Method("GET")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('LabsFacturationBundle:Entrepot');
        $list = $repository->findAll();

        return $this->render('LabsFacturationBundle:Entrepots:view.html.twig',array(
            'list'=>$list
        ));
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/edit/{slug}-{id}", name="labs_facturation_entrepot_edit")
     * @Method({"PUT", "GET"})
     */

    public function editAction($id, $slug , Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // On recupere l'id du Genre
        $entrepot = $em->getRepository('LabsFacturationBundle:Entrepot')->find($id);

        if(null === $entrepot){
            throw new NotFoundHttpException("L'entrepot d'id ".$id." n'existe pas");
        }

        $form = $this->createForm(new EntrepotEditType(),$entrepot);
        if($form->handleRequest($request)->isValid())
        {
            $em->flush();
            $this->addFlash('success','Le contenu a été bien modifier');
            return $this->redirect($this->generateUrl('labs_facturation_entrepot_view'));
        }

        return $this->render('LabsFacturationBundle:Entrepots:edit.html.twig',array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/delete/{id}", name="labs_facturation_entrepot_delete")
     * @Method({"DELETE", "GET"})
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        // On deja le Genre grace a cette fonction
        $entrepot = $em->getRepository('LabsFacturationBundle:Entrepot')->find($id);
        if( null === $entrepot)
            throw new NotFoundHttpException('L\'entrepot '.$id.' n\'existe pas');
        else
            $em->remove($entrepot);
        $em->flush();
        $this->addFlash('success','Le contenu a été bien Supprimer');
        return $this->redirect($this->generateUrl('labs_facturation_entrepot_view'));
    }


}