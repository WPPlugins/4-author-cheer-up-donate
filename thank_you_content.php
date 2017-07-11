<?php 
defined('ABSPATH') or die('No script kiddies please!');
	global $wpdb;

	if(isset($_REQUEST["SignatureValue"])){
if(get_option('Acud_mrh_isTest') =='1'){
$mrh_pass1 = get_option('Acud_mrh_pass1_test');
}
else{
	$mrh_pass1 = get_option('Acud_mrh_pass1');
}
$out_summ = $_REQUEST["OutSum"];
$inv_id = $_REQUEST["InvId"];
$shp_item = $_REQUEST["Shp_item"];
$crc = $_REQUEST["SignatureValue"];
$crc = strtoupper($crc);
$my_crc = strtoupper(md5("$out_summ:$inv_id:$mrh_pass1"));
	if ($my_crc = $crc){
       _e("<p>Thanks!</p>",'AcuD_transl');
	}
}
	

?>
<table class="AcuD_thank_table">
<tr>
<th><?php _e('Name','AcuD_transl');?></th> <th><?php _e('Thanks','AcuD_transl');?></th> <th><?php _e('Donation amount','AcuD_transl');?></th>
</tr>
<?php
    $total_items = $wpdb->get_var("SELECT COUNT(*) FROM ".$wpdb->prefix."acud_thank_names WHERE success > 0");
    $per_page = 20;
    $current_page = get_query_var('page');
    $current_page = $current_page==0 ? 1:$current_page;
	$names = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."acud_thank_names WHERE success > 0 ORDER BY `Price` LIMIT " . $per_page . " OFFSET " . ($current_page-1) * $per_page);
foreach ($names as $name){
	switch($name->Price){
	case "item1": $name->Price = get_option("AcuD_popUp_text_level_1");  break;
	case "item2": $name->Price = get_option("AcuD_popUp_text_level_2"); break;
	case "item3": $name->Price = get_option("AcuD_popUp_text_level_3"); break;
	}
	if ($name->nameUser == "AcuD_unnamed"){
		$name->nameUser = get_option('AcuD_unnamed_text');
	}
	
	echo '<tr><td>'.$name->nameUser.'</td> <td>'.$name->text.'</td> <td>'.$name->Price.'</td></tr>';
}
?>
</table>
<?php

$args = array(
    'base'         => get_permalink()."?page=%#%",
    'format'       => '',
    'total'        => $total_items/$per_page,
    'current'      => $current_page,
    'show_all'     => False,
    'end_size'     => 1,
    'mid_size'     => 5,
    'prev_next'    => True,
    'prev_text'    => __('Back','AcuD_transl'),
    'next_text'    => __('Next','AcuD_transl'),
    'type'         => 'plain',
    'add_args'     => False,
    'add_fragment' => '',
    'before_page_number' => '',
    'after_page_number'  => ''
);
if($per_page < $total_items) {
    echo "<div style='text-align: center;font-size: medium'>".paginate_links($args)."</div>";
}

if ( get_option('Acud_is_gratitude_OnThanks') =='1'){
    echo ' <div style="float: right; margin: 0 auto; font-size: 8pt;" id="Acud_gratitude" >'. __('a team by ','AcuD_transl') .'<a href="https://socpravo.ru">socpravo.ru</a></div>';

}
?>