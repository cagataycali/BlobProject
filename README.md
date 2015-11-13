**Blob**

***Kurulum***

 - ADIM 1 ( Composer kurulumu )
	 - Composer kurduktan sonra;
		 -  php composer.phar update 
 [Makale için tıkla](http://cagataycali.com/composer-kurulumu/)
 
 
 - ADIM 2 ( Parameters.yml eklenmesi ) 
	 - app/config/ içerisine parameters.yml adlı bir dosya oluşturun.
	 - Parameters.yml.dist dosyasından kopyalayabilirsiniz.
 
 - ADIM 3 ( Veritabanını güncelleyin! )  & ( Sql 'i içeri aktarın )
	 - `php app/console do:da:cr` => Veritabanını açtınız.
	 - `php app/console do:sc:up --force` => Tabloları yüklediniz
	 - `php app/console fos:user:create` => Birde kullanıcı açarsanız tadından yenmez :)
	 
	 &
	 
	 - sorgular.sql 'i içe aktarın


Kodlarla oynayın, pull requestlerinizi bekliyorum.

http://localhost/BlobProject/web/app_dev.php

![Ekran görüntüsü](http://s16.postimg.org/tvi4iqaut/Ekran_Resmi_2015_11_13_23_32_25.png)


#Dipnot : 

x Dakika önce.. yazısının türkçeleştirilmesi composer ile gidip gelirken arada kayboluyor,ingilizce olarak görülmesi bilinen issuedir.