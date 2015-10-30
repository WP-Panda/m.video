<?php
/**
 * Bolder Compare Products Table of Features
 *
 * @author      Bolder Elements
 * @category    Inc
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'BE_Compare_Table_Features' ) ) :

/*************************** LOAD THE BASE CLASS ********************************/

if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

/************************** CREATE A PACKAGE CLASS ******************************/

class BE_Compare_Table_Features extends WP_List_Table {

    function __construct( $args = array() ){
        global $status, $page;
                
        $args = wp_parse_args( $args, array(
            'features' => null,
        ) );

        //Set parent defaults
        parent::__construct( array(
            'singular'  => 'feat', 
            'plural'    => 'feats',
            'ajax'      => false,
            'features'  => $args['features']
        ) );

    }
    

    /**
     * Remove extra header information but add bulk actions
     */
    function extra_tablenav( $which ) { }
    function get_bulk_actions() {
        $actions = array(
            'delete'    => 'Delete'
        );
        return $actions;
    }
    

    /**
     * Text that appears when no features have been created
     */
    function no_items() { echo __( 'No features could be found.', 'be-compare-products') . " " . __( 'Create the first one under the Categories & Features section', 'be-compare-products' ) . "."; }
    function get_column_count() { return 3; }


    /**
     * If no function has been created for the given column ID
     */
    function column_ordering( $item ){ return '<span class="feature-sort"></span>'; }

    
    /**
     * Checkbox Column Data Output
     */
    function column_cb($item){
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            /*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("movie")
            /*$2%s*/ $item['id']                //The value of the checkbox should be the record's id
        );
    }


    /**
     * Title Column Data Output
     */
    function column_title( $item ){

        //Return the title contents
        return esc_attr( stripslashes( $item['title'] ) );
    }


    /**
     * Type Column Data Output
     */
    function column_type( $item ){

        switch ( $item['type'] ) {
            case 'text-input':
                $return = __( "Text Input", 'be-compare-products' );
                break;
            case 'text-area':
                $return = __( "Textarea", 'be-compare-products' );
                break;
            case 'bool':
                $return = __( "Yes / No", 'be-compare-products' );
                break;
            case 'single-select':
                $return = __( "Single Option", 'be-compare-products' );
                break;
            case 'multi-select':
                $return = __( "Multiple Options", 'be-compare-products' );
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
        
        return '<span class="feature-delete"></span><span class="feature-edit"></span>';
    }


    /**
     * If no function has been created for the given column ID
     */
    function column_default( $item, $column_name ) { return __( "Data Could Not Be Found", "be-compare-products" ); }


    /**
     * Array of column IDs
     */
    function get_columns(){
        $columns = array(
            'cb'        => '<input type="checkbox" />',
            'title'     => __( 'Feature', 'be-compare-products' ),
            'type'      => __( 'Type', 'be-compare-products' ),
            'links'     => '&nbsp',
        );
        return $columns;
    }

    /**
     * Array of sortable columns
     */
    function get_sortable_columns() {

        $sortable_columns = array(
            'title'     => array( 'title', true ),
            'type'      => array( 'type', false ),
        );
  
        return $sortable_columns;
    }

    /**
     * Determine how to sort data
     */
    function usort_reorder( $a, $b ) {

        // If no sort, default to title
        $orderby = ( ! empty( $_GET['orderby'] ) ) ? $_GET['orderby'] : 'title';
        // If no order, default to asc
        $order = ( ! empty($_GET['order'] ) ) ? $_GET['order'] : 'asc';
        // Determine sort order
        $result = strcmp( $a[$orderby], $b[$orderby] );

        // Send final sort direction to usort
        return ( $order === 'asc' ) ? $result : -$result;
    }
    
    function prepare_items() {
    global $wpdb, $_wp_column_headers;
    //$screen = get_current_screen();

    /* -- Preparing your query -- */
        extract( $this->_args );
        $data = $features;
        uasort( $data, array( &$this, 'usort_reorder' ) );
        $per_page = 25;

    /* -- Register the Columns --
        $columns = $this->get_columns();
        var_dump($screen);
        $_wp_column_headers[$screen->id]=$columns; */

    /* -- Fetch the items -- */

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        
        $this->_column_headers = array($columns, $hidden, $sortable);
        
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
        foreach ( $this->items as $key => $item )
            $this->single_row_alt( $item, $key );
    }

    function single_row_alt( $item, $key ) {
        static $row_class = '';
        $row_class = ( $row_class == '' ? ' class="alternate"' : '' );
        $item['id'] = $key;

        echo '<tr' . $row_class . ' feature-id="' . $key . '">';
        echo $this->single_row_columns( $item );
        echo '</tr>';
    }

    function cmp_by_order($a, $b) {
      return $a["order"] - $b["order"];
    }

    
    function process_bulk_action() {
        global $wpdb;

        extract( $this->_args );
        $features = $features;

        //Detect when a bulk action is being triggered...
        if( 'delete' === $this->current_action() ) {
            if(isset($_GET['zone']) && is_numeric($_GET['zone'])) :
                if(!array_key_exists($_GET['zone'], $shipping_zones)) 
                    echo "<div class=\"error\"><p>".__('A zone with the ID provided does not exist', 'be_table_rate').".</p></div>";
                else {
                    $zone_title = $shipping_zones[$_GET['zone']]['zone_title'];
                    unset($shipping_zones[$_GET['zone']]);
                    update_option('be_woocommerce_shipping_zones', $shipping_zones);
                    echo "<div class=\"updated\"><p>".__("The zone titled <strong>".$zone_title."</strong> has been deleted",'be_table_rate').".</p></div>";
                }
            endif;
        }
    }
}

endif;