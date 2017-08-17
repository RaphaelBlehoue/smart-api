<?php
namespace Labs\FacturationBundle\Controller;

use Labs\FacturationBundle\Entity\Stock;
use Labs\FacturationBundle\Form\StockEditType;
use Labs\FacturationBundle\Form\StockType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class StockController
 * @package Labs\FacturationBundle\Controller
 * @Route("/stock")
 */
class StockController extends Controller
{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/mouvement/Instock", name="labs_facturation_stock_get_enter")
     * @Method("POST")
     */
    public function InStockMouvementAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $stock = new Stock();

        $repository = $em->getRepository('LabsFacturationBundle:Stock');
        $list = $repository->findBy(array(
           'code_mouv' => 1
        ));

        //formulaire declarer dans un services
        $form = $this->createForm(new StockType(), $stock);

        if($form->handleRequest($request)->isValid()){
            $stock->setCodeMouv(1);
            $em->persist($stock);
            $em->flush();
            // Enregistrement du message dans la session
            $this->addFlash('success','le contenu à est bien enregistré');
            return $this->redirect($this->generateUrl('labs_facturation_stock_get_enter'));
        }

        return $this->render('LabsFacturationBundle:Stocks:instock.html.twig',array(
            'form'=>$form->createView(),
            'list' => $list
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/mouvement/Outstock", name="labs_facturation_stock_get_out")
     * @Method("POST")
     */
    public function OutStockMouvementAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $stock = new Stock();

        $repository = $em->getRepository('LabsFacturationBundle:Stock');
        $list = $repository->findBy(array(
            'code_mouv' => 0
        ));

        //formulaire declarer dans un services
        $form = $this->createForm(new StockType(), $stock);

        if($form->handleRequest($request)->isValid()){
            $stock->setCodeMouv(0);
            $em->persist($stock);
            $em->flush();
            // Enregistrement du message dans la session
            $this->addFlash('success','le contenu à est bien enregistré');
            return $this->redirect($this->generateUrl('labs_facturation_stock_get_out'));
        }
        return $this->render('LabsFacturationBundle:Stocks:outstock.html.twig', array(
            'form'=>$form->createView(),
            'list' => $list
        ));
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/mouvement/allstock", name="labs_facturation_stock_get_all")
     * @Method("GET")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('LabsFacturationBundle:Stock');
        $list = $repository->findAll();
        return $this->render('LabsFacturationBundle:Stocks:stock.html.twig', array(
            'list' => $list
        ));
    }

    /**
     * @param $id
     * @param $proforma
     * @param Request $request
     * @return JsonResponse
     * Recuperation de l'inventaire ( stock restant ) du produit dont l'id est envoyer en paramètre et la proforma
     * @Route("/stock/{id}/{proforma}", name="labs_facturation_stock_get_qte_rest", options={ "expose" : true})
     * @Method("GET")
     */
     public function StockAjaxMethodTopAction($id, $proforma, Request $request)
     {
         $em = $this->getDoctrine()->getManager();
         $data = array();
        //$category = $em->getRepository('LabsFacturationBundle:Stock')->find($id);
        if($request->isXmlHttpRequest()){
            $countQte = $this->get('inventaire.stock.test.quantity');
            $data = $countQte->getQauntityFromProduct($id, $proforma);
            return new JsonResponse($data);
        }
     }

    /**
     * @param $product
     * @param $entrepot
     * @return JsonResponse
     * @throws \Exception
     * Recuperation de l'inventaire (stock restant) du produit qui en paramètre dans un entrepot en paramètre
     * @Route("/stockentrepot/{product}/{entrepot}", name="labs_facturation_stock_get_qte_entrepot_stock", options={ "expose" : true })
     * @Method("GET")
     */
    public function StockEntrepotAjaxMethodTopAction($product, $entrepot)
    {
        $em = $this->getDoctrine()->getManager();
        $prd = $em->getRepository('LabsFacturationBundle:Product')->findPrdId($product);
        $prod = null;
        foreach($prd as $p){
            $prod = $p->getId();
        }
        $countQte = $this->get('inventaire.stock.test.quantity');
        $result = $countQte->getQuantityFromEntrepot($prod, $entrepot);
        if($this->container->get('request')->isXmlHttpRequest()){
            $response = new JsonResponse();
            return $response->setData(array('json' => $result));
        }
    }

    /**
     * @param $product
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     * Enregistrement d'une sortie de stock du produit passé en paramètre
     * @Route("/stockentrepot/{product}", name="labs_facturation_stock_get_qte_inventor_cmd", options={ "expose" : true })
     * @Method("GET")
     */
    public function AddOutAjaxAction($product, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $json = array();
        if($this->container->get('request')->isXmlHttpRequest()){
            $stock = new stock();

            // recherche des objet dans leur entité pour recuperation de l'objet
            $product = $this->getProductObject($request->attributes->get('product'));
            $entrepot = $this->getEntrepotObject($request->request->get('entrepot'));
            $mouvment = $this->getMouvementObject($request->request->get('mouvement'));

            /**
             * en fonction des qte entre et la commande
             * rapel plusieurs teste à realiser au niveau des inventaires de stock
             */

            if($request->request->get('_labsqtecmd') < $request->request->get('_qte')){
               $json = array(
                   'errors' => 'La quantité commande restante est de '.$product->getName().' est inférieur à votre demande',
                   'messageCode' => true
               );
            }else{
                $stock->setCodeMouv(0); // symbolise une sortie de stock
                $stock->setQuantity($request->request->get('_qte'));
                $stock->setSku($product->getReference());
                $stock->setReferrer($request->request->get('_labsrefcmd'));
                $stock->setMouvement($mouvment);
                $stock->setProduct($product);
                $stock->setEntrepot($entrepot);
                $em->persist($stock);
                $em->flush();
                $newQte = $request->request->get('_labsqtecmd') - $request->request->get('_qte');
                $qteCmd = $request->request->get('_qte');
                $json = array(
                    'succes'       => 'Inventaire crée avec success',
                    'messageCode'  => false,
                    'newQte'       => $newQte,
                    'qtecommande'  => $qteCmd
                );
            }
            $response = new JsonResponse();
            return $response->setData(array('json' => $json));
        }
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/delete/{id}", name="labs_facturation_stock_delete", requirements={ "id" : "\d+"})
     * @Method({"DELETE", "GET"})
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $stock = $em->getRepository('LabsFacturationBundle:Stock')->find($id);
        if( null === $stock)
            throw new NotFoundHttpException('Le stock '.$id.' n\'existe pas');
        else
            $em->remove($stock);
        $em->flush();
        $this->addFlash('success','Le contenu à été bien Supprimer');
        return $this->redirect($this->generateUrl('labs_facturation_stock_get_all'));
    }

    private function getProductObject($productid){
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('LabsFacturationBundle:Product')->find($productid);
        return $product;
    }

    private function getEntrepotObject($entrepotid){
        $em = $this->getDoctrine()->getManager();
        $entrepot = $em->getRepository('LabsFacturationBundle:Entrepot')->find($entrepotid);
        return $entrepot;
    }

    private function getMouvementObject($mouvementId){
        $em = $this->getDoctrine()->getManager();
        $mouvement = $em->getRepository('LabsFacturationBundle:Mouvement')->find($mouvementId);
        return $mouvement;
    }

}