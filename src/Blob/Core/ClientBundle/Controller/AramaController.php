<?php

namespace Blob\Core\ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AramaController extends Controller
{
    public function aramaAction(Request $request)
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
         * Gelen veriyi alalım.
         */
        $icerik = $request->request->get('icerik');

        /**
         * Yanıt dizimizi hazırlayalım
         */
        $yanit = array();

        if(strlen(trim($icerik)) == 0)
        {
            $yanit["durum"] = 404;

            $response = new Response(json_encode($yanit));
            $response->headers->set('Content-type', 'application/json; charset=utf-8');
            $response->setStatusCode(200);
            return $response;
        }

        $arama_sorgusu = $em->createQueryBuilder()
            ->select('k')
            ->from('BlobCoreLibraryBundle:Kullanici','k')
            ->leftJoin('BlobCoreLibraryBundle:Profil','p','WITH','p.kullanici = k.id')
            ->where('k.username LIKE :icerik')
            ->setParameter('icerik','%'.$icerik.'%')
            ->orderBy('k.username','DESC')
            ->getQuery()
            ->getResult();

        $yanit["durum"] = 200;

        if(count($arama_sorgusu) == 0)
        {
            $yanit["icerik"] = "Sanırım aradığın kişi bizde kayıtlı değil, hemen davet edebilirsin :)";
        }

        foreach ($arama_sorgusu as $arama)
        {
            $yanit["icerik"] = $arama->getUsername()."<br>";
            $yanit["icerik"] = '
<a href="'.$this->generateUrl('profil_detay',array('username'=>$arama->getUsername())).'" class="fa fa-user fa-2x">'.$arama->getUsername().'</a>
';
        }

        $response = new Response(json_encode($yanit));
        $response->headers->set('Content-type', 'application/json; charset=utf-8');
        $response->setStatusCode(200);
        return $response;
    }
}
