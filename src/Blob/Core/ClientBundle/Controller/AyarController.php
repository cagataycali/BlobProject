<?php

namespace Blob\Core\ClientBundle\Controller;

use Blob\Core\LibraryBundle\Entity\Ayar;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AyarController extends Controller
{
    public function ayarAction()
    {
        /**
         * Giriş yapan kullanıcının profil bilgilerini direkt olarak return olarak döndüreceğiz.
         */
        return $this->render('BlobCoreClientBundle:Ayar:index.html.twig');
    }

    public function ayarGuncelleAction(Request $request)
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
         * Gelen veriyi alalım
         */
        $ayar_adi = $request->request->get('ayar');

        /**
         * Kullanıcının ayarlarını alalım
         */
        $ayar = $em -> getRepository('BlobCoreLibraryBundle:Ayar')->findOneBy(array('kullanici'=>$kimlik));


        /**
         * Ayar hiç yoksa oluşturacağız.
         */
        if(!$ayar)
        {
            $ayar = new Ayar();

            $ayar ->setProfilGizli(0);
            $ayar ->setBildirimler(1);

            if($ayar_adi == "profil")
            {
                $ayar ->setProfilGizli(1);

            }
            elseif($ayar_adi == "bildirimler")
            {
                $ayar ->setBildirimler(0);
            }

            $ayar->setKullanici($kimlik);

            $em->persist($ayar);

        }
        else
        {


            /**
             * Ayar var, ayar adı profil , ve veritabanında 1 ise , 0 yapacağız
             */
            if ($ayar and $ayar_adi == "profil" and $ayar->getProfilGizli() == 1)
            {

                $ayar->setProfilGizli(0);
            }elseif ($ayar and $ayar_adi == "profil" and $ayar->getProfilGizli() == 0)
            {

                $ayar->setProfilGizli(1);
            }
            elseif($ayar and $ayar_adi == "bildirimler" and $ayar->getBildirimler() == 1)
            {
                $ayar->setBildirimler(0);
            }
            elseif ($ayar and $ayar_adi == "bildirimler" and $ayar->getBildirimler() == 0)
            {
                $ayar->setBildirimler(1);
            }


        }


        $em->flush();

        $yanit = "Başarılı";

        $response = new Response(json_encode($yanit));
        $response->headers->set('Content-type', 'application/json; charset=utf-8');
        $response->setStatusCode(200);
        return $response;

    }
}
