<?php

namespace Blob\Core\ClientBundle\Controller;

use Blob\Core\LibraryBundle\Entity\Yorum;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class YorumController extends Controller
{
    public function yorumYapAction(Request $request)
    {
        /**
         * Kimlik
         */
        $kimlik = $this->getUser();

        /**
         * Doctrine yardımcısı
         */
        $em = $this->getDoctrine()->getManager();

        /**
         * Fos user user manager
         */
        $userManager = $this->get('fos_user.user_manager');

        /**
         * Time ago eklentisini kullanabilmek için.
         */
        $time_bundle = $this->container->get('time.templating.helper.time');

        /**
         * Bildirimi göndereceğimiz servis!
         */
        $guvercin = $this->container->get('bildirim_gonder');

        /**
         * Yorum 2. şablona girdiği için şablon nesnesini bulalım
         */
        $sablon = $em -> getRepository( 'BlobCoreLibraryBundle:BildirimSablon' ) -> find(6);

        /**
         * Posttan gelen verileri alalım
         */
        $yorum = $request->request->get('yorum');
        $hash = $request->request->get('hash');

        /**
         * Gelen fotograf nesnesini yakalayalım
         */
        $fotograf = $em -> getRepository( 'BlobCoreLibraryBundle:Fotograf' ) -> findOneBy(array('hash'=>$hash));

        /**
         * Yorum yapan insanların id değerlerini bir y_id_degeleri arrayinde toplayalım
         */
        $y_id_degerleri = array();

        /**
         * Fotoğrafın yorum sayısını bulalım
         */
        $s = 0 ;
        foreach ($fotograf->getYorumlar() as $yorumlar)
        {
            if($yorumlar->getKullanici() != $this->getUser())# Benim haricimdeki kullanıcılar
            {
                $y_id_degerleri[$s] = $yorumlar->getKullanici()->getId();
                $s++;
            }
        }

        /**
         * Diğer kullanıcının ayarlarını çekelim.
         */
        $ayar = $em -> getRepository('BlobCoreLibraryBundle:Ayar')->findOneBy(array('kullanici'=>$fotograf->getKullanici()));

        /**
         * Kullanıcının takip ettiği insanları alalım
         */
        $takip = $kimlik->getTakipEden();

        /**
         * Takip ettiğim insanların id değerlerini bir arrayde toplayalım
         */
        foreach ($takip as $t)
        {
            $id_degerleri[] = $t->getTakipEdilen()->getId();
        }

        $id_degerleri[] = $kimlik->getId(); # todo : kendi fotoğrafına yorum yapılsın mı?


        /**
         * Aratacağız
         */
        if(!in_array($fotograf->getKullanici()->getId(),$id_degerleri))
        {
            $yanit = 'Bu fotoğrafı görmeye yetkiniz yok!';

            $response = new Response(json_encode($yanit));
            $response->headers->set('Content-type', 'application/json; charset=utf-8');
            $response->setStatusCode(200);
            return $response;
        }

        /**
         * Yorum yapalım.
         */
        $yeni_yorum = new Yorum();

        $yeni_yorum->setDurum(1);
        $yeni_yorum->setKullanici($kimlik);
        $yeni_yorum->setFotograf($fotograf);
        $yeni_yorum->setYorum($yorum);

        #Persist
        $em->persist($yeni_yorum);

        #Flush
        $em->flush();

        /**
         * Default tanımlıyoruz!
         */
        $yorum_sil= '';

        if($kimlik == $yeni_yorum->getKullanici())
        {
            $yorum_sil = '<i id="yorum_'.$yeni_yorum->getId().'" class="fa fa-trash yorum_sil pull-right"></i>';
        }

        $yanit = '  <li class="media media-comment" id="yorum_div_'.$yeni_yorum->getId().'">
                             <div class="media-body">
                                        <div class="media-inner">
                                            <p>
                                                <b class="post-author"> '.$yeni_yorum->getKullanici()->getUserName().'</b>
                                                    '.$yeni_yorum->getYorum().'
                                                     <i class="pull-right">'.$time_bundle->diff($yeni_yorum->getCreatedAt()).'</i>
                                                    '.$yorum_sil.'
                                            </p>
                                        </div>
                             </div>
                     </li>';


        if($this->getUser() != $fotograf->getKullanici()) # Fotoğrafın sahibi ben değilsem
        {

            #Bildirim

                #Ayarlarda bildirimler açıksa
                if($ayar and $ayar->getBildirimler() == 1)
                {
                    $guvercin->bildirimGonder($kimlik,$fotograf->getKullanici(),$sablon,$fotograf,$em);
                }
                elseif(!$ayar)
                {
                    $guvercin->bildirimGonder($kimlik,$fotograf->getKullanici(),$sablon,$fotograf,$em);
                }

            #Bildirim

        }
        elseif($this->getUser() == $fotograf->getKullanici() and $s > 0)# Fotoğrafın sahibi benim fakat yorum mevcut!
        {
            #Ayarlarda bildirimler açıksa
            if($ayar and $ayar->getBildirimler() == 1)
            {
                /**
                 * Yorum yaptığın fotoğrafa sahibi yorum yaptı şablonu 7
                 */
                $sablon = $em -> getRepository( 'BlobCoreLibraryBundle:BildirimSablon' ) -> find(7);

                #Benim dışımdaki yorum yapan insanlara bildirim gidecek!
                foreach ($y_id_degerleri as $y)
                {
                    $kullanici =  $userManager->findUserByUsernameOrEmail($y);

                    $guvercin->bildirimGonder($this->getUser(),$kullanici,$sablon,$fotograf,$em);
                }
            }
        }

        /**
         * Yorum nesnesini boşalttık!
         */
        $yorum = "";

        $response = new Response(json_encode($yanit));
        $response->headers->set('Content-type', 'application/json; charset=utf-8');
        $response->setStatusCode(200);
        return $response;
    }

    public function yorumSilAction(Request $request)
    {
        /**
         * Doctrine
         */
        $em = $this->getDoctrine()->getManager();

        /**
         * Kullanıcı & Kimlik
         */
        $kimlik = $this->getUser();

        /**
         * Posttan gelen yorum id değerini alalım
         */
        $yorum_id = $request->request->get('id');

        /**
         * Yorum id değeri yorum_id şeklinde gelecektir buyüzden explode edelim
         */
        $expolode = explode('_',$yorum_id);

        $yorum_id_degeri = $expolode[1];

        /**
         * Yorum nesnesini bulalım
         */
        $yorum = $em->getRepository('BlobCoreLibraryBundle:Yorum')->findOneBy(array('kullanici'=>$kimlik,'id'=>$yorum_id_degeri));

        if(!$yorum)
        {
            $yanit = 'Bu yorumu silmeye yetkiniz yok!';

            $response = new Response(json_encode($yanit));
            $response->headers->set('Content-type', 'application/json; charset=utf-8');
            $response->setStatusCode(200);
            return $response;
        }

        $em->remove($yorum);
        $em->flush();

        $yanit = $yorum_id_degeri;

        $response = new Response(json_encode($yanit));
        $response->headers->set('Content-type', 'application/json; charset=utf-8');
        $response->setStatusCode(200);
        return $response;
    }
}
