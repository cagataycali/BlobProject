<?php

namespace Blob\Core\ClientBundle\Controller;

use Blob\Core\LibraryBundle\Entity\Konusma;
use Blob\Core\LibraryBundle\Entity\KullaniciKonusma;
use Blob\Core\LibraryBundle\Entity\Mesaj;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MesajController extends Controller
{
    public function indexAction()
    {
//        /**
//         * Doctrine
//         */
//        $em = $this->getDoctrine()->getManager();
//
//        /**
//         * Yeni konuşma açalım
//         */
//        $yeni_konusma = new Konusma();
//        $yeni_konusma->setKonusmacilar(array($this->getUser()->getUsername(),$this->getUser()->getUsername()));
//
//        #todo : Tüm konuşmalar arasından benim konuşmalarımı çekeceğiz!
//
//        $em->persist($yeni_konusma);
//
//        /**
//         * Kullanıcı konuşmalarına ekleyelim
//         */
//        $yeni_kullanici_konusma = new KullaniciKonusma();
//
//        $yeni_kullanici_konusma->setKonusma($yeni_konusma);
//        $yeni_kullanici_konusma->setKullanici($this->getUser());
//
//        $em->persist($yeni_kullanici_konusma);
//
//
//        /**
//         * Yeni mesaj girelim
//         */
//        $yeni_mesaj = new Mesaj();
//
//        $yeni_mesaj ->setKonusma($yeni_konusma);
//        $yeni_mesaj ->setYazan($this->getUser());
//        $yeni_mesaj->setMesaj("Test mesajdır!");
//
//        $em->persist($yeni_mesaj);
//
//        $em->flush();

        return $this->render('BlobCoreClientBundle:Mesaj:index.html.twig');
    }
}
