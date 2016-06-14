<?php

namespace TotoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use TotoBundle\Entity\Toto;
use TotoBundle\Form\TotoType;

/**
 * Toto controller.
 *
 */
class TotoController extends Controller
{
    /**
     * Lists all Toto entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $totos = $em->getRepository('TotoBundle:Toto')->findAll();

        return $this->render('toto/index.html.twig', array(
            'totos' => $totos,
        ));
    }

    /**
     * Creates a new Toto entity.
     *
     */
    public function newAction(Request $request)
    {
        $toto = new Toto();
        $form = $this->createForm('TotoBundle\Form\TotoType', $toto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($toto);
            $em->flush();

            return $this->redirectToRoute('admin_toto_show', array('id' => $toto->getId()));
        }

        return $this->render('toto/new.html.twig', array(
            'toto' => $toto,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Toto entity.
     *
     */
    public function showAction(Toto $toto)
    {
        $deleteForm = $this->createDeleteForm($toto);

        return $this->render('toto/show.html.twig', array(
            'toto' => $toto,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Toto entity.
     *
     */
    public function editAction(Request $request, Toto $toto)
    {
        $deleteForm = $this->createDeleteForm($toto);
        $editForm = $this->createForm('TotoBundle\Form\TotoType', $toto);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($toto);
            $em->flush();

            return $this->redirectToRoute('admin_toto_edit', array('id' => $toto->getId()));
        }

        return $this->render('toto/edit.html.twig', array(
            'toto' => $toto,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Toto entity.
     *
     */
    public function deleteAction(Request $request, Toto $toto)
    {
        $form = $this->createDeleteForm($toto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($toto);
            $em->flush();
        }

        return $this->redirectToRoute('admin_toto_index');
    }

    /**
     * Creates a form to delete a Toto entity.
     *
     * @param Toto $toto The Toto entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Toto $toto)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_toto_delete', array('id' => $toto->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
