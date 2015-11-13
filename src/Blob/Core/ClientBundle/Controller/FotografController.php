<?php

namespace Blob\Core\ClientBundle\Controller;

use Blob\Core\LibraryBundle\Entity\Begeni;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Twig_ExtensionInterface;
use Blob\Core\LibraryBundle\Entity\Takip;
use Blob\Core\LibraryBundle\Entity\Yorum;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FotografController extends Controller
{
    public function fotografDetayAction($hash)
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
         * Gelen fotograf nesnesini yakalayalım
         */
        $fotograf = $em -> getRepository( 'BlobCoreLibraryBundle:Fotograf' ) -> findOneBy(array('hash'=>$hash));

        if(!$fotograf)
        {
            return $this->redirectToRoute('profil');
        }

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

        $id_degerleri[] = $kimlik->getId(); # todo : kendi fotoğrafını beğesin mi?

        /**
         * Aratacağız
         */
        if(!in_array($fotograf->getKullanici()->getId(),$id_degerleri))
        {
            throw new AccessDeniedException("Bu fotoğrafı görmeye yetkiniz yok :)");
        }

        return $this->render('BlobCoreClientBundle:Profil:fotograf_detay.html.twig',array('f'=>$fotograf));
    }

    /**
     * @param Request $request
     * @return Response
     * Fotoğraf beğenmeye yarayan fonksiyon
     */
    public function fotografBegenAction(Request $request)
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
         * Bildirimi göndereceğimiz servis!
         */
        $guvercin = $this->container->get('bildirim_gonder');

        /**
         * Beğeninin bildirimi 5. şablona girdiği için şablon nesnesini bulalım
         */
        $sablon = $em -> getRepository( 'BlobCoreLibraryBundle:BildirimSablon' ) -> find(5);

        /**
         * Posttan gelen veriyi alalım. Id değeri fotoğrafın hash değerini taşır.
         */
        $id = $request->request->get('id');

        /**
         * Gelen fotograf nesnesini yakalayalım
         */
        $fotograf = $em -> getRepository( 'BlobCoreLibraryBundle:Fotograf' ) -> findOneBy(array('hash'=>$id));


        /**
         * Kullanıcının takip ettiği insanları alalım
         */
        $takip = $kimlik->getTakipEden();

        /**
         * Takip ettiğim insanların id değerlerini bir arrayde toplayalım
         */
        foreach ($takip as $t)
        {
            if($t->getDurum() == 1)
            {
                $id_degerleri[] = $t->getTakipEdilen()->getId();
            }
        }

        $id_degerleri[] = $kimlik->getId(); # todo : kendi fotoğrafını beğesin mi?


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
         * Diğer kullanıcının ayarlarını çekelim.
         */
        $ayar = $em -> getRepository('BlobCoreLibraryBundle:Ayar')->findOneBy(array('kullanici'=>$fotograf->getKullanici()));


        /**
         * Beğeni kontrol
         */
        $begeni = $em -> getRepository( 'BlobCoreLibraryBundle:Begeni' )->findOneBy(array('kullanici'=>$kimlik,'fotograf'=>$fotograf));

        /**
         * Kullanıcı daha önce hiç beğenmediyse.
         */
        if(!$begeni)
        {
            $begeni = new Begeni();

            $begeni -> setFotograf($fotograf);
            $begeni -> setKullanici($kimlik);

            #Persist
            $em -> persist($begeni);

            /**
             * Kalp değerini değiştireceğiz
             */
            $kalp = "fa-heart";

            if($fotograf->getKullanici() != $this->getUser() )
            {
                #Bildirim
                    #Ayarlarda bildirimler kapalıysa
                    if($ayar and $ayar->getBildirimler() == 1)
                    {
                        #todo Bildirim!
                        $guvercin->bildirimGonder($kimlik,$fotograf->getKullanici(),$sablon,$fotograf,$em);
                    }
                    elseif(!$ayar )
                    {
                        $guvercin->bildirimGonder($kimlik,$fotograf->getKullanici(),$sablon,$fotograf,$em);
                    }
                #Bildirim
            }


        }
        /**
         * Daha önceden beğendiyse beğeniyi kaldırıyoruz.
         */
        else
        {
            #Remove
            $em->remove($begeni);

            /**
             * Kalp değerini değiştireceğiz
             */
            $kalp = "fa-heart-o";
        }

        #Flush
        $em->flush();

        /**
         * Fotoğrafın beğenilerini yakalayalım.
         */
        $begeni_sayisi = $fotograf->getBegeniler();

        /**
         * Beğeni sayısını hesaplatalım
         */
        $o = 0;
        foreach ($begeni_sayisi as $b)
        {
            $o++;
        }

        /**
         * Yanıt dizimizi açalım
         */
        $yanit = array();

        $yanit["hash_degeri"] = $fotograf->getHash();
        $yanit["icerik"] = 'fa '.$kalp.' fa-4x like';
        $yanit["begeni_sayisi"] = $o;

        $response = new Response(json_encode($yanit));
        $response->headers->set('Content-type', 'application/json; charset=utf-8');
        $response->setStatusCode(200);
        return $response;
    }


    public function fotografSilAction(Request $request)
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
         * Posttan gelen veriyi alalım.Id değeri fotoğrafın hash değerini taşır.
         */
        $hash = $request->request->get('hash');

        /**
         * Gelen fotograf nesnesini yakalayalım
         */
        $fotograf = $em -> getRepository( 'BlobCoreLibraryBundle:Fotograf' ) -> findOneBy(array('hash'=>$hash,'kullanici'=>$kimlik));

        if(!$fotograf)
        {
            $yanit["durum"] = 403;

            $yanit["icerik"] = "Bu fotoğrafı silmeye yetkiniz yok!";

            $response = new Response(json_encode($yanit));
            $response->headers->set('Content-type', 'application/json; charset=utf-8');
            $response->setStatusCode(200);
            return $response;
        }

        #Fotoğrafı silelim
        $em->remove($fotograf);

        # Flush
        $em->flush();

        $yanit = "Başarılı";

        $response = new Response(json_encode($yanit));
        $response->headers->set('Content-type', 'application/json; charset=utf-8');
        $response->setStatusCode(200);
        return $response;
    }


    public function fotografEkleAction(Request $request)

    {

//        try {
//            //save to database
//            $this->em->persist($user);
//            $this->em->flush();
//        }
//        catch(Exception $err){
//
//            die($err->getMessage());
//
//            return false;
//        }
//        return true;
//    }

        /**
         * todo : Fotoğraf yüklerken bakılacak.
         * Fotoğrafı kaydederken unique değer mevcut, hash değeri bir unique değer ve bu değer sadece veritabanında bir kez yer alabilir,
         * Bu değer geldiğinde persist çalışmayacak buyuzden for döngüsüyle bir kez daha hash oluşturulup veritabanına o hash değerini deniyeceğiz.
         */


        /**
         * Fotoğrafın hash değerini oluşturalım
         */
        function crypto_rand_secure($min, $max) {
            $range = $max - $min;
            if ($range < 0) return $min; // not so random...
            $log = log($range, 2);
            $bytes = (int) ($log / 8) + 1; // length in bytes
            $bits = (int) $log + 1; // length in bits
            $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
            do
            {
                $rnd = hexdec ( bin2hex ( openssl_random_pseudo_bytes($bytes) ) );
                $rnd = $rnd & $filter; // discard irrelevant bits

            }
            while ($rnd >= $range);

            return $min + $rnd;
        }

        function getToken($length)
        {

            $token = "";

            $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
            $codeAlphabet.= "0123456789";

            for( $i=0; $i<$length; $i++ )
            {
                $token .= $codeAlphabet[ crypto_rand_secure ( 0, strlen($codeAlphabet) ) ];
            }
            return $token;
        }

        $min = 1;
        $max = 9;

        $link = getToken(5).crypto_rand_secure($min, $max);

        # todo : Burada takipçilere bildirim gidecek.


//        /**
//         * Bildirimi göndereceğimiz servis!
//         */
//        $guvercin = $this->container->get('bildirim_gonder');
//
//
//        /**
//         * Yeni fotoğraf 4. şablona girdiği için şablon nesnesini bulalım
//         */
//        $sablon = $em -> getRepository( 'BlobCoreLibraryBundle:BildirimSablon' ) -> find(4);
//
//
//        /**
//         * Takipçilerim
//         */
//        $takipcilerim = $this->getUser()->getTakipEden();
//
//        foreach ($takipcilerim as $k)
//        {
//            if($k->getAyar()->getBildirimler() == 1) # Ayarlarımda bildirim açıksa!
//            {
//                $guvercin->bildirimGonder($k,$this->getUser(),$sablon,$fotograf,$em);
//
//            }
//        }


    }

    public function sonsuzKaydirmaAction(Request $request)
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
         * Doctrine
         */
        $em = $this->getDoctrine()->getManager();

        /**
         * Kullanıcının görebileceği fotoğrafları alalım
         */
        $kullanici_fotograflari = $em->createQueryBuilder()
            ->select('f')
            ->from('BlobCoreLibraryBundle:Fotograf','f')
            ->leftJoin('BlobCoreLibraryBundle:Takip','t','WITH','t.takip_edilen = f.kullanici')
            ->where('t.takip_eden =:takip_eden OR f.kullanici=:takip_eden')
            ->andWhere('t.durum =:durum OR f.kullanici=:takip_eden')
            ->setParameter('takip_eden',$kimlik)
            ->setParameter('durum',1)
            ->orderBy('f.createdAt','DESC')
            ->getQuery()
            ->getResult();

        /**
         * Kaçıncı sayfada olduğumuzu alalım.
         */
        $sayfa = $request->request->get('page');

        /**
         * Son fotoğrafı hash değerinden bulalım. O fotoğrafı tekrar göndermeyeceğiz.
         */
        $son_fotograf_hash = $request->request->get('son');

        /**
         * Ayarları çekelim
         */
        $ayarlar = $em->getRepository('BlobCoreLibraryBundle:SistemAyar')->find(1);

        /**
         * 5 erli bir şekilde infinitive scrolling yapacağız.
         */
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $kullanici_fotograflari,
            $request->query->getInt('page', $sayfa)/*page number*/,
            $ayarlar->getKaydirincaGelecekFotografSayisi()/*limit per page*/
        );

        /**
         * Yanıt dizisi
         */
        $yanit = "";


        /**
         * Kullanıcının fotoğrafları nesnesini foreach ile dökeceğiz
         */
        foreach ($pagination as $p)
        {

            /**
             * Eğer hiç beğeni yoksa,
             * Kullanıcıda beğenmemiş demektir.
             * Buyuzden kalp'i boş göndereceğiz.
             */
            $heart_icon = "fa-heart-o";

            /**
             * Fotoğrafın beğeni sayısı
             */
            $begeni_sayisi = $p->getBegeniler();

            /**
             * Beğeni sayısını hesaplatalım
             */
            $o = 0;
            foreach ($begeni_sayisi as $b)
            {
                /**
                 * Eğer bende beğendiysem.
                 */
                if($b->getKullanici() == $kimlik)
                {
                    $heart_icon = "fa-heart";
                }
                else
                {
                    $heart_icon = "fa-heart-o";
                }
                $o++;
            }

            /**
             * Fotoğrafın yorumları
             */
            $yorumlar = "";

            $y = 0;
            foreach ($p->getYorumlar() as $yorum)
            {
                $yorumlar = '
                                    <li class="media media-comment">
                                        <div class="media-body">
                                            <div class="media-inner">
                                                <p>
                                                    <b class="post-author"> <a href="'. $url = $this->generateUrl('profil_detay',array('username'=>$yorum->getKullanici())).'">'.$yorum->getKullanici()->getUserName().'</a></b>
                                                    '.$yorum->getYorum().'
                                                     <i class="pull-right">'.$time_bundle->diff($yorum->getCreatedAt()).'</i>
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>';
                $y++;
            }

            /**
             * Yorum sayısı 0 sa comment-o
             */
            if($y == 0)
            {
                $comment = "fa-comment-o";
            }
            else
            {
                $comment = "fa-comment";
            }

            /**
             * Eğer fotoğrafın yorumu yoksa.
             */
            if(!$p->getYorumlar())
            {
                $yorumlar = '<div class="comments padded post-showinfo" id="comments">
                               <i style="color: deepskyblue;" class="dutluk">Eskiden buralar dutluktu..</i>
                            </div>';
            }

            $fotograf_footer_box = "";

            if($p->getKullanici() == $this->getUser())
            {
                $fotograf_footer_box = ' <div class="panel-footer">
                                            <div class="row">
                                                <div class="col-md-4"></div>
                                                <div class="col-md-4 sil" id="'.$p->getHash().'"><i class="fa fa-trash"></i> Fotoğrafı kaldır</div>
                                                <div class="col-md-4"></div>
                                            </div>
                                        </div>
                                    ';
            }

            /**
             * Yorumla kutusu..
             */
            $yorumla_box = '
                                            <div class="form-group form-icon-group">
                                                <form method="post" id="form_'.$p->getHash().'" onsubmit="return false;">
                                                    <textarea class="form-control yorum_field" name="yorum" placeholder="Mesajınız *" maxlength="140" rows="2" data-parsley-range="[5, 140]" data-parsley-required="required"></textarea>

                                                    <input type="submit" name="yorumla" value="Yorumla" style="float: right" class="btn btn-info btn-block yorum" id="'.$p->getHash().'">

                                                    <input type="hidden" name="hash" value="'.$p->getHash().'">
                                                </form>
                                            </div>
                                       ';


            /**
             * Döndüreceğimiz yanıt.
             */
            $yanit .= '<div class="row" id="fotograf_'.$p->getHash().'">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <article class="post post-showinfo">
                                <div class="post-media overlay">
                                    <a class="feature-image hover-animate img-responsive" >
                                        <img src="'.$p->getUrl().'" >
                                        <i style="color: #d12b31;;" class="fa fa-heart heart_like_'.$p->getHash().'"> '.$o.'</i>
                                    </a>
                                </div>
                                <div class="post-head small-screen-center">
                                    <small class="post-body">
                                        <b class="post-author"> <a href="'.$this->generateUrl('profil_detay',array('username'=>$p->getKullanici())).'">  '.$p->getKullanici()->getUsername().'</a></b> &nbsp;&nbsp; '.$p->getIcerik().'
                                    </small>
                                    <small class="post-date pull-right">
                                        <a >'.$time_bundle->diff($p->getCreatedAt()).'</a>
                                    </small>
                                </div>
                                <div class="text-center">
                                    <div class="row">
                                        <div class="col-md-2"></div>

                                        <div class="col-md-4">
                                            <a>
                                                <i id="'.$p->getHash().'" style="color: #93151a" class="fa '.$heart_icon.' fa-4x like faa-pulse animated-hover"></i>
                                            </a>
                                        </div>
                                        <div class="col-md-4">
                                            <a data-toggle="collapse" href="#comment_'.$p->getHash().'">
                                                <i style="color: #93151a" class="fa '.$comment.' fa-4x faa-burst animated-hover"></i>
                                            </a>
                                        </div>
                                        <div class="col-md-2"></div>

                                    </div>
                                </div>
                            </article>
                             <div class="panel-group" id="accordion">
                                <div class="panel panel-default">
                                    <div class="panel-collapse collapse" id="comment_'.$p->getHash().'" style="height: 0px;">
                                        <div class="panel-body">
                                        <div class="comments padded post-showinfo" id="comments">
                               <ul class="comments-list comments-body media-list" id="comment_box_'.$p->getHash().'">

                                    '.$yorumlar.'
                                      </ul>
                                                </div>

                                      '.$yorumla_box.'
                                        </div>
                                        '.$fotograf_footer_box.'
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';


        }



        $response = new Response(json_encode($yanit));
        $response->headers->set('Content-type', 'application/json; charset=utf-8');
        $response->setStatusCode(200);
        return $response;
    }
}
