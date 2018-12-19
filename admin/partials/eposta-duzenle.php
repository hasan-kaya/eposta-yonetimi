<h4><?php echo esc_html(get_admin_page_title()); ?></h4>
<form id="frmYandexMailAc" name="frmYandexMailAc" method="post" action="javascript:void(null);">
    <input type="hidden" name="islem" value="4">
    <input type="hidden" name="enabled" value="yes">
    <input type="hidden" name="ready" value="yes">
    <input type="hidden" name="login" value="<?=$data['login']?>">
    <div class="form-group">
        <label>Yeni Şifre:</label>
        <input type="text" name="password" class="form-control">
        <small class="form-text text-muted">Boş bırakırsanız eski şifreniz geçerli kalır.</small>
    </div>
    <div class="form-group">
        <label>İsim:</label> <input type="text" name="iname" value="<?=$data['iname']?>" class="form-control">
    </div>
    <div class="form-group">
        <label>Soyisim:</label> <input type="text" name="fname" value="<?=$data['fname']?>" class="form-control">
    </div>
    <div class="form-group">
        <label>Doğum Tarihi:</label> <input type="text" name="birth_date" class="form-control" value="<?=$data['birth_date']?>">
        <small class="form-text text-muted">YYYY-AA-GG formatında olmalı.</small>
    </div>
    <div class="form-group">
        <label>Cinsiyet:</label> <select name="sex" class="form-control" chosen="1">
            <option value="">Seçiniz</option>
            <option value="1" <?=$data['cinsiyet_erkek']?>>Erkek</option>
            <option value="2" <?=$data['cinsiyet_kadin']?>>Kadın</option>
        </select>
    </div>
    <div class="form-group">
        <label>Gizli Soru:</label> <input type="text" name="hintq" value="<?=$data['hintq']?>" class="form-control">
    </div>
    <div class="form-group">
        <label>Gizli Soru Cevabı:</label> <input type="text" name="hinta" class="form-control">
        <small class="form-text text-muted">Boş bırakırsanız eski gizli cevabınız geçerli kalır.</small>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-success" value="Düzenle" style="width:100%;" id="eposta_duzenle_btn">
    </div>
    <div class="form-group" id="result">
    </div>
</form>