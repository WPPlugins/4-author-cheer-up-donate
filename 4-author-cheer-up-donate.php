<?php
/*
Plugin Name: 4-author-cheer-up-donate
Plugin URI: https://socpravo.ru
Version: 1.3
Description: The 4-author-cheer-up-donate is plugin to collect donations for the author in the form of a conditional payment for coffee, beer or other goods.
Author: sciffuld and kenny5660
Author URI: https://socpravo.ru/
License: GPL2
Text Domain: AcuD_transl
Domain Path: /languages

*/
/*  Copyright 2016  sciffuld and kenny5660  (email: socpravo.ru@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
defined('ABSPATH') or die('No script kiddies please!');

function AcuD_logo_content_short($atts){
	ob_start();
    include(__DIR__ .'/logo_content.php');
    $outputs = ob_get_contents();
    ob_end_clean();
    return $outputs;
}
add_shortcode('AcuD_donate', 'AcuD_logo_content_short');

function AcuD_thank_you_content(){
	ob_start();
    include(__DIR__ .'/thank_you_content.php');
    $outputs = ob_get_contents();
    ob_end_clean();
    return $outputs;  
}
add_shortcode('AcuD_thank_you', 'AcuD_thank_you_content');


add_action('admin_menu','AcuD_register_options',104.562);
function AcuD_register_options(){ 
add_options_page( __('4-author-cheer-up-donate','AcuD_transl'),__('4-author-cheer-up-donate','AcuD_transl'),  'manage_options', 'AcuD_options', 'AcuD_options_callback' );
}
function AcuD_options_callback(){
	 include(__DIR__ .'/admin/admin_options.php');
 }
 
  add_action('wp_ajax_AcuD_send', 'wp_ajax_AcuD_send_callback');
 add_action('wp_ajax_nopriv_AcuD_send', 'wp_ajax_AcuD_send_callback');
function wp_ajax_AcuD_send_callback() {
      include(__DIR__ .'/send.php');
wp_die();

}
  add_action('wp_ajax_AcuD_result', 'wp_ajax_AcuD_result_callback');
 add_action('wp_ajax_nopriv_AcuD_result', 'wp_ajax_AcuD_result_callback');
function wp_ajax_AcuD_result_callback() {
      include(__DIR__ .'/result.php');
wp_die();
}
add_action('wp_ajax_AcuD_success', 'wp_ajax_AcuD_success_callback');
add_action('wp_ajax_nopriv_AcuD_success', 'wp_ajax_AcuD_success_callback');
function wp_ajax_AcuD_success_callback() {
	//echo "<script type='text/javascript'>window.top.location='".get_permalink( get_option('Acud_thanks_page'))."';</script>";
wp_redirect(get_permalink( get_option('Acud_thanks_page')),301);
echo "<script type='text/javascript'>window.top.location='".get_permalink( get_option('Acud_thanks_page'))."';</script>";
    wp_die();
}

add_action('wp_ajax_AcuD_fail', 'wp_ajax_AcuD_fail_callback');
add_action('wp_ajax_nopriv_AcuD_fail', 'wp_ajax_AcuD_fail_callback');
function wp_ajax_AcuD_fail_callback() {
    wp_redirect(get_permalink( get_option('Acud_thanks_page') ));
	echo "<script type='text/javascript'>window.top.location='".get_permalink( get_option('Acud_thanks_page'))."';</script>";
    wp_die();
}

add_filter('the_content', 'AcuD_filter_post');
function AcuD_filter_post( $text ){

    if (is_page(get_option('Acud_rules_page')) && get_option('Acud_is_gratitude_OnRules') =='1'){
        $text .= ' <div style="float: right; margin: 0 auto; font-size: 8pt;" id="Acud_gratitude" >Разработан командой <a href="https://socpravo.ru">socpravo.ru</a></div>';
        return  $text;
    }
    if (!is_singular('post'))
    {
        return  $text;
    }
  $Acud_logo_after_post = get_option("Acud_logo_after_post");
    $Acud_logo_befor_post = get_option("Acud_logo_befor_post");
    if($Acud_logo_after_post == "1"){
        $text =   $text . do_shortcode('[AcuD_donate float="'.get_option("Acud_logo_after_post_select").'"]');
    }
    if($Acud_logo_befor_post == "1") {
        $text = do_shortcode('[AcuD_donate float="'.get_option("Acud_logo_befor_post_select").'"]') . $text;
    }
   


    return  $text;
}
add_action('plugins_loaded', 'AcuD_textdomain');
function AcuD_textdomain(){
	load_textdomain('AcuD_transl',__DIR__ ."/languages/AcuD_".get_locale().'.mo');
}

function AcuD_Plugin_activ(){
	load_textdomain('AcuD_transl',__DIR__ ."/languages/AcuD_".get_locale().'.mo');
	global $wpdb;
    $wp_upload_dir = wp_upload_dir();
    $logos_files = array('AcuD_logo_imgID'=>'AcuD_logo_2.jpg','AcuD_popUp_img_level_2'=>'AcuD_middle.jpg','AcuD_popUp_img_level_1'=>'AcuD_pit-stop_2.jpg','AcuD_popUp_img_level_3'=>'AcuD_cafe.jpg');
    foreach ($logos_files as $key =>$file) {//добавляем фалы по-умолчанию
        $filename = $wp_upload_dir['basedir'] .'/4-author-cheer-up-donate/'. $file;
        $id = $wpdb->get_var("SELECT id FROM ".$wpdb->prefix."posts WHERE post_title = '".preg_replace('/\.[^.]+$/', '', basename($filename))."';");
        if(  $id  == NULL) {
            mkdir($wp_upload_dir['basedir'] . '/4-author-cheer-up-donate/', 0755);
            rename(plugin_dir_path(__FILE__) . 'logos/' . $file, $filename);
            $attachment = array(
                'guid' => $wp_upload_dir['baseurl'] . '/4-author-cheer-up-donate/' . basename($filename),
                'post_mime_type' => 'image/jpeg',
                'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
                'post_content' => '',
                'post_status' => 'inherit'
            );
            $attach_id = wp_insert_attachment($attachment, $filename);
            wp_update_attachment_metadata($attach_id, wp_generate_attachment_metadata($attach_id, $filename));
            add_option($key, $attach_id);// текст в popUP под товарами
        }
        else
        {
            add_option($key, $id);
        }
    }
	    foreach (glob(plugin_dir_path(__FILE__) . 'logos/*') as $key =>$file) {//добавляем все остальные
			$filename = $wp_upload_dir['basedir'] .'/4-author-cheer-up-donate/'.  basename($file);
        $id = $wpdb->get_var("SELECT id FROM ".$wpdb->prefix."posts WHERE post_title = '".preg_replace('/\.[^.]+$/', '', basename($filename))."';");
        if(  $id  == NULL) {
            mkdir($wp_upload_dir['basedir'] . '/4-author-cheer-up-donate/', 0755);
            rename($file, $filename);
            $attachment = array(
                'guid' => $wp_upload_dir['baseurl'] . '/4-author-cheer-up-donate/' . basename($filename),
                'post_mime_type' => 'image/jpeg',
                'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
                'post_content' => '',
                'post_status' => 'inherit'
            );
            $attach_id = wp_insert_attachment($attachment, $filename);
            wp_update_attachment_metadata($attach_id, wp_generate_attachment_metadata($attach_id, $filename));
        }
		}
		
	add_option('Acud_mrh_login');//индетификатор магазина
	add_option('Acud_mrh_pass1');//пароль #1
	add_option('Acud_mrh_pass2');//пароль #2
	add_option('Acud_mrh_pass1_test');// тестовый пароль #1
	add_option('Acud_mrh_pass2_test');// тестовый пароль #2
	add_option('Acud_mrh_isTest',0);// чекбокс тестовых паролей
	
    add_option('Acud_logo_size',12);// размер лого в процентах
    add_option('Acud_logo_after_post',1);// лого после поста
    add_option('Acud_logo_after_post_select','right');// и его местоположение
    add_option('Acud_logo_befor_post',0);// лого перед постос
    add_option('Acud_logo_befor_post_select','left');// и его местоположение
    add_option('Acud_text_logo',__('May you will treat a tired author a cup of coffee?','AcuD_transl'));//ID картинки лого
    add_option('AcuD_popUp_main_text',__('<div style="text-align: center">Did you like the material? You can treat the author of a cup of aromatic coffee and leave him a good wish ("Thanks").</div><br> Your cup will be delivered to the author. A cup of coffee is not much, but it warms and gives strength to create further. You can choose to treat a author.<br>','AcuD_transl'));// теск в popUP над товарами
    add_option('AcuD_popUp_text_level_1',__('A cup of coffee with PitStop for 50 rubles.','AcuD_transl'));// текст в popUP под товарами
    add_option('AcuD_popUp_text_level_2',__('A cup of coffee with a gas station for 100 rubles.','AcuD_transl'));// текст в popUP под товарами
    add_option('AcuD_popUp_text_level_3',__('A cup of coffee with a Cafe for 150 rubles.','AcuD_transl'));// текст в popUP под товарами
	
	add_option('AcuD_popUp_price_level_1','50');// цена 1 товара
    add_option('AcuD_popUp_price_level_2','100');//  цена 2 товара
    add_option('AcuD_popUp_price_level_3','150');//  цена 3 товара
	add_option('AcuD_unnamed_text',__('Unknown kind man','AcuD_transl'));// текст в аннонима
    
	add_option('Acud_is_rules',1);// показ сылки на правила использования
    add_option('Acud_is_gratitude',1);// показ благодарности
    add_option('Acud_is_gratitude_OnRules',1);// показ благодарности на странице правил
    add_option('Acud_is_gratitude_OnThanks',1);// показ благодарности на странице Спасибо

    $defaults = array(
        'post_title'    => __('Terms of use','AcuD_transl'),
        'post_content'  => __('<p>1. All the funds pay you, when using this plugin, will be considered a donation.<br>2. Your donation is voluntary.<br>3. All donations are transferred to the author for personal use on the terms of the site.<br>4. No one can demand a donation back.<br>5. If you did not have the right to make a donation - contact the site administration urgently.<br><p>','AcuD_transl'),
        'post_status'   => 'publish',
        'post_type'     => 'page',
        'post_author'   => get_current_user_id(),
        'ping_status'   => get_option('default_ping_status'),
        'post_parent'   => 0,
        'menu_order'    => 0,
        'to_ping'       => '',
        'pinged'        => '',
        'post_password' => '',
        'guid'          => '',
        'post_content_filtered' => '',
        'post_excerpt'  => '',
        'import_id'     => 0
    );
    add_option('Acud_rules_page',wp_insert_post( $defaults ));// показ сылки на правила использования
    $defaults = array(
        'post_title'    => __('Page "Thanks"','AcuD_transl'),
        'post_content'  => '[AcuD_thank_you]',
        'post_status'   => 'publish',
        'post_type'     => 'page',
        'post_author'   => get_current_user_id(),
        'ping_status'   => get_option('default_ping_status'),
        'post_parent'   => 0,
        'menu_order'    => 0,
        'to_ping'       => '',
        'pinged'        => '',
        'post_password' => '',
        'guid'          => '',
        'post_content_filtered' => '',
        'post_excerpt'  => '',
        'import_id'     => 0
    );
    add_option('Acud_thanks_page',wp_insert_post( $defaults ));// страница спсибо
$wpdb->query(//создание таблицы сохраненых полей если такой несуществует
"
CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."acud_thank_names
(
id int UNSIGNED NOT NULL PRIMARY KEY auto_increment,
nameUser varchar(100) NOT NULL ,
text  text,
Price varchar(100) NOT NULL,
`success` TINYINT NOT NULL DEFAULT 0,
`from_url` VARCHAR(2300) NULL
);");
}
register_activation_hook( __FILE__,'AcuD_Plugin_activ');
?>