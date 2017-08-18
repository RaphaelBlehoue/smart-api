<?php

namespace Labs\MembersBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Class UsersController
 * @package Labs\MembersBundle\Controller
 * @Route("/users")
 */
class UsersController extends Controller
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/view", name="labs_members_office_view")
     * @Method("GET")
     */
    public function getUsersListAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('LabsMembersBundle:User');
        $list = $repository->findAll();
        return $this->render('LabsMembersBundle:Employer:list.html.twig',array(
            'list'=>$list
        ));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \LogicException
     * @Route("/delete/{id}", name="labs_members_employer_delete", requirements={"id" : "\d+"})
     * @Method({"GET", "DELETE"})
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        // On deja le Genre grace a cette fonction
        $employer = $em->getRepository('LabsMembersBundle:User')->find($id);
        if (null !== $employer) {
            $em->remove($employer);
        }
        else {
            throw new NotFoundHttpException('L\'employer '.$id.' n\'existe pas');
        }
        $em->flush();
        $this->addFlash('success','Le contenu à été bien Supprimer');
        return $this->redirect($this->generateUrl('labs_members_office_view'));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/profile", name="labs_members_profile_overview")
     * @Method("GET")
     */
    public function OverviewAction()
    {
        return $this->render('LabsMembersBundle:Profile:profil_overview.html.twig');
    }
}
