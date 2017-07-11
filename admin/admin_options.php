<?php 
defined('ABSPATH') or die('No script kiddies please!');
if(!current_user_can('manage_options')){echo 'You can not manage options!';return;}	
	wp_enqueue_style( 'Acud_admin_style' ,plugins_url("/admin_style.css", __FILE__));
    wp_enqueue_script('jquery-ui-tooltip');
    wp_enqueue_style('jqueryui', plugins_url("/jquery-ui.css", dirname(__FILE__)), false, null );

?>
<h1> <?php echo '4-author-cheer-up-donate(options)'; ?></h1>
<?php 
function ilc_admin_tabs404tboc( $current = 'General' ) {
	global $AcuD_is_update;
    $tabs = array( 'General' => __('Main settings','AcuD_transl'), 'payment' => __('Technical Settings Robokassa','AcuD_transl'), 'tableThank' =>__( 'Table "Thanks"','AcuD_transl') );
    echo '<div id="icon-themes" class="icon32"><br></div>';
    echo '<h2 class="nav-tab-wrapper">';
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
        echo "<a class='nav-tab$class' href='?page=AcuD_options&tab=$tab'>$name</a>";

    }
    echo '</h2>';
	switch($current){
		case 'tableThank' : 
         include(__DIR__ .'/table_thank.php');
		break;
		
		case 'General' : include(__DIR__ .'/logo_options.php');

       break; 
		case 'payment' : 
	          include(__DIR__ .'/payment_options.php');
       break;
    }
}
	if ( isset ( $_GET['tab'] ) ) ilc_admin_tabs404tboc($_GET['tab']); else ilc_admin_tabs404tboc('General');
	// подключаем все необходимые скрипты: jQuery, jquery-ui, datepicker
	wp_enqueue_script('jquery-ui-tooltip');

	// подключаем нужные css стили
	wp_enqueue_style('jqueryui', plugins_url("jquery-ui.css", dirname(__FILE__)), false, null );
?>
<script>
    jQuery( function() {
        jQuery( 'span, .AcuD_logo' ).tooltip();
    } );
</script>
