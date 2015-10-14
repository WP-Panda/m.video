<?php
$redux_opt_name = "wps5_option";

if ( !function_exists( "redux_add_metaboxes" ) ):
    function redux_add_metaboxes($metaboxes) {

        // Global Alice
        global $options_alice;

        // ID prefix
        $prefix = 'wps5_';

        // Define arrays
        $metaboxes = array();

        // Revolution Slider
        include_once(ABSPATH.'wp-admin/includes/plugin.php');

        if (is_plugin_active('revslider/revslider.php')) {
            global $wpdb;
            $query = $wpdb->prepare(
              "
              SELECT id, title, alias
              FROM ".$wpdb->prefix."revslider_sliders
              ORDER BY %s ASC LIMIT 100
              ", 'id'
            );

            $rs = $wpdb->get_results($query);
            $revsliders = array();
            if ($rs) {
                foreach ( $rs as $slider ) {
                    $revsliders[$slider->alias] = $slider->alias;
                }
            } else {
                $revsliders["No sliders found"] = 0;
            }
        } else {
            $revsliders["No Plugin Installed"] = null;
        }

        // Main Settings

        /*-----------------------------------------------------------------------------------*/
        /*  - Preloader
        /*-----------------------------------------------------------------------------------*/
        if( !empty($options_alice['preloader_settings']) && $options_alice['preloader_settings'] == 1) {

            $main_settings[] = array(
                'title'     => __( 'Preloader', 'wppandashop5' ),
                'icon'      => 'el-icon-cog',
                'fields'    => array(
                    array(
                        'id'        =>  $prefix . 'preloader_display',
                        'type'      =>  'button_set',
                        'title'     =>  __('Preloader Settings', 'wppandashop5'),
                        'subtitle'  =>  __('Enable or Disable the Preloader.', 'wppandashop5'),
                        'options'   =>  array(
                            'show'  =>  'Show',
                            'hide'  =>  'Hide',
                        ),
                        'default'   =>  $options_alice['global_preloader_visibility'],
                    ),
                ),
            );

        }

        /*-----------------------------------------------------------------------------------*/
        /*  - Logo & Menu
        /*-----------------------------------------------------------------------------------*/
        $main_settings[] = array(
            'title'     => __( 'Logo & Menu', 'wppandashop5' ),
            'icon'      => 'el-icon-cog',
            'fields'    => array(

                array(
                    'id'        =>  $prefix . 'logo_navi_type_color',
                    'type'      =>  'button_set',
                    'title'     =>  __('Logo/Navigation Type', 'wppandashop5'),
                    'subtitle'  =>  __('The setting refers to which type of logo/navigation will appear.', 'wppandashop5'),
                    'options'   =>  array(
                        'light' =>  'Light',
                        'dark'  =>  'Dark',
                    ),
                    'default'   =>  $options_alice['global_logo_navi_type_color'],
                ),
            ),
        );

        /*-----------------------------------------------------------------------------------*/
        /*  - Dots Menu
        /*-----------------------------------------------------------------------------------*/
        $main_settings[] = array(
            'title'     => __( 'Dots Menu', 'wppandashop5' ),
            'icon'      => 'el-icon-cog',
            'fields'    => array(

                array(
                    'id'        =>  $prefix . 'dots_menu_display',
                    'type'      =>  'button_set',
                    'title'     =>  __('Dots Menu', 'wppandashop5'),
                    'subtitle'  =>  __('Side dots navigation on left side of the page. Useful for long pages.', 'wppandashop5'),
                    'options'   =>  array(
                        ''      =>  'Hide',
                        'show'  =>  'Show',
                    ),
                    'default'   =>  '',
                ),

                array(
                    'id'        =>  $prefix . 'dots_menu_id_sections',
                    'type'      =>  'text',
                    'title'     =>  __( 'Section IDs', 'wppandashop5' ),
                    'subtitle'  =>  __( 'Required. Write the section ids in this field, separated by commas.<br><br><em>ID of the top page is main.</em>', 'wppandashop5' ),
                    'default'   =>  '',
                    'required'  =>  array( $prefix . 'dots_menu_display', '=', 'show' ),
                ),

                array(
                    'id'        =>  $prefix . 'dots_menu_label_sections',
                    'type'      =>  'text',
                    'title'     =>  __( 'Label Section IDs', 'wppandashop5' ),
                    'subtitle'  =>  __( 'Optional. Write the label text for your sections ids in this field, separated by commas.', 'wppandashop5' ),
                    'default'   =>  '',
                    'required'  =>  array( $prefix . 'dots_menu_display', '=', 'show' ),
                ),

            ),
        );


        /*-----------------------------------------------------------------------------------*/
        /*  - Footer Widget
        /*-----------------------------------------------------------------------------------*/
        $main_settings[] = array(
            'title'     => __( 'Footer Widget', 'wppandashop5' ),
            'icon'      => 'el-icon-cog',
            'fields'    => array(

                array(
                    'id'        =>  $prefix . 'footer_widget_display',
                    'type'      =>  'button_set',
                    'title'     =>  __('Footer Widget Settings', 'wppandashop5'),
                    'subtitle'  =>  __('Enable or Disable the Footer Widget Area.', 'wppandashop5'),
                    'options'   =>  array(
                        'show'  =>  'Show',
                        'hide'  =>  'Hide',
                    ),
                    'default'   =>  $options_alice['global_footer_widget_visibility'],
                ),

            ),
        );

        /*-----------------------------------------------------------------------------------*/
        /*  - Title Header for Pages/Posts
        /*-----------------------------------------------------------------------------------*/
        $main_settings[] = array(
            'title'     => __( 'Title Header', 'wppandashop5' ),
            'icon'      => 'el-icon-cog',
            'fields'    => array(
                // Title Header
                array(
                    'id'        =>  $prefix . 'title_header_display',
                    'type'      =>  'button_set',
                    'title'     =>  __('Title Header', 'wppandashop5'),
                    'subtitle'  =>  __('Enable or Disable the Title Header Area.', 'wppandashop5'),
                    'options'   =>  array(
                        'show'  =>  'Show',
                        'hide'  =>  'Hide',
                    ),
                    'default'   =>  $options_alice['global_title_header_visibility'],
                ),

                // Title Header Hide Options
                array(
                    'id'        =>  $prefix . 'title_header_hide_display',
                    'type'      =>  'button_set',
                    'title'     =>  __('Title Header Hide Module', 'wppandashop5'),
                    'subtitle'  =>  __('Select if the page header is transparent or has a simple background color when this is hide.', 'wppandashop5'),
                    'options'   =>  array(
                        'transparent'  =>  'Transparent',
                        'colorful'  =>  'Colorful',
                    ),
                    'default'   =>  $options_alice['global_title_header_hide_visibility'],
                    'required'  =>  array( $prefix . 'title_header_display', '=', 'hide' ),
                ),

                array(
                    'id'            =>  $prefix .'title_header_hide_color',
                    'type'          =>  'color',
                    'title'         =>  __( 'Title Header Text Color', 'wppandashop5' ),
                    'subtitle'      =>  __( 'Optional. Choose a text color for your heading and subheading.', 'wppandashop5' ),
                    'output'        =>  false,
                    'validate'      =>  false,
                    'transparent'   =>  false,
                    'default'       =>  $options_alice['global_title_header_hide_color'],
                    'required'  => array(
                        array( $prefix . 'title_header_display', '=', 'hide' ),
                        array( $prefix . 'title_header_hide_display', '=', 'colorful' ),
                    ),
                ),

                // Title Header Layout
                array(
                    'id'        =>  $prefix . 'title_header_layout',
                    'type'      =>  'button_set',
                    'title'     =>  __('Title Header Layout', 'wppandashop5'),
                    'subtitle'  =>  __('Select your layout for the title header page.', 'wppandashop5'),
                    'options'   =>  array(
                        'normal'     =>  'Normal',
                        'fullscreen' =>  'Full Screen',
                    ),
                    'default'   =>  $options_alice['global_title_header_layout_container'],
                    'required'  =>  array( $prefix . 'title_header_display', '!=', 'hide' ),
                ),

                // Title Header Height
                array(
                    'id'        => $prefix . 'title_header_height',
                    'type'      => 'text',
                    'title'     => __( 'Title Header Height', 'wppandashop5' ),
                    'subtitle'  => __( 'Select your custom height for your title header page. Default is 600px.<br><br><em>Enter only a number value.</em>', 'wppandashop5' ),
                    'default'   => $options_alice['global_title_header_height'],
                    'required'  => array(
                        array( $prefix . 'title_header_display', '!=', 'hide' ),
                        array( $prefix . 'title_header_layout', '!=', 'fullscreen' ),
                    ),
                ),

                // Title Header Scroll To Next Section
                array(
                    'id'        =>  $prefix . 'scroll_to_section',
                    'type'      =>  'button_set',
                    'title'     =>  __('Scroll Button To Next Section', 'wppandashop5'),
                    'subtitle'  =>  __('Enable or Disable Scroll Button Feature.', 'wppandashop5'),
                    'options'   =>  array(
                        'enable'    =>  'Enable',
                        'disable'   =>  'Disable',
                    ),
                    'default'   =>  $options_alice['global_scroll_to_section'],
                    'required'  =>  array( $prefix . 'title_header_layout', '=', 'fullscreen' ),
                ),

                // Title Header Module
                array(
                    'id'        =>  $prefix . 'title_header_module',
                    'type'      =>  'select',
                    'title'     =>  __('Title Header Module', 'wppandashop5'),
                    'subtitle'  =>  __('Select your favorite Title Header Module.', 'wppandashop5'),
                    'options'   =>  array(
                        'normal'            =>  __( 'Normal', 'wppandashop5' ),
                        'image'             =>  __( 'Image', 'wppandashop5' ),
                        'image_parallax'    =>  __( 'Image Parallax', 'wppandashop5' ),
                        'video'             =>  __( 'Video', 'wppandashop5' ),
                        'slider'            =>  __( 'Slider', 'wppandashop5' ),
                        'animate'           =>  __( 'Animated Pattern Background', 'wppandashop5' ),
                    ),
                    'default'   =>  'normal',
                    'required'  =>  array( $prefix . 'title_header_display', '!=', 'hide' ),
                ),

                // Title Header Module: Normal
                array(
                    'id'            =>  $prefix .'title_header_normal_bg_color',
                    'type'          =>  'color',
                    'title'         =>  __( 'Title Header Background Color', 'wppandashop5' ),
                    'subtitle'      =>  __( 'Optional. Choose a background color for your title header section.', 'wppandashop5' ),
                    'output'        =>  false,
                    'validate'      =>  false,
                    'transparent'   =>  false,
                    'default'       =>  $options_alice['global_title_header_normal_bg_color'],
                    'required'      =>  array( $prefix . 'title_header_module', '=', 'normal' ),
                ),

                // Title Header Module: Image
                array(
                    'id'        =>  $prefix . 'title_header_image',
                    'type'      =>  'media', 
                    'title'     =>  __('Title Header Background Image', 'wppandashop5'),
                    'subtitle'  =>  __('Upload your image.', 'wppandashop5'),
                    'default'   =>  '',
                    'required'  =>  array( $prefix . 'title_header_module', '=', 'image' ),
                ),

                array(
                    'id'        =>  $prefix . 'title_header_image_position',
                    'type'      =>  'select',
                    'title'     =>  __('Title Header Image Position', 'wppandashop5'),
                    'subtitle'  =>  __('Select your background image position.', 'wppandashop5'),
                    'options'   =>  array(
                        'left_top'      =>  __( 'Left Top', 'wppandashop5' ),
                        'left_center'   =>  __( 'Left Center', 'wppandashop5' ),
                        'left_bottom'   =>  __( 'Left Bottom', 'wppandashop5' ),
                        'center_top'    =>  __( 'Center Top', 'wppandashop5' ),
                        'center_center' =>  __( 'Center Center', 'wppandashop5' ),
                        'center_bottom' =>  __( 'Center Bottom', 'wppandashop5' ),
                        'right_top'     =>  __( 'Right Top', 'wppandashop5' ),
                        'right_center'  =>  __( 'Right Center', 'wppandashop5' ),
                        'right_bottom'  =>  __( 'Right Bottom', 'wppandashop5' ),
                    ),
                    'default'   =>  'center_center',
                    'required'  =>  array( $prefix . 'title_header_module', '=', 'image' ),
                ),

                array(
                    'id'        =>  $prefix . 'title_header_image_repeat',
                    'type'      =>  'select',
                    'title'     =>  __('Title Header Image Repeat', 'wppandashop5'),
                    'subtitle'  =>  __('Select your background image repeat.', 'wppandashop5'),
                    'options'   =>  array(
                        'no_repeat' =>  __( 'No Repeat', 'wppandashop5' ),
                        'repeat'    =>  __( 'Repeat', 'wppandashop5' ),
                        'repeat_x'  =>  __( 'Repeat Horizontally', 'wppandashop5' ),
                        'repeat_y'  =>  __( 'Repeat Vertically', 'wppandashop5' ),
                        'stretch'   =>  __( 'Stretch to fit', 'wppandashop5' ),
                    ),
                    'default'   =>  'stretch',
                    'required'  =>  array( $prefix . 'title_header_module', '=', 'image' ),
                ),

                // Title Header Module: Image Parallax
                array(
                    'id'        =>  $prefix .'title_header_image_parallax',
                    'type'      =>  'media', 
                    'title'     =>  __('Title Header Background Image Parallax', 'wppandashop5'),
                    'subtitle'  =>  __('Upload your image.', 'wppandashop5'),
                    'default'   =>  '',
                    'required'  =>  array( $prefix . 'title_header_module', '=', 'image_parallax' ),
                ),

                // Pattern & Background Color Mask Overlay
                array(
                    'id'        =>  $prefix . 'title_header_mask_mode',
                    'type'      =>  'select',
                    'title'     =>  __('Title Header Mask', 'wppandashop5'),
                    'subtitle'  =>  __('Select your favorite Title Header Mask Mode.<br><br><em>Not work with Revolution Slider</em>', 'wppandashop5'),
                    'options'   =>  array(
                        'none'                  =>  __( 'None', 'wppandashop5' ),
                        'mask_color'            =>  __( 'Mask Color', 'wppandashop5' ),
                        'mask_pattern'          =>  __( 'Mask Pattern', 'wppandashop5' ),
                        'mask_pattern_color'    =>  __( 'Mask Color and Pattern', 'wppandashop5' ),
                    ),
                    'default'   =>  'none',
                    'required'  => array(
                        array( $prefix . 'title_header_module', '!=', 'normal' ),
                        array( $prefix . 'title_header_module', '!=', 'animate' ),
                    ),
                ),
                
                // Pattern
                array(
                    'id'        =>  $prefix . 'title_header_mask_pattern',
                    'type'      =>  'media', 
                    'title'     =>  __('Pattern Mask', 'wppandashop5'),
                    'subtitle'  =>  __('Optional. Upload your pattern image.', 'wppandashop5'),
                    'default'   =>  '',
                    'required'  => array(
                        array( $prefix . 'title_header_mask_mode', '!=', 'none' ),
                        array( $prefix . 'title_header_mask_mode', '!=', 'mask_color' ),
                    ),
                ),

                array(
                    'id'            =>  $prefix . 'title_header_mask_pattern_opacity',
                    'type'          =>  'slider', 
                    'title'         =>  __('Pattern Mask Opacity', 'wppandashop5'),
                    'subtitle'      =>  __('Optional. Choose opacity value for your pattern image.', 'wppandashop5'),
                    'default'       =>  1,
                    'min'           =>  0,
                    'step'          =>  .01,
                    'max'           =>  1,
                    'resolution'    =>  0.01,
                    'display_value' => 'text',
                    'required'  => array(
                        array( $prefix . 'title_header_mask_mode', '!=', 'none' ),
                        array( $prefix . 'title_header_mask_mode', '!=', 'mask_color' ),
                    ),
                ),

                // Color
                array(
                    'id'            =>  $prefix . 'title_header_mask_background',
                    'type'          =>  'color_rgba',  
                    'title'         =>  __( 'Color Mask', 'wppandashop5' ),
                    'subtitle'      =>  __( 'Optional. Select your custom hex color with opacity.', 'wppandashop5' ),
                    'default'       =>  array( 'color' => '#000000', 'alpha' => '0.55' ),
                    'validate'      =>  'colorrgba',
                    'transparent'   =>  false,
                    'required'  => array(
                        array( $prefix . 'title_header_mask_mode', '!=', 'none' ),
                        array( $prefix . 'title_header_mask_mode', '!=', 'mask_pattern' ),
                    ),
                ),

                // Title Header Module: Animated Pattern Background
                array(
                    'id'            =>  $prefix . 'animated_pattern_background_color',
                    'type'          =>  'color',
                    'title'         =>  __( 'Pattern Background Color', 'wppandashop5' ),
                    'subtitle'      =>  __( 'Optional. Choose a background color for your title header section is your pattern background image is a transparent png.', 'wppandashop5' ),
                    'output'        =>  false,
                    'validate'      =>  false,
                    'transparent'   =>  false,
                    'default'       =>  '',
                    'required'      =>  array( $prefix . 'title_header_module', '=', 'animate' ),
                ),

                array(
                    'id'        =>  $prefix . 'animated_pattern_background_image',
                    'type'      =>  'media', 
                    'title'     =>  __('Pattern Background Image', 'wppandashop5'),
                    'subtitle'  =>  __('Upload a pattern background Png image.', 'wppandashop5'),
                    'default'   =>  '',
                    'required'  =>  array( $prefix . 'title_header_module', '=', 'animate' ),
                ),

                array(
                    'id'        =>  $prefix . 'animated_pattern_animation_moveset',
                    'type'      =>  'select',
                    'title'     =>  __('Pattern Animation Moveset', 'wppandashop5'),
                    'subtitle'  =>  __('Select your favorite moveset.', 'wppandashop5'),
                    'options'   =>  array(
                        'topbottom'  =>  __( 'Top to Bottom', 'wppandashop5' ),
                        'bottomtop'  =>  __( 'Bottom to Top', 'wppandashop5' ),
                        'leftright'  =>  __( 'Left to Right', 'wppandashop5' ),
                        'rightleft'  =>  __( 'Right to Left', 'wppandashop5' ),
                    ),
                    'default'   =>  'bottomtop',
                    'required'  =>  array( $prefix . 'title_header_module', '=', 'animate' ),
                ),

                array(
                    'id'        =>  $prefix . 'animated_pattern_animation_duration',
                    'type'      =>  'text',
                    'title'     =>  __( 'Pattern Duration Animation', 'wppandashop5' ),
                    'subtitle'  =>  __( 'Enter your custom duration of animation. Default is 20 seconds.<br><br><em>Enter only a number value.</em>', 'wppandashop5' ),
                    'default'   =>  '',
                    'required'  =>  array( $prefix . 'title_header_module', '=', 'animate' ),
                ),

                // Title Header Module: Video
                array(
                    'id'        =>  $prefix . 'title_header_video_mode',
                    'type'      =>  'select',
                    'title'     =>  __('Video Mode', 'wppandashop5'),
                    'subtitle'  =>  __('Select your video mode.', 'wppandashop5'),
                    'options'   =>  array(
                        'vimeo_embed_code'  =>  __( 'Vimeo', 'wppandashop5' ),
                        'youtube_url'       =>  __( 'Youtube', 'wppandashop5'),
                        'self_hosted'       =>  __( 'Self Hosted Video', 'wppandashop5' ),
                    ),
                    'default'   =>  'self_hosted',
                    'required'  =>  array( $prefix . 'title_header_module', '=', 'video' ),
                ),

                array(
                    'id'        =>  $prefix . 'title_header_video_mobile_settings',
                    'type'      =>  'button_set',
                    'title'     =>  __('Video Mobile Settings', 'wppandashop5'),
                    'subtitle'  =>  __('Choose the option for video on mobile/tablets.', 'wppandashop5'),
                    'options'   =>  array(
                        'lightbox'  =>  'Pop-up',
                        ''          =>  'New Window',
                    ),
                    'default'   =>  '',
                    'required'  =>  array( $prefix . 'title_header_module', '=', 'video' ),
                ),

                array(
                    'id'        =>  $prefix . 'title_header_video_image',
                    'type'      =>  'media', 
                    'title'     =>  __('Mobile Background Image Fallback', 'wppandashop5'),
                    'subtitle'  =>  __('Required. Upload your image for mobile and tablet devices.', 'wppandashop5'),
                    'default'   =>  '',
                    'required'  =>  array( $prefix . 'title_header_module', '=', 'video' ),
                ),

                // Self-Hosted Video
                array(
                    'id'        =>  $prefix . 'title_header_video_self_image',
                    'type'      =>  'media', 
                    'title'     =>  __('Self-Hosted Background Image Fallback', 'wppandashop5'),
                    'subtitle'  =>  __('Optional. Upload your image.', 'wppandashop5'),
                    'default'   =>  '',
                    'required'  =>  array( $prefix . 'title_header_video_mode', '=', 'self_hosted' ),
                ),

                array(
                    'id'        =>  $prefix . 'title_header_video_volume',
                    'type'      =>  'button_set',
                    'title'     =>  __( 'Mute Video', 'wppandashop5' ),
                    'subtitle'  =>  __( 'Mute the audio.', 'wppandashop5' ),
                    'options'   =>  array(
                        ''      =>  'Yes',
                        'off'   =>  'No',
                    ),
                    'default'   =>  '',
                    'required'  =>  array( $prefix . 'title_header_video_mode', '=', 'self_hosted' ),
                ),

                array(
                    'id'        =>  $prefix . 'title_header_video_autoplay',
                    'type'      =>  'button_set',
                    'title'     =>  __('Video Autoplay', 'wppandashop5'),
                    'subtitle'  =>  __('Autoplay the video.', 'wppandashop5'),
                    'options'   =>  array(
                        ''      =>  'Yes',
                        'off'   =>  'No',
                    ),
                    'default'   =>  '',
                    'required'  =>  array( $prefix . 'title_header_video_mode', '=', 'self_hosted' ),
                ),

                array(
                    'id'        =>  $prefix . 'title_header_video_loop',
                    'type'      =>  'button_set',
                    'title'     =>  __('Video Loop', 'wppandashop5'),
                    'subtitle'  =>  __('Loop the video.', 'wppandashop5'),
                    'options'   =>  array(
                        ''      =>  'Yes',
                        'off'   =>  'No',
                    ),
                    'default'   =>  '',
                    'required'  =>  array( $prefix . 'title_header_video_mode', '=', 'self_hosted' ),
                ),

                array(
                    'id'        =>  $prefix . 'title_header_video_webm',
                    'type'      =>  'media', 
                    'preview'   =>  false,
                    'mode'      =>  false,
                    'title'     =>  __('WEBM File', 'wppandashop5'),
                    'subtitle'  =>  __('Required. Upload a WEBM video file.<br><br><em>You must include both formats.</em>', 'wppandashop5'),
                    'default'   =>  '',
                    'required'  =>  array( $prefix . 'title_header_video_mode', '=', 'self_hosted' ),
                ),

                array(
                    'id'        =>  $prefix . 'title_header_video_mp4',
                    'type'      =>  'media', 
                    'preview'   =>  false,
                    'mode'      =>  false,
                    'title'     =>  __('MP4 File', 'wppandashop5'),
                    'subtitle'  =>  __('Required. Upload a MP4 video file.<br><br><em>You must include both formats.</em>', 'wppandashop5'),
                    'default'   =>  '',
                    'required'  =>  array( $prefix . 'title_header_video_mode', '=', 'self_hosted' ),
                ),

                // Youtube URL
                array(
                    'id'        =>  $prefix . 'title_header_video_youtube_image',
                    'type'      =>  'media', 
                    'title'     =>  __('Youtube Background Image Fallback', 'wppandashop5'),
                    'subtitle'  =>  __('Optional. Upload your image.', 'wppandashop5'),
                    'default'   =>  '',
                    'required'  =>  array( $prefix . 'title_header_video_mode', '=', 'youtube_url' ),
                ),

                array(
                    'id'        =>  $prefix . 'title_header_video_youtube_url',
                    'type'      =>  'text',
                    'title'     =>  __( 'Youtube Video ID', 'wppandashop5' ),
                    'subtitle'  =>  __( 'Required. Enter only ID video from Youtube.<br><br><em>Example: 3XviR7esUvo</em>', 'wppandashop5' ),
                    'default'   =>  '',
                    'required'  =>  array( $prefix . 'title_header_video_mode', '=', 'youtube_url' ),
                ),

                array(
                    'id'        =>  $prefix . 'title_header_video_youtube_volume',
                    'type'      =>  'button_set',
                    'title'     =>  __( 'Mute Video', 'wppandashop5' ),
                    'subtitle'  =>  __( 'Mute the audio.', 'wppandashop5' ),
                    'options'   =>  array(
                        ''      =>  'Yes',
                        'off'   =>  'No',
                    ),
                    'default'   =>  '',
                    'required'  =>  array( $prefix . 'title_header_video_mode', '=', 'youtube_url' ),
                ),

                array(
                    'id'        =>  $prefix . 'title_header_video_youtube_autoplay',
                    'type'      =>  'button_set',
                    'title'     =>  __( 'Autoplay Video', 'wppandashop5' ),
                    'subtitle'  =>  __( 'Autoplay the video.', 'wppandashop5' ),
                    'options'   =>  array(
                        ''      =>  'Yes',
                        'off'   =>  'No',
                    ),
                    'default'   =>  '',
                    'required'  =>  array( $prefix . 'title_header_video_mode', '=', 'youtube_url' ),
                ),

                array(
                    'id'        =>  $prefix . 'title_header_video_youtube_loop',
                    'type'      =>  'button_set',
                    'title'     =>  __( 'Loop Video', 'wppandashop5' ),
                    'subtitle'  =>  __( 'Loop the video.', 'wppandashop5' ),
                    'options'   =>  array(
                        ''      =>  'Yes',
                        'off'   =>  'No',
                    ),
                    'default'   =>  '',
                    'required'  =>  array( $prefix . 'title_header_video_mode', '=', 'youtube_url' ),
                ),

                // Vimeo Embed Code
                array(
                    'id'        =>  $prefix . 'title_header_video_vimeo_id',
                    'type'      =>  'text',
                    'title'     =>  __( 'Vimeo Video ID', 'wppandashop5' ),
                    'subtitle'  =>  __( 'Required. Enter only ID video from Vimeo.<br><br><em>Example: 116214074</em>', 'wppandashop5' ),
                    'default'   =>  '',
                    'required'  =>  array( $prefix . 'title_header_video_mode', '=', 'vimeo_embed_code' ),
                ),

                array(
                    'id'        =>  $prefix . 'title_header_video_vimeo_volume',
                    'type'      =>  'button_set',
                    'title'     =>  __( 'Mute Video', 'wppandashop5' ),
                    'subtitle'  =>  __( 'Mute the audio.', 'wppandashop5' ),
                    'options'   =>  array(
                        ''      =>  'Yes',
                        'off'   =>  'No',
                    ),
                    'default'   =>  '',
                    'required'  =>  array( $prefix . 'title_header_video_mode', '=', 'vimeo_embed_code' ),
                ),

                array(
                    'id'        =>  $prefix . 'title_header_video_vimeo_autoplay',
                    'type'      =>  'button_set',
                    'title'     =>  __( 'Autoplay Video', 'wppandashop5' ),
                    'subtitle'  =>  __( 'Autoplay the video.', 'wppandashop5' ),
                    'options'   =>  array(
                        ''      =>  'Yes',
                        'off'   =>  'No',
                    ),
                    'default'   =>  '',
                    'required'  =>  array( $prefix . 'title_header_video_mode', '=', 'vimeo_embed_code' ),
                ),

                array(
                    'id'        =>  $prefix . 'title_header_video_vimeo_loop',
                    'type'      =>  'button_set',
                    'title'     =>  __( 'Loop Video', 'wppandashop5' ),
                    'subtitle'  =>  __( 'Loop the video.', 'wppandashop5' ),
                    'options'   =>  array(
                        ''      =>  'Yes',
                        'off'   =>  'No',
                    ),
                    'default'   =>  '',
                    'required'  =>  array( $prefix . 'title_header_video_mode', '=', 'vimeo_embed_code' ),
                ),

                // Title Header Module: Slider
                array(
                    'id'        =>  $prefix . 'title_header_slider_mode',
                    'type'      =>  'select',
                    'title'     =>  __('Slider Mode', 'wppandashop5'),
                    'subtitle'  =>  __('Select your slider mode.<br><br><em>For use Revolution Slider you need install and activate the plugin.</em>', 'wppandashop5'),
                    'options'   =>  array(
                        'az_slider'  =>  __( 'AZ Slider', 'wppandashop5' ),
                        'rev_slider' =>  __( 'Revolution Slider', 'wppandashop5'),
                    ),
                    'default'   =>  'az_slider',
                    'required'  =>  array( $prefix . 'title_header_module', '=', 'slider' ),
                ),

                // AZ Slider Settings
                array(
                    'id'        =>  $prefix . 'title_header_az_slider_text_format',
                    'type'      =>  'button_set',
                    'title'     =>  __( 'AZ Slider Text and Caption Size Format', 'wppandashop5' ),
                    'subtitle'  =>  __( 'Select your size/design for slider text.', 'wppandashop5' ),
                    'options'   =>  array(
                        'normal_format'  =>  'Normal',
                        'big_format'     =>  'Big',
                    ),
                    'default'   =>  'normal_format',
                    'required'  =>  array( $prefix . 'title_header_slider_mode', '=', 'az_slider' ),
                ),

                array(
                    'id'        =>  $prefix . 'title_header_az_slider_animation_type',
                    'type'      =>  'select',
                    'title'     =>  __('AZ Slider Animation', 'wppandashop5'),
                    'subtitle'  =>  __('Select your animation type.', 'wppandashop5'),
                    'options'   =>  array(
                        'fade'  =>  __( 'Fade', 'wppandashop5' ),
                        'slide' =>  __( 'Slide', 'wppandashop5'),
                    ),
                    'default'   =>  'slide',
                    'required'  =>  array( $prefix . 'title_header_slider_mode', '=', 'az_slider' ),
                ),

                array(
                    'id'        =>  $prefix . 'title_header_az_slider_autoplay',
                    'type'      =>  'button_set',
                    'title'     =>  __('AZ Slider Autoplay', 'wppandashop5'),
                    'subtitle'  =>  __('Choose if your slider start automatically.', 'wppandashop5'),
                    'options'   =>  array(
                        ''    =>  __( 'On', 'wppandashop5' ),
                        'off' =>  __( 'Off', 'wppandashop5'),
                    ),
                    'default'   =>  '',
                    'required'  =>  array( $prefix . 'title_header_slider_mode', '=', 'az_slider' ),
                ),

                array(
                    'id'        =>  $prefix . 'title_header_az_slider_loop',
                    'type'      =>  'button_set',
                    'title'     =>  __('AZ Slider Loop', 'wppandashop5'),
                    'subtitle'  =>  __('Choose if your slider have a loop.', 'wppandashop5'),
                    'options'   =>  array(
                        ''      =>  __( 'On', 'wppandashop5' ),
                        'off'   =>  __( 'Off', 'wppandashop5'),
                    ),
                    'default'   =>  '',
                    'required'  =>  array( $prefix . 'title_header_az_slider_autoplay', '=', '' ),
                ),

                array(
                    'id'        => $prefix . 'title_header_az_slider_slide_speed',
                    'type'      => 'text',
                    'title'     => __( 'AZ Slider Slide Speed', 'wppandashop5' ),
                    'subtitle'  => __( 'Set the speed of animations of slide, in milliseconds. Default is 600.<br><br><em>Enter only a number value.</em>', 'wppandashop5' ),
                    'default'   => '600',
                    'required'  =>  array( $prefix . 'title_header_slider_mode', '=', 'az_slider' ),
                ),

                array(
                    'id'        => $prefix . 'title_header_az_slider_slideshow_speed',
                    'type'      => 'text',
                    'title'     => __( 'AZ Slider SlideShow Speed', 'wppandashop5' ),
                    'subtitle'  => __( 'Set the speed of the slideshow cycling, in milliseconds. Default is 7000.<br><br><em>Required Autoplay Enabled.<br>Enter only a number value.</em>', 'wppandashop5' ),
                    'default'   => '7000',
                    'required'  =>  array( $prefix . 'title_header_slider_mode', '=', 'az_slider' ),
                ),

                array(
                    'id'        =>  $prefix . 'title_header_az_slider_parallax',
                    'type'      =>  'button_set',
                    'title'     =>  __( 'Parallax', 'wppandashop5' ),
                    'subtitle'  =>  __( 'Parallax slide to scroll.', 'wppandashop5' ),
                    'options'   =>  array(
                        ''      =>  'On',
                        'off'   =>  'Off',
                    ),
                    'default'   =>  '',
                    'required'  =>  array( $prefix . 'title_header_slider_mode', '=', 'az_slider' ),
                ),

                array(
                    'id'          =>  $prefix . 'title_header_az_slider_alias',
                    'type'        =>  'slides',
                    'title'       =>  __( 'Slides Options', 'wppandashop5' ),
                    'subtitle'    =>  __( 'Unlimited slides with drag and drop sortings.', 'wppandashop5' ),
                    'desc'        =>  '',
                    'placeholder' =>  array(
                        'title'       => __( 'Optional. Insert a title.', 'wppandashop5' ),
                        'description' => __( 'Optional. Insert a caption.', 'wppandashop5' ),
                        'url'         => __( 'Optional. Insert a link. Only URL.', 'wppandashop5' ),
                    ),
                    'required'  =>  array( $prefix . 'title_header_slider_mode', '=', 'az_slider' ),
                ),

                // Revolution Slider
                array(
                    'id'        =>  $prefix . 'title_header_revolution_slider_alias',
                    'type'      =>  'select',
                    'title'     =>  __('Revolution Slider Alias', 'wppandashop5'),
                    'subtitle'  =>  __('Select your Revolution Slider Alias.', 'wppandashop5'),
                    'options'   =>  $revsliders,
                    'default'   =>  '',
                    'required'  =>  array( $prefix . 'title_header_slider_mode', '=', 'rev_slider' ),
                ),

                // Title Header Text
                array(
                    'id'        =>  $prefix . 'title_header_text_display',
                    'type'      =>  'button_set',
                    'title'     =>  __('Title Header Text', 'wppandashop5'),
                    'subtitle'  =>  __('Enable or Disable the Title Header Text.<br><br><em>Not visible with Slider Mode.</em>', 'wppandashop5'),
                    'options'   =>  array(
                        'show'  =>  'Show',
                        'hide'  =>  'Hide',
                    ),
                    'default'   =>  $options_alice['global_title_header_text_visibility'],
                    'required'  =>  array( $prefix . 'title_header_display', '!=', 'hide' ),
                ),

                array(
                    'id'        =>  $prefix . 'title_header_text_format',
                    'type'      =>  'button_set',
                    'title'     =>  __( 'Heading & Subheading Size Format', 'wppandashop5' ),
                    'subtitle'  =>  __( 'Select your size/design for title header text.', 'wppandashop5' ),
                    'options'   =>  array(
                        'normal_format'  =>  'Normal',
                        'big_format'     =>  'Big',
                    ),
                    'default'   =>  'normal_format',
                    'required'  =>  array( $prefix . 'title_header_text_display', '!=', 'hide' ),
                ),

                array(
                    'id'        =>  $prefix . 'title_header_text_heading',
                    'type'      =>  'text',
                    'title'     =>  __( 'Heading', 'wppandashop5' ),
                    'subtitle'  =>  __( 'Enter your custom heading.<br>Default is page/post title.', 'wppandashop5' ),
                    'default'   =>  '',
                    'required'  =>  array( $prefix . 'title_header_text_display', '!=', 'hide' ),
                ),

                array(
                    'id'        =>  $prefix . 'title_header_text_subheading',
                    'type'      =>  'textarea',
                    'title'     =>  __( 'Subheading', 'wppandashop5' ),
                    'subtitle'  =>  __( 'Enter your page subheading.', 'wppandashop5' ),
                    'default'   =>  '',
                    'required'  =>  array( $prefix . 'title_header_text_display', '!=', 'hide' ),
                ),

                array(
                    'id'            =>  $prefix . 'title_header_text_color',
                    'type'          =>  'color',
                    'title'         =>  __( 'Title Header Text Color', 'wppandashop5' ),
                    'subtitle'      =>  __( 'Optional. Choose a text color for your heading and subheading.', 'wppandashop5' ),
                    'output'        =>  false,
                    'validate'      =>  false,
                    'transparent'   =>  false,
                    'default'       =>  $options_alice['global_title_header_text_color'],
                    'required'      =>  array( $prefix . 'title_header_text_display', '!=', 'hide' ),
                ),

            ),
        );
        
        // Set Main settings array for all post types
        $page_settings = $post_settings = $team_settings = $portfolio_settings = $main_settings;


        /*-----------------------------------------------------------------------------------*/
        /*  - For Team Only
        /*-----------------------------------------------------------------------------------*/
        $team_settings[] = array(
            'title' => __( 'Team', 'wppandashop5' ),
            'icon'  => 'el-icon-cog'
        );

        $team_settings[] = array(
            'title'      => __( 'Creative Module', 'wppandashop5' ),
            'icon'       => 'font-icon-arrow-right-simple-thin-round',
            'subsection' =>  true,
            'fields'     => array(

                array(
                    'id'        =>  $prefix . 'team_single_creative_image',
                    'type'      =>  'media', 
                    'title'     =>  __('Single Team Creative Mode: Image', 'wppandashop5'),
                    'subtitle'  =>  __('Required. Upload an image.<br><br><strong>This is available only for Team Creative Module.</strong></br>', 'wppandashop5'),
                    'default'   =>  '',
                ),

                array(
                    'id'        =>  $prefix . 'team_single_creative_output_text',
                    'type'      =>  'editor',
                    'title'     =>  __('Single Team Creative Mode: Description', 'wppandashop5'),
                    'subtitle'  =>  __('Required. Enter a description.<br><br><strong>This is available only for Team Creative Module.</strong></br>', 'wppandashop5'),
                    'default'   =>  '',
                    'args'   => array(
                        'teeny'     => false,
                        'wpautop'   => false
                    )
                ),

            ),
        );
        
        if( $options_alice['back_to_team'] == 1 && $options_alice['back_to_team_mode'] == "custom" ) {

            $team_settings[] = array(
                'title'      => __( 'Back to URL', 'wppandashop5' ),
                'icon'       => 'font-icon-arrow-right-simple-thin-round',
                'subsection' =>  true,
                'fields'     => array(

                    array(
                        'id'        =>  $prefix . 'back_team_url_custom',
                        'type'      =>  'select',
                        'data'      =>  'pages',
                        'title'     =>  __( 'Custom Back to Team Page', 'wppandashop5' ),
                        'subtitle'  =>  __( 'Required. Select your custom main team page for back to team feature.', 'wppandashop5' ),
                        'default'   =>  '',
                    ),

                ),
            );

        }

        /*-----------------------------------------------------------------------------------*/
        /*  - For Portfolio Only
        /*-----------------------------------------------------------------------------------*/
        $portfolio_settings[] = array(
            'title' => __( 'Portfolio', 'wppandashop5' ),
            'icon'  => 'el-icon-cog'
        );

        $portfolio_settings[] = array(
            'title'      => __( 'Creative Module', 'wppandashop5' ),
            'icon'       => 'font-icon-arrow-right-simple-thin-round',
            'subsection' =>  true,
            'fields'     => array(

                array(
                    'id'        =>  $prefix . 'portfolio_single_creative_image',
                    'type'      =>  'media', 
                    'title'     =>  __('Single Portfolio Creative Mode: Image', 'wppandashop5'),
                    'subtitle'  =>  __('Required. Upload an image.<br><br><strong>This is available only for Portfolio Creative Module.</strong></br>', 'wppandashop5'),
                    'default'   =>  '',
                ),

                array(
                    'id'        =>  $prefix . 'portfolio_single_creative_gallery_image',
                    'type'      =>  'gallery',
                    'title'     =>  __('Single Portfolio Creative Mode: Gallery', 'wppandashop5'),
                    'subtitle'  =>  __('Optional. Create a gallery images.<br><br><strong>This is available only for Portfolio Creative Module.</strong></br>', 'wppandashop5')
                ),

                array(
                    'id'        =>  $prefix . 'portfolio_single_creative_output_text',
                    'type'      =>  'editor',
                    'title'     =>  __('Single Portfolio Creative Mode: Description', 'wppandashop5'),
                    'subtitle'  =>  __('Required. Enter a description.<br><br><strong>This is available only for Portfolio Creative Module.</strong></br>', 'wppandashop5'),
                    'default'   =>  '',
                    'args'   => array(
                        'teeny'     => false,
                        'wpautop'   => false
                    )
                ),

            ),
        );

        $portfolio_settings[] = array(
            'title'      => __( 'Project Type', 'wppandashop5' ),
            'icon'       => 'font-icon-arrow-right-simple-thin-round',
            'subsection' => true,
            'fields'     => array(

                array(
                    'id'        =>  $prefix . 'portfolio_project_type',
                    'type'      =>  'select',
                    'title'     =>  __('Single Portfolio Project Type', 'wppandashop5'),
                    'subtitle'  =>  __('Select your single portfolio project type.<br><br>
                                        <em><strong>Normal</strong>: Open the single portfolio post in its corresponding single page.</em><br><br>
                                        <em><strong>Fancybox</strong>: Open the single portfolio post with the fancybox pop-up for images or videos. This type is excluded from the navigation.</em><br><br>
                                        <em><strong>External URL</strong>: Open the single portfolio post indicated in the URL Field. This type is excluded from the navigation.</em><br><br>
                                        <strong>This is available only for Portfolio Classic Module.</strong>', 'wppandashop5'),
                    'options'   =>  array(
                        'normal_type'   =>  __( 'Normal', 'wppandashop5' ),
                        'fancybox_type' =>  __( 'Fancybox', 'wppandashop5' ),
                        'external_type' =>  __( 'External URL', 'wppandashop5' ),
                    ),
                    'default'   =>  ''
                ),

                // Fancy Image
                array(
                    'id'        =>  $prefix . 'portfolio_fancybox_mode',
                    'type'      =>  'button_set',
                    'title'     =>  __('Fancybox Mode', 'wppandashop5'),
                    'subtitle'  =>  __('Select if you want a fancybox with image/images or video/videos pop-up.', 'wppandashop5'),
                    'options'   =>  array(
                        'image_mod' =>  'Image',
                        'video_mod' =>  'Video',
                    ),
                    'default'   =>  'image_mod',
                    'required'  =>  array( $prefix . 'portfolio_project_type', '=', 'fancybox_type' ),
                ),

                array(
                    'id'        =>  $prefix . 'portfolio_fancybox_image_diff',
                    'type'      =>  'media', 
                    'title'     =>  __('Fancy Image', 'wppandashop5'),
                    'subtitle'  =>  __('Optional. Upload an image if you want display another image instead the default featured image.<br><br><em>If you want a caption set/write the Caption Field field when select the image.</em>', 'wppandashop5'),
                    'default'   =>  '',
                    'required'  =>  array( $prefix . 'portfolio_fancybox_mode', '=', 'image_mod' ),
                ),

                array(
                    'id'        =>  $prefix . 'portfolio_fancybox_gallery_image',
                    'type'      =>  'gallery',
                    'title'     =>  __('Fancy Gallery Images', 'wppandashop5'),
                    'subtitle'  =>  __('Optional. Create a gallery images.<br><br><em>If you want a caption set/write the Caption Field when select the image.</em>', 'wppandashop5'),
                    'required'  =>  array( $prefix . 'portfolio_fancybox_mode', '=', 'image_mod' ),
                ),

                array(
                    'id'        =>  $prefix . 'portfolio_fancybox_gallery_name',
                    'type'      =>  'text',
                    'title'     =>  __( 'Fancy Image Gallery Name', 'wppandashop5' ),
                    'subtitle'  =>  __( 'Optional. Enter a gallery name if you want use Fancy Gallery Images or you want a gallery between other portfolio fancybox type posts.', 'wppandashop5' ),
                    'default'   =>  '',
                    'required'  =>  array( $prefix . 'portfolio_fancybox_mode', '=', 'image_mod' ),
                ),
                
                // Fancy Video
                array(
                    'id'        =>  $prefix . 'portfolio_fancybox_video_url',
                    'type'      =>  'text',
                    'title'     =>  __('Fancy Video URL', 'wppandashop5'),
                    'subtitle'  =>  __('Required. Enter video url.<br><br><em>Only Youtube and Vimeo Support.</em>', 'wppandashop5'),
                    'default'   =>  '',
                    'required'  =>  array( $prefix . 'portfolio_fancybox_mode', '=', 'video_mod'),
                ),

                array(
                    'id'        =>  $prefix . 'portfolio_fancybox_video_caption',
                    'type'      =>  'text',
                    'title'     =>  __('Fancy Video Caption', 'wppandashop5'),
                    'subtitle'  =>  __('Optional. Insert a caption text.', 'wppandashop5'),
                    'default'   =>  '',
                    'required'  =>  array( $prefix . 'portfolio_fancybox_mode', '=', 'video_mod'),
                ),

                array(
                    'id'          =>  $prefix . 'portfolio_fancybox_gallery_video',
                    'type'        =>  'slides',
                    'title'       =>  __( 'Fancy Gallery Videos', 'wppandashop5' ),
                    'subtitle'    =>  __( 'Optional. Create a gallery videos.', 'wppandashop5' ),
                    'desc'        =>  '',
                    'placeholder' =>  array(
                        'title'       => __( 'Optional. Identify the video here.', 'wppandashop5' ),
                        'url'         => __( 'Required. Insert a link. Only URL.', 'wppandashop5' ),
                        'description' => __( 'Optional. Insert a caption.', 'wppandashop5' ),
                    ),
                    'required'  =>  array( $prefix . 'portfolio_fancybox_mode', '=', 'video_mod' ),
                ),

                array(
                    'id'        =>  $prefix . 'portfolio_fancybox_video_gallery_name',
                    'type'      =>  'text',
                    'title'     =>  __( 'Fancy Video Gallery Name', 'wppandashop5' ),
                    'subtitle'  =>  __( 'Optional. Enter a gallery name if you want use Fancy Gallery Videos or you want a gallery between other portfolio fancybox type posts.', 'wppandashop5' ),
                    'default'   =>  '',
                    'required'  =>  array( $prefix . 'portfolio_fancybox_mode', '=', 'video_mod' ),
                ),

                // External URL
                array(
                    'id'        =>  $prefix . 'portfolio_external_url',
                    'type'      =>  'text',
                    'title'     =>  __( 'External URL', 'wppandashop5' ),
                    'subtitle'  =>  __( 'Required. Enter your custom link location (remember to include "http://").', 'wppandashop5' ),
                    'default'   =>  '',
                    'required'  =>  array( $prefix . 'portfolio_project_type', '=', 'external_type' ),
                ),

                array(
                    'id'        =>  $prefix . 'portfolio_external_url_target',
                    'type'      =>  'button_set',
                    'title'     =>  __('Target URL', 'wppandashop5'),
                    'subtitle'  =>  __('Specifies where to open the linked document.', 'wppandashop5'),
                    'options'   =>  array(
                        '_self'  =>  'Same Window',
                        '_blank' =>  'New Window',
                    ),
                    'default'   =>  '_self',
                    'required'  =>  array( $prefix . 'portfolio_project_type', '=', 'external_type' ),
                ),

            ),
        );

        $portfolio_settings[] = array(
            'title'      => __( 'Colorize FX', 'wppandashop5' ),
            'icon'       => 'font-icon-arrow-right-simple-thin-round',
            'subsection' =>  true,
            'fields'     => array(

                array(
                    'id'        =>  $prefix . 'colorize_project_fx',
                    'type'      =>  'color_rgba',
                    'title'     =>  __( 'Colorize Effect', 'wppandashop5' ),
                    'subtitle'  =>  __( 'Required. Select your custom color hover effect.<br><br><strong>This is available only for Portfolio Colorize Effect option active.</strong></br>', 'wppandashop5' ),
                    'default'       =>  array( 'color' => '#000000', 'alpha' => '0.01' ),
                    'validate'      =>  'colorrgba',
                    'transparent'   =>  false
                ),

            ),
        );

        if( $options_alice['back_to_portfolio'] == 1 && $options_alice['back_to_portfolio_mode'] == "custom" ) {

            $portfolio_settings[] = array(
                'title'      => __( 'Back to URL', 'wppandashop5' ),
                'icon'       => 'font-icon-arrow-right-simple-thin-round',
                'subsection' =>  true,
                'fields'     => array(

                    array(
                        'id'        =>  $prefix . 'back_portfolio_url_custom',
                        'type'      =>  'select',
                        'data'      =>  'pages',
                        'title'     =>  __( 'Custom Back to Portfolio Page', 'wppandashop5' ),
                        'subtitle'  =>  __( 'Required. Select your custom main portfolio page for back to team feature.', 'wppandashop5' ),
                        'default'   =>  '',
                    ),

                ),
            );

        }

        /*-----------------------------------------------------------------------------------*/
        /*  - Clients
        /*-----------------------------------------------------------------------------------*/
        $client_settings[] = array(
            'title'     => __( 'Optional Info', 'wppandashop5' ),
            'icon'      => 'el-icon-cog',
            'fields'    => array(

                array(
                    'id'            =>  $prefix . 'client_background',
                    'type'          =>  'color',
                    'title'         =>  __( 'Background Color', 'wppandashop5' ),
                    'subtitle'      =>  __( 'Optional. Choose a background color for your client logo.', 'wppandashop5' ),
                    'output'        =>  false,
                    'validate'      =>  false,
                    'transparent'   =>  false,
                    'default'       =>  ''
                ),

                array(
                    'id'        =>  $prefix . 'client_url',
                    'type'      =>  'text',
                    'title'     =>  __( 'Client URL', 'wppandashop5' ),
                    'subtitle'  =>  __( 'Optional. Enter the link here. (remember to include "http://").', 'wppandashop5' ),
                    'default'   =>  ''
                ),

                array(
                    'id'        =>  $prefix . 'client_url_target',
                    'type'      =>  'button_set',
                    'title'     =>  __('Target URL', 'wppandashop5'),
                    'subtitle'  =>  __('Specifies where to open the linked document.', 'wppandashop5'),
                    'options'   =>  array(
                        '_self'  =>  'Same Window',
                        '_blank' =>  'New Window',
                    ),
                    'default'   =>  '_self'
                ),

            ),
        );

        /*-----------------------------------------------------------------------------------*/
        /*  - Testimonial
        /*-----------------------------------------------------------------------------------*/
        $testimonial_settings[] = array(
            'title'     => __( 'Testimonial Info', 'wppandashop5' ),
            'icon'      => 'el-icon-cog',
            'fields'    => array(

                array(
                    'id'          =>  $prefix . 'testimonial_caption',
                    'type'        =>  'text',
                    'title'       =>  __( 'Testimonial Caption', 'wppandashop5' ),
                    'subtitle'    =>  __( 'Optional. Enter the caption text here.', 'wppandashop5' ),
                    'description' =>  __( 'Example: Co-founder of Company', 'wppandashop5'),
                    'default'     =>  ''
                ),

                array(
                    'id'        =>  $prefix . 'testimonial_quote',
                    'type'      =>  'editor',
                    'title'     =>  __('Testimonial Quote', 'wppandashop5'),
                    'subtitle'  =>  __('Required. Enter a quote text.', 'wppandashop5'),
                    'default'   =>  '',
                    'args'   => array(
                        'teeny'     => false,
                        'wpautop'       => true,
                        'media_buttons' => false
                    )
                ),

            ),
        );

        /*-----------------------------------------------------------------------------------*/
        /*  - Define Metaboxes
        /*-----------------------------------------------------------------------------------*/
        
        // Pages
        $metaboxes[] = array(
            'id'            => 'az-page-metaboxes',
            'title'         => __( 'Page Settings', 'wppandashop5' ),
            'post_types'    => array( 'page' ),
            'position'      => 'normal',
            'priority'      => 'high',
            'sidebar'       => true,
            'sections'      => $page_settings
        );

        // Posts
        $metaboxes[] = array(
            'id'            => 'az-post-metaboxes',
            'title'         => __( 'Post Settings', 'wppandashop5' ),
            'post_types'    => array( 'post' ),
            'position'      => 'normal',
            'priority'      => 'high',
            'sidebar'       => true,
            'sections'      => $post_settings
        );

        // Team
        $metaboxes[] = array(
            'id'            => 'az-post-metaboxes',
            'title'         => __( 'Team Settings', 'wppandashop5' ),
            'post_types'    => array( 'team' ),
            'position'      => 'normal',
            'priority'      => 'high',
            'sidebar'       => true,
            'sections'      => $team_settings
        );

        // Portfolio
        $metaboxes[] = array(
            'id'            => 'az-post-metaboxes',
            'title'         => __( 'Portfolio Settings', 'wppandashop5' ),
            'post_types'    => array( 'portfolio' ),
            'position'      => 'normal',
            'priority'      => 'high',
            'sidebar'       => true,
            'sections'      => $portfolio_settings
        );

        // Client
        $metaboxes[] = array(
            'id'            => 'az-post-metaboxes',
            'title'         => __( 'Client Settings', 'wppandashop5' ),
            'post_types'    => array( 'client' ),
            'position'      => 'normal',
            'priority'      => 'high',
            'sidebar'       => true,
            'sections'      => $client_settings
        );

        // Testimonial
        $metaboxes[] = array(
            'id'            => 'az-post-metaboxes',
            'title'         => __( 'Testimonial Settings', 'wppandashop5' ),
            'post_types'    => array( 'testimonial' ),
            'position'      => 'normal',
            'priority'      => 'high',
            'sidebar'       => true,
            'sections'      => $testimonial_settings
        );


    return $metaboxes;
  }
  add_action('redux/metaboxes/alice/boxes', 'redux_add_metaboxes');
endif;

// The loader will load all of the extensions automatically based on your $redux_opt_name
require_once(dirname(__FILE__).'/loader.php');