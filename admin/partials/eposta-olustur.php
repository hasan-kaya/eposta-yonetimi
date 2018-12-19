<h4><?php echo esc_html(get_admin_page_title()); ?></h4>
<form id="frmYandexMailAc" name="frmYandexMailAc" method="post" action="javascript:void(null);">
    <input type="hidden" name="islem" value="2">
    <div class="form-group">
        <label>Kullanıcı Adı:</label> <input type="text" name="KullaniciAdi" class="form-control">
        <small class="form-text text-muted">Sadece eposta kullanıcı adı, sonuna @siteadi.com yazmayınız.</small>
    </div>
    <div class="form-group">
        <label>Şifre:</label> <input type="text" name="Sifre" class="form-control">
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-success" value="Oluştur" style="width:100%;" id="eposta_olustur_btn">
    </div>
    <div class="form-group" id="result">
    </div>
</form>