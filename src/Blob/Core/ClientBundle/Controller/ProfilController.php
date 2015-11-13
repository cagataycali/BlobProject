<?php

namespace Blob\Core\ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ProfilController extends Controller
{
    public function profilAction(Request $request)
    {
        /**
         * Kimlik
         */
        $kimlik = $this->getUser();

        /**
         * Doctrine yardımcısını çağıralım
         */
        $em = $this->getDoctrine()->getManager();

        /**
         * Giriş yapılmamışsa
         */
        if(!$kimlik)
        {
            throw new NotFoundHttpException("Bu isimde bir profil bulunamadı!");
        }

        /**
         * Ayarlar
         */
        $ayarlar = $em->getRepository('BlobCoreLibraryBundle:SistemAyar')->find(1);

        /**
         * 5 erli bir şekilde infinitive scrolling yapacağız.
         */
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $kimlik->getFotograflar(),
            $request->query->getInt('page', 1)/*page number*/,
            4/*limit per page*/
        );

        /**
         * Giriş yapan kullanıcının profil bilgilerini direkt olarak return olarak döndüreceğiz.
         */
        return $this->render('BlobCoreClientBundle:Profil:index.html.twig',array('kullanici'=>$kimlik,'current'=>$kimlik,'takip_durum'=>1,'kullanici_fotograflari'=>$pagination));
    }

    public function profilDetayAction($username,Request $request)
    {
        /**
         * Kimlik
         */
        $kimlik = $this->getUser();

        /*
         * Şuandaki oturum
         */
        $kimlik_current = $this->getUser();

        /**
         * Doctrine yardımcısını çağıralım
         */
        $em = $this->getDoctrine()->getManager();

        /**
         * Default parametre
         */
        $takip_durum = 1;

        # todo : Düşün ; kim kimi görüntülemiş anında bildirelim mi? Bildirmeyelim mi?


        if(strlen(trim($username)) > 0)
        {
            $diger_kullanici = $this->get('fos_user.user_manager')->findUserByUsername($username);

            if(!$kimlik)
            {
                throw new NotFoundHttpException("Bu isimde bir profil bulunamadı!");
            }

            /**
             * Takipler tablosundan bu kullanıcıyı takip ediyor muyuz ona bakalım.
             */
            $takip = $em -> getRepository( 'BlobCoreLibraryBundle:Takip' ) ->findOneBy(array('takip_eden'=>$kimlik,'takip_edilen'=>$diger_kullanici));

            if(!$takip and $kimlik != $diger_kullanici) # Takip etmiyorsam ve kullanıcı ben değilsem
            {
                $takip_durum = 0;
            }
            elseif ($takip and $takip->getDurum() != 1) # Takip durumu henüz 1 değilse
            {
                $takip_durum = 2;
            }

            $kimlik = $diger_kullanici;
        }

        /**
         * 5 erli bir şekilde infinitive scrolling yapacağız.
         */
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $kimlik->getFotograflar(),
            $request->query->getInt('page', 1)/*page number*/,
            4/*limit per page*/
        );



        /**
         * Giriş yapan kullanıcının profil bilgilerini direkt olarak return olarak döndüreceğiz.
         */
        return $this->render('BlobCoreClientBundle:Profil:index.html.twig',array('kullanici'=>$kimlik,'takip_durum'=>$takip_durum,'current'=>$kimlik_current,'kullanici_fotograflari'=>$pagination));
    }

    public function fotograflarimAction(Request $request)
    {
        /**
         * Kimlik
         */
        $kimlik = $this->getUser();

        /**
         * Doctrine yardımcısını çağıralım
         */
        $em = $this->getDoctrine()->getManager();

        /**
         * Gelen veriyi alalım.
         */
        $kullanici = $request->request->get('kullanici');

        /**
         * Yanıt dizimizi hazırlayalım
         */
        $yanit = array();

        if(strlen(trim($kullanici)) == 0)
        {
            $yanit["durum"] = 404;

            $response = new Response(json_encode($yanit));
            $response->headers->set('Content-type', 'application/json; charset=utf-8');
            $response->setStatusCode(200);
            return $response;
        }

        $kullanici = $this->get('fos_user.user_manager')->findUserByUsername($kullanici);

        /**
         * Kullanıcı kendini takip edemez.
         */
        if ( $kimlik == $kullanici )
        {
            $yanit["durum"] = 404;

            $response = new Response(json_encode($yanit));
            $response->headers->set('Content-type', 'application/json; charset=utf-8');
            $response->setStatusCode(200);
            return $response;
        }

        /**
         * Kullanıcıyı takip ediyorsam
         */
        $takip = $em->getRepository('BlobCoreLibraryBundle:Takip')->findOneBy(array('takip_eden'=>$kimlik,'takip_edilen'=>$kullanici));

        if(!$takip)
        {
            $yanit["durum"] = 404;

            $response = new Response(json_encode($yanit));
            $response->headers->set('Content-type', 'application/json; charset=utf-8');
            $response->setStatusCode(200);
            return $response;
        }

        /**
         * Fotoğrafları göndermek için dizimizi hazırlayalım
         */
        $fotograflar = "";


        /**
         * Kullanıcının fotoğraflarını fotoğraflar arrayi altında açalım
         */
        foreach ($kullanici->getFotograflar() as $fotograf)
        {
            $fotograflar .=  '<div class="col-lg-3 col-sm-4 col-xs-6">
                            <a title="'.$fotograf->getIcerik().'" href="'.$this->generateUrl('fotograf-detay',array('hash'=>$fotograf->getHash())).'">
                                <img class="thumbnail img-responsive" src="'.$fotograf->getUrl().'">
                            </a>
                        </div>';

        }


        $response = new Response(json_encode($fotograflar));
        $response->headers->set('Content-type', 'application/json; charset=utf-8');
        $response->setStatusCode(200);
        return $response;
    }

    public function profilSonsuzFotografAction(Request $request)
    {
        /**
         * Time ago eklentisini kullanabilmek için.
         */
        $time_bundle = $this->container->get('time.templating.helper.time');

        /**
         * Kimlik
         */
        $kimlik = $this->getUser();

        /**
         * Doctrine yardımcısını çağıralım
         */
        $em = $this->getDoctrine()->getManager();

        /**
         * Gelen veriyi alalım.
         */
        $kullanici = $request->request->get('kullanici');

        /**
         * Yanıt dizimizi hazırlayalım
         */
        $yanit = array();

        if(strlen(trim($kullanici)) == 0)
        {
            $yanit["durum"] = 404;

            $response = new Response(json_encode($yanit));
            $response->headers->set('Content-type', 'application/json; charset=utf-8');
            $response->setStatusCode(200);
            return $response;
        }

        $kullanici = $this->get('fos_user.user_manager')->findUserByUsername($kullanici);

        /**
         * Kullanıcı kendini takip edemez.
         */
        if ( $kimlik == $kullanici )
        {
            $yanit["durum"] = 404;

            $response = new Response(json_encode($yanit));
            $response->headers->set('Content-type', 'application/json; charset=utf-8');
            $response->setStatusCode(200);
            return $response;
        }

        /**
         * Kullanıcıyı takip ediyorsam
         */
        $takip = $em->getRepository('BlobCoreLibraryBundle:Takip')->findOneBy(array('takip_eden'=>$kimlik,'takip_edilen'=>$kullanici));

        if(!$takip)
        {
            $yanit["durum"] = 404;

            $response = new Response(json_encode($yanit));
            $response->headers->set('Content-type', 'application/json; charset=utf-8');
            $response->setStatusCode(200);
            return $response;
        }

        /**
         * Kaçıncı sayfada olduğumuzu alalım.
         */
        $sayfa = $request->request->get('page');

        /**
         * Kullanıcının görebileceği fotoğrafları alalım
         */
        $kullanici_fotograflari = $em->createQueryBuilder()
            ->select('f')
            ->from('BlobCoreLibraryBundle:Fotograf','f')
            ->where('f.kullanici =:kullanici')
            ->setParameter('kullanici',$kullanici)
            ->orderBy('f.createdAt','DESC')
            ->getQuery()
            ->getResult();

        /**
         * 5 erli bir şekilde infinitive scrolling yapacağız.
         */
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $kullanici_fotograflari,
            $request->query->getInt('page', $sayfa)/*page number*/,
            4/*limit per page*/
        );

        /**
         * Yanıt dizisi
         */
        $yanit = "";

        /**
         * Kullanıcının fotoğraflarını fotoğraflar arrayi altında açalım
         */
        foreach ($pagination as $fotograf)
        {
            $yanit .=  '<div class="col-lg-3 col-sm-4 col-xs-6">
                            <a title="'.$fotograf->getIcerik().'" href="'.$this->generateUrl('fotograf-detay',array('hash'=>$fotograf->getHash())).'">
                                <img class="thumbnail img-responsive" src="'.$fotograf->getUrl().'">
                            </a>
                        </div>';

        }

        $response = new Response(json_encode($yanit));
        $response->headers->set('Content-type', 'application/json; charset=utf-8');
        $response->setStatusCode(200);
        return $response;
    }
}
