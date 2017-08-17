<?php

namespace Labs\FacturationBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RequestStack;

class StockTestQuantity
{
    private $request;

    private $em;

    /**
     * @param RequestStack $request
     * @param EntityManager $em
     */
    public function __construct(RequestStack $request, EntityManager $em)
    {
        $this->request = $request;
        $this->em = $em;
    }

    /**
     * @param $id
     * @param $proforma
     * @return array
     * Retourne la Quantité de stock du produit qui à le id indiqué dans une proforma
     */
    public function getQauntityFromProduct($id, $proforma)
    {
        //Test du type du type de produits
        $qte = array();
        $type = $this->getPrdType($id);
        if($type == 0){
            $qte = array(
                'qte' => $this->CountStockRest($id),
                'type' => 0
            );
        }else{
            $qte = array(
                'qte' => 'Aucun',
                'type' => 1
            );
        }
        $price = $this->getPrdprice($id, $proforma);
        $reference = $this->getPrdRef($id);
        $prd = $this->getPrdName($id);
        $prdid = $this->getPrdID($id);
        $data = array(
            'quantity'  => $qte['qte'],
            'name'      => $prd,
            'id'        => $prdid,
            'type'      => $qte['type'],
            'price'     => $price,
            'reference' => $reference
        );
        return $data;
    }


    /**
     * @param $id
     * @return int|number
     * Faire le calcul de la quantité de stock restant, du produit qui à le id indiqué
     */
    private function CountStockRest($id)
    {
        $enter = $this->getStockEnter($id);
        $out = $this->getStockout($id);
        $qte = ($enter - $out);
        if($qte <= 0){
            $qte = 0;
        }
        return $qte;
    }


    /**
     * @param $id
     * @return number
     * Retourne la somme de stock entrée du prd concerné
     */
    private function getStockEnter($id)
    {
        $data = array();
        $stockEnter = $this->em->getRepository('LabsFacturationBundle:Stock')->findBy(array(
            'product' => $id,
            'code_mouv' => 1
        ));
        if(!empty($stockEnter)){
            foreach ($stockEnter as $enter){
                $data[] = $enter->getQuantity();
            }
            $data = array_sum($data);
        }else{
            $data = 0;
        }
        return $data;
    }

    /**
     * @param $id
     * @return number
     * Retourne la somme de stock sortie du prd concerné
     */
    private function getStockout($id)
    {
        $data = array();
        $stockEnter = $this->em->getRepository('LabsFacturationBundle:Stock')->findBy(array(
            'product' => $id,
            'code_mouv' => 0
        ));
        if(!empty($stockEnter)){
            foreach ($stockEnter as $enter){
                $data[] = $enter->getQuantity();
            }
            $data = array_sum($data);
        }else{
            $data = 0;
        }
        return $data;
    }



    public function getQuantityFromEntrepot($product, $entrepot)
    {
        $data = array();
        $entrepot_qte = $this->CountStockEntProdRest($product, $entrepot);
        $product_qte = $this->CountStockRest($product);
        $name_entrepot = $this->getEntrepotName($entrepot);
        $data = array(
            'entrepot_qte' => $entrepot_qte,
            'product_qte' => $product_qte,
            'name_entrepot' => $name_entrepot
        );
        return $data;
    }

    /**
     * @param $product
     * @param $entrepot
     * @return array|int|number
     * Calcul la difference entre les stocks de sortie et d'entreé de ce produits dans ce entrepot
     */
    private function CountStockEntProdRest($product, $entrepot)
    {
        $enter = $this->getStockProductEntrepotIn($product, $entrepot);
        $out = $this->getStockProductEntrepotOut($product, $entrepot);
        $qte = $enter - $out;
        if($qte <= 0){
            $qte = 0;
        }
        return $qte;
    }

    /**
     * @param $product
     * @param $entrepot
     * @return number
     * Retourne la somme de stock sortie du prd concerné et de l'entrepot indiqué
     */
    private function getStockProductEntrepotOut($product, $entrepot)
    {
        $data = array();
        $stockOut = $this->em->getRepository('LabsFacturationBundle:Stock')->findBy(array(
            'entrepot' => $entrepot,
            'product'  => $product,
            'code_mouv' => 0
        ));
        if(!empty($stockOut)){
            foreach ($stockOut as $enter){
                $data[] = $enter->getQuantity();
            }
            $data = array_sum($data);
        }else{
            $data = 0;
        }
        return $data;
    }

    /**
     * @param $product
     * @param $entrepot
     * @return array|int|number
     * Retourne la somme de stock entrée du prd concerné et de l'entrepot indiqué
     */
    private function getStockProductEntrepotIn($product, $entrepot)
    {
        $data = array();
        $stockIn = $this->em->getRepository('LabsFacturationBundle:Stock')->findBy(array(
            'entrepot' => $entrepot,
            'product'  => $product,
            'code_mouv' => 1
        ));
        if(!empty($stockIn)){
            foreach ($stockIn as $enter){
                $data[] = $enter->getQuantity();
            }
            $data = array_sum($data);
        }else{
            $data = 0;
        }
        return $data;
    }

    /**
     * @param $id
     * @return null|string
     * Retourne le nom du prd concerné
     */
    private function getPrdName($id){
        $data = null;
        $Prd = $this->em->getRepository('LabsFacturationBundle:Product')->findById($id);
        if(!empty($Prd)){
            foreach ($Prd as $name){
                $data = $name->getName();
            }
        }
        return $data;
    }

    /**
     * @param $id
     * @return null
     * Recuperation du type de produit
     */
    private function getPrdType($id){
        $data = null;
        $Prd = $this->em->getRepository('LabsFacturationBundle:Product')->findById($id);
        if(!empty($Prd)){
            foreach ($Prd as $name){
                $data = $name->getType();
            }
        }
        return $data;
    }

    /**
     * @param $id
     * @return null
     * recuperation de la reference produit
     */
    private function getPrdRef($id){
        $data = null;
        $Prd = $this->em->getRepository('LabsFacturationBundle:Product')->findById($id);
        if(!empty($Prd)){
            foreach ($Prd as $name){
                $data = $name->getReference();
            }
        }
        return $data;
    }

    private function getPrdprice($id, $proforma){
        $data = null;
        $Prd = $this->em->getRepository('LabsFacturationBundle:Product')->findById($id);
        $type = $this->getProformaInformation($proforma);
        if(!empty($Prd)){
            foreach ($Prd as $p){
                //Test du type de la proforma
                if($type->getServices()->getId() == 1 ){ // designe proforma de type vente

                   if($p->getType() == 0){ // Designe un produit de type bien
                       $price =  $p->getBuyPrice() * $p->getCoef(); //Prix du vente du produit
                       $data = $price;
                   }else{ // Designe un produit de type service
                       $price = $p->getCout();
                       $data = $price;
                   }

                }else{ // designe proforma de type location

                    if($p->getType() == 0){ // Designe un produit de type bien
                        $price =  $p->getHirePrice(); //Prix de location du produit
                        $data = $price;
                    }else{ // Designe un produit de type service
                        $price = $p->getCout();
                        $data = $price;
                    }

                }
            }
        }
        return $data;
    }

    /**
     * @param $proforma
     * @return mixed
     * retourne l'information sur la proforma
     */
    private function getProformaInformation($proforma)
    {
        $proforma = $this->em->getRepository('LabsFacturationBundle:Proforma')->getProformaInfo($proforma);
        return $proforma;
    }

    /**
     * @param $id
     * @return array
     * Retourne le Nom de l'entrepot de stockage
     */
    private function getEntrepotName($id){
        $data = array();
        $entrepot = $this->em->getRepository('LabsFacturationBundle:Entrepot')->findById($id);
        if(!empty($entrepot)){
            foreach ($entrepot as $name){
                $data = array(
                    'name' => $name->getName(),
                    'emplacement' => $name->getSite()->getName()
                );
            }
        }
        return $data;
    }

    /**
     * @param $id
     * @return null|string
     * Retourne l'id du prd concerné
     */
    private function getPrdID($id){
        $data = null;
        $stockEnter = $this->em->getRepository('LabsFacturationBundle:Product')->findById($id);
        if(!empty($stockEnter)){
            foreach ($stockEnter as $enter){
                $data = $enter->getId();
            }
        }
        return $data;
    }

    /**
     * @param $product_id
     * @param $command_ref
     * @return array|int|number
     * Retourne la somme de l'inventaire de stock du produit this
     */
    public function getQuantityInventorSumProduct($product_id, $command_ref){
        $data = $this->getLineInventorProduct($product_id, $command_ref);
        return $data;
    }

    /**
     * @param $product_id
     * @param $command_ref
     * @return array|int|number
     * Retourne l'inventaire de stock de la ligne de produit
     */
    private function getLineInventorProduct($product_id, $command_ref)
    {
        $data = array();
        $stockOut = $this->em->getRepository('LabsFacturationBundle:Stock')->findBy(array(
            'referrer' => $command_ref,
            'product'  => $product_id,
            'code_mouv' => 0
        ));
        if(!empty($stockOut)){
            foreach ($stockOut as $out){
                $data[] = $out->getQuantity();
            }
            $data = array_sum($data);
        }else{
            $data = 0;
        }
        return $data;
    }

}