<?php
/**
 * Created by PhpStorm.
 * User: Максим
 * Date: 03.11.2015
 * Time: 3:15
 */

class Cr_Tax_Meta{


    /**
     * Конструктор класса
     */
    public function __construct(){

        add_action( 'admin_enqueue_scripts', array($this ,'load_custom_code') );

        add_action( 'edited_product_cat', array($this ,'crsh5_save_category_meta_fields'));
        add_action( 'create_product_cat', array($this ,'crsh5_save_category_meta_fields'));
        add_action( 'product_cat_add_form_fields', array($this ,'crsh5_category_add_meta_fields'));
        add_action( 'product_cat_edit_form_fields', array($this ,'meta_boxes_render') );

    }

    /**
     * Подключает медиаАплоадер
     */
    function load_custom_code() {
        wp_enqueue_script('jquery');
        wp_enqueue_media();
    }


    /**
     * Скрипт медиаАплоад
     */
    function media_js(){ ?>

        <script type="text/javascript">
            jQuery(document).ready(function($){
                $('#upload-btn').click(function(e) {
                    e.preventDefault();
                    var image = wp.media({
                        title: 'Upload Image',
                        multiple: false
                    }).open()
                        .on('select', function(e){
                            var uploaded_image = image.state().get('selection').first();
                            console.log(uploaded_image);
                            var image_url = uploaded_image.toJSON().url;
                            $('.cr-term-img').remove();
                            $('#image_url').val(image_url);
                            $('#image_url').before('<img style="width:250px;" class="cr-term-img" src="' +  image_url  + '">');
                        });
                });
            });
        </script>

    <?php }

    /**
     * Метабокс создания категории
     */
    function crsh5_category_add_meta_fields() {
        ?>

        <div class="form-field">
            <label><?php _e( 'Баннер категории', 'crsh5' ); ?></label>
            <input type="text" name="crsh5[fa_limit]"
                   value="" id="image_url" class="regular-text"/>
            <input type="button" name="upload-btn" id="upload-btn" class="button-secondary" value="Загрузить изображение">
        </div>

        <?php

        $this->media_js();
    }

    /**
     * Метабоксы
     */
    function meta_boxes_construct() {
        $fields = array(

            array(
                'id'    => 'fa_limit',
                'title' => __( 'Баннер категории', 'crsh5' ),
                'type'  => 'upload'
            ),

            array(
                'id'    => 'bn_link',
                'title' => __( 'Ссылка с баннера', 'crsh5' ),
                'type'  => 'text'
            )

        );

        return $fields;
    }

    /**
     * Отрисовка метабоксов
     */
    function meta_boxes_render($term) {
        $crsh5_meta =  get_option( '_crsh5_category_' . $term->term_id );

        $fields = $this->meta_boxes_construct();
        foreach ( $fields as $field_group => $field ) {
        print_r($field);
        }
        $out ='';

        foreach ( $fields as $field_group => $field ) {
            switch ($field['type']) {

                case 'upload':

                    $out .= '<tr class="form-field">' .
                        '<th scope="row" valign="top">' .
                        '<label>' . $field['title'] . '</label>' .
                        '</th>' .
                        '<td>';

                    if (!empty($crsh5_meta[$field['id']])) {
                        $out .= '<img style="width:250px;" class="cr-term-img" src="' . $crsh5_meta[$field['id']] . '">';
                    }

                    $out .= '<input type="text" name="crsh5[' . $field['id'] . ']" value="' . $crsh5_meta[$field['id']] . '" id="image_url" class="regular-text"/>' .
                        '<input type="button" name="upload-btn" id="upload-btn" class="button-secondary" value="Загрузить изображение">' .
                        '</td>' .
                        '</tr>';

                    break;

                case 'text':

                    $out .= '<tr class="form-field">' .
                        '<th scope="row" valign="top">' .
                        '<label>' . $field['title'] . '</label>' .
                        '</th>' .
                        '<td>';

                    $val = (!empty($crsh5_meta[$field['id']])) ? $crsh5_meta[$field['id']] : '';

                    $out .= '<input type="text" name="crsh5[' . $field['id'] . ']" value="' . $val . '" id="' . $field['id'] . '" class="regular-text"/>' .
                        '</td>' .
                        '</tr>';

                    break;
            }
        }


        $this->media_js();

        echo $out;

    }


    /**
     * Сохранение метаданных
     * @param $term_id - объект категории
     */
    function crsh5_save_category_meta_fields( $term_id ) {
        $term_meta = array();
        if ( isset( $_POST['crsh5'] ) ) {

            foreach ( $_POST['crsh5'] as $key => $val )
            {
                $term_meta[$key] = $val;

            }

            update_option( '_crsh5_category_'.$term_id, $term_meta );
        }

    }

}

new Cr_Tax_Meta();


