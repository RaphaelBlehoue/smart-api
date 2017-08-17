<?php
namespace Labs\FacturationBundle\Controller;

use Labs\FacturationBundle\Entity\Proforma;
use Labs\FacturationBundle\Entity\ProformasProducts;
use Labs\FacturationBundle\Form\ProformaArreteType;
use Labs\FacturationBundle\Form\ProformaEditType;
use Labs\FacturationBundle\Form\ProformasProductsType;
use Labs\FacturationBundle\Form\ProformaType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ProformaController
 * @package Labs\FacturationBundle\Controller
 * @Route("/proforma")
 */
class ProformaController extends Controller
{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * Liste des proformas
     * @Route("/list", name="labs_facturation_proforma_get_list")
     * @Method("GET")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('LabsFacturationBundle:Proforma');
        $list = $repository->findAll();
        return $this->render('LabsFacturationBundle:Proformas:list.html.twig', array(
            'list' => $list
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * Action permettant la creation d'une proforma avec un status de (-1)
     * @Route("/create", name="labs_facturation_proforma_get_create")
     */
    public function CreateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $proforma = new Proforma();

        // verifie si le users en cours à déjà une proforma brouillon

        $DrafProforma = $em->getRepository('LabsFacturationBundle:Proforma')->findOneBy(array(
            'status' => - 1,
            'users'  => $this->getUser()
        ));

        // Si nous avons une proforma déjà en attente c'est à dire avec le status de (-1) pour le users courant

        if(null !== $DrafProforma)
        {
            $this->addFlash('warning','Vous ne pouvez pas créer une autre proforma. Vous avez déja une en attende de validation. Pour créer un autre, validez celle-ci');
            return $this->redirect($this->generateUrl('labs_facturation_proforma_add_product',array(
                'id' => $DrafProforma->getId(),
                'reference' => $DrafProforma->getReference()
            )));
        }

        //Service qui permet de génére la reference de la proforma

        $CreateReference = $this->get('generate.reference.proforma');
        $reference = $CreateReference->getReference();

        // Creation du formulaire
        $form = $this->createForm(new ProformaType(), $proforma);

        if($form->handleRequest($request)->isValid()){
            $proforma->setReferenceView($reference['refview']);
            $proforma->setReference($reference['ref']);
            $proforma->setStatus(-1);
            $proforma->setUsers($this->getUser());
            $em->persist($proforma);
            $em->flush();

            // Mise en place du flash creation
            $this->addFlash('success','La proforma a été crée avec succès');

            return $this->redirect($this->generateUrl('labs_facturation_proforma_add_product',array(
                'id' => $proforma->getId(),
                'reference' => $proforma->getReference()
            )));
        }

        return $this->render('LabsFacturationBundle:Proformas:create.html.twig',array(
            'form'=>$form->createView()
        ));
    }

    /**
     * @param $id
     * @param $reference
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/edit/content/{id}-{reference}", name="labs_facturation_proforma_edit", requirements={"id": "\d+"})
     * @Method({"PUT", "GET"})
     */
    public function editProformaAction($id, $reference, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $proforma = $em->getRepository('LabsFacturationBundle:Proforma')->find($id);
        $form = $this->createForm(new ProformaEditType(), $proforma);

        if($form->handleRequest($request)->isValid()){
            $em->flush();
            // Mise en place du flash creation
            $this->addFlash('success','La proforma a été crée avec succès');

            return $this->redirect($this->generateUrl('labs_facturation_proforma_add_product',array(
                'id' => $proforma->getId(),
                'reference' => $proforma->getReference()
            )));
        }
        return $this->render('LabsFacturationBundle:Proformas:edit.html.twig',array(
            'form'=>$form->createView(),
            'proforma' => $proforma
        ));
    }

    /**
     * @param $id
     * @param $reference
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * Action qui permet l'ajout de produit dans la proforma et persite dans la table associé a produit et proforma (ProformasProducts)
     * @Route("/addproduct/{id}-{reference}", name="labs_facturation_proforma_add_product", requirements={"id": "\d+"})
     * @Method({"POST", "PUT"})
     */
    public function ProformaAddProductAction($id, $reference, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $ProformaProduct = new ProformasProducts();
        $json = array();

        $info = $this->getOneProforma($id, $reference);
        $sum = $this->get('get.montant.proforma'); // recupération du service qui calcul le montant total de proforma en cours
        $mont = $sum->getMontant($id); //Montant total en cours de la proforma envoyer quand la page est charger

        $proforma = $em->getRepository('LabsFacturationBundle:Proforma')->find($id);

        $form = $this->createForm(new ProformasProductsType(), $ProformaProduct);

        if($request->isXmlHttpRequest()){
            //Stcokage des request envoyer pas l'event

            $type = false; // d'origine : proforma de type ventes

            $post = $request->request->all();
            $data = $post['labs_facturationbundle_proformasproducts'];
            $productId = $post['_product'];
            $price = $this->setPriceLine($post['_price_init'], $data['price']); // prix
            $product = $em->getRepository('LabsFacturationBundle:Product')->findOne($productId); // produit
            $duration = $data['duration'];
            $qte = $data['qteCmd'];
            $remise = $data['remise'];

            $montHt = $this->setMontHT($id, $qte, $price, $duration, $remise); // Montant hors taxe de chaque ligne de produit


            $proformaSaving = $em->getRepository('LabsFacturationBundle:Proforma')->getProformaInfo($id); // information sur la proforma

            if($proformaSaving->getServices()->getId() == 2){
                $type = true; //  Proforma de type location
            }

            // persistance des données

            $ProformaProduct->setProducts($product);
            $ProformaProduct->setProformas($proformaSaving);
            $ProformaProduct->setQteCmd($qte);
            $ProformaProduct->setPrice($price);
            $ProformaProduct->setRemise($remise);
            $ProformaProduct->setMontHt($montHt);
            $ProformaProduct->setDuration($duration);
            $em->persist($ProformaProduct);
            $em->flush();
            $autremont = $sum->getMontant($proformaSaving); // Mise à jour du montant Total après ajout sans rechagement de la proforma
            $router = $this->generateUrl('labs_facturation_proforma_product_delete', array(
                'id'            => $ProformaProduct->getId(),
                'proformaid'    => $proformaSaving->getId(),
                'proformaref'   => $proformaSaving->getReference()
            ));
            // Formatage des données à renvoyer

            $json = array(
                'reference'      => $product->getReference(),
                'name'           => $product->getName(),
                'qte'            => $qte,
                'price'          => $price,
                'remise'         => $remise,
                'montHT'         => $montHt,
                'id'             => $ProformaProduct->getId(),
                'proformaId'     => $id,
                'proformaRef'    => $reference,
                'montToTal'      => $autremont,
                'type'           => $type,
                'duration'       => $ProformaProduct->getDuration(),
                'url'            => $router
            );
            return new JsonResponse($json);

        }

        return $this->render('LabsFacturationBundle:Proformas:proforma_add_product.html.twig',array(
            'data'  => $info,
            'form'  => $form->createView(),
            'total' => $mont
        ));
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * Action de validation de la proforma et rediriger vers la page view de la proforma
     * @Route("/proforma/validate/{id}", name="labs_facturation_proforma_validate_ending")
     * @Method("GET")
     */
    public function ProformaValidateAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $proforma = $em->getRepository('LabsFacturationBundle:Proforma')->find($id);
        if(null === $proforma){
            throw new NotFoundHttpException("La proforma d'id ".$id." n'existe pas");
            exit();
        }
        $proforma->setStatus(0);
        $em->flush();
        $this->addFlash('success','Proforma a été approuvée avec succès');
        return $this->redirect($this->generateUrl('labs_facturation_proforma_view',array(
            'id' => $proforma->getId(),
            'reference' => $proforma->getReference()
        )));

    }

    /**
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * Annulation de la proforma, mais ne supprime pas les produits ajoutés
     * @Route("/proforma/cancel/{id}", name="labs_facturation_proforma_cancel")
     * @Method({"GET", "POST"})
     */

    public function ProformaCancelAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $proforma = $em->getRepository('LabsFacturationBundle:Proforma')->find($id);
        $commande = $em->getRepository('LabsFacturationBundle:Commandes')->find($id);
        $stock_inventor = $em->getRepository('LabsFacturationBundle:Stock')->findBy(array(
            'referrer' => $proforma->getReference()
        ));
        if(null === $proforma){
            throw new NotFoundHttpException("La proforma d'id ".$id." n'existe pas");
            exit();
        }
        $proforma->setStatus(3);
        if(null != $commande){
            $em->remove($commande);
        }
        if(null != $stock_inventor){
            foreach($stock_inventor as $inv){
                $em->remove($inv);
            }
        }
        $em->flush();
        $this->addFlash('success','Proforma a été annuler');
        return $this->redirect($this->generateUrl('labs_facturation_proforma_view',array(
            'id' => $proforma->getId(),
            'reference' => $proforma->getReference()
        )));

    }


    /**
     * @param $id
     * @param $reference
     * @return \Symfony\Component\HttpFoundation\Response
     * Action qui affiche les détail de la proforma
     * @Route("/proforma/view/{id}-{reference}", name="labs_facturation_proforma_view")
     * @Method("GET")
     */
    public function proformaViewAction($id, $reference)
    {
        $info = $this->getOneProforma($id, $reference);
        $sum = $this->get('get.montant.proforma');
        $mont = $sum->getMontant($id);
        return $this->render('LabsFacturationBundle:Proformas:view_proforma.html.twig',array(
            'data' => $info,
            'total' =>  $mont
        ));
    }

    /**
     * @param $id
     * @param $reference
     * @return Response
     * @throws \HTML2PDF_exception
     * Fonction de generation de PDF
     * @Route("/proforma/pdf/{id}-{reference}", name="labs_facturation_proforma_view_pdf")
     * @Method("GET")
     */
    public function proformaViewPdfAction($id, $reference)
    {
        $info = $this->getOneProforma($id, $reference);
        $sum = $this->get('get.montant.proforma');
        $mont = $sum->getMontant($id);
        $html =  $this->renderView('LabsFacturationBundle:Proformas:proforma_pdf.html.twig',array(
            'data'  => $info,
            'total' => $mont
        ));
        $html2pdf = $this->get('html2pdf_factory')->create();
        $html2pdf->pdf->SetDisplayMode('real');
        $html2pdf->writeHTML($html);
        $html2pdf->Output('pro-forma.pdf');
        $response = new Response();
        $response->headers->set('Content-type', 'application/pdf');
        return $response;
    }

    /**
     * @param $id
     * @param Request $request
     * @return JsonResponse|\Symfony\Component\HttpFoundation\Response
     * Action de mise à jour de l'arrete de la preforma, en ajax  l'arreté enregistre
     * @Route("/edit-somme/{id}", options={"expose"=true} ,name="labs_facturation_proforma_edit_arrete")
     * @Method("GET")
     */
    public function ProformaLetterSumAction($id, Request $request)
    {
        $json = array();
        $em = $this->getDoctrine()->getManager();
        $proforma = $em->getRepository('LabsFacturationBundle:Proforma')->find($id);
        $form = $this->createForm(new ProformaArreteType(), $proforma);
        if($request->isXmlHttpRequest()){
            $d =$request->request->all();
            $dataSend = $d['labs_facturationbundle_edit_arrete_proforma']['arrete'];
            if(!empty($proforma)){
                $proforma->setArrete($dataSend);
                $json = array(
                    'data'     => $proforma->getArrete()
                );
                $em->flush();
            }else{
                $json = array(
                    'result' => 1,
                    'error' => 'Aucune reference trouve'
                );
            }
            return new JsonResponse($json);
        }
        return $this->render('LabsFacturationBundle:Includes:add_arrete.html.twig',array(
            'form' => $form->createView()
        ));
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
     * @param $proforma_id
     * @param $product_id
     * @return ProformasProducts|null|object
     * Test si un produits existe déjà dans la proforma
     */
    private function isExisteProformaProduct($proforma_id, $product_id){
        $em = $this->getDoctrine()->getManager();
        $product_exist = $em->getRepository('LabsFacturationBundle:ProformasProducts')->findOneBy(array(
            'proformas' => $proforma_id,
            'products'  => $product_id
        ));
        return $product_exist;
    }

    /**
     * @param Request $request
     * @param $is_product_exist
     * Modifie la ligne d'un produit dans la proforma
     */
    private function EditLineProformasProduct(Request $request, $is_product_exist){
        $em = $this->getDoctrine()->getManager();

        $ErrorMessage = " .Dans ce cas, Nous vous proposons : Soit de diminuer la quantité si cela est possible,
        Soit de faire une demande de réapprovisonnement de ce stock produit,
        Soit d'annuler la proforma et d'informer la direction et le service en charge du stock";

        $stockTotalProduct = $this->get('inventaire.stock.test.quantity');
        $stock_dispo = $stockTotalProduct->getQauntityFromProduct($is_product_exist->getProducts());
        $param = $request->request->get('labs_facturationbundle_proformasproducts');

        $qte_cmd_exist = $is_product_exist->getQteCmd();
        $qte_cmd_post = $param['qteCmd'];
        $qte_dispo = $stock_dispo['qte'];
        $qte_cmd_new = ($qte_cmd_exist + $qte_cmd_post);
        if($qte_cmd_new > $qte_dispo){
            $this->addFlash('warning','La quantité commandée : '.$qte_cmd_post.',  pour la référence '.$is_product_exist->getProducts()->getReference().' est supérieur à la quantité disponible : '.$qte_dispo.' '.$ErrorMessage);
        }else{
            $is_product_exist->setQteCmd($qte_cmd_new);
            $em->persist($is_product_exist);
            $em->flush();
            $this->addFlash('success','Produit ajouté avec success, pour modifier la remise veillez cliquez sur bouton modifier en vert  de la ligne du produit');
        }
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * Fonction de suppression d'une proforma
     * @Route("/delete/{id}", name="labs_facturation_proforma_delete", requirements={"id" : "\d+"})
     * @Method({"DELETE", "GET"})
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $proforma = $em->getRepository('LabsFacturationBundle:Proforma')->find($id);
        $commande = $em->getRepository('LabsFacturationBundle:Commandes')->find($id);
        $stock_inventor = $em->getRepository('LabsFacturationBundle:Stock')->findBy(array(
            'referrer' => $proforma->getReference()
        ));
        if(null != $commande){
            $em->remove($commande);
        }
        if(null != $stock_inventor){
            foreach($stock_inventor as $inv){
                $em->remove($inv);
            }
        }
        if( null != $proforma){
            $em->remove($proforma);
        }else{
            throw new NotFoundHttpException('La proforma '.$id.' n\'existe pas');
        }
        $em->flush();
        $this->addFlash('success','Le contenu à été bien Supprimer');
        return $this->redirect($this->generateUrl('labs_facturation_proforma_get_list'));
    }

    /**
     * @param $init_price
     * @param $price
     * @return mixed
     * retourne le prix selectionné du produit à enregister
     */
    private function setPriceLine($init_price, $price)
    {
        $prices = $init_price;
        if(!empty($price)){
            $prices = $price;
        }
        return $prices;
    }

    /**
     * @param $id
     * @param $qte
     * @param $price
     * @param $duration
     * @param $remise
     * @return null
     * Calcul le montant HT d'une ligne de la proforma
     */
    private function setMontHT($id, $qte, $price, $duration, $remise)
    {
        $em = $this->getDoctrine()->getManager();
        $montHt = null;
        $proforma = $em->getRepository('LabsFacturationBundle:Proforma')->getProformaInfo($id);
        if($proforma->getServices()->getId() == 1){ // montant HT pour une vente
            if(!empty($remise) && $remise >= 1){
                $remise = ((($price * $qte) * $remise)/100);
                $montHt = ($price * $qte) - $remise;
            }else{
                $montHt = $price * $qte;
            }
        }else{ // montant HT pour une location
            if(!empty($remise) && $remise >= 1){
                $remise = ((($price * $qte * $duration) * $remise)/100);
                $montHt = ($price * $qte * $duration) - $remise;
            }else{
                $montHt = $price * $qte * $duration;
            }
        }
        return $montHt;
    }

}