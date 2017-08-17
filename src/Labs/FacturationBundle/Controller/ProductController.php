<?php

namespace Labs\FacturationBundle\Controller;

use Labs\FacturationBundle\Entity\Product;
use Labs\FacturationBundle\Form\ProductEditType;
use Labs\FacturationBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ProductController
 * @package Labs\FacturationBundle\Controller
 * @Route("/product")
 */
class ProductController extends Controller
{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/add", name="labs_facturation_product_add")
     * @Method("POST")
     */
    public function addAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $product = new Product();

        //formulaire declarer dans un services
        $form = $this->createForm(new ProductType(), $product);

        if($form->handleRequest($request)->isValid()){
            $em->persist($product);
            $em->flush();
            // Enregistrement du message dans la session
            $this->addFlash('success','le contenu à est bien enregistré');
            return $this->redirect($this->generateUrl('labs_facturation_product_view'));
        }

        return $this->render('LabsFacturationBundle:Product:add.html.twig',array(
            'form'=>$form->createView()
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/view", name="labs_facturation_product_view")
     * @Method("GET")
     */
    public function ViewAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('LabsFacturationBundle:Product');
        $list = $repository->findAll();
        return $this->render('LabsFacturationBundle:Product:list.html.twig',array(
            'list'=>$list
        ));
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/edit/{slug}-{id}", name="labs_facturation_product_edit")
     * @Method({"PUT", "GET"})
     */
    public function editAction($id, $slug , Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $product = $em->getRepository('LabsFacturationBundle:Product')->findOne($id);

        if(null === $product){
            throw new NotFoundHttpException("Le produit d'id ".$id." n'existe pas");
        }
        $form = $this->createForm(new ProductEditType(), $product);
        if($form->handleRequest($request)->isValid())
        {
            $em->flush();
            $this->addFlash('success','Le contenu à été bien modifier');
            return $this->redirect($this->generateUrl('labs_facturation_product_view'));
        }
        return $this->render('LabsFacturationBundle:Product:edit.html.twig',array(
            'form' => $form->createView(),
            'product' => $product
        ));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/delete/{id}", name="labs_facturation_product_delete")
     * @Method({"DELETE", "GET"})
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        // On deja le Genre grace a cette fonction
        $product = $em->getRepository('LabsFacturationBundle:Product')->find($id);
        if( null === $product)
            throw new NotFoundHttpException('L\'product '.$id.' n\'existe pas');
        else
            $em->remove($product);
        $em->flush();
        $this->addFlash('success','Le contenu à été bien Supprimer');
        return $this->redirect($this->generateUrl('labs_facturation_product_view'));
    }

    /**
     * @param Request $request
     * @param $service_id
     * @return JsonResponse
     * Retourne la liste des types de produits en fonction du type envoyer en paramètre
     * @Route("/get/reference/product/{service_id}",
     *      options={"expose"=true},
     *      name="labs_facturation_get_reference_product"
     * )
     * @Method("GET")
     */
    public function getProductReferenceAction(Request $request, $service_id)
    {
        $data = array();
        $type = null;
        if($request->isXmlHttpRequest())
        {
            $result = $this->getProductType($service_id);
            if(!empty($result)){
                if($service_id == 1){
                    $type = 'service';
                }else{
                    $type = 'bien';
                }
                foreach($result as $r){
                    $data[] = array(
                        'type'       => $type,
                        'id'         => $r->getId(),
                        'name'       => $r->getName()
                    );
                }
            }
            return new JsonResponse($data);
        }
    }

    /**
     * @param $type
     * @return array
     * Retourne la reference et le nom des produits en fonction du type
     */
    private function getProductType($type)
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('LabsFacturationBundle:Product')->getProductType($type);
        return $products;
    }
}
