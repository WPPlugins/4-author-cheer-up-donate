<?php 
defined('ABSPATH') or die('No script kiddies please!');
if(empty($atts['float'])) $atts['float'] = "right";
include_once(__DIR__ .'/popUp.php');
?>

<img class="AcuD_logo" title="<?php echo get_option("Acud_text_logo"); ?>" style="width: <?php echo get_option("Acud_logo_size"); ?>%; <?php echo "float:".$atts['float']; ?>"
 src="<?php  echo wp_get_attachment_image_url(get_option('AcuD_logo_imgID')); ?>"  width="300" height="300"/>

