<?php

namespace Blob\Core\LibraryBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Blob\Core\LibraryBundle\Entity\Fotograf;
use Blob\Core\LibraryBundle\Form\FotografType;

/**
 * Fotograf controller.
 *
 */
class FotografController extends Controller
{

    /**
     * Lists all Fotograf entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BlobCoreLibraryBundle:Fotograf')->findAll();

        return $this->render('BlobCoreLibraryBundle:Fotograf:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Fotograf entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Fotograf();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_fotograf__show', array('id' => $entity->getId())));
        }

        return $this->render('BlobCoreLibraryBundle:Fotograf:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Fotograf entity.
     *
     * @param Fotograf $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Fotograf $entity)
    {
        $form = $this->createForm(new FotografType(), $entity, array(
            'action' => $this->generateUrl('admin_fotograf__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Fotograf entity.
     *
     */
    public function newAction()
    {
        $entity = new Fotograf();
        $form   = $this->createCreateForm($entity);

        return $this->render('BlobCoreLibraryBundle:Fotograf:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Fotograf entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BlobCoreLibraryBundle:Fotograf')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fotograf entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BlobCoreLibraryBundle:Fotograf:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Fotograf entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BlobCoreLibraryBundle:Fotograf')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fotograf entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BlobCoreLibraryBundle:Fotograf:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Fotograf entity.
    *
    * @param Fotograf $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Fotograf $entity)
    {
        $form = $this->createForm(new FotografType(), $entity, array(
            'action' => $this->generateUrl('admin_fotograf__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Fotograf entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BlobCoreLibraryBundle:Fotograf')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fotograf entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_fotograf__edit', array('id' => $id)));
        }

        return $this->render('BlobCoreLibraryBundle:Fotograf:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Fotograf entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BlobCoreLibraryBundle:Fotograf')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Fotograf entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_fotograf_'));
    }

    /**
     * Creates a form to delete a Fotograf entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_fotograf__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
