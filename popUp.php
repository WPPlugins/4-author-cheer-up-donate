<?php
defined('ABSPATH') or die('No script kiddies please!');
wp_enqueue_style( 'AcuD_logo_style' ,plugins_url("/logo_style.css", __FILE__));
// подключаем все необходимые скрипты: jQuery, jquery-ui, datepicker
wp_enqueue_script('jquery-ui-tooltip');
wp_enqueue_script('bPopup',plugins_url("/jquery.bpopup.min.js", __FILE__));
wp_enqueue_script('AcuD_logoJS',plugins_url("/logo_JS.js", __FILE__));
// подключаем нужные css стили
wp_enqueue_style('jqueryui', plugins_url("/jquery-ui.css", __FILE__), false, null );
?>
<div class="AcuD_popUp" id="AcuD_popUp">
<span class="b-close">X</span>
    <?php echo get_option('AcuD_popUp_main_text');  ?>
<div style="margin: 5% 0; float:left;width:100%;">
<div class="AcuD_logo_Levels" id="AcuD_logo_Level_1"><img  src="<?php echo wp_get_attachment_image_url(get_option('AcuD_popUp_img_level_1'));?>"  width="100" height="100"/><p><?php echo get_option('AcuD_popUp_text_level_1'); ?></p></div>
<div class="AcuD_logo_Levels" id="AcuD_logo_Level_2"><img  src="<?php echo wp_get_attachment_image_url(get_option('AcuD_popUp_img_level_2'));?>"  width="100" height="100"/><p><?php echo get_option('AcuD_popUp_text_level_2'); ?></p></div>
<div class="AcuD_logo_Levels" id="AcuD_logo_Level_3"><img  src="<?php echo wp_get_attachment_image_url(get_option('AcuD_popUp_img_level_3'));?>"  width="100" height="100"/><p><?php echo get_option('AcuD_popUp_text_level_3'); ?></p></div>
</div>
<div style="<?php if(get_option('Acud_is_rules') == 0){echo "display: none;";} ?> float: left; margin: 0 auto; font-size: 8pt;"><a href="<?php echo get_permalink( get_option('Acud_rules_page') ); ?>"><?php _e('Terms of use','AcuD_transl'); ?></a></div>
<div style="<?php if(get_option('Acud_is_gratitude') == 0){echo "display: none;";} ?> float: right; margin: 0 auto; font-size: 7pt;"><?php _e('a team by ','AcuD_transl'); ?><a href="https://socpravo.ru">socpravo.ru</a></div>
</div>
<div class="AcuD_popUp" id="AcuD_popUp2">
    <span class="b-close">X</span>
    <?php _e('Do you want to leave a wish for the author?','AcuD_transl'); ?>
    <p><input type="text" id="AcuD_thanks_nickname" placeholder="Ваше имя"></p>
    <p><textarea id="AcuD_thanks_text" placeholder="Пожелание" rows="10" cols="45" ></textarea></p>
    <p>
        <button onclick="AcuD_click_skip()"><?php _e('Leave a wish','AcuD_transl'); ?></button>
        <button onclick="AcuD_click_skip()"><?php _e('Skip','AcuD_transl');?></button>
    </p>
</div>
<script>
    var AcuD_shp_item = "0";
    function AcuD_click_skip()
    {
        jQuery.post("<?php echo admin_url('admin-ajax.php');?>",{action:"AcuD_send",shp_item:AcuD_shp_item,nonce:'<?php echo  wp_create_nonce('AcuD_nonce_send'); ?>',nickname:jQuery("#AcuD_thanks_nickname").val(),text:jQuery("#AcuD_thanks_text").val(),from_url:window.location.href},function(data) {
            jQuery('.AcuD_logo').append(data);
        });
    }
</script>
