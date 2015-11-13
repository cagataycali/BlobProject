<?php

namespace Blob\Core\LibraryBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Blob\Core\LibraryBundle\Entity\SistemAyar;
use Blob\Core\LibraryBundle\Form\SistemAyarType;

/**
 * SistemAyar controller.
 *
 */
class SistemAyarController extends Controller
{

    /**
     * Lists all SistemAyar entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BlobCoreLibraryBundle:SistemAyar')->findAll();

        return $this->render('BlobCoreLibraryBundle:SistemAyar:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new SistemAyar entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new SistemAyar();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_sistem-ayar__show', array('id' => $entity->getId())));
        }

        return $this->render('BlobCoreLibraryBundle:SistemAyar:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a SistemAyar entity.
     *
     * @param SistemAyar $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(SistemAyar $entity)
    {
        $form = $this->createForm(new SistemAyarType(), $entity, array(
            'action' => $this->generateUrl('admin_sistem-ayar__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new SistemAyar entity.
     *
     */
    public function newAction()
    {
        $entity = new SistemAyar();
        $form   = $this->createCreateForm($entity);

        return $this->render('BlobCoreLibraryBundle:SistemAyar:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a SistemAyar entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BlobCoreLibraryBundle:SistemAyar')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SistemAyar entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BlobCoreLibraryBundle:SistemAyar:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing SistemAyar entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BlobCoreLibraryBundle:SistemAyar')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SistemAyar entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BlobCoreLibraryBundle:SistemAyar:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a SistemAyar entity.
    *
    * @param SistemAyar $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(SistemAyar $entity)
    {
        $form = $this->createForm(new SistemAyarType(), $entity, array(
            'action' => $this->generateUrl('admin_sistem-ayar__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing SistemAyar entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BlobCoreLibraryBundle:SistemAyar')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SistemAyar entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_sistem-ayar__edit', array('id' => $id)));
        }

        return $this->render('BlobCoreLibraryBundle:SistemAyar:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a SistemAyar entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BlobCoreLibraryBundle:SistemAyar')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find SistemAyar entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_sistem-ayar_'));
    }

    /**
     * Creates a form to delete a SistemAyar entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_sistem-ayar__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
