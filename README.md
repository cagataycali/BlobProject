**Blob**

***Kurulum***

 - Composer kurulumu
	 - Composer kurduktan sonra;
		 -  php composer.phar update 
 [Makale için tıkla](http://cagataycali.com/composer-kurulumu/)
 
 
 - Parameters.yml eklenmesi
	 - app/config/ içerisine parameters.yml adlı bir dosya oluşturun.
	 - Parameters.yml.dist dosyasından kopyalayabilirsiniz.
 
 - Veritabanını güncelleyin!
	 - `php app/console do:da:cr` => Veritabanını açtınız.
	 - `php app/console do:sc:up --force` => Tabloları yüklediniz
	 - `php app/console fos:user:create` => Birde kullanıcı açarsanız tadından yenmez :)


Kodlarla oynayın, pull requestlerinizi bekliyorum.