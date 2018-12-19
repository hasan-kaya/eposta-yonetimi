<div class="wrap">
    <?php flush_rewrite_rules(); ?>
    <form method="post" action="options.php">
        <?php
        settings_fields("eposta_ayarlari_bolumu");
        do_settings_sections("eposta-ayarlari");
        submit_button();
        ?>
    </form>
</div>