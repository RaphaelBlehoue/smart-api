<?php
namespace Labs\MembersBundle\Controller;

use Labs\MembersBundle\Entity\Client;
use Labs\MembersBundle\Form\ClientEditType;
use Labs\MembersBundle\Form\ClientType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
//use Symfony\Component\HttpFoundation\JsonResponse;

class ClientController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
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

    /**
     * Ajax modif genre champs Top"
     */

   /* public function editAjaxMethodOnlineAction( $id)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('LabsFacturationBundle:Category')->find($id);
        if($this->container->get('request')->isXmlHttpRequest()){
            // On deja le Genre grace a cette fonction
            $json = array();
            if($category)
            {
                if($category->getOnline() == true){
                    $category->setOnline(false);
                    $json['class'] = " label label-danger";
                    $json['content'] = "HORS LIGNE";
                }else{
                    $category->setOnline(true);
                    $json['class'] = " label label-success";
                    $json['content'] = "EN LIGNE";
                }
            }
            else{
                $json = null;
            }
            $em->flush();
            $response = new JsonResponse();
            return $response->setData(array('json' => $json));
        }else{
            $category = $em->getRepository('LabsFacturationBundle:Category')->find($id);
            if($category)
            {
                if($category->getOnline() == true){
                    $category->setOnline(false);
                }else{
                    $category->setOnline(true);
                }
            }
            $em->flush();
            return $this->render('LabsFacturationBundle:Category:list.html.twig');
        }
    } */

    /* public function editAjaxMethodTopAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('LabsFacturationBundle:Category')->find($id);
        if($this->container->get('request')->isXmlHttpRequest()){
            // On deja le Genre grace a cette fonction
            $json = array();
            if($category)
            {
                if($category->getTop() == true){
                    $category->setTop(false);
                    $json['class'] = " label label-danger";
                    $json['content'] = "METTRE EN TOP";
                }else{
                    $category->setTop(true);
                    $json['class'] = " label label-success";
                    $json['content'] = "EN TOP";
                }
            }
            else{
                $json = null;
            }
            $em->flush();
            $response = new JsonResponse();
            return $response->setData(array('json' => $json));
        }else{
            if($category)
            {
                if($category->getTop() == true){
                    $category->setTop(false);
                }else{
                    $category->setTop(true);
                }
            }
            $em->flush();
            return $this->render('LabsFacturationBundle:Category:list.html.twig');
        }
    } */

}