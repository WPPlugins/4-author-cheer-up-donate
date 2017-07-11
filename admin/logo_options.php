<?php
defined('ABSPATH') or die('No script kiddies please!');
if(!current_user_can('manage_options')){echo 'You can not manage options!';return;}
    wp_enqueue_media();
wp_enqueue_style( 'AcuD_logo_style_admin' ,plugins_url("/logo_style_admin.css", __FILE__));
wp_enqueue_script('jquery-ui-tooltip');
wp_enqueue_style('jqueryui', plugins_url("/jquery-ui.css", dirname(__FILE__)), false, null );
wp_enqueue_script('bPopup',plugins_url("/jquery.bpopup.min.js",dirname(__FILE__)));
$AcuD_is_update = 0;


if ( !empty($_POST) && check_admin_referer('AcuD_admin_nonce','AcuD_admin_nonce_field') )//обновление данных
{
    $_POST = wp_unslash($_POST) ;


    if(isset( $_POST['AcuD_logo_imgID'] )){

        if(intval(sanitize_text_field($_POST['Acud_is_rules'])) == 1){update_option('Acud_is_rules',1);}else{update_option('Acud_is_rules',0);}
        if(intval(sanitize_text_field($_POST['Acud_is_gratitude'])) == 1){update_option('Acud_is_gratitude',1);}else{update_option('Acud_is_gratitude',0);}
        if(intval(sanitize_text_field($_POST['Acud_is_gratitude_OnRules'])) == 1){update_option('Acud_is_gratitude_OnRules',1);}else{update_option('Acud_is_gratitude_OnRules',0);}

      if(intval(sanitize_text_field($_POST['Acud_logo_after_post'])) == 1){update_option('Acud_logo_after_post',1);}else{update_option('Acud_logo_after_post',0);}
        update_option('Acud_logo_after_post_select',sanitize_text_field($_POST['Acud_logo_after_post_select']));

        if(intval(sanitize_text_field($_POST['Acud_logo_befor_post'])) == 1){update_option('Acud_logo_befor_post',1);}else{update_option('Acud_logo_befor_post',0);}
        $Acud_logo_befor_post_select = intval(sanitize_text_field($_POST['Acud_logo_befor_post_select']));
        if($Acud_logo_befor_post_select == 1){update_option('Acud_logo_befor_post_select','left');}
         if($Acud_logo_befor_post_select == 2){update_option('Acud_logo_befor_post_select','right');}

         $Acud_logo_after_post_select = intval(sanitize_text_field($_POST['Acud_logo_after_post_select']));
        if($Acud_logo_after_post_select == 1){update_option('Acud_logo_after_post_select','left');}
         if($Acud_logo_after_post_select == 2){update_option('Acud_logo_after_post_select','right');}

        update_option('AcuD_logo_imgID',intval($_POST['AcuD_logo_imgID']));
        update_option('Acud_rules_page',intval($_POST['Acud_rules_page']));
        update_option('Acud_logo_size',intval($_POST['Acud_logo_size']));
        update_option(' Acud_text_logo', wp_kses( $_POST['Acud_text_logo'] , 'post' ));

        update_option('Acud_thanks_page',intval($_POST['Acud_thanks_page']));

        update_option(' AcuD_popUp_main_text', wp_kses( $_POST['AcuD_popUp_main_text'] , 'post' ));

        update_option(' AcuD_popUp_text_level_1', wp_kses( $_POST['AcuD_popUp_text_level_1'] , 'post' ));
        update_option(' AcuD_popUp_text_level_2', wp_kses( $_POST['AcuD_popUp_text_level_2'] , 'post' ));
        update_option(' AcuD_popUp_text_level_3', wp_kses( $_POST['AcuD_popUp_text_level_3'] , 'post' ));
		update_option('AcuD_popUp_price_level_1',intval($_POST['AcuD_popUp_price_level_1']));
        update_option('AcuD_popUp_price_level_2',intval($_POST['AcuD_popUp_price_level_2']));
        update_option('AcuD_popUp_price_level_3',intval($_POST['AcuD_popUp_price_level_3']));
		
		update_option(' AcuD_unnamed_text', wp_kses( $_POST['AcuD_unnamed_text'] , 'post' ));

        update_option('AcuD_popUp_img_level_1',intval(sanitize_text_field($_POST['AcuD_popUp_img_level_1'])));
        update_option('AcuD_popUp_img_level_2',intval(sanitize_text_field($_POST['AcuD_popUp_img_level_2'])));
        update_option('AcuD_popUp_img_level_3',intval(sanitize_text_field($_POST['AcuD_popUp_img_level_3'])));
        $AcuD_is_update =1;
    }
}
?>

<h2><?php _e('Logo settings','AcuD_transl');?></h2>
<form action="" method=post enctype=multipart/form-data>
<div>
    <img class="AcuD_logo" id="AcuD_logo" title="<?php echo get_option("Acud_text_logo"); ?>"
          src="<?php echo wp_get_attachment_image_url(get_option('AcuD_logo_imgID')); ?>"  width="300" height="300"/><br>
    <p style="float:left;"> <input class="button upload_image_logo_button" type=button  value="<?php _e('Select the image','AcuD_transl'); ?>" >
        <input type="hidden" name="AcuD_logo_imgID" id="AcuD_logo_imgID" value="<?php echo get_option('AcuD_logo_imgID'); ?>">
    </p>
    <p style="float:left; margin-left: 1%; "><button type="button" class="button" onclick="jQuery('#AcuD_popUp_admin1').bPopup({speed: 350});" ><?php _e('How do change the image?','AcuD_transl'); ?></button></p>
    <div class="AcuD_popUp_admin" id="AcuD_popUp_admin1">
        <span class="b-close">X</span>
       <p style="font-size: large">
           <?php _e('How to replace the image: <br>
           1. You can easily replace the images with those that you like. Initially, the plugin displays images of coffee, but who prevents you from putting images of beer? :-) <br>
           2. All images are stored in your media library. You can save any images to your library and use them. <br>
           3. By clicking the "Select the Image" button, you will be taken to the Media Library where you can select any image. <br>
           4. If you suddenly lost our images in the library, enter "ACUD" media files in the search string <br>','AcuD_transl'); ?>
       </p>
    </div>
</div>


<div style="width: 60%;">

        <?php wp_nonce_field('AcuD_admin_nonce','AcuD_admin_nonce_field'); ?>
        <table class="wp-list-table widefat fixed striped" ><tbody>
            <tr>
                <td><span  class="AcuD_ask" title="<?php _e('"Welcome" text. Please speak to the user, interest him. ".".','AcuD_transl'); ?>"><?php _e('Hover text','AcuD_transl'); ?></span></td>
                <td><input  class="regular-text" value="<?php echo get_option('Acud_text_logo'); ?>" name="Acud_text_logo" type="text"></td>
            </tr>
            <tr>
                <td><span  class="AcuD_ask" title="<?php _e('Set a Logo size as a percentage of the entire page width','AcuD_transl'); ?>"><?php _e('Logo size','AcuD_transl'); ?></span></td>
                <td><input  class="regular-text" value="<?php echo get_option('Acud_logo_size'); ?>" name="Acud_logo_size" type="number"></td>
            </tr>
            <tr>
                <td><span  class="AcuD_ask" title="<?php _e('Show the logo at the beginning of the post of type \'post\', the first line.','AcuD_transl'); ?>"><?php _e('Show the logo at the beginning of each post.','AcuD_transl'); ?></span></td>
                <td><input name="Acud_logo_befor_post" id="Acud_logo_befor_post" type="checkbox" value="1" <?php if(get_option('Acud_logo_befor_post') =='1') echo 'checked';?>>
                    <select name="Acud_logo_befor_post_select" id="Acud_logo_befor_post_select">
                        <option value="1">Слева</option>
                        <option value="2">Справа</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><span  class="AcuD_ask" title="<?php _e('Show the logo at the end of the post of type \'post\', the last line.','AcuD_transl'); ?>"><?php _e('Show the logo at the end of each post.','AcuD_transl'); ?></span></td>
                <td><input name="Acud_logo_after_post" id="Acud_logo_after_post" type="checkbox" value="1" <?php if(get_option('Acud_logo_after_post') =='1') echo 'checked';?>>
                    <select name="Acud_logo_after_post_select" id="Acud_logo_after_post_select">
                        <option value="1">Слева</option>
                        <option value="2">Справа</option>
                    </select>
                </td>
            </tr>

            </tbody></table>
    <?php if($AcuD_is_update){ echo '<p style="color: #21ce21;">'.__('Updated','AcuD_transl').'</p>'; } ?>
	<p><?php _e('The logo can be anywhere in the text - using the shortcode [AcuD_donate] or [AcuD_donate float = "left"], if you want to place the logo on the left.','AcuD_transl');?></p>
    <p> <input class="button-primary" type=submit  value="<?php _e('Update','AcuD_transl'); ?>" > </p><br>
</div>


<h2><?php _e('Customize product selection','AcuD_transl');?></h2>
<div  style="width: 60%;">
    <div class="AcuD_popUp" id="AcuD_popUp">
        <textarea   style="resize: vertical;width: 100%" name="AcuD_popUp_main_text" id="AcuD_popUp_main_text" rows="4" style="width: 100%"><?php echo get_option('AcuD_popUp_main_text');  ?></textarea>
        <div style="margin: 5% 0; float:left;width:100%;">
            <div class="AcuD_logo_Levels" id="AcuD_logo_Level_1"><img  src="<?php echo wp_get_attachment_image_url(get_option('AcuD_popUp_img_level_1'));?>"  width="100" height="100"/><p> <input class="button upload_image_popUp_button" type=button  value="<?php _e('Выбрать изображение','AcuD_transl'); ?>" > <input type="hidden" name="AcuD_popUp_img_level_1" id="AcuD_popUp_img_level_1" class="AcuD_popUp_img" value="<?php echo get_option('AcuD_popUp_img_level_1'); ?>"></p><p><textarea   style="resize: none" rows="3"  cols="20" maxlength="60" name="AcuD_popUp_text_level_1"><?php echo get_option('AcuD_popUp_text_level_1');  ?></textarea></p><p> <span  class="AcuD_ask" title="<?php _e('Set price for that item','AcuD_transl'); ?>"><?php _e('Price:','AcuD_transl'); ?></span><br><input style="width: 40%;"  class="regular-text" value="<?php echo get_option('AcuD_popUp_price_level_1'); ?>" name="AcuD_popUp_price_level_1" type="number"></p></div>
            <div class="AcuD_logo_Levels" id="AcuD_logo_Level_2"><img  src="<?php echo wp_get_attachment_image_url(get_option('AcuD_popUp_img_level_2'));?>"  width="100" height="100"/><p> <input class="button upload_image_popUp_button" type=button   value="<?php _e('Выбрать изображение','AcuD_transl'); ?>" > <input type="hidden" name="AcuD_popUp_img_level_2" id="AcuD_popUp_img_level_2" class="AcuD_popUp_img" value="<?php echo get_option('AcuD_popUp_img_level_2'); ?>"></p><p><textarea   style="resize: none" rows="3" cols="20" maxlength="60" name="AcuD_popUp_text_level_2"><?php echo get_option('AcuD_popUp_text_level_2');  ?></textarea></p> <p> <span  class="AcuD_ask" title="<?php _e('Set price for that item','AcuD_transl'); ?>"><?php _e('Price:','AcuD_transl'); ?></span><br><input style="width: 40%;"  class="regular-text" value="<?php echo get_option('AcuD_popUp_price_level_2'); ?>" name="AcuD_popUp_price_level_2" type="number"></p></div>
            <div class="AcuD_logo_Levels" id="AcuD_logo_Level_3"><img  src="<?php echo wp_get_attachment_image_url(get_option('AcuD_popUp_img_level_3'));?>"  width="100" height="100"/><p> <input class="button upload_image_popUp_button" type=button  value="<?php _e('Выбрать изображение','AcuD_transl'); ?>" > <input type="hidden" name="AcuD_popUp_img_level_3" id="AcuD_popUp_img_level_3" class="AcuD_popUp_img" value="<?php echo get_option('AcuD_popUp_img_level_3'); ?>"></p><p><textarea   style="resize: none" rows="3" cols="20" maxlength="60" name="AcuD_popUp_text_level_3"><?php echo get_option('AcuD_popUp_text_level_3');  ?></textarea></p>  <p> <span  class="AcuD_ask" title="<?php _e('Set price for that item','AcuD_transl'); ?>"><?php _e('Price:','AcuD_transl'); ?></span><br><input style="width: 40%;"  class="regular-text" value="<?php echo get_option('AcuD_popUp_price_level_3'); ?>" name="AcuD_popUp_price_level_3" type="number"></p></div>
        </div>
        <div style="<?php if(get_option('Acud_is_rules') == 0){echo "display: none;";} ?> float: left; margin: 0 auto; font-size: 8pt;" id="Acud_rules"><a href="<?php echo get_permalink( get_option('Acud_rules_page') ); ?>"><?php _e('Terms of use','AcuD_transl');?></a></div>
        <div style="<?php if(get_option('Acud_is_gratitude') == 0){echo "display: none;";} ?> float: right; margin: 0 auto; font-size: 7pt;" id="Acud_gratitude" ><?php _e('a team by ','AcuD_transl');?> <a href="https://socpravo.ru">socpravo.ru</a></div>
    </div>
</div>
    <div style="width: 60%; margin-top: 3%">

        <?php wp_nonce_field('AcuD_admin_nonce','AcuD_admin_nonce_field'); ?>
        <table class="wp-list-table widefat fixed striped" ><tbody>
		  <tr>
                <td><span  class="AcuD_ask" title="<?php _e('Set text for unnamed contributor','AcuD_transl'); ?>"><?php _e('Text for unnamed contributor','AcuD_transl'); ?></span></td>
                <td><input  class="regular-text" value="<?php echo get_option('AcuD_unnamed_text'); ?>" name="AcuD_unnamed_text" type="text"></td>
            </tr>
			
            <tr>
                <td><span  class="AcuD_ask" title="<?php  echo esc_attr(__('We recommend using the "Terms of Use", where it will be indicated that this is a donation.','AcuD_transl')); ?>"><?php _e('Show link to "Terms of Use".','AcuD_transl'); ?></span></td>
                <td><input name="Acud_is_rules" id="Acud_is_rules" type="checkbox" value="1" <?php if(get_option('Acud_is_rules') =='1') echo 'checked';?>
                </td>
            </tr>
            <tr class="AcuD_select_page" style="<?php if(get_option('Acud_is_rules') == 0){echo "display: none;";} ?>" id="Acud_rules_page_tr">
                <td><span  class="AcuD_ask" title="<?php _e("If you don't want to use your page, don't change anything - the default page will be used.",'AcuD_transl'); ?>"><?php _e('Page with "Terms of Use".','AcuD_transl'); ?></span></td>
                <td><?php wp_dropdown_pages(array(
                        'depth'            => 0,
                        'child_of'         => 0,
                        'selected'         => get_option('Acud_rules_page'),
                        'echo'             => 1,
                        'name'             => 'Acud_rules_page',
                        'show_option_none' => '',
                        'exclude'          => '',
                        'exclude_tree'     => '',
                        'value_field'      => 'ID', // поле для значения value e тега option
                    )); ?></td>
            </tr>
            <tr>
                <td> <span  class="AcuD_ask" title="<?php _e('If the checkbox is enabled, the plugin on the page a link to the developer`s website. Otherwise, no.','AcuD_transl'); ?>"><?php _e('Show link to the plugin the developer`s website. Thank you, if you decide to show :-)','AcuD_transl'); ?></span></td>
                <td><input name="Acud_is_gratitude" id="Acud_is_gratitude" type="checkbox" value="1" <?php if(get_option('Acud_is_gratitude') =='1') echo 'checked';?>></td>
            </tr>

            <tr class="AcuD_select_page" id="Acud_thanks_page">
                <td><span  class="AcuD_ask" title="<?php  echo esc_attr(__("If you don't want to use your page, don't change anything - the default page will be used.",'AcuD_transl')); ?>"><?php _e('Page "Thanks"','AcuD_transl'); ?></span></td>
                <td><?php wp_dropdown_pages(array(
                        'depth'            => 0,
                        'child_of'         => 0,
                        'selected'         => get_option('Acud_thanks_page'),
                        'echo'             => 1,
                        'name'             => 'Acud_thanks_page',
                        'show_option_none' => '',
                        'exclude'          => '',
                        'exclude_tree'     => '',
                        'value_field'      => 'ID', // поле для значения value e тега option
                    )); ?></td>
            </tr>
            <tr>
                <td> <span  class="AcuD_ask" title="<?php _e('If the checkbox is enabled, on the page "Terms of Use" show a link to the developer`s website. Otherwise, no. ','AcuD_transl'); ?>"><?php _e('Show link to the plugin developer site on the "Terms of Use" page.','AcuD_transl'); ?></span></td>
                <td><input name="Acud_is_gratitude_OnRules" id="Acud_is_gratitude_OnRules" type="checkbox" value="1" <?php if(get_option('Acud_is_gratitude_OnRules') =='1') echo 'checked';?>></td>
            </tr>

            </tbody></table>
      <?php if($AcuD_is_update){ echo '<p style="color: #21ce21;">'.__('Updated','AcuD_transl').'</p>'; } ?>
    <p> <input class="button-primary" type=submit  value="<?php _e('Update','AcuD_transl'); ?>" > </p><br>

    </div>
</form>
<script>
    jQuery("#Acud_logo_befor_post_select").val("<?php  if(get_option('Acud_logo_befor_post_select')== 'left')echo '1'; if(get_option('Acud_logo_befor_post_select')== 'right')echo '2'; ?>").change();
    jQuery("#Acud_logo_after_post_select").val("<?php  if(get_option('Acud_logo_after_post_select')== 'left')echo '1'; if(get_option('Acud_logo_after_post_select')== 'right')echo '2'; ?>").change();
    jQuery(function($) {
        $('#Acud_is_rules').click(function () {

            if($(this).prop("checked")){
                $("#Acud_rules").fadeIn(400);
                $("#Acud_rules_page_tr").fadeIn(400);
            }
            else{
                $("#Acud_rules").fadeOut(400);
                $("#Acud_rules_page_tr").fadeOut(400);
            }
        });
        $('#Acud_is_gratitude').click(function () {

            if($(this).prop("checked")){
                $("#Acud_gratitude").fadeIn(400);
            }
            else{
                $("#Acud_gratitude").fadeOut(400);
            }
        });



        $('.upload_image_logo_button').click(function () {
            var send_attachment_bkp = wp.media.editor.send.attachment;
            var button = $(this);
            wp.media.editor.send.attachment = function (props, attachment) {
                $("#AcuD_logo").attr('src', attachment.url);
                $("#AcuD_logo_imgID").val(attachment.id);
                wp.media.editor.send.attachment = send_attachment_bkp;
            };
            wp.media.editor.open(button);
            return false;
        });
        $('.upload_image_popUp_button').click(function () {
            var send_attachment_bkp = wp.media.editor.send.attachment;
            var button = $(this);
            wp.media.editor.send.attachment = function (props, attachment) {
                $(button).parent().prev().attr('src', attachment.url);
                $(button).next().val(attachment.id);
                wp.media.editor.send.attachment = send_attachment_bkp;
            };
            wp.media.editor.open(button);
            return false;
        });
    });
</script>