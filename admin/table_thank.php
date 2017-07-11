<?php
defined('ABSPATH') or die('No script kiddies please!');
global $wpdb;
$AcuD_is_update = 0;
if (!empty($_POST) && check_admin_referer('AcuD_admin_nonce', 'AcuD_admin_nonce_field'))//обновление данных
{
    if (intval(sanitize_text_field($_POST['Acud_is_gratitude_OnThanks'])) == 1) {
        update_option('Acud_is_gratitude_OnThanks', 1);
    } else {
        update_option('Acud_is_gratitude_OnThanks', 0);
    }
$AcuD_is_update = 1;
}

if (isset($_GET["action"])) { //удаление ссылкой
    if ($_GET["action"] == "delete") {
        $wpdb->delete($wpdb->prefix . "acud_thank_names", array('id' => $_GET["pole"]));
    }
}
if ((isset($_POST['action']) && $_POST['action'] == 'delete')//удаление чек боксами
    || (isset($_POST['action2']) && $_POST['action2'] == 'delete')
) {
    foreach ($_POST['pole'] as $id) {
        $wpdb->delete($wpdb->prefix . "acud_thank_names", array('id' => $id));
    }

}
if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

?>
<?php

class Poles_Table extends WP_List_Table
{

    function extra_tablenav($which)
    {
        if ($which == "top") {
            //Код добавляет разметку до таблицы
            $this->search_box(__('Search','AcuD_transl'), 'search_id');
            echo "<h3>". __('All available fields.','AcuD_transl')."</h3>";

        }
        if ($which == "bottom") {
            //Код добавляет разметку после таблицы

        }
    }

    function get_bulk_actions()
    {
        $actions = array(
            'delete' => __('Delete','AcuD_transl')
        );
        return $actions;
    }

    function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="pole[]" value="%s" />', $item['id']
        );
    }

    function get_columns()
    {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'nameUser' => __('Name','AcuD_transl'),
            'text' =>__('Thanks','AcuD_transl') ,
            'Price' =>__('Donation amount','AcuD_transl') ,
            'success' => __('Is the payment successful?','AcuD_transl'),
            'from_url' => __('Donate page','AcuD_transl')
        );
        return $columns;
    }

    function prepare_items()
    {
        global $wpdb, $_wp_column_headers;
        $screen = get_current_screen();
        $per_page = 20;
        $current_page = $this->get_pagenum();
        $total_items = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->prefix . "acud_thank_names");

        /* -- Регистрируем колонки -- */
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = array();
        $this->_column_headers = array($columns, $hidden, $sortable);

        /* -- Выборка элементов -- */
        if (isset($_POST['s'])) {
            $itm = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "acud_thank_names WHERE nameUser LIKE '%" . $_POST['s'] . "%' || TEXT LIKE '%" . $_POST['s'] . "%' ORDER BY id DESC", ARRAY_A);

            foreach ($itm as &$suc) {
                if ($suc['success'] == "1") {
                    $suc['success'] = __('Yes', 'AcuD_transl');
                } else {
                    $suc['success'] = __('No', 'AcuD_transl');
                }
            }
            $this->items = $itm;
        } else {
            $this->set_pagination_args([
                'total_items' => $total_items, //WE have to calculate the total number of items
                'per_page' => $per_page //WE have to determine how many items to show on a page
            ]);
            $itm = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "acud_thank_names ORDER BY id DESC LIMIT " . $per_page . " OFFSET " . ($current_page - 1) * $per_page, ARRAY_A);

            foreach ($itm as &$suc) {
                if ($suc['success'] == "1") {
                    $suc['success'] = __('Yes', 'AcuD_transl');
                } else {
                    $suc['success'] = __('No', 'AcuD_transl');
                }
				switch($suc['Price'] ){
					case "item1": $suc['Price'] = get_option("AcuD_popUp_text_level_1");  break;
					case "item2": $suc['Price'] = get_option("AcuD_popUp_text_level_2"); break;
					case "item3": $suc['Price'] = get_option("AcuD_popUp_text_level_3"); break;
				}
				if ($suc['nameUser'] == "AcuD_unnamed"){
					$suc['nameUser'] = get_option('AcuD_unnamed_text');
				}
            }
            $this->items = $itm;
        }
    }

    function column_default($item, $column_name)
    {
        return $item[$column_name];
    }

    function column_nameUser($item)
    {
        $actions = array(
            'delete' => sprintf('<a href="?page=' . $_REQUEST['page'] . '&tab=' . $_REQUEST['tab'] . '&action=delete&pole=' . $item['id'] . '">'.__('delete', 'AcuD_transl').'</a>')
        );

        return sprintf('%1$s %2$s', $item['nameUser'], $this->row_actions($actions));
    }
}


$PolesTable = new Poles_Table();
$PolesTable->prepare_items();
echo '<form id="posts-filter" method="post">';
//$PolesTable->search_box('Поиск', 'search_id');
$PolesTable->display();
wp_nonce_field('AcuD_admin_nonce', 'AcuD_admin_nonce_field');
echo '</form>';
?>
<form action="" method=post enctype=multipart/form-data>
    <div style="width: 65%; margin: 2% 0">

        <?php wp_nonce_field('AcuD_admin_nonce', 'AcuD_admin_nonce_field'); ?>
        <table class="wp-list-table widefat fixed striped">
            <tbody>
            <tr>
                <td><span class="AcuD_ask"
                          title="<?php _e('If the checkbox is enabled, on the page "Thanks" show a link to the developer`s website. Otherwise, no. ', 'AcuD_transl'); ?>"><?php _e("Show link to developer's website on the \"Thanks\" page.", 'AcuD_transl'); ?></span>
                </td>
                <td><input name="Acud_is_gratitude_OnThanks" id="Acud_is_gratitude_OnThanks" type="checkbox"
                           value="1" <?php if (get_option('Acud_is_gratitude_OnThanks') == '1') echo 'checked'; ?>></td>
            </tr>
            </tbody>
        </table>
        <?php if($AcuD_is_update){ echo '<p style="color: #21ce21;">'.__('Updated','AcuD_transl').'</p>'; } ?>
        <p><input class="button-primary" type=submit value="<?php _e('Update', 'AcuD_transl'); ?>"></p><br>
    </div>
</form>