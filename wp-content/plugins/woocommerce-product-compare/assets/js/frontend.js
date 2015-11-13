jQuery( function( $ ) {


    function ffff($this){
        product_id =  $this.parent().parent().attr('product-id');

       // alert(product_id);
        $this.parent().parent().block({
            message: null,
            overlayCSS: {
                background: '#fff url(' + woocommerce_params.ajax_loader_url + ') no-repeat center',
                backgroundSize: '34px 34px',
                opacity: 0.6
            }
        });

        var data_ap = {
            action: 'be_compare_add_product',
            product: product_id
        };

        $.post(
            woocommerce_params.ajax_url,
            data_ap,
            function( response ) {

                $( '#compare-link-' + product_id ).replaceWith( response );

                var data_ub = {
                    action: 'be_compare_update_basket'
                };

                $.post(
                    woocommerce_params.ajax_url,
                    data_ub,
                    function( response ) {

                        $( 'div#compare-products-basket' ).replaceWith( response );

                    });

                $iop = $('.cr-i-check').iCheck('destroy').iCheck({checkboxClass: 'icheckbox_minimal-aero'});
               //  $('.cr-i-check').iCheck({checkboxClass: 'icheckbox_minimal-comp'});
                $iop.on('ifChanged', function(){
                    ffff($(this));

                });
            });
    }

    function ffff2($this){
        product_id =  $this.parent().parent().attr('product-id');

        // alert(product_id);
        $this.parent().parent().block({
            message: null,
            overlayCSS: {
                background: '#fff url(' + woocommerce_params.ajax_loader_url + ') no-repeat center',
                backgroundSize: '34px 34px',
                opacity: 0.6
            }
        });

        var data_ap = {
            action: 'be_compare_add_product',
            product: product_id
        };

        $.post(
            woocommerce_params.ajax_url,
            data_ap,
            function( response ) {

                $( '#compare-link-' + product_id ).replaceWith( response );

                var data_ub = {
                    action: 'be_compare_update_basket'
                };

                $.post(
                    woocommerce_params.ajax_url,
                    data_ub,
                    function( response ) {

                        $( 'div#compare-products-basket' ).replaceWith( response );

                    });

                $iap = $('.cr-i-check-full').iCheck('destroy').iCheck({checkboxClass: 'icheckbox_minimal-comp-full'});
                //  $('.cr-i-check').iCheck({checkboxClass: 'icheckbox_minimal-comp'});
                $iap.on('ifChanged', function(){
                    ffff2($(this));

                });
            });
    }

    // Process 'Add to Compare'
    $( document ).on( 'change', '.compare-product-link input', function(e) {
        e.preventDefault();

        product_id = jQuery( this ).parent().attr('product-id');

        alert(product_id);

        $( this ).parent().block({ message: null, overlayCSS: { background: '#fff url(' + woocommerce_params.ajax_loader_url + ') no-repeat center', backgroundSize: '16px 16px', opacity: 0.6 } });

        var data_ap = { action: 'be_compare_add_product', product: product_id };

        $.post( woocommerce_params.ajax_url, data_ap, function( response ) {

            $( '#compare-link-' + product_id ).replaceWith( response );

            var data_ub = { action: 'be_compare_update_basket' };

            $.post( woocommerce_params.ajax_url, data_ub, function( response ) {

                $( 'div#compare-products-basket' ).replaceWith( response );

            });

        });

        return;

    })

    // Trigger Basket Update after 'Add to Compare'
    $( document ).on( 'change', '.compare-product-link', function(e) {
        e.preventDefault();

        return;

    })

    // Delete single item from basket
    $( document ).on( 'click', '#compare-products-basket .compare-product-remove', function(e) {
        e.preventDefault();

        product_id = jQuery( this ).parent().attr('product-id');

        $( this ).parent().block({ message: null, overlayCSS: { background: '#fff url(' + woocommerce_params.ajax_loader_url + ') no-repeat center', backgroundSize: '16px 16px', opacity: 0.6 } });

        var data_ap = { action: 'be_compare_add_product', product: product_id };
        $.post( woocommerce_params.ajax_url, data_ap, function( response ) {

            $( '#compare-link-' + product_id ).replaceWith( response );

        });

        var data_ub = { action: 'be_compare_update_basket' };
        $.post( woocommerce_params.ajax_url, data_ub, function( response ) {

            $( 'div#compare-products-basket' ).replaceWith( response );

        });

        return;

    });

    // Clear all items in compare basket
    jQuery('#compare-products-basket .compare-clear-items a').live('click', function(e){
        e.preventDefault();

        // Reset any 'compare buttons' for active products
        jQuery( '.compare-product-link input:checked' ).each( function( index ) {

            product_id = jQuery(this).parent().attr('product-id');
            var inactive_html = '<input type="checkbox" id="compare-checkbox-' + product_id + '" />' +
                '<label for="compare-checkbox-' + product_id + '">' + be_compare_params.text_add_compare + '</label>';
            $( '#compare-link-' + product_id ).html( inactive_html );

        });

        var data_ap = { action: 'be_compare_empty_basket' };
        $.post( woocommerce_params.ajax_url, data_ap, function( response ) {

            $( 'div#compare-products-basket' ).replaceWith( response );

        });

    });

    // Show / Hide category details
    jQuery('.compare-products-button').live('click', function(){
        window.location.href = be_compare_params.compare_button_url;
        return false;
    });

    // Delete single item from compare table
    $( document ).on( 'click', '#be_compare_features_table .compare-product-remove', function(e) {
        e.preventDefault();

        product_id = jQuery( this ).parent().attr('product-id');
        var ndx = jQuery( this ).parent().index() + 1;

        $( this ).block({ message: null, overlayCSS: { background: '#fff url(' + woocommerce_params.ajax_loader_url + ') no-repeat center', backgroundSize: '16px 16px', opacity: 0.6 } });

        var data_ap = { action: 'be_compare_add_product', product: product_id };
        $.post( woocommerce_params.ajax_url, data_ap, function( response ) {

            // Find and remove all TH and TD elements with the same index
            //jQuery( "th:nth-child(" + ndx + "), td:nth-child(" + ndx + ")" ).animate({width: "0"}, 500, "linear", function() { jQuery( this ).remove(); });
            jQuery( "th:nth-child(" + ndx + "), td:nth-child(" + ndx + ")" ).fadeOut( 500, function() { jQuery( this ).remove(); });

        });

        return;

    });

    $iop = $('.cr-i-check').iCheck({checkboxClass: 'icheckbox_minimal-aero'});
    $iop.on('ifChanged', function(){
        ffff($(this));

    });

    $iap = $('.cr-i-check-full').iCheck({checkboxClass: 'icheckbox_minimal-comp-full'});
    $iap.on('ifChanged', function(){
        ffff2($(this));

    });

});
