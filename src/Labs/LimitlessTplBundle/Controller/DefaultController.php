<?php

namespace Labs\LimitlessTplBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('LabsLimitlessTplBundle:Default:index.html.twig');
    }
}
