<?php

namespace Labs\FacturationBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class generateRefProforma
{
    private $request;

    private $em;

    private $container;

    public function __construct(RequestStack $request, EntityManager $em, ContainerInterface $container)
    {
        $this->request = $request;
        $this->em = $em;
        $this->container = $container;
    }


    public function getReference()
    {
        $data = $this->getLastId();
        $year = date('y');
        $token = $this->getCurrentUserTwoInitial();
        $referenceView = $data.'/'.$token['f'].$token['l'].'-'.$year;
        $reference = $data.$token['f'].$token['l'].$year;
        $ref = array(
            'refview' => $referenceView,
            'ref'     => $reference
        );
        return $ref;
    }

    /**
     * @return int|null
     * recupération du dernier Id de proforma (son numero)
     */
    private function getLastId(){
        $data = null;
        $reference = $this->em->getRepository('LabsFacturationBundle:Proforma')->getLastInsert();
        if(null == $reference){
            $data = 001;
        }else{
            foreach ($reference as $d){
                switch(true){
                    case (($d->getId()+1) <= 9):
                    return $data = '00'.($d->getId()+1);

                    case (($d->getId()+1) > 9 && ($d->getId()+1) <= 99):
                    return $data = '0'.($d->getId()+1);

                    case (($d->getId()+1) > 99):
                    return $data = $d->getId()+1;
                }
            }
        }
        return $data;
    }

    /**
     * @return array
     * return les premieres lettre du user de firstname et lastname
     */
    private function getCurrentUserTwoInitial() {
        $userManager = $this->container->get('security.context')->getToken()->getUser();
        $firstname = $userManager->getFirstname();
        $lastname  = $userManager->getLastName();
        $count_firstname = strlen($firstname);
        $count_lastname = strlen($lastname);
        $f = substr($firstname, -$count_firstname, 1);
        $l = substr($lastname, -$count_lastname, 1);
        $user = array(
            'l' => $l,
            'f' => $f
        );
        return $user;
    }

}