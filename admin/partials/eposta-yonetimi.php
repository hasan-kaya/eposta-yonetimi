<? if(!$data['token']){ ?>
    <div class="row">
        <div class="col-md-4">
            <div class="alert alert-danger" style="margin-top:2em;">
                Lütfen <strong>E-Posta Ayarları</strong> bölümünden <strong>Yandex Mail Token</strong> bölümünü doldurunuz.<br>
                <a href="https://pddimp.yandex.ru/api2/admin/get_token" target="_blank">Token almak için tıklayın.</a>
            </div>
        </div>
    </div>
<? }else{ ?>
    <div class="row" style="margin:20px 0;">
        <div class="col-md-offset-4 col-md-3 text-center">
            <h4>Mail Yönetimi</h4>
        </div>
        <div class="col-md-2 pull-right">
            <a href="admin.php?page=eposta-olustur" class="btn btn-success" style="width:100%;">Yeni E-Posta Aç</a>
        </div>
        <div class="col-md-2 pull-right">
            <a href="http://webcozumevi.com.tr/yandex/index.html" target="_blank" class="btn btn-info" style="width:100%;">Kurulum Yönergeleri</a>
        </div>
    </div>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">E-Posta</th>
            <th scope="col">İsim</th>
            <th scope="col">Durum</th>
            <th scope="col">İşlemler</th>
        </tr>
        </thead>
        <tbody>
        <?
        foreach($data['mailler'] as $mail){
            $i++;
            ?>
            <tr>
                <th scope="row"><?=$i?></th>
                <td><?=$mail->login;?></td>
                <td><?=$mail->iname.' '.$mail->fname;?></td>
                <td>
                    <? if($mail->ready == 'yes'){ ?>
                        <i class="fa fa-check"></i> Kurulum Başarılı
                    <? }else{ ?>
                        <i class="fa fa-times"></i> <a href="http://webcozumevi.com.tr/yandex/index.html" target="_blank">Kurulum Yapmak İçin Tıklayın</a>
                    <? } ?>
                </td>
                <td>
                    <a class="btn btn-warning" href="admin.php?page=eposta-duzenle&islem=3&uid=<?=$mail->uid?>&login=<?=$mail->login?>">Düzenle</a>
                </td>
            </tr>
        <? } ?>
        </tbody>
    </table>
<? } ?>