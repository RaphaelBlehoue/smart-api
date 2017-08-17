<?php
namespace Labs\FacturationBundle\Controller;

use Labs\FacturationBundle\Entity\Unite;
use Labs\FacturationBundle\Form\UniteEditType;
use Labs\FacturationBundle\Form\UniteType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class UniteController
 * @package Labs\FacturationBundle\Controller
 * @Route("/unite")
 */
class UniteController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/add", name="labs_facturation_unite_add")
     * @Method("POST")
     */
    public function addAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $unite = new Unite();

        //formulaire declarer dans un services
        $form = $this->createForm(new UniteType(), $unite);

        if($form->handleRequest($request)->isValid()){
            $em->persist($unite);
            $em->flush();
            // Enregistrement du message dans la session
            $this->addFlash('success','le contenu a été bien enregistré');
            return $this->redirect($this->generateUrl('labs_facturation_unite_view'));
        }

        return $this->render('LabsFacturationBundle:Unite:add.html.twig',array(
            'form'=>$form->createView()
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/modal/add", name="labs_facturation_unite_modal_add")
     * @Method("POST")
     */
    public function addModalAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $unite = new Unite();

        //formulaire declarer dans un services
        $form = $this->createForm(new UniteType(), $unite);

        if($form->handleRequest($request)->isValid()){
            $em->persist($unite);
            $em->flush();
            // Enregistrement du message dans la session
            $this->addFlash('success','le contenu a été bien enregistré');
            return $this->redirect($this->generateUrl('labs_facturation_product_add'));
        }

        return $this->render('LabsFacturationBundle:Includes:modal_unite.html.twig',array(
            'form'=>$form->createView()
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/view", name="labs_facturation_unite_view")
     * @Method("GET")
     */
    public function ViewAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('LabsFacturationBundle:Unite');
        $list = $repository->findAll();

        return $this->render('LabsFacturationBundle:Unite:list.html.twig',array(
            'list'=>$list
        ));
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/edit/{name}-{id}", name="labs_facturation_unite_edit", requirements={ "id" : "/d+"})
     * @Method({"PUT", "POST"})
     */
    public function editAction($id, $name , Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // On recupere l'id du Genre
        $unite = $em->getRepository('LabsFacturationBundle:Unite')->find($id);

        if(null === $unite){
            throw new NotFoundHttpException("L'unite d'id ".$id." n'existe pas");
        }

        $form = $this->createForm(new UniteEditType(), $unite);
        if($form->handleRequest($request)->isValid())
        {
            $em->flush();
            $this->addFlash('success','Le contenu a été bien modifier');
            return $this->redirect($this->generateUrl('labs_facturation_unite_view'));
        }

        return $this->render('LabsFacturationBundle:Unite:edit.html.twig',array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/delete/{id}", name="labs_facturation_unite_delete", requirements={ "id" : "/d+" })
     * @Method({"DELETE", "GET"})
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        // On deja le Genre grace a cette fonction
        $unite = $em->getRepository('LabsFacturationBundle:Unite')->find($id);
        if( null === $unite)
            throw new NotFoundHttpException('L\'unite '.$id.' n\'existe pas');
        else
            $em->remove($unite);
        $em->flush();
        $this->addFlash('success','Le contenu a été bien Supprimer');
        return $this->redirect($this->generateUrl('labs_facturation_unite_view'));
    }

}