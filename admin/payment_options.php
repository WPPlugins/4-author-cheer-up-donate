<?php 
defined('ABSPATH') or die('No script kiddies please!');
if(!current_user_can('manage_options')){echo 'You can not manage options!';return;}	
	
	$AcuD_is_update = 0;
	if ( !empty($_POST) && check_admin_referer('AcuD_admin_nonce','AcuD_admin_nonce_field') )//обновление данных
     {
	$_POST = wp_unslash($_POST) ;
	if(isset( $_POST['Acud_mrh_login'] )){
	 if(sanitize_text_field($_POST['Acud_mrh_isTest']) == '1'){update_option('Acud_mrh_isTest','1');}else{update_option('Acud_mrh_isTest','0');}
		update_option('Acud_mrh_login',sanitize_text_field($_POST['Acud_mrh_login']));
		update_option('Acud_mrh_pass1',sanitize_text_field($_POST['Acud_mrh_pass1']));
		update_option('Acud_mrh_pass2',sanitize_text_field($_POST['Acud_mrh_pass2']));		
        update_option('Acud_mrh_pass1_test',sanitize_text_field($_POST['Acud_mrh_pass1_test']));
		update_option('Acud_mrh_pass2_test',sanitize_text_field($_POST['Acud_mrh_pass2_test']));			
		$AcuD_is_update = 1;
	}
     }
	 
?>
<div style="width: 80%;">
<form action="" method=post enctype=multipart/form-data>
 <?php wp_nonce_field('AcuD_admin_nonce','AcuD_admin_nonce_field'); ?>
<table class="wp-list-table widefat fixed striped" ><tbody>
    <tr>
        <td><a href="<?php echo esc_attr(__('https://www.robokassa.ru/en/','AcuD_transl')); ?>" target="_blank"><button class="button-primary" style="width: 100%" type="button" ><?php _e('Website of Robocassa','AcuD_transl'); ?></button></a></td>
        <td><a href="<?php echo esc_attr(__('http://docs.robokassa.ru/en/#2483','AcuD_transl')); ?>" target="_blank"><button class="button-primary" style="width: 100%" type="button" ><?php _e('Robokassa - For developers','AcuD_transl'); ?></button></a></td>
    </tr>
<tr>
<td><span  class="AcuD_ask" title="<?php echo esc_attr(__('"The Shop Identifier" can be found in the settings of the robokassa store in the "Technical settings" tab.','AcuD_transl')); ?>"><?php _e('The Shop Identifier','AcuD_transl'); ?></span></td>
<td><input class="regular-text" value="<?php echo get_option('Acud_mrh_login'); ?>" name="Acud_mrh_login" type="text"></td>
</tr>
<tr>
<td><span  class="AcuD_ask" title="<?php echo esc_attr(__('"Password #1" can be found in the settings of the robokassa store in the "Technical settings" tab.','AcuD_transl')); ?>"><?php _e('Password #1','AcuD_transl'); ?></span></td>
<td><input class="regular-text" value="<?php echo get_option('Acud_mrh_pass1'); ?>" name="Acud_mrh_pass1" type="text"></td>
</tr>
<tr>
<td><span  class="AcuD_ask" title="<?php echo esc_attr(__('"Password #2" can be found in the settings of the robokassa store in the "Technical settings" tab.','AcuD_transl')); ?>"><?php _e('Password #2','AcuD_transl'); ?></span></td>
<td><input class="regular-text" value="<?php echo get_option('Acud_mrh_pass2'); ?>" name="Acud_mrh_pass2" type="text"></td>
</tr>
<tr>
<td><span  class="AcuD_ask" title="<?php echo esc_attr(__('You need to copy this link and paste it into the "Result Url" field, which is located in the settings of the robokassa store in the "Technical settings" tab.','AcuD_transl')); ?>">Result Url</span></td>
<td><?php echo admin_url('admin-ajax.php')."?action=AcuD_result" ?></td>
</tr>
<tr>
<td><span  class="AcuD_ask" title="<?php echo esc_attr(__('You need to copy this link and paste it into the "Success Url" field, which is located in the settings of the robokassa store in the "Technical settings" tab.','AcuD_transl')); ?>">Success Url</span></td>
<td><?php echo admin_url('admin-ajax.php')."?action=AcuD_success" ?></td>
</tr>
<tr>
<td><span  class="AcuD_ask" title="<?php echo esc_attr(__('You need to copy this link and paste it into the "Fail Url" field, which is located in the settings of the robokassa store in the "Technical settings" tab.','AcuD_transl')); ?>">Fail Url</span></td>
<td><?php echo admin_url('admin-ajax.php')."?action=AcuD_fail" ?></td>
</tr>
<tr>
<td><span  class="AcuD_ask" title="<?php echo esc_attr(__('"Test Password #1" can be found in the settings of the robokassa store in the "Technical settings" tab.','AcuD_transl')); ?>"><?php _e('Тестовый Пароль #1','AcuD_transl'); ?></span></td>
<td><input class="regular-text" value="<?php echo get_option('Acud_mrh_pass1_test'); ?>" name="Acud_mrh_pass1_test" type="text"></td>
</tr>
<tr>
<td><span  class="AcuD_ask" title="<?php echo esc_attr(__('"Test Password #2" can be found in the settings of the robokassa store in the "Technical settings" tab.','AcuD_transl')); ?>"><?php _e('Тестовый Пароль #2','AcuD_transl'); ?></span></td>
<td><input class="regular-text" value="<?php echo get_option('Acud_mrh_pass2_test'); ?>" name="Acud_mrh_pass2_test" type="text"></td>
</tr>
<tr>
<td><span  class="AcuD_ask" title="<?php echo esc_attr(__('Enable, if you want to testing the shop payment initiation interfacemake, for real payments this item should be turned off.','AcuD_transl')); ?>"><?php _e('Use test passwords?','AcuD_transl'); ?></span></td>
<td><input name="Acud_mrh_isTest" id="Acud_mrh_isTest" type="checkbox" value="1" <?php if(get_option('Acud_mrh_isTest') =='1') echo 'checked';?>></td>
</tr>
</tbody></table>
    <?php if($AcuD_is_update){ echo '<p style="color: #21ce21;">'.__('Updated','AcuD_transl').'</p>'; } ?>
 <p> <input class="button-primary" type=submit  value="<?php _e('Updated','AcuD_transl'); ?>" > </p><br>
</form>
</div>

