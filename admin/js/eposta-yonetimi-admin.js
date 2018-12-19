jQuery(document).ready(function ($) {

    $("body").on('click', '#eposta_duzenle_btn', function () {
        var form = $(this).parents('form:first');
        var data = {
            action: 'eposta_yonetimi_ajax',
            data: form.serialize(),
        };
        form.find('#result').html('<div class="alert alert-info">İşlem Yapılıyor...</div>');
        $.post(eposta_yonetimi.ajax_url, data, function (response) {
            if (response) {
                response = JSON.parse(response);
                if (response['success'] == true) {
                    form.find('#result').html('<div class="alert alert-success">Düzenlendi.</div>');
                } else {
                    form.find('#result').html('<div class="alert alert-warning">' + response['result'] + '</div>');
                }
            }
        });
    });

    $("body").on('click', '#eposta_olustur_btn', function () {
        var form = $(this).parents('form:first');
        var data = {
            action: 'eposta_yonetimi_ajax',
            data: form.serialize(),
        };
        form.find('#result').html('<div class="alert alert-info">İşlem Yapılıyor...</div>');
        $.post(eposta_yonetimi.ajax_url, data, function (response) {
            if (response) {
                response = JSON.parse(response);
                if (response['success'] == true) {
                    form.find('#result').html('<div class="alert alert-success">Oluşturuldu.</div>');
                    setTimeout(function () {
                        window.location.href = 'admin.php?page=eposta-yonetimi';
                    }, 500);
                } else {
                    form.find('#result').html('<div class="alert alert-warning">' + response['result'] + '</div>');
                }
            }
        });
    });


});