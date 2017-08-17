<?php

namespace Labs\FacturationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FacturationController extends Controller
{
    public function indexAction()
    {
        return $this->render('LabsFacturationBundle:Facturation:index.html.twig');
    }
}
