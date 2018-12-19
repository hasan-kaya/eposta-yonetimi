<?php

class Eposta_Yonetimi_Admin
{

    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version)
    {
        $this->plugin_name=$plugin_name;
        $this->version=$version;
        $this->yandex_mail_token = get_option('yandex_mail_token');
        $this->domain=$this->get_domain_name();

        add_action('admin_menu', array($this, 'admin_sayfa_ekle'));
        add_action('admin_init', array($this, 'register_setting'));
        add_action('wp_ajax_eposta_yonetimi_ajax', array($this, 'eposta_yonetimi_ajax'));
    }

    public function enqueue_styles()
    {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__).'css/eposta-yonetimi-admin.css', array(), $this->version, 'all');
        wp_register_style('wce_bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
        wp_enqueue_style('wce_bootstrap');
    }

    public function enqueue_scripts()
    {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__).'js/eposta-yonetimi-admin.js', array('jquery'), $this->version, false);
        wp_localize_script(
            $this->plugin_name,
            'eposta_yonetimi',
            array(
                'ajax_url' => admin_url('admin-ajax.php')
            )
        );
    }

    function load_admin_partial($template, $data=array())
    {
        $dir=trailingslashit(WCE_PATH.'admin/partials');
        if(file_exists($dir.$template.'.php')){
            require_once($dir.$template.'.php');
            return true;
        }
        return false;
    }

    function register_setting()
    {
        add_settings_section("eposta_ayarlari_bolumu", "E-Posta Ayarları", "", "eposta-ayarlari");
        add_settings_field("yandex_mail_token", "Yandex Mail Token", array($this, 'eposta_ayarlari_input_cb'), "eposta-ayarlari", "eposta_ayarlari_bolumu", array('name'=>'yandex_mail_token'));
        register_setting("eposta_ayarlari_bolumu", "yandex_mail_token");
    }

    function YandexPost($Type, $Post)
    {
        $curl=curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://pddimp.yandex.ru/api2/admin/email/".$Type);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $Post);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('PddToken: '.$this->yandex_mail_token));
        $server_output=curl_exec($curl);
        curl_close($curl);
        return json_decode($server_output);
    }

    function eposta_ayarlari_input_cb($args)
    {
        include plugin_dir_path(dirname(__FILE__)).'admin/partials/input.php';
    }

    function YandexMailOku()
    {
        //if(!file_exists(WCE_PATH.'admin/yandex.json')){
        $this->YandexMailCek();
        //}
        $mailler_json=file_get_contents(WCE_PATH.'admin/yandex.json');
        return json_decode($mailler_json);
    }

    function get_domain_name()
    {
        $domain=get_option('siteurl'); //or home
        $domain=str_replace('http://', '', $domain);
        $domain=str_replace('www.', '', $domain); //add the . after the www if you don't want it
        return $domain;
    }

    function objectsIntoArray($arrObjData, $arrSkipIndices=array())
    {
        $arrData=array();
        if(is_object($arrObjData)){
            $arrObjData=get_object_vars($arrObjData);
        }
        if(is_array($arrObjData)){
            foreach($arrObjData as $index=>$value){
                if(is_object($value) || is_array($value)){
                    $value=$this->objectsIntoArray($value, $arrSkipIndices); // recursive call
                }
                if(in_array($index, $arrSkipIndices)){
                    continue;
                }
                $arrData[$index]=$value;
            }
        }
        return $arrData;
    }

    function DosyayaKaydet($filename, $content)
    {
        $Hata="";
        if($filename){
            if(@fopen($filename, "w")){
                $f=fopen($filename, "w");
                $Hata.="Dosya Açıldı\n";
            }else{
                $Hata.="Dosya Açılamadı\n";
            }
            if(@fputs($f, "$content")){
                $Hata.="İçerik Eklendi\n";
            }else{
                $Hata.="İçerik Eklenemedi\n";
            }
            @fclose($f);
        }else{
            $Hata.=" Dosya Adı Gelmedi\n";
        }
        return $Hata;
    }

    function YandexMailCek()
    {
        if(!$this->yandex_mail_token){
            return;
        }

        $opts=array(
            'http'=>array(
                'method'=>"GET",
                'header'=>"PddToken: ".$this->yandex_mail_token
            )
        );
        $context=stream_context_create($opts);
        $limit=30;

        $sayfa=1;
        $listelenen_mail_sayisi=0;
        $toplam_mail=0;

        do{
            $file=file_get_contents('https://pddimp.yandex.ru/api2/admin/email/list?domain='.$this->domain.'&page='.$sayfa.'&on_page='.$limit, false, $context);
            $veriler=json_decode($file);
            $toplam_mail=$veriler->total;
            $listelenen_mail_sayisi+=$limit;
            $sayfa++;
            foreach($veriler->accounts as $mailler){
                $mail[$mailler->uid]=$mailler;
            }
        }
        while($toplam_mail > $listelenen_mail_sayisi);

        $this->DosyayaKaydet(WCE_PATH.'admin/yandex.json', json_encode($mail));
    }

    function admin_sayfa_ekle()
    {
        add_menu_page('E-Popta Yönetimi', 'E-Posta Yönetimi', 'manage_options', 'eposta-yonetimi', array($this, 'eposta_yonetimi_sayfasi'));
        add_submenu_page('eposta-yonetimi', 'Yeni E-Posta Oluştur', 'Yeni E-Posta Oluştur', 'manage_options', 'eposta-olustur', array($this, 'eposta_olustur_sayfasi'));
        add_submenu_page('eposta-yonetimi', 'Ayarlar', 'Ayarlar', 'manage_options', 'eposta-ayarlari', array($this, 'eposta_ayarlari_sayfasi'));
        add_submenu_page('null', 'E-Posta Düzenle', 'E-Posta Düzenle', 'manage_options', 'eposta-duzenle', array($this, 'eposta_duzenle_sayfasi'));
    }

    function eposta_yonetimi_sayfasi()
    {
        $mailler=$this->YandexMailOku();

        $this->load_admin_partial('eposta-yonetimi', array(
            'mailler'=>$mailler,
            'token'=>get_option('yandex_mail_token')
        ));
        $this->load_admin_partial('eposta-yonetimi');
    }

    function eposta_olustur_sayfasi()
    {
        $this->load_admin_partial('eposta-olustur');
    }

    function eposta_ayarlari_sayfasi()
    {
        $this->load_admin_partial('eposta-ayarlari');
    }

    function eposta_duzenle_sayfasi()
    {
        $mailler=$this->YandexMailOku();
        $data = $this->objectsIntoArray($mailler->$_GET['uid']);
        if($data['sex'] == 1){
            $data['cinsiyet_erkek'] = 'selected';
        }elseif($PopupInner['sex'] == 2){
            $data['cinsiyet_kadin'] = 'selected';
        }
        $this->load_admin_partial('eposta-duzenle',$data);
    }

    function eposta_yonetimi_ajax(){
        parse_str($_POST['data'], $K);

        if( $K['islem'] == 2 ){ //yeni mail işlem
            if(!$K['KullaniciAdi'] or !$K['Sifre']){
                echo json_encode(array('success' => false, 'result' => 'Bilgilerde Eksilik Var.'));
            }else{
                $Post = "domain=".$this->domain."&login=".$K['KullaniciAdi']."&password=".$K['Sifre'];
                $sonuc = $this->YandexPost("add",$Post);
                if($sonuc->success == 'error'){
                    echo json_encode(array('success' => false, 'result' => $sonuc->error));
                }else{
                    echo json_encode(array('success' => true));
                }
            }
        }elseif( $K['islem'] == 4 ){ //mail düzenle işlem
            unset($K['islem']);
            $Post = 'domain='.$this->domain;
            foreach($K as $key => $value) {
                if($value){
                    $Post .= '&'.$key.'='.$value;
                }
            }
            $sonuc = $this->YandexPost('edit',$Post);
            if($sonuc->success == 'error'){
                echo json_encode(array('success' => false, 'result' => $sonuc->error));
            }else{
                echo json_encode(array('success' => true));
            }
        }

        die;
    }
}
