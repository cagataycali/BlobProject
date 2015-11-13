/**
 * Variables
 */
var body = $('body');
var attach = $('#attach');
var search = $('#search');
var content=$('#content');
var resimalani=$('#resimalani');
var search_div = $("search");
var like =$('.like');
var heart_like = $('.heart_like');

/**
 * Attach
 **/
$(document).on('click','.attach', function () {

    attach.slideDown("slow");

    search.slideUp("slow");
    resimalani.slideUp("slow");

    $('html, body').animate({scrollTop: 0}, 300);

});
// Attach end

$(document).on('click','.search', function () {

    search.slideDown("slow");

    attach.slideUp("slow");
    resimalani.slideUp("slow");

    $('html, body').animate({scrollTop: 0}, 1000);

});
// Attach end
/**
 * Resim Yükle Ekranı
 **/
//$(document).on('click','#bulutfa',function (){
//
//    search.slideUp("fast");
//    attach.slideUp("fast");
//    resimalani.slideToggle("fast");
//
//
//});

/**
 * Attach slide
 */
body.on('DOMMouseScroll', function(e){
    if(e.originalEvent.detail > 0) {

        /**
         * Down slide
         */
        attach.slideUp("fast");
        search.slideUp("fast");
        //resimalani.slideUp("fast");
    }
});

//IE, Opera, Safari
body.on('mousewheel', function(e){
    if(e.originalEvent.wheelDelta < 0) {

        /**
         * Down slide
         */
        search.slideUp("fast");
        attach.slideUp("fast");
        //resimalani.slideUp("fast");

    }
});
// Attach slide end

$(document).on('click','.like',function ( ){

    /**
     * İd değerimiz.
     * @type {*|jQuery}
     */
    var id = $(this).attr('id');

    /**
     * Sonradan hash değerini değiştireceğimiz nesne.
     * @type {*|jQuery|HTMLElement}
     */
    var nesne = $(this);


    $.ajax({
        url: Routing.generate('fotograf_begen'),
        data: "id="+id,
        type: 'post',
        dataType: 'json',
        success: function(yanit)
        {
            /**
             * Beğeni butonunu yakalayalım.
             * @type {*|jQuery|HTMLElement}
             */

            nesne.attr('class',yanit.icerik);

            $('.heart_like_'+yanit.hash_degeri).html(yanit.begeni_sayisi);
        }
    });

});

/**
 * Yorumla
 */
$(document).on('click','.yorum',function (){

    /**
     * İd değerimiz.
     * @type {*|jQuery}
     */
    var id = $(this).attr('id');

    /**
     * Sonradan hash değerini değiştireceğimiz nesne.
     * @type {*|jQuery|HTMLElement}
     */
    var form = $('#form_'+id);

    form.parsley();

    form.parsley().validate();

    if( form.parsley().isValid() )
    {

    $.ajax({
        url: Routing.generate('yorum_yap'),
        data: form.serialize(),
        type: 'post',
        dataType: 'json',
        success: function(yanit)
        {
            $('#comment_box_'+id).prepend(yanit);

            $('.yorum_field').val(" ");

            $('.dutluk').slideDown("slow");

            form.parsley().reset();
        }
    });

    }
});

/**
 * Kullanıcı arama yapması
 */
$(document).on('keyup','.kullanici-ara',function()
{
    var icerik = $(this).val();
    //alert(icerik);

    $.ajax({
        url: Routing.generate('arama'),
        data: 'icerik='+icerik,
        type: 'post',
        dataType: 'json',
        success: function(yanit)
        {
            if(yanit.durum != 200)
            {

            }
            else
            {
                $('#arama_sonuclari').slideDown("slow").html(yanit.icerik);
            }
        }
    });
});

$(document).on('click','.takip',function()
{
    var button = $(this);

    $.ajax({
        url: Routing.generate('takip'),
        data: 'kullanici='+button.attr('id'),
        type: 'post',
        dataType: 'json',
        success: function(yanit)
        {

                button.attr('class',yanit.class_degeri);
                button.html(yanit.icerik);

                if(yanit.trigger_degeri == 1)
                {
                    $.ajax({
                        url: Routing.generate('fotograflarim'),
                        data: 'kullanici='+button.attr('id'),
                        type: 'post',
                        dataType: 'json',
                        success: function(yanit)
                        {
                            $('.fotograflar').slideDown("slow").html(yanit);
                        }
                    });

                }
                else
                {
                    $('.fotograflar').html('<h2 class="text-center">Kullanıcıyı takip etmediğiniz için fotoğraflarını görüntüleyemezsiniz.</h2>');
                }

        }
    });
});



$(document).on('click','.sil',function()
{
    var hash = $(this).attr('id');

    $.ajax({
        url: Routing.generate('fotograf_sil'),
        data: 'hash='+hash,
        type: 'post',
        dataType: 'json',
        success: function(yanit)
        {
           $('#fotograf_'+hash).hide("slow");
        }
    });
});

// todo : jquery sürümleri çakışıyor olabilir.
//
//$().cropper('getCroppedCanvas').toBlob(function (blob) {
//    var formData = new FormData();
//
//    formData.append('croppedImage', blob);
//
//    $.ajax('upload.php', {
//        method: "POST",
//        data: formData,
//        processData: false,
//        contentType: false,
//        success: function () {
//            console.log('Upload success');
//        },
//        error: function () {
//            console.log('Upload error');
//        }
//    });
//});
//
//
//$().cropper('getCroppedCanvas').toBlob(function (blob) {
//    var formData = new FormData();
//
//    formData.append('croppedImage', blob);
//
//    $.ajax({
//        url: Routing.generate('foto-crop-yukle'),
//        method: "POST",
//        data: formData,
//        processData: false,
//        contentType: false,
//        success: function () {
//            console.log('Upload success');
//        },
//        error: function () {
//            console.log('Upload error');
//        }
//    });
//
//});

$(document).on('click','.yorum_sil',function()
{
    var hash = $(this).attr('id');

    $.ajax({
        url: Routing.generate('yorum_sil'),
        data: 'id='+hash,
        type: 'post',
        dataType: 'json',
        success: function(yanit)
        {
            $('#yorum_div_'+yanit).hide("slow");
        }
    });
});

$(document).on('click','.tumunu_gor',function()
{
        var hash = "tumunu_gor";

        $.ajax({
            url: Routing.generate('tumunu_gor'),
            data: 'id='+hash,
            type: 'post',
            dataType: 'json',
            success: function(yanit)
            {
                $('.tum_bildirimler').slideUp("slow");
            }
        });
});


$(document).on('click','.closer',function()
{

    var bildirim = $(this).attr('id');

    $.ajax({
        url: Routing.generate('bildirim_goruldu'),
        data: 'bildirim='+bildirim,
        type: 'post',
        dataType: 'json',
        success: function(yanit)
        {
           $('#fotograf_'+hash).hide("slow");
        }
    });
});


/**
 * Takip onayı
 */
$(document).on('change',':checkbox',function(){

    var buton = $(this);

    var id_degeri = buton.val();
    var kullanici = buton.attr('name');

    $.ajax({
        url: Routing.generate('takip_onay'),
        data: 'kullanici='+kullanici+'&bildirim='+id_degeri,
        type: 'post',
        dataType: 'json',
        success: function(yanit)
        {
            $('#li_'+id_degeri).slideUp("slow");
        }
    });
});
