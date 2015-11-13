Bildirim göndermek için :

<?php

                /**
                 * Bildirim servisini çağır, veri dizisini oluştur ve bildirim gönder
                 */
                $veriler = array();

                /**
                 * Alıcı Bilgileri
                 */
                $anahtarlar = $em->createQueryBuilder()
                    ->select('a.osType, a.deviceToken, a.registerId, p.ad, p.soyad')
                    ->from('CoreCommonBundle:OgrenciVeli', 'o')
                    ->innerJoin('CoreCommonBundle:Profil', 'p', 'WITH', 'o.profil = p.id')
                    ->innerJoin('CoreCommonBundle:Kullanici', 'k', 'WITH', 'p.kullanici = k.id')
                    ->innerJoin('CoreCommonBundle:Anahtar', 'a', 'WITH', 'a.kullanici = k.id')
                    ->where('o.ogrenci = :ogrenci')
                    ->setParameter('ogrenci', $ogrenci)
                    ->getQuery()
                    ->getResult();

                $cihazlar = array();

                foreach ($anahtarlar as $anahtar)
                {
                    $cihazlar['ad_soyad'] = $anahtar['ad'] . ' ' . $anahtar['soyad'];
                    $cihazlar['os'] = $anahtar['osType'];
                    $cihazlar['device_token'] = $anahtar['deviceToken'];
                    $cihazlar['register_id'] = $anahtar['registerId'];
                    $cihazlar['ekstra'] = array(
                        'tip' => 'dinamik-modul',
                        'modul_id' => $yeni_modul_icerigi->getAltModul()->getModul()->getId(),
                        'alt_modul_id' => $yeni_modul_icerigi->getAltModul()->getId(),
                        'ogrenci_id' => $ogrenci_id,
                    );

                    $veriler[] = $cihazlar;
                }

                /**
                 * Vereceğimiz verileri hazırlayalım.
                 */
                $ogrenci_id = $ogrenci->getId();
                $ogrenci_ad = $ogrenci->getAd() . " " . $ogrenci->getSoyad();
                $modul_adi = $yeni_modul_icerigi->getAltModul()->getModul()->getBaslik();
                $alt_modul_adi = $yeni_modul_icerigi->getAltModul()->getBaslik();
                $modul_icerik_baslik = $yeni_modul_icerigi->getBaslik();
                $modul_icerik_aciklama = $yeni_modul_icerigi->getMetin();

                /**
                 * Bildirim Hazırlıkları
                 */
                $tip = 'sabit'; // sabit = Tek Metin, degisken = Farklı Metinler

                $konu = "$ogrenci_ad  $modul_adi'ne  $alt_modul_adi görevi verildi !";

                $icerik = "$alt_modul_adi: $modul_icerik_baslik adlı görev verildi.";

                /*
                $veriler = array(

                    array(
                        'ad_soyad' => 'Buğra YÜKSEL',
                        'os' => 'ios',
                        'device_token' => 'd176c3d6f71f344b08aa71c3f553b577cb195c1de244d4d3502bc38c7c797e83',
                        'register_id' => '',
                        'ekstra' => array(
                            'tip' => 'galeri', // tip => galeri, haber
                            'id' => '21' // id = 21, 28
                        )
                    ),

                );*/

                /**
                 * Bildirim gönderme servisine gerekli parametreleri gönder ve işlemi başlat
                 */
                $guvercin = $this->get('bildirim');

                $guvercin->bildirimGonder($tip, $konu, $icerik, $veriler); //$guvercin->bildirimGonder($tip, $konu, $icerik, $veriler);
