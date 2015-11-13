-- phpMyAdmin SQL Dump
-- version 4.4.9
-- http://www.phpmyadmin.net
--
-- Anamakine: localhost:8889
-- Üretim Zamanı: 17 Eki 2015, 17:12:03
-- Sunucu sürümü: 5.5.42
-- PHP Sürümü: 5.5.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Veritabanı: `blob`
--

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
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `begeniler`
--

INSERT INTO `begeniler` (`id`, `kullanici_id`, `fotograf_id`, `created_at`, `updated_at`) VALUES
(50, 1, 1, '2015-10-16 21:36:00', '2015-10-16 21:36:00'),
(56, 1, 5, '2015-10-17 03:32:00', '2015-10-17 03:32:00'),
(57, 1, 3, '2015-10-17 17:11:00', '2015-10-17 17:11:00');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `bildirimler`
--

CREATE TABLE `bildirimler` (
  `id` int(11) NOT NULL,
  `kullanici_id` int(11) DEFAULT NULL,
  `durum` smallint(6) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `fotograflar`
--

CREATE TABLE `fotograflar` (
  `id` int(11) NOT NULL,
  `kullanici_id` int(11) DEFAULT NULL,
  `url` longtext COLLATE utf8_unicode_ci NOT NULL,
  `icerik` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `hash` longtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `fotograflar`
--

INSERT INTO `fotograflar` (`id`, `kullanici_id`, `url`, `icerik`, `created_at`, `updated_at`, `hash`) VALUES
(1, 3, 'http://localhost/angle/icons/custom-icon-apple.png', 'Apple candır gerisi heyecandır..', '2015-10-15 00:00:00', '0000-00-00 00:00:00', 'cagatay'),
(2, 2, 'http://localhost/angle/icons/custom-icon-apple.png', 'Apple candır gerisi heyecandır..', '2015-10-15 00:00:00', '0000-00-00 00:00:00', 'cali'),
(3, 2, 'http://localhost/angle/icons/custom-icon-briefcase-closed.png', 'Sepetimi aldım gidiyorum!', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '123'),
(4, 2, 'http://localhost/angle/icons/custom-icon-briefcase-closed.png', 'Sepetimi aldım gidiyorum!', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '123'),
(5, 2, 'http://localhost/angle/icons/custom-icon-briefcase-closed.png', 'appleeee', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '12312'),
(6, 2, 'http://localhost/angle/icons/custom-icon-briefcase-closed.png', '12312', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '123124');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `kullanicilar`
--

INSERT INTO `kullanicilar` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`, `last_activity_at`) VALUES
(1, 'cagatay', 'cagatay', 'cagatay@cali.com', 'cagatay@cali.com', 1, '8ojnufcz0j8csokgk84skowgkckskwc', '$2y$13$8ojnufcz0j8csokgk84skeKqbdLf8ffyBHXiL1DBGtcIQkyq0UCoO', '2015-10-17 17:11:34', 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, '2015-10-17 17:11:34'),
(2, 'test', 'test', 'test@test.com', 'test@test.com', 1, '5q1qz2lqb2o80goo4cgg04wokgccwws', '$2y$13$5q1qz2lqb2o80goo4cgg0uldXhrgp2BUeluT1bxO/hR82W8ezycVq', NULL, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, NULL),
(3, 'emre', 'emre', 'emre@vural.com', 'emre@vural.com', 1, 'dl4di4hkvsowogwoc8kswg4ogwo4cgk', '$2y$13$dl4di4hkvsowogwoc8ksweHZpp0Bu1Bj9lmyqDthBHbuAVqgPqjuy', NULL, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanici_fotograflari`
--

CREATE TABLE `kullanici_fotograflari` (
  `id` int(11) NOT NULL,
  `kullanici_id` int(11) DEFAULT NULL,
  `fotograf_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `kullanici_fotograflari`
--

INSERT INTO `kullanici_fotograflari` (`id`, `kullanici_id`, `fotograf_id`, `created_at`) VALUES
(1, 1, 1, '0000-00-00 00:00:00'),
(2, 1, 2, '2015-10-16 00:00:00'),
(4, 1, 3, '0000-00-00 00:00:00'),
(5, 1, 4, '0000-00-00 00:00:00'),
(6, 1, 5, '0000-00-00 00:00:00'),
(7, 1, 6, '0000-00-00 00:00:00');

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
(1, 1, 2, 'white-red');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `takipler`
--

INSERT INTO `takipler` (`id`, `takip_eden_id`, `takip_edilen`, `durum`, `created_at`) VALUES
(1, 1, 3, 1, '2015-10-15 00:00:00'),
(2, 1, 2, 1, '2015-10-15 00:00:00');

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `yorumlar`
--

INSERT INTO `yorumlar` (`id`, `kullanici_id`, `fotograf_id`, `yorum`, `created_at`, `updated_at`, `durum`) VALUES
(1, 1, 1, 'Elma iyidir..', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
(2, 1, 2, 'Elma iyidir..', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
(3, 1, 4, 'Elma iyidir..', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
(4, 1, 5, 'Elma iyidir..', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
(5, 1, 6, 'Elma iyidir..', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1);

--
-- Dökümü yapılmış tablolar için indeksler
--

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
  ADD KEY `IDX_42DD4FF6356306AF` (`kullanici_id`);

--
-- Tablo için indeksler `fotograflar`
--
ALTER TABLE `fotograflar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_664AC295356306AF` (`kullanici_id`);

--
-- Tablo için indeksler `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_2F43623F92FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_2F43623FA0D96FBF` (`email_canonical`);

--
-- Tablo için indeksler `kullanici_fotograflari`
--
ALTER TABLE `kullanici_fotograflari`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_24B00339356306AF` (`kullanici_id`),
  ADD KEY `IDX_24B003397C6AA605` (`fotograf_id`);

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
-- Tablo için AUTO_INCREMENT değeri `begeniler`
--
ALTER TABLE `begeniler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=58;
--
-- Tablo için AUTO_INCREMENT değeri `bildirimler`
--
ALTER TABLE `bildirimler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `fotograflar`
--
ALTER TABLE `fotograflar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Tablo için AUTO_INCREMENT değeri `kullanici_fotograflari`
--
ALTER TABLE `kullanici_fotograflari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- Tablo için AUTO_INCREMENT değeri `sistem_ayar`
--
ALTER TABLE `sistem_ayar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Tablo için AUTO_INCREMENT değeri `takipler`
--
ALTER TABLE `takipler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Tablo için AUTO_INCREMENT değeri `yorumlar`
--
ALTER TABLE `yorumlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

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
  ADD CONSTRAINT `FK_42DD4FF6356306AF` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `fotograflar`
--
ALTER TABLE `fotograflar`
  ADD CONSTRAINT `FK_664AC295356306AF` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `kullanici_fotograflari`
--
ALTER TABLE `kullanici_fotograflari`
  ADD CONSTRAINT `FK_24B00339356306AF` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_24B003397C6AA605` FOREIGN KEY (`fotograf_id`) REFERENCES `fotograflar` (`id`) ON DELETE CASCADE;

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
