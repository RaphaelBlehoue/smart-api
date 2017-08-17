<?php
namespace Labs\FacturationBundle\Controller;

use Labs\FacturationBundle\Entity\Category;
use Labs\FacturationBundle\Form\CategoryEditType;
use Labs\FacturationBundle\Form\CategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class CategoryController
 * @package Labs\FacturationBundle\Controller
 * @Route("/category")
 */
class CategoryController extends Controller
{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/add", name="labs_facturation_category_add")
     * @Method("POST")
     */
    public function addAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $category = new Category();

        //formulaire declarer dans un services
        $form = $this->createForm(new CategoryType(), $category);

        if($form->handleRequest($request)->isValid()){
            //chargement de la base de donnée
            $em->persist($category);
            $em->flush();
            // Enregistrement du message dans la session
            $this->addFlash('success','le contenu à est bien enregistré');
            return $this->redirect($this->generateUrl('labs_facturation_category_list'));
        }

        return $this->render('LabsFacturationBundle:Category:add.html.twig',array(
            'form'=>$form->createView()
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/modal/add", name="labs_facturation_category_modal_add")
     * @Method({"GET", "POST"})
     */
    public function addOtherAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $category = new Category();

        //formulaire declarer dans un services
        $form = $this->createForm(new CategoryType(), $category);

        if($form->handleRequest($request)->isValid()){
            //chargement de la base de donnée
            $em->persist($category);
            $em->flush();
            // Enregistrement du message dans la session
            $this->addFlash('success','le contenu à est bien enregistré');
            return $this->redirect($this->generateUrl('labs_facturation_product_add'));
        }

        return $this->render('LabsFacturationBundle:Includes:modal_category.html.twig',array(
            'form'=>$form->createView()
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/list", name="labs_facturation_category_list")
     * @Method("GET")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('LabsFacturationBundle:Category');
        $list = $repository->findAll();

        return $this->render('LabsFacturationBundle:Category:list.html.twig',array(
            'list'=>$list
        ));
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/edit/{id}-{name}", name="labs_facturation_category_edit")
     * @Method("PUT")
     */
    public function editAction($id, $name , Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // On recupere l'id du Genre
        $category = $em->getRepository('LabsFacturationBundle:Category')->find($id);

        if(null === $category){
            throw new NotFoundHttpException("La Category d'id ".$id." n'existe pas");
        }

        $form = $this->createForm(new CategoryEditType(),$category);
        if($form->handleRequest($request)->isValid())
        {
            $em->flush();
            $this->addFlash('success','Le contenu à été bien modifier');
            return $this->redirect($this->generateUrl('labs_facturation_category_list'));
        }

        return $this->render('LabsFacturationBundle:Category:edit.html.twig',array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/delete/{id}", name="labs_facturation_category_delete", requirements={"id": "\d+"})
     * @Method({"GET", "DELETE"})
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        // On deja le Genre grace a cette fonction
        $category = $em->getRepository('LabsFacturationBundle:Category')->find($id);
        if( null === $category)
            throw new NotFoundHttpException('La category '.$id.' n\'existe pas');
        else
            $em->remove($category);
        $em->flush();
        $this->addFlash('success','Le contenu à été bien Supprimer');
        return $this->redirect($this->generateUrl('labs_facturation_category_list'));
    }

}