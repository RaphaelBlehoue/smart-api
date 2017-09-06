<?php

namespace Labs\AppBundle\Controller;

use Labs\AppBundle\Entity\Type;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class TypeController extends Controller
{
    /**
     * @Route("/types", name="types_list")
     * @Method("GET")
     */
    public function getTypesAction(Request $request)
    {
        return new JsonResponse([
            new Type('lorem pixum 1'),
            new Type('lorem pixum 2'),
            new Type('lorem pixum 3')
        ]);
    }

}
