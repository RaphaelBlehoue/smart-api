<?php

namespace Labs\LoginTplBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('LabsLoginTplBundle:Default:index.html.twig', array('name' => $name));
    }
}
