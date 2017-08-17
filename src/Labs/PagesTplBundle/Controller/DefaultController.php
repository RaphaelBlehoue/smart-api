<?php

namespace Labs\PagesTplBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('LabsPagesTplBundle:Default:index.html.twig');
    }
}
