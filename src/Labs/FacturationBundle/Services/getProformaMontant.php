<?php

namespace Labs\FacturationBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RequestStack;

class getProformaMontant
{
    private $request;

    private $em;

    public function __construct(RequestStack $request, EntityManager $em)
    {
        $this->request = $request;
        $this->em = $em;
    }

    /**
     * @param $id
     * @return array
     * Retourne tous les totaux des produits de la proforma d'id passé en paramètre dans la table proformasProduct
     *
     */
    public function getMontant($id)
    {
        $montHt = $this->getMontHt($id);
        $montTva = $this->getMontTva($id);
        $montTTC = $montHt + $montTva;
        $mont = array(
            'montHt' => $montHt,
            'montTva' => $montTva,
            'montTTC' => $montTTC
        );
        return $mont;
    }

    /**
     * @param $id
     * @return float
     * Retourne le montant Total de la Tva de la somme HT
     */
    private function getMontTva($id) {
        $mt = $this->getMontHt($id);
        $tva = (($mt * 18) / 100);
        return round($tva);
    }

    /**
     * @param $id
     * @return number
     * Recuperation de toute les lignes de la proformasProduits dont l'id de proforma est passé en paramètre et calcul de la somme
     */
    private function getMontHt($id){
        $montHt = array();
        $data = $this->em->getRepository('LabsFacturationBundle:ProformasProducts')->getAll($id);
        foreach($data as $d){
            $montHt[] = $d->getMontHt();
        }
        return array_sum($montHt);
    }

}