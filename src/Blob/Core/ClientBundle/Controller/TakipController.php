<?php

namespace Blob\Core\ClientBundle\Controller;

use Blob\Core\LibraryBundle\Entity\Ayar;
use Blob\Core\LibraryBundle\Entity\Kullanici;
use Blob\Core\LibraryBundle\Entity\Takip;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TakipController extends Controller
{
    public function takipAction(Request $request)
    {
        /**
         * Kimlik
         */
        $kimlik = $this->getUser();

        /**
         * Doctrine
         */
        $em = $this->getDoctrine()->getManager();

        /**
         * Bildirimi göndereceğimiz servis!
         */
        $guvercin = $this->container->get('bildirim_gonder');

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
         * Takip tablosuna bakalım
         *
         * Daha önceden takip etmiyorsam edeceğim.
         */
        $takip = $em -> getRepository('BlobCoreLibraryBundle:Takip')->findOneBy(array('takip_eden'=>$kimlik,'takip_edilen'=>$kullanici));

        /**
         * Diğer kullanıcının ayarlarını çekelim.
         */
        $ayar = $em -> getRepository('BlobCoreLibraryBundle:Ayar')->findOneBy(array('kullanici'=>$kullanici));

        /**
         * Default açık.
         */
        $durum = 1;

        if(!$ayar)
        {
            $durum = 1; # Profili açıktır.
        }
        if($ayar and $ayar->getProfilGizli() == 0)
        {
            $durum = 1; # Profili açıktır.
        }
        if($ayar and $ayar->getProfilGizli() == 1)
        {
            $durum = 0; # Profili gizlidir.
        }


        # Takip etmiyorsam ..
        if(!$takip)
        {
            $yeni_takip = new Takip();

            $yeni_takip ->setDurum($durum);
            $yeni_takip ->setTakipEden($kimlik);
            $yeni_takip ->setTakipEdilen($kullanici);
            $yeni_takip ->setDurum($durum);

            $em->persist($yeni_takip);

            $em->flush();

            #Ayarlarda bildirimler açıksa
            if($ayar and $ayar->getBildirimler() == 1)
            {
                if($durum == 0) ## Profili gizliyse
                {
                    /**
                     * Takip isteği 2. şablona girdiği için şablon nesnesini bulalım
                     */
                    $sablon = $em -> getRepository( 'BlobCoreLibraryBundle:BildirimSablon' ) -> find(2);

                }
                else ## Profili açıksa
                {
                    /**
                     * Takip bildirimi 1. şablona girdiği için şablon nesnesini bulalım
                     */
                    $sablon = $em -> getRepository( 'BlobCoreLibraryBundle:BildirimSablon' ) -> find(1);
                }

                $guvercin->bildirimGonder($kimlik,$kullanici,$sablon,null,$em);

                #todo :Bildirim!
            }
            else
            {
                if($durum == 0)
                {
                    /**
                     * Takip isteği 2. şablona girdiği için şablon nesnesini bulalım
                     */
                    $sablon = $em -> getRepository( 'BlobCoreLibraryBundle:BildirimSablon' ) -> find(2);
                }
                else
                {
                    /**
                     * Takip bildirimi 1. şablona girdiği için şablon nesnesini bulalım
                     */
                    $sablon = $em -> getRepository( 'BlobCoreLibraryBundle:BildirimSablon' ) -> find(1);
                }

                $guvercin->bildirimGonder($kimlik,$kullanici,$sablon,null,$em);
            }


            /**
             * Buton classları
             */
            if($yeni_takip->getDurum() == 0)
            {
                $yanit["icerik"] = 'Takip için onay bekliyorsun';
                $yanit["trigger_degeri"] = 0; # Kullanıcının fotoğraflarını çekme triggeri.
                $yanit["class_degeri"] = 'btn btn-info takip';

            }
            else
            {
                $yanit["icerik"] = 'Takip ediyorsun';
                $yanit["class_degeri"] = 'btn btn-success takip';
                $yanit["trigger_degeri"] = 1; # Kullanıcının fotoğraflarını çek jquery kodunu trigger ettik.
            }
        }

        # Takip ediyorum fakat tekrar tıkladığımda takibi bırak olacak buyuzden takipler tablosundan veriyi siliyoruz..
        if ($takip and $takip->getDurum() == 1)
        {
            $em->remove($takip);

            $em->flush();

            /**
             * Buton classları
             */
            $yanit["icerik"] = 'Takip et';
            $yanit["class_degeri"] = 'btn btn-primary takip';
            $yanit["trigger_degeri"] = 0; # Kullanıcının fotoğraflarını çek jquery kodunu görünmez hale getirdik.
        }

        # Takip isteğim onay bekliyor fakat tekrar tıkladığımda takibi bırak olacak buyuzden takipler tablosundan veriyi siliyoruz..
        if ($takip and $takip->getDurum() == 0)
        {
            $em->remove($takip);

            $em->flush();

            /**
             * Buton classları
             */
            $yanit["icerik"] = 'Takip et';
            $yanit["class_degeri"] = 'btn btn-primary takip';
            $yanit["trigger_degeri"] = 0; # Kullanıcının fotoğraflarını çek jquery kodunu görünmez hale getirdik.
        }


        $response = new Response(json_encode($yanit));
        $response->headers->set('Content-type', 'application/json; charset=utf-8');
        $response->setStatusCode(200);
        return $response;
    }

    public function takipOnayAction(Request $request)
    {
        /**
         * Kimlik
         */
        $kimlik = $this->getUser();

        /**
         * Doctrine
         */
        $em = $this->getDoctrine()->getManager();

        /**
         * Bildirimi göndereceğimiz servis!
         */
        $guvercin = $this->container->get('bildirim_gonder');

        /**
         * Gelen veriyi alalım.
         */
        $kullanici = $request->request->get('kullanici');
        $bildirim_id = $request->request->get('bildirim');

        /**
         * Bildirim nesnesini alalım
         */
        $bildirim = $em->getRepository('BlobCoreLibraryBundle:Bildirim')->find($bildirim_id);

        if(!$bildirim)
        {
            $yanit["durum"] = 404;

            $response = new Response(json_encode($yanit));
            $response->headers->set('Content-type', 'application/json; charset=utf-8');
            $response->setStatusCode(200);
            return $response;
        }

        /**
         * Yanıt dizimizi hazırlayalım
         */
        $yanit = array();

        $kullanici = $this->get('fos_user.user_manager')->findUserByUsername($kullanici);

        if(!$kullanici)
        {
            $yanit["durum"] = 406;

            $response = new Response(json_encode($yanit));
            $response->headers->set('Content-type', 'application/json; charset=utf-8');
            $response->setStatusCode(200);
            return $response;
        }

        /**
         * Kullanıcı kendini takip edemez.
         */
        if ( $this->getUser() == $kullanici )
        {
            $yanit["durum"] = 404;

            $response = new Response(json_encode($yanit));
            $response->headers->set('Content-type', 'application/json; charset=utf-8');
            $response->setStatusCode(200);
            return $response;
        }

        /**
         * Takip tablosuna bakalım
         *
         * Takip isteğini onaylıyoruz! Mehmet -> Çağatay'ı takip etmek istedi,çağatay onay veriyor!
         */
        $takip = $em -> getRepository('BlobCoreLibraryBundle:Takip')->findOneBy(array('takip_eden'=>$kullanici,'takip_edilen'=>$this->getUser(),'durum'=>0));


        $takip->getDurum(1);
        $em->flush();

        #Bildirim

        /**
         * Takip Onayı Şablonu
         */
        /**
         * Takip onayının bildirimi 3. şablona girdiği için şablon nesnesini bulalım
         */
        $sablon = $em -> getRepository( 'BlobCoreLibraryBundle:BildirimSablon' ) -> find(3);

        /**
         * Bildirim kime gidecek?
         */
        $kime = $kullanici; # Bildirim kullanici nesnesine gidecek
        $kim = $kimlik; # Bildirimi kim tetikleyecek

        $guvercin->bildirimGonder($kim,$kime,$sablon,null,$em);
        # todo Bildirim !

        #Bildirim

        $bildirim->setDurum(1);

        #Takibi Onayladık
        $takip->setDurum(1);

        #Flush!
        $em->flush();

        /**
         * Yanıt nesnemizi hazırlayalım!
         */
        $yanit["durum"] = 200;


        $response = new Response(json_encode($yanit));
        $response->headers->set('Content-type', 'application/json; charset=utf-8');
        $response->setStatusCode(200);
        return $response;
    }
}
