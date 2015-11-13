<?php
/**
 * Created by PhpStorm.
 * User: cagatay
 * Date: 1.11.15
 * Time: 18:20
 */

namespace Blob\Core\ServiceBundle\Controller;


use Blob\Core\LibraryBundle\Entity\Bildirim;
use Blob\Core\LibraryBundle\Entity\BildirimSablon;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BildirimGonder extends Controller
{
    public function bildirimGonder($kim,$kime,$sablon,$fotograf = null , $em) # Fotoğraf boş olabilir!
    {


        /**
         * Yeni bildirim oluşturalım
         */
        $yeni_bildirim = new Bildirim();

        $yeni_bildirim ->setDurum(0); # Henüz görülmedi!
        $yeni_bildirim ->setKim($kim); # Bildirimi kimin gönderttiği
        $yeni_bildirim ->setKullanici($kime); # Bildirimin kime gideceği!

        $yeni_bildirim ->setNeyi($fotograf); # Eğer tür 1 değilse! & Eğer tür takip bildirimi değilse

        # todo : Şablon entity'si gelmiyor,gelsede id değerine inemiyoruz bir problem mevcut $sablon->getId() değeri bulunamadığı için şablonu boş gönderiyor!

        $yeni_bildirim ->setSablon($sablon);

        $em->persist($yeni_bildirim);
        $em->flush();

        # todo :  Mobil cihazlara bildirimi gönderecek kodu burada yazacağız! & Ayırmayı düşünebiliriz, ama yinede bu servisin içerisinde yer alırsa daha iyi olacaktır.


        return true;
    }
}