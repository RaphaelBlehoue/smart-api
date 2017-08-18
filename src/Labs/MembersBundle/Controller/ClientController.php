<?php
namespace Labs\MembersBundle\Controller;

use Labs\MembersBundle\Entity\Client;
use Labs\MembersBundle\Form\ClientEditType;
use Labs\MembersBundle\Form\ClientType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 * Class UsersController
 * @package Labs\MembersBundle\Controller
 * @Route("/customer")
 */
class ClientController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/add", name="labs_members_client_add")
     * @Method("POST")
     */
    public function addAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $client = new Client();

        //formulaire declarer dans un services
        $form = $this->createForm(new ClientType(), $client);

        if($form->handleRequest($request)->isValid()){
            $em->persist($client);
            $em->flush();
            // Enregistrement du message dans la session
            $this->addFlash('success','le client a été bien créer');
            return $this->redirect($this->generateUrl('labs_members_client_view'));
        }

        return $this->render('LabsMembersBundle:Client:add.html.twig',array(
            'form'=>$form->createView()
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/modal/create", name="labs_members_client_modal_add")
     * @Method("POST")
     */
    public function addModalAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $client = new Client();

        //formulaire declarer dans un services
        $form = $this->createForm(new ClientType(), $client);

        if($form->handleRequest($request)->isValid()){
            $em->persist($client);
            $em->flush();
            // Enregistrement du message dans la session
            $this->addFlash('success','le client a été bien créer');
            return $this->redirect($this->generateUrl('labs_facturation_proforma_get_create'));
        }

        return $this->render('LabsMembersBundle:Includes:modal_client.html.twig',array(
            'form'=>$form->createView()
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/view", name="labs_members_client_view")
     * @Method("GET")
     */
    public function ViewAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('LabsMembersBundle:Client');
        $list = $repository->findAll();

        return $this->render('LabsMembersBundle:Client:list.html.twig',array(
            'list'=>$list
        ));
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/edit/{slug}-{id}", name="labs_members_client_edit", requirements={ "id" : "\d+"})
     * @Method({"PUT", "POST"})
     */
    public function editAction($id, $slug , Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // On recupere l'id du Genre
        $client = $em->getRepository('LabsMembersBundle:Client')->find($id);

        if(null === $client){
            throw new NotFoundHttpException("Le Client d'id ".$id." n'existe pas");
        }

        $form = $this->createForm(new ClientEditType(), $client);
        if($form->handleRequest($request)->isValid())
        {
            $em->flush();
            $this->addFlash('success','Le contenu a été bien modifier');
            return $this->redirect($this->generateUrl('labs_members_client_view'));
        }

        return $this->render('LabsMembersBundle:Client:edit.html.twig',array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/delete/{id}", name="labs_members_client_delete", requirements={"id" : "\d+"})
     * @Method({"DELETE", "GET"})
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        // On deja le Genre grace a cette fonction
        $client = $em->getRepository('LabsMembersBundle:Client')->find($id);
        if( null === $client)
            throw new NotFoundHttpException('Le client '.$id.' n\'existe pas');
        else
            $em->remove($client);
        $em->flush();
        $this->addFlash('success','Le contenu a été bien Supprimer');
        return $this->redirect($this->generateUrl('labs_members_client_view'));
    }

}