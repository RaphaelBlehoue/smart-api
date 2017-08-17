<?php

namespace Labs\MembersBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UsersController extends Controller
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }

    public function getUsersListAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('LabsMembersBundle:User');
        $list = $repository->findAll();
        return $this->render('LabsMembersBundle:Employer:list.html.twig',array(
            'list'=>$list
        ));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        // On deja le Genre grace a cette fonction
        $employer = $em->getRepository('LabsMembersBundle:User')->find($id);
        if( null === $employer)
            throw new NotFoundHttpException('L\'employer '.$id.' n\'existe pas');
        else
            $em->remove($employer);
        $em->flush();
        $this->addFlash('success','Le contenu à été bien Supprimer');
        return $this->redirect($this->generateUrl('labs_members_office_view'));
    }

    public function OverviewAction()
    {
        return $this->render('LabsMembersBundle:Profile:profil_overview.html.twig');
    }

}
