<?
global $wpdb;
// регистрационная информация (пароль #2)
// registration info (password #2)
if(get_option('Acud_mrh_isTest') =='1'){
$mrh_pass2 = get_option('Acud_mrh_pass2_test');
}
else{
	$mrh_pass2 = get_option('Acud_mrh_pass2');
}
// чтение параметров
// read parameters
$out_summ = $_REQUEST["OutSum"];
$inv_id = $_REQUEST["InvId"];
$crc = $_REQUEST["SignatureValue"];
$crc = strtoupper($crc);
$my_crc = strtoupper(md5("$out_summ:$inv_id:$mrh_pass2"));
// проверка корректности подписи
if ($my_crc !=$crc)
{
  echo "bad sign\n";
  exit();
}
// признак успешно проведенной операции
echo "OK$inv_id\n";

$wpdb->update( $wpdb->prefix.'acud_thank_names',
	array('success' => 1),
	array( 'ID' => $inv_id )
);

?>


