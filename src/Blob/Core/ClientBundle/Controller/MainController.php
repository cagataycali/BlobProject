<?php

namespace Blob\Core\ClientBundle\Controller;

use Blob\Core\LibraryBundle\Entity\Begeni;
use Blob\Core\LibraryBundle\Entity\Yorum;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    public function mainAction(Request $request)
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
            ->orderBy('f.createdAt','DESC') # TODO : HEM CREATED HEM İD
            ->getQuery()
            ->getResult();

        /**
         * Ayarlar
         */
        $ayarlar = $em->getRepository('BlobCoreLibraryBundle:SistemAyar')->find(1);

        /**
         * 5 erli bir şekilde infinitive scrolling yapacağız.
         */
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $kullanici_fotograflari,
            $request->query->getInt('page', 1)/*page number*/,
            $ayarlar->getAnaSayfadakiFotografSayisi()/*limit per page*/
        );

        return $this->render('BlobCoreClientBundle:Main:main.html.twig',array('kullanici_fotograflari'=>$pagination,'kimlik'=>$kimlik,'ayar'=>$ayarlar));
    }
}
