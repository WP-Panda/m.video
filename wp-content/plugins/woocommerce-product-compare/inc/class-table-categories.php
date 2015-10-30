<?php
/**
 * Bolder Compare Products Table of Categories
 *
 * @author      Bolder Elements
 * @category    Inc
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'BE_Compare_Table_Categories' ) ) :

/*************************** LOAD THE BASE CLASS ********************************/

if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

/************************** CREATE A PACKAGE CLASS ******************************/

class BE_Compare_Table_Categories extends WP_List_Table {
    public $counter;

    function __construct( $args = array() ){
        global $status, $page;

        $this->counter = 999;
                
        $args = wp_parse_args( $args, array(
            'key' => null,
            'cat' => null,
            'screen' => null,
        ) );

        $GLOBALS['hook_suffix'] = 'woocommerce_page_be-compare-products';

        //Set parent defaults
        parent::__construct( array(
            'singular'  => 'cat', 
            'plural'    => 'cats',
            'ajax'      => false,
            'screen'    => $args['screen'],
            'cat_key'   => $args['key'],
            'cat'       => $args['cat']
        ) );

    }
    

    /**
     * Do NOT alter table headers & no bulk actions
     */
    function display_tablenav( $which ) { }
    function extra_tablenav( $which ) { }
    function get_bulk_actions() { }
    

    /**
     * Text that appears when no subcategories have been created
     */
    function no_items() { _e( 'No fields were found for this subcategory', 'be-compare-products' ); }
    function get_column_count() { return 3; }
    

    /**
     * Alter row structure
     */
    function display_rows_or_placeholder() {
        if ( $this->has_items() ) {
            $this->display_rows();
        } else {
            list( $columns, $hidden ) = $this->get_column_info();
            echo '<tr class="no-items"><td colspan="' . $this->get_column_count() . '">';
            $this->no_items();
            echo '</td></tr>';
        }
    }


    /**
     * If no function has been created for the given column ID
     */
    function column_ordering( $item ){ return '<span class="feature-sort"></span>'; }


    /**
     * Title Column Data Output
     */
    function column_title( $item ){

        //Return the title contents
        if( is_object( $item ) )
            return esc_attr( stripslashes( $item->attribute_label ) );

        return esc_attr( stripslashes( $item['title'] ) );
    }


    /**
     * Type Column Data Output
     */
    function column_type( $item ){

        if( is_object( $item ) && isset( $item->attribute_id ) )
            return __( "WooCommerce Attribute", "be-compare-products" );

        switch ( $item['type'] ) {
            case 'text-input':
                $return = __( "Text Input", "be-compare-products" );
                break;
            case 'text-area':
                $return = __( "Textarea", "be-compare-products" );
                break;
            case 'bool':
                $return = __( "Yes", "be-compare-products" ) . " / " . __( "No", "be-compare-products" );
                break;
            case 'single-select':
                $return = __( "Single Option", "be-compare-products" );
                break;
            case 'multi-select':
                $return = __( "Multiple Options", "be-compare-products" );
                break;
            
            default:
                $return = "";
                break;
        }

        return $return;
    }


    /**
     * Title Column Data Output
     */
    function column_links( $item ){
        
        return '<span class="feature-delete"></span>';
    }


    /**
     * If no function has been created for the given column ID
     */
    function column_default( $item, $column_name ){ return "Data Could Not Be Found"; }


    /**
     * Array of column IDs
     */
    function get_columns(){
        $columns = array(
            'ordering'  => '&nbsp;',
            'title'     => __( 'Feature', 'be-compare-products' ),
            'type'      => __( 'Type', 'be-compare-products' ),
            'links'     => '&nbsp',
        );
        return $columns;
    }
    
    function prepare_items() {
    global $wpdb, $_wp_column_headers;

    /* -- Preparing your query -- */
        uasort( $this->items, array( $this, 'cmp_by_order' ) );
        $data = array();
        $features = get_option( "be_compare_features" );
        $attributes = wc_get_attribute_taxonomies();
        if( $features ) {
            $itemAr = ( isset( $this->items ) && is_array( $this->items ) ) ? $this->items : array();
            foreach ($itemAr as $featID => $feat) {
                if( array_key_exists( $featID, $features ) )
                    $data[ $featID ] = $features[ $featID ];

                elseif( strstr( $featID, 'attr_' ) ) {
                    // find WC attribute
                    $attr_id = str_replace( 'attr_', '', $featID, $temp = 1 );
                    $result = array_search( $attr_id, array_map( array( $this, 'map_attribute_id' ), $attributes ) );
                    if( $result !== false )
                        $data[ $featID ] = $attributes[ $result ];
                }
            }
        }
        $per_page = 9999;

    /* -- Register the Columns -- */
        $columns = $this->get_columns();
        //if( !empty( $screen ) ) $_wp_column_headers[$screen->id]=$columns;

    /* -- Fetch the items -- */

        $columns = $this->get_columns();
        $hidden = array();
        
        $this->_column_headers = array($columns, $hidden, false);
        
        $current_page = $this->get_pagenum();
        $total_items = count($data);
        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);
        $this->items = $data;
        
    /* -- Register the pagination -- */
        
        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
        ) );

    }

    /**
     * add feature ID to single_row options
     */
    function display_rows() {
        foreach ( $this->items as $key=> $item )
            $this->single_row_alt( $item, $key );
    }

    function single_row_alt( $item, $key ) {
        static $row_class = '';
        $row_class = ( $row_class == '' ? ' class="alternate"' : '' );

        echo '<tr' . $row_class . ' feature-id="' . $key . '">';
        echo $this->single_row_columns( $item );
        echo '</tr>';
    }


    /**
     * array_map function to return attribute_id
     */
    function map_attribute_id( $element ){ return $element->attribute_id; }

    /**
     * Display the table
     *
     * @since 3.1.0
     * @access public
     */
    function display() {
        //extract( $this->_args );
        $cat = $this->_args['cat'];
        $cat_key = $this->_args['cat_key'];

?>
<div id="category-table-<?php echo $cat_key; ?>" class="category-table-container" category-id="<?php echo $cat_key; ?>">
    <div class="category-headline">
        <span class="category-show down"></span>
        <?php echo $cat['title']; ?>
        <span class="category-delete"></span>
    </div>
    <?php $this->display_category_info( $cat, $cat_key ); ?>
</div>
<?php
    }

    function display_category_info( $cat, $cat_key ) {
?>

<table class="wp-list-table <?php echo implode( ' ', $this->get_table_classes() ); ?>">
    <tbody id="the-list"<?php if ( isset( $singular ) ) echo " data-wp-lists='list:$singular'"; ?>>

<?php if( $cat['sub_cats'] && count( $cat['sub_cats'] ) ) : ?>

    <?php uasort( $cat['sub_cats'], array( $this, 'cmp_by_order' ) ); foreach( $cat['sub_cats'] as $key => $sub ) : ?>

        <tr class="row-subcategory" subcategory-id="<?php echo $key; ?>">
            <td><span class="reorder"></span></td>
            <td class="no-padding">
                <table class="subcategory-info">
                    <tbody>
                        <tr class="subcategory-title">
                            <th>
                                <?php echo esc_attr( stripslashes( $sub['title'] ) ); ?>
                                <span class="links" subcat-id="<?php echo $key; ?>">
                                    <a href="#" class="feature-new"><?php _e( 'Add Feature', 'be-compare-products' ); ?></a> |
                                    <a href="#" class="subcategory-delete"><?php _e( 'Delete', 'be-compare-products' ); ?></a>
                                </span>
                            </th>
                        </tr>
                        <tr>
                            <td class="subcategory_features">
                                <table class="subcategory_features-table" subcategory-id="<?php echo $key; ?>">
                                    <?php $this->items = $sub['features']; $this->prepare_items(); $this->display_rows_or_placeholder(); ?>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>

    <?php endforeach; ?>

<?php else: ?>
        <tr><td colspan="2"><?php _e( 'No subcategories could be found.', 'be-compare-products' ); ?></td></tr>
<?php endif; ?>

    </tbody>
    <tfoot>
    <tr>
        <td colspan="2"><a href="#" class="add button sub-category" category-id="<?php echo $cat_key; ?>"><?php _e( 'Add New Subcategory', 'be-compare-products' ); ?></a></td>
    </tr>
    </tfoot>
</table>

<?php
    }

    function cmp_by_order($a, $b) {
        // Adjust so new items are left at the bottom of the list (not the top)
        if( !isset( $b["order"] ) ) $b["order"] = ++$this->counter;
        if( !isset( $a["order"] ) ) $a["order"] = ++$this->counter;
        return $a["order"] - $b["order"];
    }
}

endif;