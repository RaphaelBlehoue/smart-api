<?php
namespace Labs\FacturationBundle\Controller;

use Labs\FacturationBundle\Entity\Service;
use Labs\FacturationBundle\Form\ServiceEditType;
use Labs\FacturationBundle\Form\ServiceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
//use Symfony\Component\HttpFoundation\JsonResponse;

class ServiceController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/add", name="labs_facturation_service_add")
     * @Method("POST")
     */
    public function addAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $service = new Service();

        //formulaire declarer dans un services
        $form = $this->createForm(new ServiceType(), $service);

        if($form->handleRequest($request)->isValid()){
            $em->persist($service);
            $em->flush();
            // Enregistrement du message dans la session
            $this->addFlash('success','le contenu à est bien enregistré');
            return $this->redirect($this->generateUrl('labs_facturation_service_view'));
        }

        return $this->render('LabsFacturationBundle:Service:add.html.twig',array(
            'form'=>$form->createView()
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/view", name="labs_facturation_service_view")
     * @Method("GET")
     */
    public function ViewAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('LabsFacturationBundle:Service');
        $list = $repository->findAll();

        return $this->render('LabsFacturationBundle:Service:list.html.twig',array(
            'list'=>$list
        ));
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("edit/{name}-{id}", name="labs_facturation_service_edit", requirements={"id" : "\d+"})
     * @Method({"PUT","POST"})
     */
    public function editAction($id, $name , Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // On recupere l'id du Genre
        $service = $em->getRepository('LabsFacturationBundle:Service')->find($id);

        if(null === $service){
            throw new NotFoundHttpException("Le Service d'id ".$id." n'existe pas");
        }

        $form = $this->createForm(new ServiceEditType(), $service);
        if($form->handleRequest($request)->isValid())
        {
            $em->flush();
            $this->addFlash('success','Le contenu à été bien modifier');
            return $this->redirect($this->generateUrl('labs_facturation_service_view'));
        }

        return $this->render('LabsFacturationBundle:Service:edit.html.twig',array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/delete/{id}", name="labs_facturation_service_delete", requirements={"id" : "\d+"})
     * @Method({"GET", "DELETE"})
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        // On deja le Genre grace a cette fonction
        $service = $em->getRepository('LabsFacturationBundle:Service')->find($id);
        if( null === $service)
            throw new NotFoundHttpException('Le service '.$id.' n\'existe pas');
        else
            $em->remove($service);
        $em->flush();
        $this->addFlash('success','Le contenu à été bien Supprimer');
        return $this->redirect($this->generateUrl('labs_facturation_service_view'));
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