<?php
if( ! defined('WP_UNINSTALL_PLUGIN') )
    exit;
global $wpdb;
$wpdb->query("DROP TABLE ".$wpdb->prefix."acud_thank_names ;");
delete_option('Acud_mrh_login');//индетификатор магазина
delete_option('Acud_mrh_pass1');//пароль #1
delete_option('Acud_mrh_pass2');//пароль #2
delete_option('Acud_mrh_pass1_test');// тестовый пароль #1
delete_option('Acud_mrh_pass2_test');// тестовый пароль #2
delete_option('Acud_logo_after_post');// лого после поста
delete_option('Acud_logo_after_post_select');// и его местоположение
delete_option('Acud_logo_befor_post');// лого перед постос
delete_option('Acud_logo_befor_post_select');// и его местоположение
delete_option('Acud_text_logo');//ID картинки лого
delete_option('AcuD_popUp_main_text');// теск в popUP над товарами
delete_option('AcuD_popUp_text_level_1');// текст в popUP под товарами
delete_option('AcuD_popUp_text_level_2');// текст в popUP под товарами
delete_option('AcuD_popUp_text_level_3');// текст в popUP под товарами
delete_option('AcuD_popUp_img_level_1');// текст в popUP под товарами
delete_option('AcuD_popUp_img_level_2');// текст в popUP под товарами
delete_option('AcuD_popUp_img_level_3');// текст в popUP под товарами
delete_option('Acud_is_rules');// показ сылки на правила использования
delete_option('Acud_is_gratitude');// показ благодарности
delete_option('Acud_is_gratitude_OnRules');// показ благодарности на странице правил
delete_option('Acud_is_gratitude_OnThanks');// показ благодарности на странице Спасибо
delete_option('AcuD_logo_imgID');
delete_option('Acud_rules_page');
delete_option('Acud_thanks_page');
delete_option('Acud_logo_size');
delete_option('Acud_mrh_isTest');
?>