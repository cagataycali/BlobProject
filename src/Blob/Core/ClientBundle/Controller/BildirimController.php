<?php

namespace Blob\Core\ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BildirimController extends Controller
{
    public function indexAction()
    {
//        /**
//         * Doctrine
//         */
//        $em = $this->getDoctrine()->getManager();
//
//        /**
//         * Kullanıcının görülmemiş bildirimlerini alalım
//         */
//        $bildirimler = $em->getRepository('BlobCoreLibraryBundle:Bildirim')->findBy(array('kullanici'=>$this->getUser(),'durum'=>0));
//
//        foreach ($bildirimler as $b)
//        {
//            $b->setDurum(1);
//        }
//
//        $em->flush();,

        /**
         * Bildirimler servisini çağırıp cihazlara bildirim göndereceğiz!
         */

        return $this->render('@BlobCoreClient/Bildirim/index.html.twig');
    }

    public function gorulduAction(Request $request)
    {
        /**
         * Bildirim id değerini tutalım
         */
        $bildirim_id = $request->request->get('bildirim');

        /**
         * Doctrine
         */
        $em = $this->getDoctrine()->getManager();

        /**
         * Bildirim nesnesini yakalayalım
         */
        $bildirim = $em -> getRepository('BlobCoreLibraryBundle:Bildirim')->findOneBy(array('id'=>$bildirim_id,'kullanici'=>$this->getUser()));

        if(!$bildirim)
        {
            echo "Senin bildirimin değil";

            exit;
        }

        $bildirim->setDurum(1);

        $em->flush();

        $yanit = "Başarılı";

        $response = new Response(json_encode($yanit));
        $response->headers->set('Content-type', 'application/json; charset=utf-8');
        $response->setStatusCode(200);
        return $response;

    }

    public function tumunuGorAction(Request $request)
    {
        /**
         * Bildirim id değerini tutalım
         */
        $bildirim_id = $request->request->get('bildirim');

        /**
         * Doctrine
         */
        $em = $this->getDoctrine()->getManager();

        /**
         * Bildirim nesnesini yakalayalım
         */
        $bildirim = $em -> getRepository('BlobCoreLibraryBundle:Bildirim')->findBy(array('kullanici'=>$this->getUser(),'durum'=>0));

        foreach ($bildirim as $b)
        {
            $b->setDurum(1);
        }

        $em->flush();

        $yanit = "Başarılı";

        $response = new Response(json_encode($yanit));
        $response->headers->set('Content-type', 'application/json; charset=utf-8');
        $response->setStatusCode(200);
        return $response;

    }
}
