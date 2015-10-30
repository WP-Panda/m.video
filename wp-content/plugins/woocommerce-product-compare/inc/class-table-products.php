<?php
/**
 * Bolder Compare Products Table of Categories
 *
 * @author      Bolder Elements
 * @category    Inc
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'BE_Compare_Table_Products' ) ) :

/*************************** LOAD THE BASE CLASS ********************************/

if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

/************************** CREATE A PACKAGE CLASS ******************************/

class BE_Compare_Table_Products extends WP_List_Table {

    function __construct( $args = array() ){
        global $status, $page;
                
        //Set parent defaults
        parent::__construct( array(
            'singular'  => 'compare_product', 
            'plural'    => 'compare_products',
            'ajax'      => false
        ) );

    }
    

    /**
     * Show pagination but no bulk actions
     */
    function display_tablenav( $which ) {
?>
    <div class="tablenav <?php echo esc_attr( $which ); ?>">

<?php
        $this->pagination( $which );
?>

        <br class="clear" />
    </div>
<?php
    }
    function extra_tablenav( $which ) { }
    function get_bulk_actions() { }
    

    /**
     * Text that appears when no subcategories have been created
     */
    function no_items() { _e( 'No products have been added yet.' ); echo ' <a href="' . get_admin_url() . '/edit.php?post_type=product">' . __( 'View Products', 'be-compare-products' ) . '</a>'; }


    /**
     * Title Column Data Output
     */
    function column_title( $item ){

        //Return the title contents
        return $item[ 'title' ];
    }


    /**
     * Product Category Column Data Output
     */
    function column_cat_prod( $item ){

        // Return the product categories
        return $item[ 'cat_prod' ];
    }


    /**
     * Compare Category Column Data Output
     */
    function column_cat_comp( $item ){

        // Find categories
        return $item[ 'cat_comp' ];
    }


    /**
     * Compare Category Column Data Output
     */
    function column_status( $item ){

        // Find categories
        return $item[ 'status' ];
    }


    /**
     * Title Column Data Output
     */
    function column_links( $item ){
        return $item[ 'links' ];
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
            //'cb'        => '&nbsp;',
            'title'         => __( 'Product', 'be-compare-products' ),
            'cat_prod'      => __( 'Product Category', 'be-compare-products' ),
            'cat_comp'      => __( 'Compare Category', 'be-compare-products' ),
            'status'        => __( 'Status', 'be-compare-products' ),
            'links'         => __( 'Ссылка', 'be-compare-products' ),
        );
        return $columns;
    }

    /**
     * Array of sortable columns
     */
    function get_sortable_columns() {

        $sortable_columns = array(
            'title'         => array( 'title', true ),
            'cat_prod'      => array( 'cat_prod', false ),
            'cat_comp'      => array( 'cat_comp', false ),
            'status'        => array( 'status', false ),
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

    /**
     * Setup which products are displayed on the current page
     */
    function prepare_items() {
    global $wpdb, $_wp_column_headers;
    $screen = get_current_screen();

    /* -- Preparing your query -- */
        $data = array();
        $args = array( 'post_type' => 'product', 'posts_per_page' => -1 );
        $products = get_posts( $args ); 

        if( $products ) {
            foreach( $products as $pid => $product ) {
                // Find categories
                $cats = array();
                $terms = get_the_terms( $product->ID, 'product_cat' );

                if( $terms ) {
                    foreach( $terms as $key => $value)
                        $cats[] = $value->name;
                    sort( $cats );
                    $cat_prod = implode( ', ', $cats );
                } else $cat_prod = __( 'No Categories', 'be-compare-products' );

                // Retrieve compare category
                $categories = get_option( 'be_compare_categories' );
                $cat_comp = ( isset( $categories[ get_post_meta( $product->ID, 'selcat_compare_product', true ) ] ) ) ? $categories[ get_post_meta( $product->ID, 'selcat_compare_product', true ) ]['title'] : '';

                $data[ $pid ] = array(
                    'ID'     => $product->ID,
                    'title'     => $product->post_title,
                    'cat_prod'  => $cat_prod,
                    'cat_comp'  => $cat_comp,
                    'status'    => ( get_post_meta( $product->ID, 'enable_compare_product', true ) == 'yes' ) ? '<span class="compare-active">'  . __( 'Active', 'be-compare-products' ) . '</span>' : '<span class="compare-inactive">'  . __( 'Inactive', 'be-compare-products' ) . '</span>',
                    'links'     => '<a href="#" class="compare-product-edit" data-id="'. $product->ID .'" data-title="'. $product->post_title .'">Edit</a>'
                    );
            }
        }

        usort( $data, array( &$this, 'usort_reorder' ) );
        $per_page = 25;

    /* -- Register the Columns -- */
        $columns = $this->get_columns();
        $_wp_column_headers[$screen->id]=$columns;

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
    function single_row( $item ) {
        static $row_class = '';
        $row_class = ( $row_class == '' ? ' class="alternate"' : '' );

        echo '<tr' . $row_class . ' product-id="' . $item['ID'] . '">';
        echo $this->single_row_columns( $item );
        echo '</tr>';
    }

}

endif;