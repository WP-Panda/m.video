// Add functionality to Bolder Compare Products settings form
(function($) {
    $(document).ready(function () {

        // Hide popup window on cancel
        jQuery('.be-popup-container .cancel').live('click', function () {
            jQuery('.be-compare-popup').remove();
            return false;
        });

        /**
         * Вызов формы создания новой категории продуктов
         */
        $(document).on('click', '#be-compare-cat-tables a.add.category', function (e) {

            e.preventDefault();

            var $create_form =
                '<div id="be-compare-new-category" class="be-compare-popup">' +
                '<div class="be-popup-container add_form" id="be-compare-new-category-form">' +
                '<form method="post">' +
                '<p><label for="cat_id">' + be_compare_data.text_new_category + '</label></p>' +
                '<p><span>' + be_compare_data.text_new_category_desc + '</span></p>' +
                '<p><input type="text" name="cat_id" id="cat_id" /></p>' +
                '<p><input type="submit" name="submit" value="' + be_compare_data.text_add_new + '" class="form_submit" /> <a href="#" class="cancel">' + be_compare_data.text_cancel + '</a></p>' +
                '</form>' +
                '</div>' +
                '</div>';

            //insert lightbox HTML into page
            $('body').append($create_form);
            becpwc_doBoxSize();

        });

        /**
         * Создание новой категории продуктов
         */
        $(document).on('submit', '#be-compare-new-category-form', function (e) {
            e.preventDefault();

            var $inputTitle = $('#be-compare-new-category #cat_id').val();

            if ($inputTitle) {

                $(this).block({
                    message: null,
                    overlayCSS: {
                        background: '#fff url(' + be_compare_data.ajax_loader_url + ') no-repeat center',
                        backgroundSize: '32px 32px',
                        opacity: 0.6
                    }
                });

                var $data = {
                    action: 'be_compare_add_category',
                    title: $inputTitle
                };

                $.post(ajaxurl, $data, function ($response) {

                    $('#be-compare-cat-tables').replaceWith($response);
                    $('#be-compare-new-category').remove();
                    becpwc_doSort();
                    var $message_div = becpwc_message();
                    becpwc_message_update($message_div, 'success');

                });

            } else {

                $('#be-compare-new-category').remove();
                var $message_div = becpwc_message();
                becpwc_message_update($message_div, 'error');

            }

            return false;

        });



        // Show / Hide category details
        jQuery('.category-table-container .category-show').live('click', function (e) {

            if (jQuery(this).hasClass('down')) {
                jQuery(this).closest('.category-table-container').find('.wp-list-table').show();
                jQuery(this).removeClass('down');
            } else {
                jQuery(this).closest('.category-table-container').find('.wp-list-table').hide();
                jQuery(this).addClass('down');
            }

        });

        // Delete category button
        jQuery('.category-table-container .category-delete').live('click', function () {

            cat_id = jQuery(this).parent().parent().attr('category-id');

            var create_form =
                '<div id="be-compare-delete-category" class="be-compare-popup">' +
                '<div class="be-popup-container add_form" id="be-compare-delete-category-form">' +
                '<form method="post">' +
                '<input type="hidden" name="cat_id" id="cat_id" value="' + cat_id + '" />' +
                '<p><label for="cat_id">' + be_compare_data.text_del_category + '?</label></p>' +
                '<p><span><strong>' + be_compare_data.text_del_category_desc + '!</strong></span></p>' +
                '<p><input type="submit" name="submit" value="' + be_compare_data.text_delete + '" class="form_submit" /> <a href="#" class="cancel">' + be_compare_data.text_cancel + '</a></p>' +
                '</form>' +
                '</div>' +
                '</div>';

            //insert lightbox HTML into page
            jQuery('body').append(create_form);
            becpwc_doBoxSize();

        });

        // Create, Save, and Display list after deleting category
        jQuery('#be-compare-delete-category-form').live('submit', function (e) {
            e.preventDefault();

            var inputID = jQuery('#be-compare-delete-category #cat_id').val();

            if (inputID) {

                $(this).block({
                    message: null,
                    overlayCSS: {
                        background: '#fff url(' + be_compare_data.ajax_loader_url + ') no-repeat center',
                        backgroundSize: '32px 32px',
                        opacity: 0.6
                    }
                });

                var data = {action: 'be_compare_delete_category', cid: inputID};

                $.post(ajaxurl, data, function (response) {

                    jQuery('#be-compare-cat-tables').replaceWith(response);
                    jQuery('#be-compare-delete-category').remove();
                    becpwc_doSort();
                    var message_div = becpwc_message();
                    becpwc_message_update(message_div, 'success');

                });
            } else {
                jQuery('#be-compare-delete-category').remove();
                var message_div = becpwc_message();
                becpwc_message_update(message_div, 'error');
            }

            return false;
        });

        // Create new subcategory button
        jQuery('#be-compare-cat-tables a.add.sub-category').live('click', function (e) {

            //prevent default action (hyperlink)
            e.preventDefault();

            cat_id = jQuery(this).attr('category-id');

            var create_form =
                '<div id="be-compare-new-subcategory" class="be-compare-popup">' +
                '<div class="be-popup-container add_form" id="be-compare-new-subcategory-form">' +
                '<form method="post">' +
                '<input type="hidden" name="cat_id" id="cat_id" value="' + cat_id + '" />' +
                '<p><label for="sub_title">' + be_compare_data.text_new_subcategory + '</label></p>' +
                '<p><span>' + be_compare_data.text_new_subcategory_desc + '</span></p>' +
                '<p><input type="text" name="sub_title" id="sub_title" /></p>' +
                '<p><input type="submit" name="submit" value="' + be_compare_data.text_add_new + '" class="form_submit" /> <a href="#" class="cancel">' + be_compare_data.text_cancel + '</a></p>' +
                '</form>' +
                '</div>' +
                '</div>';

            //insert lightbox HTML into page
            jQuery('body').append(create_form);
            becpwc_doBoxSize();

        });

        // Create, Save, and Display new subcategory
        jQuery('#be-compare-new-subcategory-form').live('submit', function (e) {
            e.preventDefault();

            var catID = jQuery('#be-compare-new-subcategory #cat_id').val();
            var subTitle = jQuery('#be-compare-new-subcategory #sub_title').val();

            if (subTitle && catID) {

                $(this).block({
                    message: null,
                    overlayCSS: {
                        background: '#fff url(' + be_compare_data.ajax_loader_url + ') no-repeat center',
                        backgroundSize: '32px 32px',
                        opacity: 0.6
                    }
                });

                var data = {action: 'be_compare_add_subcategory', cat_id: catID, title: subTitle};

                $.post(ajaxurl, data, function (response) {

                    jQuery('#category-table-' + catID + ' .wp-list-table').replaceWith(response);
                    jQuery('#category-table-' + catID + ' .wp-list-table').show();
                    jQuery('#be-compare-new-subcategory').remove();
                    becpwc_doSort();
                    var message_div = becpwc_message();
                    becpwc_message_update(message_div, 'success');

                });
            } else {
                jQuery('#be-compare-new-subcategory').remove();
                var message_div = becpwc_message();
                becpwc_message_update(message_div, 'error');
            }

            return false;
        });

        // Delete subcategory button
        jQuery('.category-table-container .subcategory-delete').live('click', function () {

            cat_id = jQuery(this).closest('.category-table-container').attr('category-id');
            sub_id = jQuery(this).parent().attr('subcat-id');

            var create_form =
                '<div id="be-compare-delete-subcategory" class="be-compare-popup">' +
                '<div class="be-popup-container add_form" id="be-compare-delete-subcategory-form">' +
                '<form method="post">' +
                '<input type="hidden" name="cat_id" id="cat_id" value="' + cat_id + '" />' +
                '<input type="hidden" name="cat_id" id="sub_id" value="' + sub_id + '" />' +
                '<p><label for="cat_id">' + be_compare_data.text_del_subcategory + '?</label></p>' +
                '<p><span><strong>' + be_compare_data.text_del_category_desc + '!</strong></span></p>' +
                '<p><input type="submit" name="submit" value="' + be_compare_data.text_delete + '" class="form_submit" /> <a href="#" class="cancel">' + be_compare_data.text_cancel + '</a></p>' +
                '</form>' +
                '</div>' +
                '</div>';

            //insert lightbox HTML into page
            jQuery('body').append(create_form);
            becpwc_doBoxSize();

        });

        // Create, Save, and Display list after deleting subcategory
        jQuery('#be-compare-delete-subcategory-form').live('submit', function (e) {
            e.preventDefault();

            var catID = jQuery('#be-compare-delete-subcategory #cat_id').val();
            var subID = jQuery('#be-compare-delete-subcategory #sub_id').val();

            if (catID && subID) {

                $(this).block({
                    message: null,
                    overlayCSS: {
                        background: '#fff url(' + be_compare_data.ajax_loader_url + ') no-repeat center',
                        backgroundSize: '32px 32px',
                        opacity: 0.6
                    }
                });

                var data = {action: 'be_compare_delete_subcategory', cat_id: catID, sub_id: subID};

                $.post(ajaxurl, data, function (response) {

                    jQuery('#category-table-' + catID + ' .wp-list-table').replaceWith(response);
                    jQuery('#category-table-' + catID + ' .wp-list-table').show();
                    jQuery('#be-compare-delete-subcategory').remove();
                    becpwc_doSort();
                    var message_div = becpwc_message();
                    becpwc_message_update(message_div, 'success');

                });
            } else {
                jQuery('#be-compare-delete-subcategory').remove();
                var message_div = becpwc_message();
                becpwc_message_update(message_div, 'error');
            }

            return false;
        });

        // Добавлет ноый параметр к категории характеристик
        jQuery(document).on('click', '.category-table-container .feature-new', function (e) {

            alert('ddd');

            //prevent default action (hyperlink)
            e.preventDefault();

            cat_id = jQuery(this).closest('.category-table-container').attr('category-id');
            sub_id = jQuery(this).parent().attr('subcat-id');

            var input_types = "";
            jQuery.each(be_compare_input_type, function (index, value) {
                input_types += '<option value="' + index + '">' + value + '</option>';
            });

            var feature_ops = "";
            jQuery.each(be_compare_feature_types, function (index, value) {
                feature_ops += '<option value="' + index + '">' + value + '</option>';
            });

            var attribute_ops = "";
            jQuery.each(be_compare_attribute_types, function (index, value) {
                attribute_ops += '<option value="' + index + '">' + value + '</option>';
            });

            var create_form =
                '<div id="be-compare-new-feature" class="be-compare-popup">' +
                '<div class="be-popup-container add_form" id="be-compare-new-feature-form">' +
                '<form method="post">' +
                '<input type="hidden" name="cat_id" id="cat_id" value="' + cat_id + '" />' +
                '<input type="hidden" name="sub_id" id="sub_id" value="' + sub_id + '" />' +
                '<p><label>' + be_compare_data.text_new_feature + '</label></p>' +
                '<p><span>' + be_compare_data.text_new_feature_sel + '</span></p>' +
                '<p><select name="feat_selection" id="feat_selection">' + feature_ops + '</select> <input type="submit" id="selected_feature" value="' + be_compare_data.text_go + '" /></p>' +
                '<p><select name="attr_selection" id="attr_selection">' + attribute_ops + '</select> <input type="submit" id="selected_attribute" value="' + be_compare_data.text_go + '" /></p><hr />' +
                '<p><span>' + be_compare_data.text_new_feature_new + '</span></p>' +
                '<div class="labeled-form">' +
                '<p><label for="feat_title">' + be_compare_data.text_feature_title + '</label><input type="text" name="feat_title" id="feat_title" /></p>' +
                '<p><label for="feat_type">' + be_compare_data.text_feature_type + '</label><select type="text" name="feat_type" id="feat_type">' + input_types + '</select></p>' +
                '<p style="display: none;"><label for="feat_ops">' + be_compare_data.text_feature_ops + '</label><textarea name="feat_ops" id="feat_ops" rows="4"></textarea></p>' +
                '</div>' +
                '<p><input type="submit" name="submit" id="add_new_feature" value="' + be_compare_data.text_add_new + '" class="form_submit" /> <a href="#" class="cancel">' + be_compare_data.text_cancel + '</a></p>' +
                '</form>' +
                '</div>' +
                '</div>';

            //insert lightbox HTML into page
            jQuery('body').append(create_form);
            becpwc_doBoxSize();

        });

        // Create new feature button
        jQuery('#be-compare-new-feature #feat_type, #be-compare-edit-feature #feat_type').live('change', function (e) {

            needs_ops = ["single-select", "multi-select"];

            if (jQuery.inArray(jQuery(this).val(), needs_ops) !== -1) {
                jQuery(this).parent().next().css('display', 'block');
            } else {
                jQuery(this).parent().next().css('display', 'none');
            }

        });

        // Add existing feature to subcategory
        jQuery('#be-compare-new-feature-form #selected_feature').live('click', function (e) {
            e.preventDefault();

            var catID = jQuery('#be-compare-new-feature #cat_id').val();
            var subID = jQuery('#be-compare-new-feature #sub_id').val();
            var featID = jQuery('#be-compare-new-feature #feat_selection').val();

            if (catID && subID && featID) {

                $(this).closest('.be-popup-container').block({
                    message: null,
                    overlayCSS: {
                        background: '#fff url(' + be_compare_data.ajax_loader_url + ') no-repeat center',
                        backgroundSize: '32px 32px',
                        opacity: 0.6
                    }
                });

                var data = {action: 'be_compare_add_existing_feature', cat_id: catID, sub_id: subID, feat_id: featID};

                $.post(ajaxurl, data, function (response) {

                    jQuery('#category-table-' + catID + ' .wp-list-table').replaceWith(response);
                    jQuery('#category-table-' + catID + ' .wp-list-table').show();
                    jQuery('#be-compare-new-feature').remove();
                    becpwc_doSort();
                    var message_div = becpwc_message();
                    becpwc_message_update(message_div, 'success');

                });
            }

            return false;
        });

        // Add existing attribute to subcategory
        jQuery('#be-compare-new-feature-form #selected_attribute').live('click', function (e) {
            e.preventDefault();

            var catID = jQuery('#be-compare-new-feature #cat_id').val();
            var subID = jQuery('#be-compare-new-feature #sub_id').val();
            var attrID = jQuery('#be-compare-new-feature #attr_selection').val();

            if (catID && subID && attrID) {

                $(this).closest('.be-popup-container').block({
                    message: null,
                    overlayCSS: {
                        background: '#fff url(' + be_compare_data.ajax_loader_url + ') no-repeat center',
                        backgroundSize: '32px 32px',
                        opacity: 0.6
                    }
                });

                var data = {action: 'be_compare_add_existing_attribute', cat_id: catID, sub_id: subID, attr_id: attrID};

                $.post(ajaxurl, data, function (response) {
                    console.log(response)
                    jQuery('#category-table-' + catID + ' .wp-list-table').replaceWith(response);
                    jQuery('#category-table-' + catID + ' .wp-list-table').show();
                    jQuery('#be-compare-new-feature').remove();
                    becpwc_doSort();
                    var message_div = becpwc_message();
                    becpwc_message_update(message_div, 'success');

                });
            }

            return false;
        });

        /**
         * Добавляет новый параметр к категории характеристики
         */
        jQuery(document).on('click', '#be-compare-new-feature-form #add_new_feature', function (e) {
            e.preventDefault();

            alert('// Create new feature to add to subcategory');
            //return false;
            var catID = jQuery('#be-compare-new-feature #cat_id').val();
            var subID = jQuery('#be-compare-new-feature #sub_id').val();
            var featTitle = jQuery('#be-compare-new-feature #feat_title').val();
            var featType = jQuery('#be-compare-new-feature #feat_type').val();
            var featOps = jQuery('#be-compare-new-feature #feat_ops').val();

            if (catID && subID && featTitle && featType) {

                $(this).closest('.be-popup-container').block({
                    message: null,
                    overlayCSS: {
                        background: '#fff url(' + be_compare_data.ajax_loader_url + ') no-repeat center',
                        backgroundSize: '32px 32px',
                        opacity: 0.6
                    }
                });

                var data = {
                    action: 'be_compare_create_feature',
                    cat_id: catID,
                    sub_id: subID,
                    feat_title: featTitle,
                    feat_type: featType,
                    feat_ops: featOps
                };

                $.post(ajaxurl, data, function (response) {
                    var data2 = {action: 'be_compare_update_list_features'}
                    $.post(ajaxurl, data2, function (response2) {
                        console.log(response2)
                        jQuery('#be_compare_features_list').replaceWith(response2);
                        alert('ОТвет 2' + response2);
                    });

                    jQuery('#category-table-' + catID + ' .wp-list-table').replaceWith(response);
                    jQuery('#category-table-' + catID + ' .wp-list-table').show();
                    jQuery('#be-compare-new-feature').remove();
                    becpwc_doSort();
                    var message_div = becpwc_message();
                    becpwc_message_update(message_div, 'success');

                    alert('ОТвет 1' + response);

                });
            } else {
                jQuery('#be-compare-new-feature').remove();
                var message_div = becpwc_message();
                becpwc_message_update(message_div, 'error');
            }

            return false;
        });

        // Remove feature from subcategory button
        jQuery('.category-table-container .feature-delete').live('click', function () {

            cat_id = jQuery(this).closest('.category-table-container').attr('category-id');
            sub_id = jQuery(this).closest('.subcategory_features-table').attr('subcategory-id');
            feat_id = jQuery(this).parent().parent().attr('feature-id');

            var create_form =
                '<div id="be-compare-remove-feature" class="be-compare-popup">' +
                '<div class="be-popup-container add_form" id="be-compare-remove-feature-form">' +
                '<form method="post">' +
                '<input type="hidden" name="cat_id" id="cat_id" value="' + cat_id + '" />' +
                '<input type="hidden" name="sub_id" id="sub_id" value="' + sub_id + '" />' +
                '<input type="hidden" name="feat_id" id="feat_id" value="' + feat_id + '" />' +
                '<p><label for="cat_id">' + be_compare_data.text_rem_feature + '?</label></p>' +
                '<p><span><strong>' + be_compare_data.text_del_category_desc + '!</strong></span></p>' +
                '<p><input type="submit" name="submit" value="' + be_compare_data.text_delete + '" class="form_submit" /> <a href="#" class="cancel">' + be_compare_data.text_cancel + '</a></p>' +
                '</form>' +
                '</div>' +
                '</div>';

            //insert lightbox HTML into page
            jQuery('body').append(create_form);
            becpwc_doBoxSize();

        });

        // Delete, Save, and Display list after deleting feature
        jQuery('#be-compare-remove-feature-form').live('submit', function (e) {
            e.preventDefault();

            var catID = jQuery('#be-compare-remove-feature #cat_id').val();
            var subID = jQuery('#be-compare-remove-feature #sub_id').val();
            var featID = jQuery('#be-compare-remove-feature #feat_id').val();

            if (catID && subID && featID) {

                $(this).block({
                    message: null,
                    overlayCSS: {
                        background: '#fff url(' + be_compare_data.ajax_loader_url + ') no-repeat center',
                        backgroundSize: '32px 32px',
                        opacity: 0.6
                    }
                });

                var data = {action: 'be_compare_remove_feature', cat_id: catID, sub_id: subID, feat_id: featID};

                $.post(ajaxurl, data, function (response) {

                    jQuery('#category-table-' + catID + ' .wp-list-table').replaceWith(response);
                    jQuery('#category-table-' + catID + ' .wp-list-table').show();
                    jQuery('#be-compare-remove-feature').remove();
                    becpwc_doSort();
                    var message_div = becpwc_message();
                    becpwc_message_update(message_div, 'success');

                });
            } else {
                jQuery('#be-compare-remove-feature').remove();
                var message_div = becpwc_message();
                becpwc_message_update(message_div, 'error');
            }

            return false;
        });

        // Create edit form for compare product settings
        jQuery(document).on('click', '.compare-product-edit', function (e) {
            e.preventDefault();

            var productID = jQuery(this).data('id'),
                productTitle = jQuery(this).data('title');

            var create_form =
                '<div id="be-compare-product-edit" class="be-compare-popup">' +
                '<div class="be-popup-container add_form" id="be-compare-product-edit-form">' +
                '</div>' +
                '</div>';

            //insert lightbox HTML into page
            jQuery('body').append(create_form);
            becpwc_doBoxSize();

            if (productID) {
                var fields = jQuery('body .be-popup-container');
                fields.block({
                    message: null,
                    overlayCSS: {
                        background: '#fff url(' + be_compare_data.ajax_loader_url + ') no-repeat center',
                        backgroundSize: '32px 32px',
                        opacity: 0.6
                    }
                });
                update_compare_form(productID, fields);
            }

            return false;
        });

        function update_compare_form(productID, fields) {

            var data = {action: 'be_compare_edit_product_form', product_id: productID};

            $.post(ajaxurl, data, function (response) {

                fields.html(response);

            });
        }

        // Change compare fields if enabled / disabled changes
        jQuery('#be-compare-product-edit #comp_enabled').live('change', function (e) {

            if (jQuery(this).is(':checked')) {
                jQuery('#be-compare-product-edit #enabled_only').show();
            } else {
                jQuery('#be-compare-product-edit #enabled_only').hide();
            }

        });

        // Change compare fields if category changes
        jQuery('#compare-products-table #comp_category').live('change', function (e) {

            var selValue = jQuery(this).val();
            var productID = jQuery('#be-compare-product-edit #product_id').val();
            var div_update = jQuery('#be-compare-product-edit .labeled-form');
            var data = {action: 'be_compare_edit_product_update', product_id: productID, category: selValue};

            div_update.html('<span style="display:block;width100%;height:32px;"></span>');
            div_update.block({
                message: null,
                overlayCSS: {
                    background: '#fff url(' + be_compare_data.ajax_loader_url + ') no-repeat center',
                    backgroundSize: '32px 32px',
                    opacity: 0.6
                }
            });

            if (selValue && productID) {

                $.post(ajaxurl, data, function (response) {

                    div_update.replaceWith(response);

                });

            } else {

                div_update.replaceWith('<h3>Uh oh... something went wrong!</h3>');

            }

        });

        // Change compare fields if category changes
        jQuery(document).on('change', '#comp_category', function (e) {
            var selValue = jQuery(this).val();
            var productID = jQuery(this).data('id');
            var div_update = jQuery('.labeled-form');
            var data = {
                action: 'be_compare_edit_product_update',
                product_id: productID,
                category: selValue
            };

            div_update.html('<span style="display:block;width100%;height:32px;"></span>');
            div_update.block({
                message: null,
                overlayCSS: {
                    background: '#fff url(' + be_compare_data.ajax_loader_url + ') no-repeat center',
                    backgroundSize: '32px 32px',
                    opacity: 0.6
                }
            });

            if (selValue && productID) {

                $.post(ajaxurl, data, function (response) {

                    div_update.replaceWith(response);

                });

            } else {

                div_update.replaceWith('<h3>Uh oh... something went wrong!</h3>');

            }

        });


        // Save product compare features
        jQuery('#be-compare-product-edit-form form').live('submit', function (e) {
            e.preventDefault();

            var return_fields = {};
            var be_nonce = jQuery('#be-compare-product-edit-form #be-nonce').val();
            var productID = jQuery('#be-compare-product-edit-form #product_id').val();
            var comp_enabled = jQuery('#be-compare-product-edit-form #comp_enabled');

            if (comp_enabled.prop("checked")) {
                var catID = jQuery('#be-compare-product-edit-form #comp_category').val();
                comp_enabled = 'true';

                // setup values by section
                jQuery('#be-compare-product-edit-form .section').each(function (index) {
                    var sub_id = jQuery(this).attr('subcat-id');
                    var checkboxes = [];
                    var $this = jQuery(this);
                    return_fields[sub_id] = {};

                    // Get checkbox data
                    jQuery(this).find(':checkbox').each(function (index) {
                        checkboxes.push(jQuery(this).attr('name'));
                    });
                    checkboxes = jQuery.unique(checkboxes);
                    jQuery.each(checkboxes, function (index, value) {
                        var selectedBoxes = $this.find(":checkbox[name=" + value + "]:checked").map(function () {
                            return jQuery(this).val();
                        }).get();
                        return_fields[sub_id][value] = selectedBoxes;
                    });

                    // Get radio input data
                    jQuery(this).find(':radio:checked').each(function (index) {
                        return_fields[sub_id][jQuery(this).attr('name')] = jQuery(this).val();
                    });

                    // Get text input data
                    jQuery(this).find(':text').each(function (index) {
                        return_fields[sub_id][jQuery(this).attr('name')] = jQuery(this).val();
                    });

                    // Get textarea data
                    jQuery(this).find('textarea').each(function (index) {
                        return_fields[sub_id][jQuery(this).attr('name')] = jQuery(this).val();
                    });

                    // Get select data
                    jQuery(this).find('select').each(function (index) {
                        return_fields[sub_id][jQuery(this).attr('name')] = jQuery(this).val();
                    });

                });

            } else {
                comp_enabled = 'false';
            }

            $(this).block({
                message: null,
                overlayCSS: {
                    background: '#fff url(' + be_compare_data.ajax_loader_url + ') no-repeat center',
                    backgroundSize: '32px 32px',
                    opacity: 0.6
                }
            });
            var message_div = becpwc_message();

            if (return_fields) {

                var data = {
                    action: 'be_compare_edit_product_save',
                    post: return_fields,
                    security: be_nonce,
                    product_id: productID,
                    enabled: comp_enabled,
                    categoryID: catID
                };

                $.post(ajaxurl, data, function (response) {

                    if (response == "SUCCESS") becpwc_message_update(message_div, 'success');
                    else becpwc_message_update(message_div, 'error');

                    jQuery('#be-compare-product-edit').remove();

                });
            }

            // Change status column to appropriate message
            var status_col = jQuery("tr[product-id='" + productID + "'] .status");
            if (comp_enabled == 'true') {
                status_col.html('<span class="compare-active">' + be_compare_data.text_active + '</span>');
            } else {
                status_col.html('<span class="compare-inactive">' + be_compare_data.text_inactive + '</span>');
            }

            return false;
        });

        // Create confirmation form to delete feature
        jQuery('#be-compare-feat-table .feature-delete').live('click', function () {

            feat_id = jQuery(this).parent().parent().attr('feature-id');

            var create_form =
                '<div id="be-compare-delete-feature" class="be-compare-popup">' +
                '<div class="be-popup-container add_form" id="be-compare-delete-feature-form">' +
                '<form method="post">' +
                '<input type="hidden" name="fat_id" id="feat_id" value="' + feat_id + '" />' +
                '<p><label for="cat_id">' + be_compare_data.text_del_feature + '?</label></p>' +
                '<p><span><strong>' + be_compare_data.text_del_category_desc + '!</strong></span></p>' +
                '<p><input type="submit" name="submit" value="' + be_compare_data.text_delete + '" class="form_submit" /> <a href="#" class="cancel">' + be_compare_data.text_cancel + '</a></p>' +
                '</form>' +
                '</div>' +
                '</div>';

            //insert lightbox HTML into page
            jQuery('body').append(create_form);
            becpwc_doBoxSize();

        });

        // Delete, Save, and Display list after deleting feature
        jQuery('#be-compare-delete-feature-form').live('submit', function (e) {
            e.preventDefault();

            var featID = jQuery('#be-compare-delete-feature #feat_id').val();

            $(this).block({
                message: null,
                overlayCSS: {
                    background: '#fff url(' + be_compare_data.ajax_loader_url + ') no-repeat center',
                    backgroundSize: '32px 32px',
                    opacity: 0.6
                }
            });

            if (featID !== undefined) {

                var data = {action: 'be_compare_delete_feature', feat_id: featID};

                $.post(ajaxurl, data, function (response) {

                    var par_orderby = getUrlParameter('orderby');
                    var par_order = getUrlParameter('order');
                    var parpaged = getUrlParameter('paged');
                    var data2 = {
                        action: 'be_compare_update_table_feat',
                        orderby: par_orderby,
                        order: par_order,
                        paged: parpaged
                    };
                    $.get(ajaxurl, data2, function (response2) {

                        jQuery('#be-compare-feat-table').replaceWith(response2);
                        jQuery('#be-compare-delete-feature').remove();
                        var message_div = becpwc_message();
                        becpwc_message_update(message_div, 'success');

                    });

                });
            } else {
                jQuery('#be-compare-delete-feature').remove();
                var message_div = becpwc_message();
                becpwc_message_update(message_div, 'error');
            }

            return false;
        });

        // Create confirmation form for bulk deleting features
        jQuery('#be-compare-feat-table .button.action').live('click', function (e) {
            e.preventDefault();

            var action = jQuery(this).parent().find('select').val();
            var checkboxes = [];

            if (action === 'delete') {

                // Get checkbox data
                jQuery('#be-compare-feat-table table tbody').find(':checkbox:checked').each(function (index) {
                    checkboxes.push(jQuery(this).attr('value'));
                });

                var create_form =
                    '<div id="be-compare-delete-features" class="be-compare-popup">' +
                    '<div class="be-popup-container add_form" id="be-compare-delete-features-form">' +
                    '<form method="post">' +
                    '<input type="hidden" name="feat_ids" id="feat_ids" value="' + checkboxes.toString() + '" />' +
                    '<p><label for="cat_id">' + be_compare_data.text_del_features + '?</label></p>' +
                    '<p><span><strong>' + be_compare_data.text_del_category_desc + '!</strong></span></p>' +
                    '<p><input type="submit" name="submit" value="' + be_compare_data.text_delete + '" class="form_submit" /> <a href="#" class="cancel">' + be_compare_data.text_cancel + '</a></p>' +
                    '</form>' +
                    '</div>' +
                    '</div>';

                //insert lightbox HTML into page
                jQuery('body').append(create_form);
                becpwc_doBoxSize();

            }
        });

        // Delete, Save, and Display list after deleting multiple features
        jQuery('#be-compare-delete-features-form').live('submit', function (e) {
            e.preventDefault();

            var featIDs = jQuery('#be-compare-delete-features #feat_ids').val();

            $(this).block({
                message: null,
                overlayCSS: {
                    background: '#fff url(' + be_compare_data.ajax_loader_url + ') no-repeat center',
                    backgroundSize: '32px 32px',
                    opacity: 0.6
                }
            });

            if (featIDs.length !== 0) {

                var data = {action: 'be_compare_delete_features', feat_ids: featIDs};

                $.post(ajaxurl, data, function (response) {

                    var par_orderby = getUrlParameter('orderby');
                    var par_order = getUrlParameter('order');
                    var parpaged = getUrlParameter('paged');
                    var data2 = {
                        action: 'be_compare_update_table_feat',
                        orderby: par_orderby,
                        order: par_order,
                        paged: parpaged
                    };
                    $.get(ajaxurl, data2, function (response2) {

                        jQuery('#be-compare-feat-table').replaceWith(response2);
                        jQuery('#be-compare-delete-features').remove();
                        var message_div = becpwc_message();
                        becpwc_message_update(message_div, 'success');

                    });

                });
            } else {
                jQuery('#be-compare-delete-feature').remove();
                var message_div = becpwc_message();
                becpwc_message_update(message_div, 'error');
            }

            return false;
        });

        // Create form for editing features
        jQuery('#be-compare-feat-table .feature-edit').live('click', function (e) {
            e.preventDefault();

            featID = jQuery(this).parent().parent().attr('feature-id');

            if (featID != undefined) {

                var create_form =
                    '<div id="be-compare-edit-feature" class="be-compare-popup">' +
                    '<div class="be-popup-container add_form" id="be-compare-edit-feature-form">' +
                    '<form method="post">' +
                    '<input type="hidden" name="feat_id" id="feat_id" value="' + featID + '" />' +
                    '<p><label>' + be_compare_data.text_edit_feature + '</label></p>' +
                    '<div class="labeled-form">' +
                    '</div>' +
                    '<p><input type="submit" name="submit" id="add_new_feature" value="' + be_compare_data.text_edit + '" class="form_submit" /> <a href="#" class="cancel">' + be_compare_data.text_cancel + '</a></p>' +
                    '</form>' +
                    '</div>' +
                    '</div>';

                //insert lightbox HTML into page
                jQuery('body').append(create_form);
                becpwc_doBoxSize();

                var data = {action: 'be_compare_edit_feature_form', feat_id: featID};
                var div_update = jQuery('#be-compare-edit-feature .labeled-form');
                div_update.html('<span style="display:block;width100%;height:32px;"></span>');
                div_update.block({
                    message: null,
                    overlayCSS: {
                        background: '#fff url(' + be_compare_data.ajax_loader_url + ') no-repeat center',
                        backgroundSize: '32px 32px',
                        opacity: 0.6
                    }
                });

                if (feat_id !== undefined) {

                    $.post(ajaxurl, data, function (response) {

                        // Setup return values
                        var return_vars = response.split('&|&');
                        var val_title = return_vars[0];
                        var val_type = return_vars[1];
                        var val_ops = return_vars[2];
                        var val_hidden = ' style="display: none;"';
                        var needs_ops = ["single-select", "multi-select"];

                        // Setup input type list and select returned value
                        var input_types = "";
                        jQuery.each(be_compare_input_type, function (index, value) {
                            input_types += '<option value="' + index + '"';
                            if (index == val_type) input_types += ' selected="selected"';
                            input_types += '>' + value + '</option>';
                        });

                        if (jQuery.inArray(val_type, needs_ops) !== -1) {
                            val_hidden = '';
                        }

                        var fields =
                            '<p><label for="feat_title">' + be_compare_data.text_feature_title + '</label><input type="text" name="feat_title" id="feat_title" value="' + val_title + '" /></p>' +
                            '<p><label for="feat_type">' + be_compare_data.text_feature_type + '</label><select type="text" name="feat_type" id="feat_type">' + input_types + '</select></p>' +
                            '<p' + val_hidden + '><label for="feat_ops">' + be_compare_data.text_feature_ops + '</label><textarea name="feat_ops" id="feat_ops" rows="4">' + val_ops + '</textarea></p>';

                        div_update.html(fields);

                    });

                } else {

                    div_update.html('<h3>Uh oh... something went wrong!</h3>');

                }

            }
        });

        // Update feature information
        jQuery('#be-compare-edit-feature-form').live('submit', function (e) {
            e.preventDefault();

            var featID = jQuery('#be-compare-edit-feature #feat_id').val();
            var featTitle = jQuery('#be-compare-edit-feature #feat_title').val();
            var featType = jQuery('#be-compare-edit-feature #feat_type').val();
            var featOps = jQuery('#be-compare-edit-feature #feat_ops').val();

            if (featID && featTitle && featType) {

                $(this).closest('.be-popup-container').block({
                    message: null,
                    overlayCSS: {
                        background: '#fff url(' + be_compare_data.ajax_loader_url + ') no-repeat center',
                        backgroundSize: '32px 32px',
                        opacity: 0.6
                    }
                });

                var data = {
                    action: 'be_compare_edit_feature',
                    feat_id: featID,
                    feat_title: featTitle,
                    feat_type: featType,
                    feat_ops: featOps
                };

                $.post(ajaxurl, data, function (response) {
                    var new_type = be_compare_input_type[featType];
                    jQuery('.wp-list-table').find('tr[feature-id="' + featID + '"] td.type').html(new_type.substr(0, new_type.search(' -')));
                    jQuery('#be-compare-edit-feature').remove();
                    var message_div = becpwc_message();
                    becpwc_message_update(message_div, 'success');

                });
            } else {
                jQuery('#be-compare-edit-feature').remove();
                var message_div = becpwc_message();
                becpwc_message_update(message_div, 'error');
            }

            return false;
        });

        function becpwc_doBoxSize() {
            // set max height for popup box
            var window_height = jQuery(window).height();
            var box_height = window_height - 180;
            jQuery('.be-popup-container').css('max-height', box_height + 'px');
        }

        jQuery(window).on('resize', function () {
            becpwc_doBoxSize();
        });

        function becpwc_doSort() {

            // Setup sortable features table
            var fixHelperTable = function (e, ui) {
                ui.children().each(function () {
                    jQuery(this).width(jQuery(this).width());
                });
                return ui;
            };

            jQuery("#be-compare-cat-tables .cats tbody").sortable({
                //helper: fixHelperTable,
                helper: function (e, tr) {
                    var $originals = tr.children();
                    var $helper = tr.clone();
                    $helper.children().each(function (index) {
                        // Set helper cell sizes to match the original sizes
                        $(this).width($originals.eq(index).width());
                    });
                    return $helper;
                },
                handle: '.reorder',
                cursor: 'move',
                placeholder: 'ui-sort-placeholder',
                update: function (event, ui) {
                    // setup compare variables
                    var subcats = [];
                    var cid = jQuery(this).parent().parent().attr('category-id');
                    jQuery(this).parent().find('tr.row-subcategory').each(function (index) {
                        subcats.push(jQuery(this).attr('subcategory-id'));
                    });
                    var data = {action: 'be_compare_update_order_cat', cat_id: cid, items: subcats};
                    var message_div = becpwc_message();

                    // submit information to be saved
                    $.post(ajaxurl, data, function (response) {

                        if (response == "SUCCESS") becpwc_message_update(message_div, 'success');
                        else becpwc_message_update(message_div, 'error');

                    });
                }
            }).disableSelection();

            jQuery("#be-compare-cat-tables .subcategory_features-table tbody").sortable({
                helper: fixHelperTable,
                handle: '.feature-sort',
                cursor: 'move',
                update: function (event, ui) {
                    // setup compare variables
                    var features = [];
                    var cid = jQuery(this).parents('.category-table-container').attr('category-id');
                    var sid = jQuery(this).parent().attr('subcategory-id');
                    jQuery(this).find('tr').each(function (index) {
                        features.push(jQuery(this).attr('feature-id'));
                    });
                    var data = {action: 'be_compare_update_order_feat', cat_id: cid, sub_id: sid, items: features};
                    var message_div = becpwc_message();

                    // submit information to be saved
                    $.post(ajaxurl, data, function (response) {

                        if (response == "SUCCESS") becpwc_message_update(message_div, 'success');
                        else becpwc_message_update(message_div, 'error');

                    });
                }
            }).disableSelection();
        }

        becpwc_doSort();

        message_id = 0;
        function becpwc_message() {
            message_id++;

            // create the container div if it does not exist already
            if (jQuery('#be_message_div').length == 0) {
                var message_container = '<div id="be_message_div"></div>';
                jQuery('body').append(message_container);
            }
            // add message box, waiting for direction
            var add_message = '<div id="be-compare-message' + message_id + '" class="compare-message"></div>';
            jQuery('#be_message_div').append(add_message);
            $('#be-compare-message' + message_id).block({
                message: null,
                overlayCSS: {
                    background: '#484848 url(' + be_compare_data.ajax_loader_url + ') no-repeat center',
                    backgroundSize: '24px 24px',
                    opacity: 0.2
                }
            });

            return '#be-compare-message' + message_id;
        }

        function becpwc_message_update(did, type) {
            // add direction to message box, remove box after 4 seconds
            if (type == 'success') {
                response = 'SUCCESS';
                jQuery(did).addClass('success');
            } else {
                response = 'ERROR';
                jQuery(did).addClass('error');
            }

            //insert lightbox HTML into page
            jQuery(did).html(response);
            jQuery(did).delay(4000).fadeOut("slow");
        }

        function getUrlParameter(sParam) {
            var sPageURL = window.location.search.substring(1);
            var sURLVariables = sPageURL.split('&');
            for (var i = 0; i < sURLVariables.length; i++) {
                var sParameterName = sURLVariables[i].split('=');
                if (sParameterName[0] == sParam) {
                    return sParameterName[1];
                }
            }
        }

    });
})(jQuery);
