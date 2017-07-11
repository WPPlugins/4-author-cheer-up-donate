<?php
	 if(!wp_verify_nonce( $_POST['nonce'], 'AcuD_nonce_send'))
	 {
		 echo "error";
		 exit();
	 }
	 $nickname = $_POST['nickname'];
	 sanitize_text_field($nickname);
	 $text = $_POST['text'];
	 sanitize_text_field($text);
	 $shp_item = $_POST['shp_item'];
	 sanitize_text_field($shp_item);
	 $from_url = $_POST['from_url'];
	 sanitize_text_field($from_url);
	 switch($shp_item){
	case "1": $out_summ = get_option("AcuD_popUp_price_level_1"); $price .= "item1";  break;
	case "2":  $out_summ = get_option("AcuD_popUp_price_level_2");  $price .= "item2"; break;
	case "3": $out_summ = get_option("AcuD_popUp_price_level_3");  $price .= "item3"; break;
	default:  echo "error"; exit(); break;
}
if($nickname ==''){
	$nickname = "AcuD_unnamed";
}
global $wpdb;
$wpdb->insert($wpdb->prefix.'acud_thank_names',
	array( 'nameUser' =>  $nickname, 'text' => $text, 'Price' => $price, 'success' => 0, 'from_url'=> $from_url),
	array( '%s', '%s', '%s', '%d' ,'%s'));
var_dump($_POST);
// регистрационная информация (логин, пароль #1)
// registration info (login, password #1)
$mrh_login = get_option('Acud_mrh_login');
if(get_option('Acud_mrh_isTest') =='1'){
$mrh_pass1 = get_option('Acud_mrh_pass1_test');
$is_test = "isTest=1&";
}
else{
	$mrh_pass1 = get_option('Acud_mrh_pass1');
	$is_test = "";
}
// номер заказа
// number of order
$inv_id = $wpdb->insert_id;

// описание заказа
// order description
$inv_desc = $price;

// предлагаемая валюта платежа
// default payment e-currency
$in_curr = "";

// язык
// language
$culture = __('en','AcuD_transl');

// кодировка
// encoding
$encoding = "utf-8";


$crc  = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1");
//$crc  = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1:Shp_item=$shp_item");
?> 
<script>
   window.location.href = "<?php echo "https://auth.robokassa.ru/Merchant/Index.aspx?".$is_test."MerchantLogin=$mrh_login&InvId=$inv_id&OutSum=$out_summ&SignatureValue=$crc&Culture=$culture&Encoding=$encoding"   ?>";

</script>