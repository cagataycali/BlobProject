<?php
/**
 * Created by PhpStorm.
 * User: cagatay
 * Date: 31.10.15
 * Time: 19:17
 */

namespace Blob\Core\ServiceBundle\Controller;


class Bildirim
{
    private $apns_server, $passphrase, $pem, $gcm_url, $project_id, $api_key, $fp, $ch, $headers;

    public function __construct($apns_server, $passphrase, $pem, $gcm_url, $project_id, $api_key)
    {
        /**
         * Parameters
         */
        $this->apns_server = $apns_server;
        $this->passphrase = $passphrase;
        $this->pem = $pem;
        $this->gcm_url = $gcm_url;
        $this->project_id = $project_id;
        $this->api_key = $api_key;

        /**
         *
         * Apple (iOS)
         * APNS Bağlantısı
         *
         * Bilgi: Çok sayıda cihaza bildirim gönderirken her defasında Apple sunucusu ile connect - disconnect işlemi yapmamak için __construct metodunda bağlantıyı gerçekleştiriyoruz.
         * Detay: Hem performans sağlamamk, hem flood saldırı şüphesini önlemek adına.
         *
         */
        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', $this->pem);
        stream_context_set_option($ctx, 'ssl', 'passphrase', $this->passphrase);

        $this->fp = stream_socket_client(
            $this->apns_server, $err,
            $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

        if (!$this->fp)
            exit("Failed to connect: $err $errstr" . PHP_EOL);

        //echo 'Connected to APNS' . PHP_EOL;

        /**
         *
         * Google (Android)
         * GCM Bağlantısı
         *
         * Bilgi: Çok sayıda cihaza bildirim gönderirken her defasında Google sunucusu ile connect - disconnect işlemi yapmamak için __construct metodunda bağlantıyı gerçekleştiriyoruz.
         * Detay: Hem performans sağlamamk, hem flood saldırı şüphesini önlemek adına.
         */

        /**
         * Headers
         */
        $this->headers = array(
            'Authorization: key=' . $this->api_key,
            'Content-Type: application/json'
        );

        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_URL, $this->gcm_url);
        curl_setopt($this->ch, CURLOPT_POST, true);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);

    }

    public function __destruct()
    {
        /**
         * APNS Sunucusu ile bağlantıyı kes
         */
        fclose($this->fp);

        /**
         * GCM Sunucusu ile bağlantıyı kes
         */
        curl_close($this->ch);
    }

    /**
     * Bildirim Gönder
     */
    public function bildirimGonder($tip, $konu = null, $icerik = null, $veriler = null)
    {

        /**
         * İçerip Tipi
         */
        if ($tip == 'sabit')
        {
            /**
             * Tek Metni Tüm Alıcılara Gönder (Android)
             */
            $android_cihazlar = array(); // Metin sabit olduğu için dizideki cihazlara tek seferde toplu gönderim için oluşturulacak dizi. Google Cloud Messaging sunucusuna her defasında 1000 cihazlık istek gönderilebiliyor.

            /**
             * Verileri parçala ve tek tek bildirim gönder
             */
            foreach ($veriler as $veri)
            {
                /**
                 * Parametreler
                 */
                $os = $veri['os'];
                $device_token = $veri['device_token'];
                $register_id = $veri['register_id'];
                $ekstra = $veri['ekstra'];

                /**
                 * Bildirim Objesini Hazırla
                 */
                if ($os == 'ios') {

                    /**
                     * Apple Push Notification Gönder
                     */
                    $this->apns($device_token, $icerik, $ekstra);

                } else if ($os == 'android') {

                    /**
                     * Android cihazlar dizisine ekle
                     */
                    $android_cihazlar[] = $register_id;

                }
            }

            /**
             * Android GCM Gönder (Sabit Metin)
             */
            $this->gcmSabit($android_cihazlar, $konu, $icerik, $ekstra);

        } else if ($tip == 'degisken') {

            /**
             * Farklı Metinleri İlgili Alıcılara Gönder
             */

            /**
             * Verileri parçala ve tek tek bildirim gönder
             */
            foreach ($veriler as $veri)
            {
                /**
                 * Parametreler
                 */
                $os = $veri['os'];
                $device_token = $veri['device_token'];
                $register_id = $veri['register_id'];
                $konu = $veri['konu'];
                $icerik = $veri['icerik'];
                $ekstra = $veri['ekstra'];

                /**
                 * Bildirim Objesini Hazırla
                 */
                if ($os == 'ios') {

                    /**
                     * Apple Push Notification Gönder
                     */
                    $this->apns($device_token, $icerik, $ekstra);

                } else if ($os == 'android') {

                    /**
                     * Android GCM Gönder (Değişken Metin)
                     */
                    $this->gcmDegisken($register_id, $konu, $icerik, $ekstra);
                }

            }

        }

        return true;

    }

    /**
     * APNS: Apple Push Notification Service
     */
    public function apns($device_token, $icerik, $ekstra)
    {

        /**
         * Payload
         */
        $body['aps'] = array(
            'alert' => $icerik,
            'sound' => 'default',
            'bilgi' => $ekstra,
            //'badge' => 1,
        );

        /**
         * Encode the payload as JSON
         */
        $payload = json_encode($body);

        /**
         * Build the binary notification
         */
        $msg = chr(0) . pack('n', 32) . pack('H*', $device_token) . pack('n', strlen($payload)) . $payload;

        /**
         * Send it to server
         */
        $result = fwrite($this->fp, $msg, strlen($msg));

        /**
         * Return
         */
        if (!$result) {
            //echo 'Message not delivered' . PHP_EOL;
            return -1;
        } else {
            //echo  Message successfully delivered' . PHP_EOL;
            return 1;
        }

        /* if ($result) {
             //echo  Message successfully delivered' . PHP_EOL;
             return 1;
         }

        */

    }

    /**
     * GCM: Google Cloud Messaging (Sabit: Aynı Metin)
     */
    public function gcmSabit($android_cihazlar, $konu, $icerik, $ekstra)
    {

        /**
         * Cihazlar
         */
        $android_cihazlar = array_unique($android_cihazlar);
        $tum_cihazlar = array_chunk($android_cihazlar, 1000);

        $result = '';

        /**
         * Tüm cihazlara 1000'erli grup olarak gönder. //Not: Google her defasında maksimum 1000 cihaza kadar istek alabiliyor.
         */
        foreach ($tum_cihazlar as $cihazlar)
        {
            /**
             * GCM Verisini Hazırla
             */
            $fields = array(
                'registration_ids' => $cihazlar,
                'data' => array("message" => $icerik, "title" => $konu, "bilgi" => $ekstra),
            );

            /**
             * Başlatılmış cURL ile ildirimi gönder
             */
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($this->ch);

        }

        /**
         * Return
         */
        if($result==false){
            return -1;
        } else {
            return 1;
        }

    }

    /**
     * GCM: Google Cloud Messaging (Değişken: Farklı metinler)
     */
    public function gcmDegisken($register_id, $konu, $icerik, $ekstra)
    {

        /**
         * GCM Verisini Hazırla
         */
        $fields = array(
            'registration_ids' => array($register_id),
            'data' => array("message" => $icerik, "title" => $konu, "bilgi" => $ekstra),
        );

        /**
         * Başlatılmış cURL ile ildirimi gönder
         */
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($this->ch);

        /**
         * Return
         */
        if($result==false){
            return -1;
        } else {
            return 1;
        }

    }

    /**
     * APNS: Apple Push Notification Service
     *
    public function apns($device_token, $icerik, $ekstra)
    {

    ////////////////////////////////////////////////////////////////////////////////
    $ctx = stream_context_create();
    stream_context_set_option($ctx, 'ssl', 'local_cert', $this->pem);
    stream_context_set_option($ctx, 'ssl', 'passphrase', $this->passphrase);

    // Open a connection to the APNS server // PRODUCTION
    $fp = stream_socket_client(
    $this->apns_server, $err,
    $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

    if (!$fp)
    exit("Failed to connect: $err $errstr" . PHP_EOL);

    //echo 'Connected to APNS' . PHP_EOL;

    // Create the payload body
    $body['aps'] = array(
    'alert' => $icerik,
    'sound' => 'default',
    'bilgi' => $ekstra,
    //'badge' => 1,
    );

    // Encode the payload as JSON
    $payload = json_encode($body);

    // Build the binary notification
    $msg = chr(0) . pack('n', 32) . pack('H*', $device_token) . pack('n', strlen($payload)) . $payload;

    // Send it to the server
    $result = fwrite($fp, $msg, strlen($msg));

    // Close the connection to the server
    fclose($fp);

    //Return
    if (!$result) {
    //echo 'Message not delivered' . PHP_EOL;
    return -1;
    } else {
    //echo  Message successfully delivered' . PHP_EOL;
    return 1;
    }

    }
     */

    /**
     * GCM: Google Cloud Messaging (Sabit: Aynı Metin)
     *
    public function gcmSabit($android_cihazlar, $konu, $icerik, $ekstra)
    {

    // Cihazlar
    $android_cihazlar = array_unique($android_cihazlar);
    $tum_cihazlar = array_chunk($android_cihazlar, 1000);

    $result = '';

    // Tüm cihazlara 1000'erli grup olarak gönder. //Not: Google her defasında maksimum 1000 cihaza kadar istek alabiliyor.
    foreach ($tum_cihazlar as $cihazlar)
    {
    // Veri hazırla
    $fields = array(
    'registration_ids' => $cihazlar,
    'data' => array("message" => $icerik, "title" => $konu, "bilgi" => $ekstra),
    );

    // Headers
    $headers = array(
    'Authorization: key=' . $this->api_key,
    'Content-Type: application/json'
    );

    //cURL işlemini başlat ve bildirimi gönder
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $this->gcm_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    curl_close($ch);
    }

    // Return
    if($result==false){
    return -1;
    } else {
    return 1;
    }

    }*/

}