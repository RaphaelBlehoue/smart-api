<?php
namespace Labs\FacturationBundle\Controller;

use Labs\FacturationBundle\Entity\Commandes;
use Labs\FacturationBundle\Entity\Stock;
use Labs\FacturationBundle\Form\CommandesType;
use Labs\FacturationBundle\Form\StockCommandeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class CommandesController
 * @package Labs\FacturationBundle\Controller
 * @Route("/command")
 */
class CommandesController extends Controller
{


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/list", name="labs_facturation_commandes_get_list")
     * @Method("GET")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('LabsFacturationBundle:Commandes');
        $list = $repository->findAll();
        return $this->render('LabsFacturationBundle:Commandes:list_commandes.html.twig', array(
            'list' => $list
        ));
    }

    /**
     * @param $proforma
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * Création de bon de livraison en mode brouillon et validation de proforma en mode attente de livraison
     * @Route("/create/{proforma}", name="labs_facturation_commandes_create")
     * @Method("GET")
     */
    public function CreateAction($proforma, Request $request)
    {
       $em = $this->getDoctrine()->getManager();
       $command_id = null;
       $proformas = $em->getRepository('LabsFacturationBundle:Proforma')->findOneBy(array(
           'id' => $proforma
       ));
       $commandes = $em->getRepository('LabsFacturationBundle:Commandes')->findOneBy(array(
            'proforma' => $proforma
       ));

       if(null != $commandes) {
            $this->addFlash('warning','Le bon de livraison  a été déjà crée');
            $command_id = $commandes->getId();
       }else{
            $commande = new Commandes();
            $commande->setReference($proformas->getReference());
            $commande->setStatus(-1);
            $commande->setProforma($proformas);
            $em->persist($commande);
            $em->flush();
            $command_id = $commande->getId();
           $this->addFlash('success','La commandes a été crée avec succès');
       }
       return $this->redirect($this->generateUrl('labs_facturation_commandes_order_processing',array(
            'id' => $command_id,
            'proforma' => $proformas->getId(),
            'reference' => $proformas->getReference()
       )));
    }

    /**
     * @param $id
     * @param $proforma
     * @param $reference
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * Action traitement de la commande client , en fonction des entrepôts en faisant l'inventaire du stock
     * @Route("/processing/{id}/{proforma}/ref-{reference}", name="labs_facturation_commandes_order_processing")
     * @Method({"GET","POST"})
     */
    public function OrderProcessingAction($id, $proforma, $reference, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $stock = new Stock();
        $form = $this->createForm(new StockCommandeType(), $stock);
        $sum = $this->get('get.montant.proforma');
        $mont = $sum->getMontant($proforma);

        $entrepot = $em->getRepository('LabsFacturationBundle:Entrepot')->findAll();
        $mouvement = $em->getRepository('LabsFacturationBundle:Mouvement')->findAll();
        $commandes = $em->getRepository('LabsFacturationBundle:Commandes')->getCommandesContent($proforma);
        return $this->render('LabsFacturationBundle:Commandes:order_processing.html.twig',array(
            'commandes' => $commandes,
            'form'      => $form->createView(),
            'entrepot'  => $entrepot,
            'mouvement' => $mouvement,
            'total' => $mont
        ));
    }

    /**
     * @param $id
     * @param $proforma
     * @param $proforma_ref
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * Action validation du bon de livraison et changement des status de ce bon
     * @Route("labs_facturation_commandes_delivery_validate", name="/delivery/validate/{id}/{proforma}_{proforma_ref}")
     * @Method({"GET"})
     */
    public function bonDeliveryValidateAction($id, $proforma, $proforma_ref)
    {
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository('LabsFacturationBundle:Commandes')->find($id);
        if(null === $commande){
            throw new NotFoundHttpException('Bon de commande introuvable dans le système');
        }
        $commande->setStatus(0);
        $commande->getProforma()->setStatus(1);
        $em->flush();
        $this->addFlash('success','Le bon de livraison a été approuvé');
        return $this->redirect($this->generateUrl('labs_facturation_commandes_view_bl', array(
            'proforma_id' => $proforma,
            'proforma_ref'=> $proforma_ref
        )));
    }

    /**
     * @param $id
     * @param $proforma
     * @param $proforma_ref
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * Action validation en mode livrée, du bon de la livraison de la proforma concerné et changement du status de la proforma
     * @Route("/delivery/checkout/{id}/{proforma}_{proforma_ref}", name="labs_facturation_commandes_delivery")
     * @Method("GET")
     */
    public function bonDeliveryAction($id, $proforma, $proforma_ref)
    {
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository('LabsFacturationBundle:Commandes')->find($id);
        if(null === $commande){
            throw new NotFoundHttpException('Bon de commande introuvable dans le système');
        }
        $commande->setStatus(1);
        $commande->getProforma()->setStatus(2);
        $em->flush();
        $this->addFlash('success','Le bon de livraison a été approuvé');
        return $this->redirect($this->generateUrl('labs_facturation_commandes_view_bl', array(
            'proforma_id' => $proforma,
            'proforma_ref'=> $proforma_ref
        )));
    }

    /**
     * @param $proforma_id
     * @param $proforma_ref
     * @return \Symfony\Component\HttpFoundation\Response
     * Action vue , du bon de livraison en entier
     * @Route("/proform/{proforma_id}/refb_{proforma_ref}_bon_de_livraison_view", name="labs_facturation_commandes_view_bl")
     * @Method("GET")
     */
    public function ViewBonDeliveryAction($proforma_id, $proforma_ref)
    {
        $em = $this->getDoctrine()->getManager();
        $sum = $this->get('get.montant.proforma');
        $mont = $sum->getMontant($proforma_id);
        $commandes = $em->getRepository('LabsFacturationBundle:Commandes')->getCommandDemand($proforma_id, $proforma_ref);
        return $this->render('LabsFacturationBundle:Commandes:view_proforma_bl.html.twig',array(
            'commandes' => $commandes,
            'total' => $mont
        ));
    }

    /**
     * @param $proforma_id
     * @param $reference
     * @return Response
     * @throws \HTML2PDF_exception
     * Gestion de l'affichages des PDF du bon de livraison
     * @Route("/commande/pdf/{proforma_id}-{reference}", name="labs_facturation_commandes_view_pdf")
     */
    public function CommandeViewPdfAction($proforma_id, $reference)
    {
        $info = $this->getOneProforma($proforma_id, $reference);
        $sum = $this->get('get.montant.proforma');
        $mont = $sum->getMontant($proforma_id);
        $html =  $this->renderView('LabsFacturationBundle:Commandes:commande_pdf.html.twig',array(
            'data' => $info,
            'total' =>  $mont
        ));
        $html2pdf = $this->get('html2pdf_factory')->create();
        $html2pdf->pdf->SetDisplayMode('real');
        $html2pdf->writeHTML($html);
        $html2pdf->Output('bon-de-livraison.pdf');
        $response = new Response();
        $response->headers->set('Content-type', 'application/pdf');
        return $response;
    }

    /**
     * @param $id
     * @param $reference
     * @return array
     * Action private qui recuperer une proforma en fonction de son id
     */
    private function getOneProforma($id, $reference)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('LabsFacturationBundle:Proforma')->getProformaDemand($id, $reference);
        return $data;
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * Supprime une proforma et ces elements associé
     * @Route("/commandes/{id}", name="labs_facturation_commandes_delete")
     * @Method({"GET", "DELETE"})
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository('LabsFacturationBundle:Commandes')->find($id);
        $stock_inventor = $em->getRepository('LabsFacturationBundle:Stock')->findBy(array(
            'referrer' => $commande->getReference()
        ));
        if(null != $stock_inventor){
            foreach($stock_inventor as $inv){
                $em->remove($inv);
            }
        }
        if( null != $commande){
            $em->remove($commande);
        }else{
            throw new NotFoundHttpException('le bon de commande '.$id.' n\'existe pas');
        }
        $em->flush();
        $this->addFlash('success','Le contenu à été bien Supprimer');
        return $this->redirect($this->generateUrl('labs_facturation_commandes_get_list'));
    }
}