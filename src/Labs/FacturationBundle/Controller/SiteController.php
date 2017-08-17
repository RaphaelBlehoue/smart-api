<?php
namespace Labs\FacturationBundle\Controller;

use Labs\FacturationBundle\Entity\Site;
use Labs\FacturationBundle\Form\SiteType;
use Labs\FacturationBundle\Form\SiteEditType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class SiteController
 * @package Labs\FacturationBundle\Controller
 * @Route("/sites")
 */
class SiteController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/add", name="labs_facturation_site_add")
     * @Method("POST")
     */
    public function addAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $site = new Site();

        //formulaire declarer dans un services
        $form = $this->createForm(new SiteType(), $site);

        if($form->handleRequest($request)->isValid()){
            //chargement de la base de donnée
            $em->persist($site);
            $em->flush();
            // Enregistrement du message dans la session
            $this->addFlash('success','le contenu a été bien enregistré');
            return $this->redirect($this->generateUrl('labs_facturation_site_view'));
        }

        return $this->render('LabsFacturationBundle:Sites:add.html.twig',array(
            'form'=>$form->createView()
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/view", name="labs_facturation_site_view")
     * @Method("GET")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('LabsFacturationBundle:Site');
        $list = $repository->findAll();

        return $this->render('LabsFacturationBundle:Sites:view.html.twig',array(
            'list'=>$list
        ));
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/edit/{slug}-{id}", name="labs_facturation_site_edit")
     * @Method({"PUT", "POST"})
     */

    public function editAction($id, $slug , Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // On recupere l'id du Genre
        $site = $em->getRepository('LabsFacturationBundle:Site')->find($id);

        if(null === $site){
            throw new NotFoundHttpException("Le site d'id ".$id." n'existe pas");
        }

        $form = $this->createForm(new SiteEditType(), $site);
        if($form->handleRequest($request)->isValid())
        {
            $em->flush();
            $this->addFlash('success','Le contenu a été bien modifier');
            return $this->redirect($this->generateUrl('labs_facturation_site_view'));
        }

        return $this->render('LabsFacturationBundle:Sites:edit.html.twig',array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/delete/{id}", name="labs_facturation_site_delete", requirements={ "id" : "\d+"})
     * @Method({"DELETE", "GET"})
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        // On deja le Genre grace a cette fonction
        $site = $em->getRepository('LabsFacturationBundle:Site')->find($id);
        if( null === $site)
            throw new NotFoundHttpException('Le Site  '.$id.' n\'existe pas');
        else
            $em->remove($site);
        $em->flush();
        $this->addFlash('success','Le contenu a été bien Supprimer');
        return $this->redirect($this->generateUrl('labs_facturation_site_view'));
    }

    /**
     * @Route("/view", name="labs_facturation_site_all_view")
     */
    public function getLocationMapAction()
    {
        die('map view');
    }
}