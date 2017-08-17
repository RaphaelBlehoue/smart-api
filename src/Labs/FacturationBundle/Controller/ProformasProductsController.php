<?php
namespace Labs\FacturationBundle\Controller;
use Labs\FacturationBundle\Form\ProformasProductsEditType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ProformasProductsController
 * @package Labs\FacturationBundle\Controller
 * @Route("/proforma_products")
 */
class ProformasProductsController extends Controller
{
    /**
     * @param $id
     * @param $reference
     * @param $proformaid
     * @param $proformaref
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/edit/{id}-{reference}/proforma/{proformaid}-{proformaref}", name="labs_facturation_proforma_product_edit")
     * @Method({"POST","PUT"})
     */
    public function editAction($id, $reference, $proformaid, $proformaref, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $proformaproducts = $em->getRepository('LabsFacturationBundle:ProformasProducts')->find($id);
        $form = $this->createForm(new ProformasProductsEditType(), $proformaproducts);
        $stockData = $this->get('inventaire.stock.test.quantity');
        $stock = $stockData->getQauntityFromProduct($proformaproducts->getProducts(), $proformaid);

        if($form->handleRequest($request)->isValid())
        {
            //dump($request); die();
            $em->flush();
            $this->addFlash('success','Le contenu à été bien modifier');
            return $this->redirect($this->generateUrl('labs_facturation_proforma_add_product',array(
                'id' => $proformaid,
                'reference' => $proformaref
            )));
        }
        return $this->render('LabsFacturationBundle:Includes:edit_proforma.html.twig',array(
            'form'        => $form->createView(),
            'id'          => $id,
            'reference'   => $reference,
            'stock'       => $stock,
            'proformaid'  => $proformaid,
            'proformaref' => $proformaref
        ));
    }

    /**
     * @param $id
     * @param $proformaid
     * @param $proformaref
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/delete/{id}/{proformaid}-{proformaref}", name="labs_facturation_proforma_product_delete")
     * @Method({"GET","DELETE"})
     */
    public function deleteAction($id, $proformaid, $proformaref)
    {
        $em = $this->getDoctrine()->getManager();
        // On deja le Genre grace a cette fonction
        $proformaproducts = $em->getRepository('LabsFacturationBundle:ProformasProducts')->find($id);
        if( null === $proformaproducts)
            throw new NotFoundHttpException('Aucune ligne trouve d '.$id);
        else
            $em->remove($proformaproducts);
        $em->flush();
        $this->addFlash('success','Le contenu à été bien Supprimer');
        return $this->redirect($this->generateUrl('labs_facturation_proforma_add_product',array(
            'id' => $proformaid,
            'reference' => $proformaref
        )));

    }

}