<?php
$meta_basics = get_post_meta( $post->ID, 'basics', true );
$data = isset( $meta_basics['data'] ) ? $meta_basics['data'] : false;

?>

<?php
    /**
     * To Get Category List of WooCommerce
     * @since 1.0.0 -10
     */
    $args = array(
        'hide_empty'    => false, 
        'orderby'       => 'count',
        'order'         => 'DESC',
    );

    //WooCommerce Product Category Object as Array
    $wpt_product_cat_object = get_terms('product_cat', $args);
?>

<div class="section ultraaddons-panel">
    <div class="wpt_column">
        <table class="ultraaddons-table">
            <?php
        $args = array(
            'hide_empty'    => false, 
            'orderby'       => 'count',
            'order'         => 'DESC',
        );
        foreach( $supported_terms as $key => $each ){
            $term_key = $key;
            $term_name = $each;
            $term_obj = get_terms( $term_key, $args );
            
            $selected_term_ids = isset( $data['terms'][$term_key] ) && !empty( $data['terms'][$term_key] ) ? $data['terms'][$term_key] : false;
            ?>
            <tr>
                <th><label for="wpt_term_<?php echo esc_attr( $term_key ); ?>"><?php echo esc_html( $term_name ); ?> Include</label></th>
                <td class="">

                    <?php
                    $options_item = esc_html( 'None ', 'wpt' ) . $term_name;
                    $options_item = "<option value=''>{$options_item}</option>";
                    $options_item = ""; //REmoved Default None Value
                    if( is_array( $term_obj ) && count( $term_obj ) > 0 ){
                        $selected_term_ids = isset( $data['terms'][$term_key] ) ? $data['terms'][$term_key] : false;
                        foreach ( $term_obj as $terms ) {
                            $selected = is_array( $selected_term_ids ) && in_array( $terms->term_id,$selected_term_ids ) ? 'selected' : false;
                            $options_item .= "<option value='{$terms->term_id}' {$selected}>{$terms->name} ({$terms->count})</option>";
                        }
                    }

                    if( !empty( $options_item ) ){
                    ?>
                    <select name="basics[data][terms][<?php echo esc_attr( $term_key ); ?>][]" class="wpt_select2 wpt_query_terms ua_query_terms_<?php echo esc_attr( $term_key ); ?> ua_select" id="wpt_term_<?php echo esc_attr( $term_key ); ?>" multiple="multiple">
                        <?php echo $options_item; ?>
                    </select>
                    
                    <?php    
                    }else{
                        echo esc_html( "No item for {$term_name}", 'wpt_pro' );
                    }
                    
                    
                    ?>

                </td>
            </tr>    
            <?php
        }
        ?>
        </table>
    </div>

<?php 
do_action( 'wpo_pro_feature_message', 'under_taxonomy_includes' );
/**
 * To add something 
 */
do_action( 'wpto_admin_basic_tab',$meta_basics, $tab, $post, $tab_array ); 
?>



    <div class="wpt_column">
        <table class="ultraaddons-table">
            <tr>
                <th>
                    <label class="wpt_label" for="wpt_product_cat_excludes"><?php echo esc_html__( 'Category Exclude', 'wpt_pro' );?></label>
                </th>
                <td>
                    <select name="basics[cat_explude][]" data-name="cat_explude" id="wpt_product_cat_excludes" class="wpt_fullwidth wpt_data_filed_atts ua_select wpt_select2" multiple>
                        <?php
                        foreach ( $wpt_product_cat_object as $category ) {
                            echo "<option value='{$category->term_id}' " . ( isset( $meta_basics['cat_explude'] ) && is_array( $meta_basics['cat_explude'] ) && in_array( $category->term_id, $meta_basics['cat_explude'] ) ? 'selected' : false ) . ">{$category->name} - {$category->slug} ({$category->count})</option>";
                        }
                        ?>
                    </select>
                    <p><?php echo esc_html__( 'Click to choose. Selected Categories products will be exclude from your table.', 'wpt_pro') ?></p>
                </td>
            </tr>
        </table>
    </div>



<?php
    do_action( 'wpo_pro_feature_message', 'pf_product_includes_by_id' );
    $wpt_product_ids_tag = false;
    /**
     * To Get Category List of WooCommerce
     * @since 1.0.0 -10
     */
    $args = array(
        'hide_empty' => true,
        'orderby' => 'count',
        'order' => 'DESC',
    );

    //WooCommerce Product Category Object as Array
    $wpt_product_tag_object = get_terms('product_tag', $args);
?>


    <div class="wpt_column">
        <table class="ultraaddons-table">
            <tr>
                <th>
                    <label class="wpt_label wpt_table_ajax_action" for='wpt_table_ajax_enable'><?php esc_html_e('Ajax Action (Enable/Disable)','wpt_pro');?></label>
                </th>
                <td>
                    <select name="basics[ajax_action]" data-name='ajax_action' id="wpt_table_ajax_enable" class="wpt_fullwidth wpt_data_filed_atts ua_input" >
                        <option value="ajax_active" <?php echo isset( $meta_basics['ajax_action'] ) && $meta_basics['ajax_action'] == 'ajax_active' ? 'selected' : false; ?>><?php esc_html_e('Active Ajax (Default)','wpt_pro');?></option>
                        <option value="no_ajax_action" <?php echo isset( $meta_basics['ajax_action'] ) && $meta_basics['ajax_action'] == 'no_ajax_action' ? 'selected' : false; ?>><?php esc_html_e('Disable Ajax Action','wpt_pro');?></option>
                    </select>
                </td>
            </tr>
        </table>
    </div>
    
    <div class="wpt_column">
        <table class="ultraaddons-table">
            <tr>
                <th>
                    <label class="wpt_label wpt_table_ajax_action" for='wpt_table_ajax_pagination'><?php esc_html_e('Ajax for Pagination (Enable/Disable)','wpt_pro');?></label>
                </th>
                <td>
                    <select name="basics[pagination_ajax]" data-name='pagination_ajax' id="wpt_table_ajax_pagination" class="wpt_fullwidth wpt_data_filed_atts ua_input" >
                        <option value="pagination_ajax" <?php echo isset( $meta_basics['pagination_ajax'] ) && $meta_basics['pagination_ajax'] == 'pagination_ajax' ? 'selected' : false; ?>><?php esc_html_e('Ajax Pagination (Default)','wpt_pro');?></option>
                        <option value="no_pagination_ajax" <?php echo isset( $meta_basics['pagination_ajax'] ) && $meta_basics['pagination_ajax'] == 'no_pagination_ajax' ? 'selected' : false; ?>><?php esc_html_e('Disable Ajax Pagination','wpt_pro');?></option>
                    </select>                   
                </td>
            </tr>
        </table>
    </div>

    <div class="wpt_column">
        <table class="ultraaddons-table">
            <tr>
                <th>
                    <label class="wpt_label" for='wpt_table_minicart_position'><?php esc_html_e( 'Mini Cart Position', 'wpt_pro' );?></label>
                </th>
                <td>
                    <select name="basics[minicart_position]" data-name='minicart_position' id="wpt_table_minicart_position" class="wpt_fullwidth wpt_data_filed_atts ua_input" >
                        <option value="top" <?php echo isset( $meta_basics['minicart_position'] ) && $meta_basics['minicart_position'] == 'top' ? 'selected' : false; ?>><?php esc_html_e( 'Top (Default)', 'wpt_pro' );?></option>
                        <option value="bottom" <?php echo isset( $meta_basics['minicart_position'] ) && $meta_basics['minicart_position'] == 'bottom' ? 'selected' : false; ?>><?php esc_html_e( 'Bottom', 'wpt_pro');?></option>
                        <option value="none" <?php echo isset( $meta_basics['minicart_position'] ) && $meta_basics['minicart_position'] == 'none' ? 'selected' : false; ?>><?php esc_html_e( 'None', 'wpt_pro' );?></option>
                    </select>
                </td>
            </tr>
        </table>
    </div>
    
    <!-- **************COMES FROM COLUMN SETTING TAB, NAME HAS NOT CHANGED YET****************** -->
    <div class="wpt_column">
        <table class="ultraaddons-table">
            <tr>
                <th>
                    <label style="display: inline;width: inherit;" class="wpt_label wpt_column_hide_unhide_tab" for="wpt_table_head_enable"><?php esc_html_e( 'Table Head', 'wpt_pro' );?></label>
                </th>
                <td>
                    <label class="switch">
                        <input  name="column_settings[table_head]" type="checkbox" id="wpt_table_head_enable" <?php echo isset( $column_settings['table_head'] ) ? 'checked="checked"' : ''; ?>>
                        <div class="slider round"><!--ADDED HTML -->
                            <span class="on">Hide</span><span class="off">Show</span><!--END-->
                        </div>
                    </label>
                    
                                    
                </td>
            </tr>
        </table>
    </div>
    <!-- **************COMES FROM COLUMN SETTING TAB, NAME HAS NOT CHANGED YET****************** -->
    
    
    <!-- **************COMES FROM PAGINATION TAB, NAME HAS NOT CHANGED YET****************** -->
    <?php
    $pagination =  get_post_meta( $post->ID, 'pagination', true );
    ?>
        <div class="wpt_column">
            <table class="ultraaddons-table">
                <tr>
                    <th>
                        <label class="wpt_label" for="wpt_table_pagination_enable"><?php esc_html_e( 'Pagination on/of', 'wpt_pro' ); ?></label>
                    </th>
                    <td>
                        <select name="pagination[start]" data-name='sort' id="wpt_table_pagination_enable" class="wpt_fullwidth wpt_data_filed_atts ua_input" >

                            <option value="1" <?php echo isset( $pagination['start'] ) && $pagination['start'] == '1' ? 'selected' : ''; ?>><?php esc_html_e( 'Enable (Default)', 'wpt_pro' ); ?></option>
                            <option value="0" <?php echo isset( $pagination['start'] ) && $pagination['start'] == '0' ? 'selected' : ''; ?>><?php esc_html_e( 'Disable', 'wpt_pro' ); ?></option>
                        </select>
                        <p><?php esc_html_e( 'To change style, go to Design tab', 'wpt_pro' ); ?></p>
                    </td>
                </tr>
            </table>
        </div>

    <!-- **************COMES FROM PAGINATION TAB, NAME HAS NOT CHANGED YET****************** -->
    
    
    
    

    <div class="wpt_column">
        <table class="ultraaddons-table">
            <tr>
                <th>
                    <label class="wpt_label" for='wpt_table_table_class'><?php esc_html_e( 'Set a Class name for Table', 'wpt_pro' );?></label>
                </th>
                <td>
                    <input name="basics[table_class]" value="<?php echo isset( $meta_basics['table_class'] ) ? $meta_basics['table_class'] : ''; ?>" class="wpt_data_filed_atts ua_input" data-name="table_class" type="text" placeholder="<?php esc_attr_e( 'Product Table Class Name (Optional)', 'wpt_pro' ); ?>" id='wpt_table_table_class'>
                </td>
            </tr>
        </table>
    </div>


    <!-- Convert as Hidden Number the Temporary number -->
    <input name="basics[temp_number]" data-name="temp_number" type="hidden" placeholder="123" id='wpt_table_temp_number' value="<?php echo isset( $meta_basics['temp_number'] ) ? $meta_basics['temp_number'] : random_int( 10, 600 ); ?>" readonly="readonly">

    <div class="wpt_column">
        <table class="ultraaddons-table">
            <tr>
                <th>
                    <label class="wpt_label" for="wpt_table_add_to_cart_text"><?php esc_html_e( '(Add to cart) Text', 'wpt_pro' );?></label>
                </th>
                <td>
                    <input name="basics[add_to_cart_text]" class="wpt_data_filed_atts ua_input" data-name="add_to_cart_text" type="text" value="<?php echo isset( $meta_basics['add_to_cart_text'] ) ? $meta_basics['add_to_cart_text'] : __( 'Add to cart', 'wpt_pro' ); ?>" placeholder="<?php esc_attr_e( 'Example: Buy', 'wpt_pro' ); ?>" id="wpt_table_add_to_cart_text">
                    <p><?php echo sprintf( esc_html__( 'Put a Space (" ") for getting default %s Add to Cart Text %s', 'wpt_pro' ), '<b>', '</b>' );?></p>
                </td>
            </tr>
        </table>
    </div>
    
    <?php do_action( 'wpo_pro_feature_message', 'pf_bulk_add_to_cart' ); ?>
    <?php do_action( 'wpo_pro_feature_message', 'pf_authorid_username_type' ); ?>
    <?php do_action( 'wpto_admin_basic_tab_bottom', $meta_basics, $tab, $post, $tab_array ); ?>
</div>