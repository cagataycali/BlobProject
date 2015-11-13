-- phpMyAdmin SQL Dump
-- version 4.4.9
-- http://www.phpmyadmin.net
--
-- Anamakine: localhost:8889
-- Üretim Zamanı: 13 Kas 2015, 23:29:06
-- Sunucu sürümü: 5.5.42
-- PHP Sürümü: 5.5.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Veritabanı: `blob`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `anahtarlar`
--

CREATE TABLE `anahtarlar` (
  `id` int(11) NOT NULL,
  `kullanici_id` int(11) DEFAULT NULL,
  `accessToken` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `os_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `os_version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `device_model` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `device_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `register_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ayarlar`
--

CREATE TABLE `ayarlar` (
  `id` int(11) NOT NULL,
  `kullanici_id` int(11) DEFAULT NULL,
  `profil_gizli` tinyint(1) DEFAULT NULL,
  `bildirimler` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `ayarlar`
--

INSERT INTO `ayarlar` (`id`, `kullanici_id`, `profil_gizli`, `bildirimler`) VALUES
(1, 4, 1, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `begeniler`
--

CREATE TABLE `begeniler` (
  `id` int(11) NOT NULL,
  `kullanici_id` int(11) DEFAULT NULL,
  `fotograf_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `begeniler`
--

INSERT INTO `begeniler` (`id`, `kullanici_id`, `fotograf_id`, `created_at`, `updated_at`) VALUES
(4, 4, 1, '2015-11-06 18:21:00', '2015-11-06 18:21:00'),
(5, 1, 4, '2015-11-12 18:59:00', '2015-11-12 18:59:00');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `bildirimler`
--

CREATE TABLE `bildirimler` (
  `id` int(11) NOT NULL,
  `kullanici_id` int(11) DEFAULT NULL,
  `sablon_id` int(11) DEFAULT NULL,
  `kim_id` int(11) DEFAULT NULL,
  `fotograf_id` int(11) DEFAULT NULL,
  `durum` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `bildirimler`
--

INSERT INTO `bildirimler` (`id`, `kullanici_id`, `sablon_id`, `kim_id`, `fotograf_id`, `durum`, `created_at`) VALUES
(13, 4, 2, 1, NULL, 1, '2015-11-06 00:28:00'),
(14, 1, 3, 4, NULL, 1, '2015-11-06 00:31:00'),
(15, 4, 5, 1, 4, 1, '2015-11-06 00:31:00'),
(16, 4, 6, 1, 4, 1, '2015-11-06 00:31:00'),
(17, NULL, 7, 4, 4, 0, '2015-11-06 00:32:00'),
(18, 1, 1, 4, NULL, 1, '2015-11-06 00:39:00'),
(19, 1, 5, 4, 1, 1, '2015-11-06 18:21:00'),
(20, 1, 6, 4, 1, 1, '2015-11-06 18:21:00'),
(21, 4, 5, 1, 4, 0, '2015-11-12 18:59:00'),
(22, 4, 6, 1, 4, 0, '2015-11-12 18:59:00');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `bildirim_sablonlari`
--

CREATE TABLE `bildirim_sablonlari` (
  `id` int(11) NOT NULL,
  `tur_id` int(11) DEFAULT NULL,
  `icerik` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `bildirim_sablonlari`
--

INSERT INTO `bildirim_sablonlari` (`id`, `tur_id`, `icerik`) VALUES
(1, 1, 'seni takip ediyor!'),
(2, 1, 'seni takip etmek istiyor!'),
(3, 1, 'takip isteğini onayladı!'),
(4, 2, 'bir fotoğraf paylaştı!'),
(5, 2, 'bir fotoğrafını beğendi!'),
(6, 2, 'bir fotoğrafına yorum yaptı!'),
(7, 2, 'yorumuna cevap verdi!');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `bildirim_turleri`
--

CREATE TABLE `bildirim_turleri` (
  `id` int(11) NOT NULL,
  `baslik` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `bildirim_turleri`
--

INSERT INTO `bildirim_turleri` (`id`, `baslik`) VALUES
(1, 'Takip'),
(2, 'Fotoğraf'),
(3, 'Mesaj');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `fotograflar`
--

CREATE TABLE `fotograflar` (
  `id` int(11) NOT NULL,
  `kullanici_id` int(11) DEFAULT NULL,
  `url` longtext COLLATE utf8_unicode_ci NOT NULL,
  `hash` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `icerik` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `fotograflar`
--

INSERT INTO `fotograflar` (`id`, `kullanici_id`, `url`, `hash`, `icerik`, `created_at`, `updated_at`) VALUES
(1, 1, 'http://localhost/angle/icons/custom-icon-envelope-large.png', 'hash1', 'İlk içeriğim oluyor.İlk içeriğim oluyor.İlk içeriğim oluyor.İlk içeriğim oluyor.', '2015-11-05 23:27:00', '2015-11-05 23:27:00'),
(2, 3, 'http://localhost/angle/icons/custom-icon-phone.png', 'hash2', 'İçerik 2', '2015-11-05 23:28:00', '2015-11-05 23:28:00'),
(3, 2, 'http://localhost/angle/icons/custom-icon-scissors.png', 'hash3', 'içerik 3', '2015-11-05 23:29:00', '2015-11-05 23:29:00'),
(4, 4, 'http://localhost/angle/icons/custom-icon-paper-clip.png', 'hash4', 'İçerik 4', '2015-11-05 23:31:00', '2015-11-05 23:31:00');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `konusmalar`
--

CREATE TABLE `konusmalar` (
  `id` int(11) NOT NULL,
  `konusmacilar` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:json_array)'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `konusmalar`
--

INSERT INTO `konusmalar` (`id`, `konusmacilar`) VALUES
(1, '["cagatay","cagatay"]'),
(2, '["cagatay","cagatay"]'),
(3, '["cagatay","cagatay"]');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE `kullanicilar` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  `last_activity_at` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `kullanicilar`
--

INSERT INTO `kullanicilar` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`, `last_activity_at`) VALUES
(1, 'cagatay', 'cagatay', 'cagataycali@kodpit.com', 'cagataycali@kodpit.com', 1, 'ixob6qend0oo8g4wg8wk8ww8884cc4k', '$2y$13$ixob6qend0oo8g4wg8wk8uNy2/qgw299Nq1gIdMmBbG8y6pZh2Bn6', '2015-11-12 18:54:45', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:10:"ROLE_ADMIN";}', 0, NULL, '2015-11-12 18:59:12'),
(2, 'fulya', 'fulya', 'fulya@demirko', 'fulya@demirko?l.com', 1, '810onkuqu4cg84gco0oo44gokko48o8', '$2y$13$810onkuqu4cg84gco0oo4uSIXNayJzPctW0BaXbpSLjecTP9uRpsO', NULL, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, NULL),
(3, 'emre', 'emre', 'emre@vural.com', 'emre@vural.com', 1, '1az2xpzu4yjo40sgw8o0wkcosoowk84', '$2y$13$1az2xpzu4yjo40sgw8o0wefhS3jVSm/rmMdJDRVXFsDookJ1aEw76', NULL, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, NULL),
(4, 'bugra', 'bugra', 'bugra@yuksel.com', 'bugra@yuksel.com', 1, 'p66uf7dr4mooo4w80gc04g8ww8o4wc8', '$2y$13$p66uf7dr4mooo4w80gc04eFpsq.NDyFHh8fqd1T/8xjr/y6tzgh6W', '2015-11-06 18:21:06', 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, '2015-11-06 18:21:43');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanici_cep`
--

CREATE TABLE `kullanici_cep` (
  `id` int(11) NOT NULL,
  `kullanici_id` int(11) DEFAULT NULL,
  `cep` varchar(35) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanici_konusma`
--

CREATE TABLE `kullanici_konusma` (
  `id` int(11) NOT NULL,
  `konusma_id` int(11) DEFAULT NULL,
  `kullanici_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `kullanici_konusma`
--

INSERT INTO `kullanici_konusma` (`id`, `konusma_id`, `kullanici_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanici_mesaj_gorulmeleri`
--

CREATE TABLE `kullanici_mesaj_gorulmeleri` (
  `id` int(11) NOT NULL,
  `mesaj_id` int(11) DEFAULT NULL,
  `kullanici_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `mesajlar`
--

CREATE TABLE `mesajlar` (
  `id` int(11) NOT NULL,
  `konusma_id` int(11) DEFAULT NULL,
  `yazan_id` int(11) DEFAULT NULL,
  `mesaj` longtext COLLATE utf8_unicode_ci NOT NULL,
  `silenler` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:json_array)',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `mesajlar`
--

INSERT INTO `mesajlar` (`id`, `konusma_id`, `yazan_id`, `mesaj`, `silenler`, `created_at`) VALUES
(1, 1, 1, 'Test mesajdır!', NULL, '2015-11-05 23:36:00'),
(2, 2, 1, 'Test mesajdır!', NULL, '2015-11-06 00:12:00'),
(3, 3, 1, 'Test mesajdır!', NULL, '2015-11-06 00:34:00');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `mesaj_gorulmeleri`
--

CREATE TABLE `mesaj_gorulmeleri` (
  `id` int(11) NOT NULL,
  `durum` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `kullanici_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `profil`
--

CREATE TABLE `profil` (
  `id` int(11) NOT NULL,
  `kullanici_id` int(11) DEFAULT NULL,
  `aciklama` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `web_adresi` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sistem_ayar`
--

CREATE TABLE `sistem_ayar` (
  `id` int(11) NOT NULL,
  `ana_sayfadaki_fotograf_sayisi` int(11) NOT NULL,
  `kaydirinca_gelecek_fotograf_sayisi` int(11) NOT NULL,
  `tema_renk` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `sistem_ayar`
--

INSERT INTO `sistem_ayar` (`id`, `ana_sayfadaki_fotograf_sayisi`, `kaydirinca_gelecek_fotograf_sayisi`, `tema_renk`) VALUES
(1, 5, 5, 'beige-black');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `takipler`
--

CREATE TABLE `takipler` (
  `id` int(11) NOT NULL,
  `takip_eden_id` int(11) DEFAULT NULL,
  `takip_edilen` int(11) DEFAULT NULL,
  `durum` smallint(6) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `takipler`
--

INSERT INTO `takipler` (`id`, `takip_eden_id`, `takip_edilen`, `durum`, `created_at`) VALUES
(7, 1, 4, 1, '2015-11-06 00:28:00'),
(8, 4, 1, 1, '2015-11-06 00:39:00');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yorumlar`
--

CREATE TABLE `yorumlar` (
  `id` int(11) NOT NULL,
  `kullanici_id` int(11) DEFAULT NULL,
  `fotograf_id` int(11) DEFAULT NULL,
  `yorum` varchar(140) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `durum` smallint(6) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `yorumlar`
--

INSERT INTO `yorumlar` (`id`, `kullanici_id`, `fotograf_id`, `yorum`, `created_at`, `updated_at`, `durum`) VALUES
(5, 1, 4, 'yorum2', '2015-11-06 00:31:00', '2015-11-06 00:31:00', 1),
(6, 4, 4, 'sağolasın canım', '2015-11-06 00:32:00', '2015-11-06 00:32:00', 1);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `anahtarlar`
--
ALTER TABLE `anahtarlar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_9BE1FE26350A9822` (`accessToken`),
  ADD UNIQUE KEY `UNIQ_9BE1FE26356306AF` (`kullanici_id`);

--
-- Tablo için indeksler `ayarlar`
--
ALTER TABLE `ayarlar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_7AC48A7E356306AF` (`kullanici_id`);

--
-- Tablo için indeksler `begeniler`
--
ALTER TABLE `begeniler`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9DDF33C2356306AF` (`kullanici_id`),
  ADD KEY `IDX_9DDF33C27C6AA605` (`fotograf_id`);

--
-- Tablo için indeksler `bildirimler`
--
ALTER TABLE `bildirimler`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_42DD4FF6356306AF` (`kullanici_id`),
  ADD KEY `IDX_42DD4FF69E2A5F8` (`sablon_id`),
  ADD KEY `IDX_42DD4FF6179F78FA` (`kim_id`),
  ADD KEY `IDX_42DD4FF67C6AA605` (`fotograf_id`);

--
-- Tablo için indeksler `bildirim_sablonlari`
--
ALTER TABLE `bildirim_sablonlari`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7C79BF3A4875F5FE` (`tur_id`);

--
-- Tablo için indeksler `bildirim_turleri`
--
ALTER TABLE `bildirim_turleri`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `fotograflar`
--
ALTER TABLE `fotograflar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_664AC295D1B862B8` (`hash`),
  ADD KEY `IDX_664AC295356306AF` (`kullanici_id`);

--
-- Tablo için indeksler `konusmalar`
--
ALTER TABLE `konusmalar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_2F43623F92FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_2F43623FA0D96FBF` (`email_canonical`);

--
-- Tablo için indeksler `kullanici_cep`
--
ALTER TABLE `kullanici_cep`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_D0D7F759FD5F42B5` (`cep`),
  ADD UNIQUE KEY `UNIQ_D0D7F759356306AF` (`kullanici_id`);

--
-- Tablo için indeksler `kullanici_konusma`
--
ALTER TABLE `kullanici_konusma`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C274FD0CC4E8D456` (`konusma_id`),
  ADD KEY `IDX_C274FD0C356306AF` (`kullanici_id`);

--
-- Tablo için indeksler `kullanici_mesaj_gorulmeleri`
--
ALTER TABLE `kullanici_mesaj_gorulmeleri`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_FF7B4A8D133D2396` (`mesaj_id`),
  ADD KEY `IDX_FF7B4A8D356306AF` (`kullanici_id`);

--
-- Tablo için indeksler `mesajlar`
--
ALTER TABLE `mesajlar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_91D4706C4E8D456` (`konusma_id`),
  ADD KEY `IDX_91D4706B7EEFECB` (`yazan_id`);

--
-- Tablo için indeksler `mesaj_gorulmeleri`
--
ALTER TABLE `mesaj_gorulmeleri`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4BDF1B8E356306AF` (`kullanici_id`);

--
-- Tablo için indeksler `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_E6D6B297356306AF` (`kullanici_id`);

--
-- Tablo için indeksler `sistem_ayar`
--
ALTER TABLE `sistem_ayar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `takipler`
--
ALTER TABLE `takipler`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_1A9BF0DDBDAC26AF` (`takip_eden_id`),
  ADD KEY `IDX_1A9BF0DDEC21E3BE` (`takip_edilen`);

--
-- Tablo için indeksler `yorumlar`
--
ALTER TABLE `yorumlar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9677FDC7356306AF` (`kullanici_id`),
  ADD KEY `IDX_9677FDC77C6AA605` (`fotograf_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `anahtarlar`
--
ALTER TABLE `anahtarlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `ayarlar`
--
ALTER TABLE `ayarlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Tablo için AUTO_INCREMENT değeri `begeniler`
--
ALTER TABLE `begeniler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- Tablo için AUTO_INCREMENT değeri `bildirimler`
--
ALTER TABLE `bildirimler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- Tablo için AUTO_INCREMENT değeri `bildirim_sablonlari`
--
ALTER TABLE `bildirim_sablonlari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- Tablo için AUTO_INCREMENT değeri `bildirim_turleri`
--
ALTER TABLE `bildirim_turleri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Tablo için AUTO_INCREMENT değeri `fotograflar`
--
ALTER TABLE `fotograflar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Tablo için AUTO_INCREMENT değeri `konusmalar`
--
ALTER TABLE `konusmalar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Tablo için AUTO_INCREMENT değeri `kullanici_cep`
--
ALTER TABLE `kullanici_cep`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `kullanici_konusma`
--
ALTER TABLE `kullanici_konusma`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Tablo için AUTO_INCREMENT değeri `kullanici_mesaj_gorulmeleri`
--
ALTER TABLE `kullanici_mesaj_gorulmeleri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `mesajlar`
--
ALTER TABLE `mesajlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Tablo için AUTO_INCREMENT değeri `mesaj_gorulmeleri`
--
ALTER TABLE `mesaj_gorulmeleri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `profil`
--
ALTER TABLE `profil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `sistem_ayar`
--
ALTER TABLE `sistem_ayar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Tablo için AUTO_INCREMENT değeri `takipler`
--
ALTER TABLE `takipler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- Tablo için AUTO_INCREMENT değeri `yorumlar`
--
ALTER TABLE `yorumlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `anahtarlar`
--
ALTER TABLE `anahtarlar`
  ADD CONSTRAINT `FK_9BE1FE26356306AF` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `ayarlar`
--
ALTER TABLE `ayarlar`
  ADD CONSTRAINT `FK_7AC48A7E356306AF` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `begeniler`
--
ALTER TABLE `begeniler`
  ADD CONSTRAINT `FK_9DDF33C2356306AF` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_9DDF33C27C6AA605` FOREIGN KEY (`fotograf_id`) REFERENCES `fotograflar` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `bildirimler`
--
ALTER TABLE `bildirimler`
  ADD CONSTRAINT `FK_42DD4FF6179F78FA` FOREIGN KEY (`kim_id`) REFERENCES `kullanicilar` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_42DD4FF6356306AF` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_42DD4FF67C6AA605` FOREIGN KEY (`fotograf_id`) REFERENCES `fotograflar` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_42DD4FF69E2A5F8` FOREIGN KEY (`sablon_id`) REFERENCES `bildirim_sablonlari` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `bildirim_sablonlari`
--
ALTER TABLE `bildirim_sablonlari`
  ADD CONSTRAINT `FK_7C79BF3A4875F5FE` FOREIGN KEY (`tur_id`) REFERENCES `bildirim_turleri` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `fotograflar`
--
ALTER TABLE `fotograflar`
  ADD CONSTRAINT `FK_664AC295356306AF` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `kullanici_cep`
--
ALTER TABLE `kullanici_cep`
  ADD CONSTRAINT `FK_D0D7F759356306AF` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `kullanici_konusma`
--
ALTER TABLE `kullanici_konusma`
  ADD CONSTRAINT `FK_C274FD0C356306AF` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_C274FD0CC4E8D456` FOREIGN KEY (`konusma_id`) REFERENCES `konusmalar` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `kullanici_mesaj_gorulmeleri`
--
ALTER TABLE `kullanici_mesaj_gorulmeleri`
  ADD CONSTRAINT `FK_FF7B4A8D133D2396` FOREIGN KEY (`mesaj_id`) REFERENCES `mesajlar` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_FF7B4A8D356306AF` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `mesajlar`
--
ALTER TABLE `mesajlar`
  ADD CONSTRAINT `FK_91D4706B7EEFECB` FOREIGN KEY (`yazan_id`) REFERENCES `kullanicilar` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_91D4706C4E8D456` FOREIGN KEY (`konusma_id`) REFERENCES `konusmalar` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `profil`
--
ALTER TABLE `profil`
  ADD CONSTRAINT `FK_E6D6B297356306AF` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `takipler`
--
ALTER TABLE `takipler`
  ADD CONSTRAINT `FK_1A9BF0DDBDAC26AF` FOREIGN KEY (`takip_eden_id`) REFERENCES `kullanicilar` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_1A9BF0DDEC21E3BE` FOREIGN KEY (`takip_edilen`) REFERENCES `kullanicilar` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `yorumlar`
--
ALTER TABLE `yorumlar`
  ADD CONSTRAINT `FK_9677FDC7356306AF` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_9677FDC77C6AA605` FOREIGN KEY (`fotograf_id`) REFERENCES `fotograflar` (`id`) ON DELETE CASCADE;
