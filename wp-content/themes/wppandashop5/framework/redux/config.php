<?php

/*
 * ReduxFramework Sample Config File
 * For full documentation, please visit: http://docs.reduxframework.com/
 */

if (!class_exists('Redux_Framework_sample_config')) {

    class Redux_Framework_sample_config {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if (  true == Redux_Helpers::isTheme(__FILE__) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }

        }

        public function initSettings() {

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            //add_action( 'redux/loaded', array( $this, 'remove_demo' ) );
            
            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 3);
            
            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            
            // Dynamically add a section. Can be also used to modify sections/fields
            //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**
         * This is a test function that will let you see when the compiler hook occurs.
         * It only runs if a field    set with compiler=>true is changed.
         * */
        function compiler_action($options, $css, $changed_values) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r($changed_values); // Values that have changed since the last save
            echo "</pre>";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

            /*
              // Demo of how to use the dynamic CSS and write your own static CSS file
              $filename = dirname(__FILE__) . '/style' . '.css';
              global $wp_filesystem;
              if( empty( $wp_filesystem ) ) {
                require_once( ABSPATH .'/wp-admin/includes/file.php' );
              WP_Filesystem();
              }

              if( $wp_filesystem ) {
                $wp_filesystem->put_contents(
                    $filename,
                    $css,
                    FS_CHMOD_FILE // predefined mode settings for WP files
                );
              }
             */
        }

        /**
         * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
         * Simply include this function in the child themes functions.php file.
         * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
         * so you must use get_template_directory_uri() if you want to use any of the built in icons
         * */
        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => __('Section via hook', 'wppandashop5'),
                'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'wppandashop5'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }

        /**
         * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
         * */
        function change_arguments($args) {
            //$args['dev_mode'] = true;

            return $args;
        }

        /**
         * Filter hook for filtering the default value of any given field. Very useful in development mode.
         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                remove_filter( 'plugin_row_meta', array(
                    ReduxFrameworkPlugin::instance(),
                    'plugin_metalinks'
                ), null, 2 );

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
            }
        }

        public function setSections() {

            /**
             * Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns      = array();

            if ( is_dir( $sample_patterns_path ) ) :

                if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) :
                    $sample_patterns = array();

                    while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

                        if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                            $name              = explode( '.', $sample_patterns_file );
                            $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                            $sample_patterns[] = array(
                                'alt' => $name,
                                'img' => $sample_patterns_url . $sample_patterns_file
                            );
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct          = wp_get_theme();
            $this->theme = $ct;
            $item_name   = $this->theme->get( 'Name' );
            $tags        = $this->theme->Tags;
            $screenshot  = $this->theme->get_screenshot();
            $class       = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf( __( 'Customize &#8220;%s&#8221;', 'wppandashop5' ), $this->theme->display( 'Name' ) );

            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                <?php endif; ?>

                <h4><?php echo $this->theme->display('Name'); ?></h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'wppandashop5'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'wppandashop5'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', 'wppandashop5') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
            <?php
            if ($this->theme->parent()) {
                printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.') . '</p>', __('http://codex.wordpress.org/Child_Themes', 'wppandashop5'), $this->theme->parent()->display('Name'));
            }
            ?>

                </div>
            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $sampleHTML = '';
            if (file_exists(dirname(__FILE__) . '/info-html.html')) {
                Redux_Functions::initWpFilesystem();
                
                global $wp_filesystem;

                $sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
            }

            // ACTUAL DECLARATION OF SECTIONS

            /*-----------------------------------------------------------------------------------*/
            /*  - General
            /*-----------------------------------------------------------------------------------*/
            $this->sections[] = array(
                'title'      =>  __('Основные', 'wppandashop5'),
                //'desc'       =>  __('Welcome to the WP Panda Shop 5 Options Panel! Control and configure the general setup of your theme.', 'wppandashop5'),
                'icon'       =>  'font-icon-house',
                'customizer' =>  false,  
                'fields'     =>  array(

                    array(
                        'id'        =>  'site_layout_mode',
                        'type'      =>  'image_select',
                        'title'     =>  __('Стиль сайта', 'wppandashop5'),
                       // 'subtitle'  =>  __('Select the main layout for the site.', 'wppandashop5'),
                        'desc'      =>  '',
                        'options'   =>  array(
                            'wide'    =>  array(
                                'title' => __('Wide','wppandashop5'),
                                'img' => ReduxFramework::$_url .'/assets/img/wide.png'
                            ),
                            'box'    =>  array(
                                'title' => __('Box','wppandashop5'),
                                'img' => ReduxFramework::$_url .'/assets/img/box.png'
                            )
                        ),
                        'default'   =>  'wide'
                    ),

                    array(
                        'id'        =>  'cyrillic_site',
                        'type'      =>  'button_set',
                        'title'     =>  __('Включить опции для киррилицы', 'wppandashop5'),
                        'subtitle'  =>  __('To enable the adaptation of the site to Russian language', 'wppandashop5'),
                        'desc'      =>  '',
                        'options'   =>  array(
                            'on'  =>  __('On','wppandashop5'),
                            'off'  =>  __('Off','wppandashop5')
                        ),
                        'default'   =>  'off',
                    ),

                    // Custom Admin Logo + Custom Favicon + Custom iOS Icons
                    array(
                        'id'        =>  'custom_admin_logo',
                        'type'      =>  'media', 
                        'title'     =>  __('Лого', 'wppandashop5'),
                        //'subtitle'  =>  __('Upload 260 x 98px image here to replace the admin login logo', 'wppandashop5'),
                        'desc'      =>  ''
                    ),

                    array(
                        'id'        =>  'favicon',
                        'type'      =>  'media', 
                        'title'     =>  __('Фавикон', 'wppandashop5'),
                       // 'subtitle'  =>  __('Upload a 16px x 16px Png/Gif image that will represent your website\'s favicon.', 'wppandashop5'),
                        'desc'      =>  ''
                    ),

                   /* array(
                        'id'        =>  'custom_ios_bookmark_title',
                        'type'      =>  'text', 
                        'title'     =>  __('Custom iOS Bookmark Title', 'wppandashop5'),
                        'subtitle'  =>  __('Enter a custom title for your site for when it is added as an iOS bookmark.', 'wppandashop5'),
                        'default'   =>  ''
                    ),

                    array(
                        'id'        =>  'custom_ios_57',
                        'type'      =>  'media', 
                        'title'     =>  __('Custom iOS 57x57', 'wppandashop5'),
                        'subtitle'  =>  __('Upload a 57px x 57px Png image that will be your website bookmark on non-retina iOS devices.', 'wppandashop5'),
                        'desc'      =>  ''
                    ),

                    array(
                        'id'        =>  'custom_ios_72',
                        'type'      =>  'media', 
                        'title'     =>  __('Custom iOS 72x72', 'wppandashop5'),
                        'subtitle'  =>  __('Upload a 72px x 72px Png image that will be your website bookmark on non-retina iOS devices.', 'wppandashop5'),
                        'desc'      =>  ''
                    ),

                    array(
                        'id'        =>  'custom_ios_114',
                        'type'      =>  'media', 
                        'title'     =>  __('Custom iOS 114x114', 'wppandashop5'),
                        'subtitle'  =>  __('Upload a 114px x 114px Png image that will be your website bookmark on retina iOS devices.', 'wppandashop5'),
                        'desc'      =>  ''
                    ),

                    array(
                        'id'        =>  'custom_ios_144',
                        'type'      =>  'media', 
                        'title'     =>  __('Custom iOS 144x144', 'wppandashop5'),
                        'subtitle'  =>  __('Upload a 144px x 144px Png image that will be your website bookmark on retina iOS devices.', 'wppandashop5'),
                        'desc'      =>  ''
                    ),
                   */

                )
            );

                // Preloader
            /*    $this->sections[] = array(
                    'title'         =>  __('Preloader', 'wppandashop5'),
                    'subsection'    =>  true,
                    'icon'          =>  'font-icon-arrow-right-simple-thin-round',
                    'customizer'    =>  false, 
                    'fields'        =>  array(
                        
                        // Preloader
                        array(
                            'id'        =>  'preloader_settings',
                            'type'      =>  'switch',
                            'title'     =>  __('Preloader Page/Post', 'wppandashop5'),
                            'subtitle'  =>  __('Enable/Disable preloader page/post for your site.', 'wppandashop5'),
                            'desc'      =>  '',
                            'default'   =>  0
                        ),

                        array(
                            'id'        =>  'global_preloader_visibility',
                            'type'      =>  'button_set',
                            'required'  =>  array('preloader_settings','=','1'), 
                            'title'     =>  __('Global Preloader Setting', 'wppandashop5'),
                            'subtitle'  =>  __('Enable or Disable the Preloader.<br/><br/><em>If you want can modify in each page/post the setting about the preloader.</em>', 'wppandashop5'),
                            'desc'      =>  '',
                            'options'   =>  array(
                                'show'  =>  'Show',
                                'hide'  =>  'Hide',
                            ),
                            'default'   =>  'show',
                        ),

                        array(
                            'id'        =>  'preloader_design_mode',
                            'type'      =>  'button_set',
                            'required'  =>  array('preloader_settings','=','1'),
                            'title'     =>  __('Preloader Design', 'wppandashop5'),
                            'subtitle'  =>  __('Select your design for your preloader.', 'wppandashop5'),
                            'desc'      =>  '',
                            'options'   =>  array(
                                '1'     =>  'Default',
                                '2'     =>  'Image'
                            ),
                            'default'   =>  '1'
                        ),

                        array(
                            'id'        =>  'preloader_media_image',
                            'type'      =>  'media', 
                            'required'  =>  array('preloader_design_mode','=','2'),
                            'title'     =>  __('Preloader Custom Image', 'wppandashop5'),
                            'subtitle'  =>  __('Upload a PNG or GIF image that will be used in all applicable areas on your site as the loading image.', 'wppandashop5'),
                            'desc'      =>  ''
                        ),

                    )
                ); */

                // Common
              /*  $this->sections[] = array(
                    'title'         =>  __('Common Options', 'wppandashop5'),
                    'subsection'    =>  true,
                    'icon'          =>  'font-icon-arrow-right-simple-thin-round',
                    'customizer'    =>  false, 
                    'fields'        =>  array(
                        
                        // Animation on Mobile Devices
                        array(
                            'id'        =>  'enable_mobile_scroll_animation_effects',
                            'type'      =>  'switch',
                            'title'     =>  __('Scroll Animation Effects on Mobile/Tablet devices', 'wppandashop5'),
                            'subtitle'  =>  __('Enable/Disable scroll animation effects on mobile/tablet devices for items.', 'wppandashop5'),
                            'desc'      =>  '',
                            'default'   =>  0
                        ),

                        // Back to Top
                        array(
                            'id'        =>  'enable_back_to_top',
                            'type'      =>  'switch',
                            'title'     =>  __('Back to Top', 'wppandashop5'),
                            'subtitle'  =>  __('Enable/Disable Back to Top Feature.', 'wppandashop5'),
                            'desc'      =>  '',
                            'default'   =>  1
                        ),

                        // Comments Pages
                        array(
                            'id'        =>  'enable_comments_page',
                            'type'      =>  'switch',
                            'title'     =>  __('Comments Pages', 'wppandashop5'),
                            'subtitle'  =>  __('Enable/Disable for Pages only.', 'wppandashop5'),
                            'desc'      =>  '',
                            'default'   =>  1
                        ),

                        // Disable Right Click
                        array(
                            'id'        =>  'disable_right_click',
                            'type'      =>  'switch',
                            'title'     =>  __('Disable Right Click', 'wppandashop5'),
                            'subtitle'  =>  __('Enable/Disable Right Click Feature.', 'wppandashop5'),
                            'desc'      =>  '',
                            'default'   =>  0
                        ),

                    )
                );

                // Tracking Code
                $this->sections[] = array(
                    'title'         =>  __('Tracking Code', 'wppandashop5'),
                    'subsection'    =>  true,
                    'icon'          =>  'font-icon-arrow-right-simple-thin-round',
                    'customizer'    =>  false,
                    'fields'        =>  array(
                        
                        // Tracking Code
                        array(
                            'id'        =>  'tracking_code',
                            'type'      =>  'text',
                            'title'     =>  __('Tracking Code', 'wppandashop5'),
                            'subtitle'  =>  __('Paste your Google Analytics Property ID ( UA-XXXX-Y ).<br/><br/>This code will be added before the closing &lt;head&gt; tag.', 'wppandashop5'),
                            'desc'      =>  __('NOTE: This use a default analytics js code. If you want a specific requirements not use this but include the script manually.', 'wppandashop5')
                        ),

                    )
                );

                // Custom CSS/JS Options
                $this->sections[] = array(
                    'title'         =>  __('Custom CSS/JS', 'wppandashop5'),
                    'subsection'    =>  true,
                    'icon'          =>  'font-icon-arrow-right-simple-thin-round',
                    'customizer'    =>  false,
                    'fields'        =>  array(

                        // Enable Custom CSS
                        array(
                            'id'        =>  'enable_custom_css',
                            'type'      =>  'switch', 
                            'title'     =>  __('Custom CSS', 'wppandashop5'),
                            'subtitle'  =>  __('Do you want enable custom css?', 'wppandashop5'),
                            'desc'      =>  '',
                            'default'   =>  0
                        ),

                        // Custom CSS
                        array(
                            'id'        =>  'custom_css',
                            'type'      =>  'ace_editor',
                            'required'  =>  array('enable_custom_css','=','1'),
                            'title'     =>  __('Custom CSS Code', 'wppandashop5'),
                            'subtitle'  =>  __('If you have any custom CSS you would like added to the site, please enter it here.<br/><br/>This code will be added before the closing &lt;head&gt; tag.', 'wppandashop5'),
                            'mode'      =>  'css',
                            'theme'     =>  'monokai',
                            'desc'      =>  ''
                        ),

                        // Enable Custom JS
                        array(
                            'id'        =>  'enable_custom_js',
                            'type'      =>  'switch', 
                            'title'     =>  __('Custom JS', 'wppandashop5'),
                            'subtitle'  =>  __('Do you want enable custom js?', 'wppandashop5'),
                            'desc'      =>  '',
                            'default'   =>  0
                        ),

                        // Custom JS
                        array(
                            'id'        =>  'custom_js',
                            'type'      =>  'ace_editor',
                            'mode'      =>  'javascript',
                            'theme'     =>  'chrome',
                            'required'  =>  array('enable_custom_js','=','1'),
                            'title'     =>  __('Custom JS Code', 'wppandashop5'),
                            'subtitle'  =>  __('If you have any custom js you would like added to the site, please enter it here.<br/><br/>This code will be added before the closing &lt;body&gt; tag.', 'wppandashop5'),
                            'desc'      =>  __('NOTE: Write or Copy &amp; Paste only the javascript/jquery code without the &lt;script&gt; tag.', 'wppandashop5')
                        ),

                    )
                );

                // Performance
                $this->sections[] = array(
                    'title'         =>  __('Performance', 'wppandashop5'),
                    'subsection'    =>  true,
                    'icon'          =>  'font-icon-arrow-right-simple-thin-round',
                    'customizer'    =>  false, 
                    'fields'        =>  array(
                        
                        // Preloader
                        array(
                            'id'        =>  'performance_minified_settings',
                            'type'      =>  'switch',
                            'title'     =>  __('Load Minified File', 'wppandashop5'),
                            'subtitle'  =>  __('Load style.css and the main.js minfied version, the other files are already minified by default.', 'wppandashop5'),
                            'desc'      =>  '',
                            'default'   =>  0
                        ),

                    )
                );

 */
            
            /*-----------------------------------------------------------------------------------*/
            /*  - Typography
            /*-----------------------------------------------------------------------------------*/
        /*    $this->sections[] = array(
                'title'      =>  __('Typography', 'wppandashop5'),
                'desc'       =>  __('Welcome to the WP Panda Shop 5 Options Panel! Control and configure the typography of your theme.', 'wppandashop5'),
                'icon'       =>  'font-icon-pencil',
                'customizer' =>  false,  
                'fields'     =>  array(
                    
                    // Enable Custom Fonts
                    array(
                        'id'        =>  'enable_custom_fonts',
                        'type'      =>  'switch', 
                        'title'     =>  __('Custom Fonts', 'wppandashop5'),
                        'subtitle'  =>  __('Do you want enable custom fonts?', 'wppandashop5'),
                        'desc'      =>  '',
                        'default'   =>  0
                    ),

                    // Logo Text
                    array(
                        'id'            =>  'logo_text_typo',
                        'type'          =>  'typography',
                        'required'      =>  array('enable_custom_fonts','=','1'),
                        'title'         =>  __( 'Logo Text', 'wppandashop5' ),
                        'compiler'      =>  false, // Use if you want to hook in your own CSS compiler
                        'google'        =>  true,  // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup'   =>  false, // Select a backup non-google font in addition to a google font
                        'font-style'    =>  false, // Includes font-style and weight. Can use font-style or font-weight to declare
                        'font-weight'   =>  false,
                        'font-size'     =>  false,
                        'subsets'       =>  true,  // Only appears if google is true and subsets not set to false
                        'line-height'   =>  false,
                        'text-align'    =>  false,
                        'word-spacing'  =>  false,
                        'letter-spacing'=>  false,
                        'color'         =>  false,
                        'preview'       =>  true,  // Disable the previewer
                        'all_styles'    =>  true,  // Enable all Google Font style/weight variations to be added to the page
                        'units'         =>  'rem',
                        'subtitle'      =>  __( 'You can change the font of these elements: logo text type only.<br><br>( see the documentation for details )', 'wppandashop5' ),
                        
                        'default'  => array(
                            'font-family' =>  'Montserrat',
                            'google'      =>  true
                        ),
                    ),

                    // Body and Others
                    array(
                        'id'            =>  'general_body_common_text_typo',
                        'type'          =>  'typography',
                        'required'      =>  array('enable_custom_fonts','=','1'),
                        'title'         =>  __( 'Body and Others', 'wppandashop5' ),
                        'compiler'      =>  false, // Use if you want to hook in your own CSS compiler
                        'google'        =>  true,  // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup'   =>  false, // Select a backup non-google font in addition to a google font
                        'font-style'    =>  false, // Includes font-style and weight. Can use font-style or font-weight to declare
                        'font-weight'   =>  false,
                        'font-size'     =>  false,
                        'subsets'       =>  true,  // Only appears if google is true and subsets not set to false
                        'line-height'   =>  false,
                        'text-align'    =>  false,
                        'word-spacing'  =>  false,
                        'letter-spacing'=>  false,
                        'color'         =>  false,
                        'preview'       =>  true,  // Disable the previewer
                        'all_styles'    =>  true,  // Enable all Google Font style/weight variations to be added to the page
                        'units'         =>  'rem',
                        'subtitle'      =>  __( 'You can change the font of these elements: body and others elements.<br><br>( see the documentation for details )', 'wppandashop5' ),
                        
                        'default'  => array(
                            'font-family' =>  'Source Sans Pro',
                            'google'      =>  true
                        ),
                    ),

                    // Headings and Others
                    array(
                        'id'            =>  'general_heading_common_text_typo',
                        'type'          =>  'typography',
                        'required'      =>  array('enable_custom_fonts','=','1'),
                        'title'         =>  __( 'Headings and Others', 'wppandashop5' ),
                        'compiler'      =>  false, // Use if you want to hook in your own CSS compiler
                        'google'        =>  true,  // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup'   =>  false, // Select a backup non-google font in addition to a google font
                        'font-style'    =>  false, // Includes font-style and weight. Can use font-style or font-weight to declare
                        'font-weight'   =>  false,
                        'font-size'     =>  false,
                        'subsets'       =>  true,  // Only appears if google is true and subsets not set to false
                        'line-height'   =>  false,
                        'text-align'    =>  false,
                        'word-spacing'  =>  false,
                        'letter-spacing'=>  false,
                        'color'         =>  false,
                        'preview'       =>  true,  // Disable the previewer
                        'all_styles'    =>  true,  // Enable all Google Font style/weight variations to be added to the page
                        'units'         =>  'rem',
                        'subtitle'      =>  __( 'You can change the font of these elements: headings and others elements.<br><br>( see the documentation for details )', 'wppandashop5' ),
                        
                        'default'  => array(
                            'font-family' =>  'Montserrat',
                            'google'      =>  true
                        ),
                    ),

                    // Special and Others
                    array(
                        'id'            =>  'general_special_common_text_typo',
                        'type'          =>  'typography',
                        'required'      =>  array('enable_custom_fonts','=','1'),
                        'title'         =>  __( 'Special and Others', 'wppandashop5' ),
                        'compiler'      =>  false, // Use if you want to hook in your own CSS compiler
                        'google'        =>  true,  // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup'   =>  false, // Select a backup non-google font in addition to a google font
                        'font-style'    =>  false, // Includes font-style and weight. Can use font-style or font-weight to declare
                        'font-weight'   =>  false,
                        'font-size'     =>  false,
                        'subsets'       =>  true,  // Only appears if google is true and subsets not set to false
                        'line-height'   =>  false,
                        'text-align'    =>  false,
                        'word-spacing'  =>  false,
                        'letter-spacing'=>  false,
                        'color'         =>  false,
                        'preview'       =>  true,  // Disable the previewer
                        'all_styles'    =>  true,  // Enable all Google Font style/weight variations to be added to the page
                        'units'         =>  'rem',
                        'subtitle'      =>  __( 'You can change the font of these elements: Normal Title Header and others elements.<br><br>( see the documentation for details )', 'wppandashop5' ),
                        
                        'default'  => array(
                            'font-family' =>  'Crimson Text',
                            'google'      =>  true
                        ),
                    ),
                    

                )
            );

            /*-----------------------------------------------------------------------------------*/
            /*  - Colors
            /*-----------------------------------------------------------------------------------*/
       /*     $this->sections[] = array(
                'title'      =>  __('Colors', 'wppandashop5'),
                'desc'       =>  __('Welcome to the WP Panda Shop 5 Options Panel! Control and configure the colors setup of your theme.', 'wppandashop5'),
                'icon'       =>  'font-icon-brush',
                'customizer' =>  true,  
                'fields'     =>  array(

                    // Enable Custom Colors
                    array(
                        'id'        =>  'enable_custom_colors',
                        'type'      =>  'switch', 
                        'title'     =>  __('Custom Colors', 'wppandashop5'),
                        'subtitle'  =>  __('Do you want enable custom colors?', 'wppandashop5'),
                        'desc'      =>  '',
                        'default'   =>  0
                    ),

                    // Logo/Navigation Type Colors
                    array(
                        'id'            =>  'light_type_custom_color',
                        'type'          =>  'color',   
                        'required'      =>  array('enable_custom_colors','=','1'),
                        'title'         =>  __( 'Light Type Logo/Navigation Colors', 'wppandashop5' ),
                        'subtitle'      =>  __( 'You can change the colors based on Light Logo/Navigation Type.<br><br>This modify the colors for header and some elements of Title Header.<br><br>( see the documentation for details )', 'wppandashop5' ),
                        'default'       =>  '#FFFFFF',
                        'transparent'   =>  false,
                    ),

                    array(
                        'id'            =>  'dark_type_custom_color',
                        'type'          =>  'color',   
                        'required'      =>  array('enable_custom_colors','=','1'),
                        'title'         =>  __( 'Dark Type Logo/Navigation Colors', 'wppandashop5' ),
                        'subtitle'      =>  __( 'You can change the colors based on Dark Logo/Navigation Type.<br><br>This modify the colors for header and some elements of Title Header.<br><br>( see the documentation for details )', 'wppandashop5' ),
                        'default'       =>  '#28282E',
                        'transparent'   =>  false,
                    ),

                    // Body and Others
                    array(
                        'id'            =>  'general_body_custom_color',
                        'type'          =>  'color',   
                        'required'      =>  array('enable_custom_colors','=','1'),
                        'title'         =>  __( 'Body and Others Colors', 'wppandashop5' ),
                        'subtitle'      =>  __( 'You can change the colors of these elements: body and others elements connected with this color.<br><br>( see the documentation for details )', 'wppandashop5' ),
                        'default'       =>  '#5D556F',
                        'transparent'   =>  false,
                    ),

                    // Main and Others
                    array(
                        'id'            =>  'general_main_custom_color',
                        'type'          =>  'color',   
                        'required'      =>  array('enable_custom_colors','=','1'),
                        'title'         =>  __( 'Main and Others Colors', 'wppandashop5' ),
                        'subtitle'      =>  __( 'You can change the colors of these elements: link and others elements connected with this color.<br><br>( see the documentation for details )', 'wppandashop5' ),
                        'default'       =>  '#EF4135',
                        'transparent'   =>  false,
                    ),

                )
            );


            /*-----------------------------------------------------------------------------------*/
            /*  - Header
            /*-----------------------------------------------------------------------------------*/
            $this->sections[] = array(
                'title'     =>  __('Header', 'wppandashop5'),
                'icon'      =>  'font-icon-list-2',
//            );
//
//                // Logo
//                $this->sections[] = array(
//                    'title'         =>  __('Menu & Logo', 'wppandashop5'),
//                    'subsection'    =>  true,
//                    'icon'          =>  'font-icon-arrow-right-simple-thin-round',
                    'customizer'    =>  false,
                    'fields'        =>  array(

                        array(
                            'id'       => 'header_layout',
                            'type'     => 'radio',
                            'title'    => __( 'Header layout', 'redux-framework-demo' ),
                            'subtitle' => __( 'Selected header layout.', 'redux-framework-demo' ),
                            //'desc'     => __( 'Selected header layout.', 'redux-framework-demo' ),
                            //Must provide key => value pairs for radio options
                            'options'  => array(
                                '1' => __( 'Header 1', 'redux-framework-demo' ),
                                '2' => __( 'Header 2', 'redux-framework-demo' ),
                                '3' => __( 'Header 3', 'redux-framework-demo' ),
                                '4' => __( 'Header 4', 'redux-framework-demo' ),
                                '5' => __( 'Header 5', 'redux-framework-demo' ),
                                '6' => __( 'Header 6', 'redux-framework-demo' ),
                                '7' => __( 'Header 7', 'redux-framework-demo' ),
                                '8' => __( 'Header 8', 'redux-framework-demo' ),
                                '9' => __( 'Header 9', 'redux-framework-demo' )
                            ),
                            'default'  => '1'
                        ),

                        array(
                            'id'        =>  'h_t',
                            'type'      =>  'text',
                           // 'required'  =>  array('use_logo_image','=','1'),
                            'title'     =>  __('Текст верхней панели', 'wppandashop5'),
                            //'subtitle'  =>  __('<em>Optional</em>. Upload your Dark Retina Logo version for Retina Devices. Double Size of Dark Logo PNG.', 'wppandashop5'),
                            'desc'      =>  '+38 099 454 43 30'
                        ),


            /*            // Menu Type
                        array(
                            'id'        =>  'global_menu_type',
                            'type'      =>  'button_set',
                            'title'     =>  __('Menu Type', 'wppandashop5'),
                            'subtitle'  =>  __('The setting refers to which type of menu will appear.<br/><br/><em>The social icons appear into footer credits area.</em>', 'wppandashop5'),
                            'desc'      =>  '',
                            'options'   =>  array(
                                'creative' =>  'Creative',
                                'classic'  =>  'Classic',
                            ),
                            'default'   =>  'creative',
                        ),

                        // Logo/Navigation Type
                        array(
                            'id'        =>  'global_logo_navi_type_color',
                            'type'      =>  'button_set',
                            'title'     =>  __('Global Logo/Navigation Type', 'wppandashop5'),
                            'subtitle'  =>  __('The setting refers to which type of logo/navigation will appear.<br/><br/><em>If you want can modify in each page/post the setting about the color type.</em>', 'wppandashop5'),
                            'desc'      =>  '',
                            'options'   =>  array(
                                'light' =>  'Light',
                                'dark'  =>  'Dark',
                            ),
                            'default'   =>  'light',
                        ),

                        // Logo Top Value
                        array(
                            'id'       =>  'logo_top_value',
                            'type'     =>  'text',
                            'title'    =>  __( 'Logo Top Value', 'wppandashop5' ),
                            'subtitle' =>  __( 'Set your custom value for top logo position.<br/><br/><em>Default is 3</em>', 'wppandashop5' ),
                            'desc'     =>  __( 'Insert only a number. (no px)', 'wppandashop5' ),
                            'default'  =>  '',
                        ),
                        
                        // Logo Max-Height Value
                        array(
                            'id'       =>  'logo_max_height_value',
                            'type'     =>  'text',
                            'title'    =>  __( 'Logo Max-Height Value', 'wppandashop5' ),
                            'subtitle' =>  __( 'Set a max height for the logo here, and this will resize it on the front end if your logo image is bigger.<br/><br/><em>Default is 50</em>', 'wppandashop5' ),
                            'desc'     =>  __( 'Insert only a number. (no px)', 'wppandashop5' ),
                            'default'  =>  '50',
                        ),

                        // Logo Text or Logo Image
                        array(
                            'id'        =>  'use_logo_image',
                            'type'      =>  'switch',
                            'title'     =>  __('Use Image for Logo?', 'wppandashop5'),
                            'subtitle'  =>  __('Upload a logo for your theme.<br/> Otherwise you will see the Plain Text Logo.', 'wppandashop5'),
                            'desc'      =>  '',
                            'default'   =>  0
                        ),

                        array(
                            'id'        =>  'logo',
                            'type'      =>  'media',
                            'required'  =>  array('use_logo_image','=','1'),    
                            'title'     =>  __('Logo PNG Upload', 'wppandashop5'),
                            'subtitle'  =>  __('Upload your logo.', 'wppandashop5'),
                            'desc'      =>  ''  
                        ),

                        array(
                            'id'        =>  'retina_logo',
                            'type'      =>  'media',
                            'required'  =>  array('use_logo_image','=','1'),
                            'title'     =>  __('Retina PNG Logo Upload', 'wppandashop5'),
                            'subtitle'  =>  __('Upload your Retina Logo for Retina Devices. Double Size of Logo PNG.', 'wppandashop5'),
                            'desc'      =>  ''  
                        ),

                        array(
                            'id'        =>  'dark_logo',
                            'type'      =>  'media',
                            'required'  =>  array('use_logo_image','=','1'),    
                            'title'     =>  __('Dark Logo PNG Upload', 'wppandashop5'),
                            'subtitle'  =>  __('<em>Optional</em>. Upload your Dark Logo version.', 'wppandashop5'),
                            'desc'      =>  ''  
                        ),

                        array(
                            'id'        =>  'dark_retina_logo',
                            'type'      =>  'media',
                            'required'  =>  array('use_logo_image','=','1'),
                            'title'     =>  __('Dark Retina PNG Logo Upload', 'wppandashop5'),
                            'subtitle'  =>  __('<em>Optional</em>. Upload your Dark Retina Logo version for Retina Devices. Double Size of Dark Logo PNG.', 'wppandashop5'),
                            'desc'      =>  ''  
                        ),

      */              )
                );

                // Top Side
        /*        $this->sections[] = array(
                    'title'         =>  __('Top Side', 'wppandashop5'),
                    'subsection'    =>  true,
                    'icon'          =>  'font-icon-arrow-right-simple-thin-round',
                    'customizer'    =>  false,
                    'fields'        =>  array(

                        array(
                            'id'        =>  'global_optional_header_menu',
                            'type'      =>  'button_set',
                            'title'     =>  __('Search/Share/Language Menu', 'wppandashop5'),
                            'subtitle'  =>  __('The setting refers to enable search, share and language switcher functionality on header area.', 'wppandashop5'),
                            'desc'      =>  '',
                            'options'   =>  array(
                                'show'  =>  'Show',
                                'hide'  =>  'Hide',
                            ),
                            'default'   =>  'hide',
                        ),

                        // Scroll Fx
                        array(
                            'id'        =>  'global_optional_header_menu_scroll',
                            'type'      =>  'button_set',
                            'required'  =>  array('global_optional_header_menu','=','show'),
                            'title'     =>  __( 'Scroll Effects', 'wppandashop5' ),
                            'subtitle'  =>  __( 'Activate the scroll feature for search/share menu.<br/><br/><em>Available on with Menu Creative.</em>', 'wppandashop5' ),
                            'desc'      =>  '',
                            'options'   =>  array(
                                'always'   =>  'Always Visible',
                                'scroll'   =>  'Only Scroll Up',
                            ),
                            'default'   =>  'always',
                        ),

                        // Search
                        array(
                            'id'        =>  'global_menu_search_button',
                            'type'      =>  'button_set',
                            'required'  =>  array('global_optional_header_menu','=','show'),
                            'title'     =>  __( 'Search', 'wppandashop5' ),
                            'subtitle'  =>  __( 'Enable or Disable Search Feature.', 'wppandashop5' ),
                            'desc'      =>  '',
                            'options'   =>  array(
                                'enable'   =>  'Enable',
                                'disable'  =>  'Disable',
                            ),
                            'default'   =>  'disable',
                        ),

                        // Share
                        array(
                            'id'        =>  'global_menu_share_button',
                            'type'      =>  'button_set',
                            'required'  =>  array('global_optional_header_menu','=','show'),
                            'title'     =>  __( 'Share', 'wppandashop5' ),
                            'subtitle'  =>  __( 'Enable or Disable Share Page Feature.', 'wppandashop5' ),
                            'desc'      =>  '',
                            'options'   =>  array(
                                'enable'   =>  'Enable',
                                'disable'  =>  'Disable',
                            ),
                            'default'   =>  'disable',
                        ),

                        // Twitter
                        array(
                            'id'        =>  'header_twitter_share',
                            'type'      =>  'checkbox',
                            'required'  =>  array('global_menu_share_button','=','enable'),
                            'title'     =>  __('Twitter', 'wppandashop5'),
                            'subtitle'  =>  'Tweet it.',
                            'desc'      =>  '',
                            'default'   =>  '1'
                        ),  

                        // Facebook
                        array(
                            'id'        =>  'header_facebook_share',
                            'type'      =>  'checkbox',
                            'required'  =>  array('global_menu_share_button','=','enable'),
                            'title'     =>  __('Facebook', 'wppandashop5'),
                            'subtitle'  =>  'Share it.',
                            'desc'      =>  '',
                            'default'   =>  '1'
                        ),

                        // Google Plus
                        array(
                            'id'        =>  'header_google_share',
                            'type'      =>  'checkbox',
                            'required'  =>  array('global_menu_share_button','=','enable'),
                            'title'     =>  __('Google Plus', 'wppandashop5'),
                            'subtitle'  =>  'Google it.',
                            'desc'      =>  '',
                            'default'   =>  '1'
                        ),

                        // Pinterest
                        array(
                            'id'        =>  'header_pinterest_share',
                            'type'      =>  'checkbox',
                            'required'  =>  array('global_menu_share_button','=','enable'),
                            'title'     =>  __('Pinterest', 'wppandashop5'),
                            'subtitle'  =>  'Pin it.',
                            'desc'      =>  '',
                            'default'   =>  '1'
                        ),

                        // Linked In
                        array(
                            'id'        =>  'header_linkedin_share',
                            'type'      =>  'checkbox',
                            'required'  =>  array('global_menu_share_button','=','enable'),
                            'title'     =>  __('Linked In', 'wppandashop5'),
                            'subtitle'  =>  'Linked it.',
                            'desc'      =>  '',
                            'default'   =>  '1'
                        ),

                        // Language Switcher
                        array(
                            'id'        =>  'global_menu_language_button',
                            'type'      =>  'button_set',
                            'required'  =>  array('global_optional_header_menu','=','show'),
                            'title'     =>  __( 'Language Switcher', 'wppandashop5' ),
                            'subtitle'  =>  __( 'Enable or Disable Language Switcher Feature.<br/><em>Required WPML Installed</em>', 'wppandashop5' ),
                            'desc'      =>  '',
                            'options'   =>  array(
                                'enable'   =>  'Enable',
                                'disable'  =>  'Disable',
                            ),
                            'default'   =>  'disable',
                        ),

                    )
                );
                
                // Left Side
                $this->sections[] = array(
                    'title'         =>  __('Left Side', 'wppandashop5'),
                    'subsection'    =>  true,
                    'icon'          =>  'font-icon-arrow-right-simple-thin-round',
                    'customizer'    =>  false,
                    'fields'        =>  array(

                        array(
                            'id'            =>  'left_side_slogan_visibility',
                            'type'          =>  'button_set',
                            'title'         =>  __( 'Left Side Panel', 'wppandashop5' ),
                            'subtitle'      =>  __( 'The setting refers to enable the slogan box in the menu area.', 'wppandashop5' ),
                            'options'       =>  array(
                                'show'   =>  'Show',
                                'hide'   =>  'Hide',
                            ),
                            'default'       =>  'show',
                        ),

                        array(
                            'id'            =>  'left_side_header_menu',
                            'type'          =>  'button_set',
                            'required'      =>  array('left_side_slogan_visibility','=','show'),
                            'title'         =>  __( 'Left Side Mode', 'wppandashop5' ),
                            'subtitle'      =>  __( 'Choose if the slogan area have the solid background or a custom image background.', 'wppandashop5' ),
                            'options'       =>  array(
                                'solid_color'   =>  'Solid Color',
                                'bg_image'      =>  'Background Image',
                            ),
                            'default'       =>  'solid_color',
                        ),

                        array(
                            'id'            =>  'left_side_background_color',
                            'type'          =>  'color',
                            'required'      =>  array('left_side_header_menu','=','solid_color'),   
                            'title'         =>  __( 'Solid Background Color', 'wppandashop5' ),
                            'subtitle'      =>  __( '<em>Optional</em>. Select your custom hex color.', 'wppandashop5' ),
                            'default'       =>  '',
                            'transparent'   =>  false,
                        ),

                        array(
                            'id'            =>  'left_side_overaly_mask_color',
                            'type'          =>  'color_rgba',
                            'required'      =>  array('left_side_header_menu','=','bg_image'),   
                            'title'         =>  __( 'Mask Overlay Color', 'wppandashop5' ),
                            'subtitle'      =>  __( '<em>Required</em>. Select your custom hex color with opacity.', 'wppandashop5' ),
                            'default'       =>  array( 'color' => '#000000', 'alpha' => '0.55' ),
                            'validate'      =>  'colorrgba',
                            'transparent'   =>  false,
                        ),

                        // Image
                        array(
                            'id'            =>  'left_side_background_image',
                            'type'          =>  'media',  
                            'title'         =>  __( 'Background Image', 'wppandashop5' ),
                            'subtitle'      =>  __( '<em>Required</em>. Upload your background image.', 'wppandashop5' ),
                            'desc'          =>  '',
                            'required'      =>  array('left_side_header_menu','=','bg_image'),
                        ),

                        array(
                            'id'        =>  'left_side_background_image_position',
                            'type'      =>  'select',
                            'title'     =>  __('Background Image: Position', 'wppandashop5'),
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
                            'required'  =>  array('left_side_header_menu','=','bg_image'),
                        ),

                        array(
                            'id'        =>  'left_side_background_image_repeat',
                            'type'      =>  'select',
                            'title'     =>  __('Background Image: Repeat', 'wppandashop5'),
                            'subtitle'  =>  __('Select your background image repeat.', 'wppandashop5'),
                            'options'   =>  array(
                                'no_repeat' =>  __( 'No Repeat', 'wppandashop5' ),
                                'repeat'    =>  __( 'Repeat', 'wppandashop5' ),
                                'repeat_x'  =>  __( 'Repeat Horizontally', 'wppandashop5' ),
                                'repeat_y'  =>  __( 'Repeat Vertically', 'wppandashop5' ),
                                'stretch'   =>  __( 'Stretch to fit', 'wppandashop5' ),
                            ),
                            'default'   =>  'stretch',
                            'required'  =>  array('left_side_header_menu','=','bg_image'),
                        ),
                        
                        // Slogan Image/Text
                        array(
                            'id'            =>  'left_side_header_slogan_logo',
                            'type'          =>  'media',   
                            'required'      =>  array('left_side_slogan_visibility','=','show'),
                            'title'         =>  __('Slogan Logo', 'wppandashop5'),
                            'subtitle'      =>  __('<em>Optional</em>. Upload your slogan logo.', 'wppandashop5'),
                            'desc'          =>  '',  
                        ),

                        array(
                            'id'            =>  'left_side_header_slogan_text',
                            'type'          =>  'textarea',   
                            'required'      =>  array('left_side_slogan_visibility','=','show'),
                            'title'         =>  __('Slogan Text', 'wppandashop5'),
                            'subtitle'      =>  __('<em>Optional</em>. Enter your slogan text.<br/><em>Only br and strong HTML tags is allowed.</em>', 'wppandashop5'),
                            'desc'          =>  '',
                            'validate'      =>  'html',  
                        ),

                        array(
                            'id'            =>  'left_side_header_slogan_text_color',
                            'type'          =>  'color',
                            'required'      =>  array('left_side_slogan_visibility','=','show'),
                            'title'         =>  __( 'Slogan Text Color', 'wppandashop5' ),
                            'subtitle'      =>  __( 'Optional. Choose a text color for your slogan text.', 'wppandashop5' ),
                            'output'        =>  false,
                            'validate'      =>  false,
                            'transparent'   =>  false,
                            'default'       =>  '',
                        ),

                    )
                );

                // Right Side
                $this->sections[] = array(
                    'title'         =>  __('Right Side', 'wppandashop5'),
                    'subsection'    =>  true,
                    'icon'          =>  'font-icon-arrow-right-simple-thin-round',
                    'customizer'    =>  false,
                    'fields'        =>  array(

                        array(
                            'id'        =>  'header_social_link',
                            'type'      =>  'switch',
                            'title'     =>  __('Social Profiles', 'wppandashop5'),
                            'subtitle'  =>  __('Activate this to enable social profiles on your header.<br/><br/>You can set your social profile in <strong>Social Options Tabs</strong>.', 'wppandashop5'),
                            'desc'      =>  '',
                            'default'   =>  0
                        ),

                    )
                );

            /*-----------------------------------------------------------------------------------*/
            /*  - Title Header
            /*-----------------------------------------------------------------------------------*/

            // Title Header
        /*    $this->sections[] = array(
                'title'         =>  __('Title Header', 'wppandashop5'),
                'desc'          =>  __('Control and configure the globals variable about the title header for pages, posts and custom post types ( portfolio and team ). If you want can modify in each page the all settings based on your needs.', 'wppandashop5'),
                'icon'          =>  'font-icon-book',
                'customizer'    =>  false,
                'fields'        =>  array(

                    array(
                        'id'        =>  'global_title_header_visibility',
                        'type'      =>  'button_set',
                        'title'     =>  __('Title Header', 'wppandashop5'),
                        'subtitle'  =>  __('Enable or Disable the Title Header Area.', 'wppandashop5'),
                        'desc'      =>  '',
                        'options'   =>  array(
                            'show'  =>  'Show',
                            'hide'  =>  'Hide',
                        ),
                        'default'   =>  'show',
                    ),

                    // Title Header Hide Options
                    array(
                        'id'        =>  'global_title_header_hide_visibility',
                        'type'      =>  'button_set',
                        'required'      =>  array('global_title_header_visibility','=','hide'),
                        'title'     =>  __('Title Header', 'wppandashop5'),
                        'subtitle'  =>  __('Select if the page header is transparent or has a simple background color when this is hide.', 'wppandashop5'),
                        'desc'      =>  '',
                        'options'   =>  array(
                            'transparent'  =>  'Transparent',
                            'colorful'     =>  'Colorful',
                        ),
                        'default'   =>  'colorful',
                    ),

                    array(
                        'id'            =>  'global_title_header_hide_color',
                        'type'          =>  'color',   
                        'required'      =>  array('global_title_header_hide_visibility','=','colorful'),
                        'title'         =>  __( 'Title Header Hide Background Color', 'wppandashop5' ),
                        'subtitle'      =>  __( '<em>Optional</em>. Choose a background color for your title header when this is hide.', 'wppandashop5' ),
                        'default'       =>  '',
                        'transparent'   =>  false,
                    ),

                    // Title Header
                    array(
                        'id'            =>  'global_title_header_normal_bg_color',
                        'type'          =>  'color',   
                        'required'      =>  array('global_title_header_visibility','=','show'),
                        'title'         =>  __( 'Title Header Background Color', 'wppandashop5' ),
                        'subtitle'      =>  __( '<em>Optional</em>. Choose a background color for your title header section.', 'wppandashop5' ),
                        'default'       =>  '',
                        'transparent'   =>  false,
                    ),

                    array(
                        'id'        =>  'global_title_header_layout_container',
                        'type'      =>  'button_set',
                        'required'  =>  array('global_title_header_visibility','=','show'), 
                        'title'     =>  __('Title Header Layout', 'wppandashop5'),
                        'subtitle'  =>  __('Select your layout for the title header page.', 'wppandashop5'),
                        'desc'      =>  '',
                        'options'   =>  array(
                            'normal'      =>  'Normal',
                            'fullscreen'  =>  'Full Screen',
                        ),
                        'default'   =>  'normal',
                    ),

                    array(
                        'id'        =>  'global_title_header_height',
                        'type'      =>  'text',
                        'required'  =>  array('global_title_header_layout_container','=','normal'),
                        'title'     =>  __( 'Title Header Height', 'wppandashop5' ),
                        'subtitle'  =>  __( 'Select your custom height for your title header page.<br/>Default is 600px.', 'wppandashop5' ),
                        'desc'      =>  '',
                        'default'   =>  '',
                    ),

                    array(
                        'id'        =>  'global_scroll_to_section',
                        'type'      =>  'button_set',
                        'required'  =>  array('global_title_header_layout_container','=','fullscreen'),
                        'title'     =>  __( 'Scroll Button To Next Section', 'wppandashop5' ),
                        'subtitle'  =>  __( 'Enable or Disable Scroll Button Feature.', 'wppandashop5' ),
                        'desc'      =>  '',
                        'options'   =>  array(
                            'enable'   =>  'Enable',
                            'disable'  =>  'Disable',
                        ),
                        'default'   =>  'disable',
                    ),

                    array(
                        'id'        =>  'global_title_header_text_visibility',
                        'type'      =>  'button_set',
                        'required'  =>  array('global_title_header_visibility','=','show'),
                        'title'     =>  __('Title Header Text', 'wppandashop5'),
                        'subtitle'  =>  __('Enable or Disable the Title Header Text.', 'wppandashop5'),
                        'desc'      =>  '',
                        'options'   =>  array(
                            'show'  =>  'Show',
                            'hide'  =>  'Hide',
                        ),
                        'default'   =>  'show',
                    ),

                    array(
                        'id'            =>  'global_title_header_text_color',
                        'type'          =>  'color',   
                        'required'      =>  array('global_title_header_text_visibility','=','show'),
                        'title'         =>  __( 'Title Header Text Color', 'wppandashop5' ),
                        'subtitle'      =>  __( '<em>Optional</em>. Choose a text color for your heading and subheading.', 'wppandashop5' ),
                        'default'       =>  '',
                        'transparent'   =>  false,
                    ),

                )
            );


            /*-----------------------------------------------------------------------------------*/
            /*  - Home page
            /*-----------------------------------------------------------------------------------*/
            $this->sections[] = array(
                'title'      =>  __('Главная', 'wppandashop5'),
                'desc'       =>  __('Control and configure of your Home Page.', 'wppandashop5'),
                'icon'       =>  'font-icon-cone',
                'customizer' =>  false,
                'fields'     =>  array(

                    array(
                        'id'        =>  'home_slider_content',
                        'type'      =>  'button_set',
                        'title'     =>  __('Home Slider Content', 'wppandashop5'),
                        'subtitle'  =>  __('Select the content for home slider.', 'wppandashop5'),
                        'desc'      =>  '',
                        'options'   =>  array(
                            'custom'   =>  'Custom slides',
                            'blog'     =>  'Blog Posts',
                            'shop'     =>  'Shop Products'
                        ),
                        'default'   =>  'custom',
                    ),

                    array(
                        'id'          => 'home-slider',
                        'type'        => 'slides',
                        'title'       => __( 'Slides Options', 'redux-framework-demo' ),
                        'subtitle'    => __( 'Unlimited slides with drag and drop sortings.', 'redux-framework-demo' ),
                        'desc'        => __( 'This field will store all slides values into a multidimensional array to use into a foreach loop.', 'redux-framework-demo' ),
                        'placeholder' => array(
                            'title'       => __( 'This is a title', 'redux-framework-demo' ),
                            'description' => __( 'Description Here', 'redux-framework-demo' ),
                            'url'         => __( 'Give us a link!', 'redux-framework-demo' ),
                        ),
                    ),

                    array(
                        'id'        =>  'home_bunner',
                        'type'      =>  'button_set',
                        'title'     =>  __('Включить блок баннеров', 'wppandashop5'),
                        'desc'      =>  '',
                        'options'   =>  array(
                            'on'   =>  'Вкл',
                            'off'  =>  'Выкл',
                        ),
                        'default'   =>  'on',
                    ),

                    array(
                        'id'        =>  'h_b_1_l',
                        'type'      =>  'text',
                        'title'     =>  __('Ссылка баннера 1', 'wppandashop5'),
                        'default'   =>  '',
                    ),

                    array(
                        'id'        =>  'h_b_1_h4',
                        'type'      =>  'text',
                        'title'     =>  __('Заголовок баннера 1', 'wppandashop5'),
                        'default'   =>  '',
                    ),

                    array(
                        'id'        =>  'h_b_1_h2',
                        'type'      =>  'text',
                        'title'     =>  __('Дополнительный Заголовок баннера 1', 'wppandashop5'),
                        'default'   =>  '',
                    ),

                    array(
                        'id'        =>  'h_b_1_i',
                        'type'      =>  'media',
                        'title'     =>  __('Изображение баннера 1', 'wppandashop5'),
                        'default'   =>  '',
                    ),

                    array(
                        'id'        =>  'h_b_2_l',
                        'type'      =>  'text',
                        'title'     =>  __('Ссылка баннера 2', 'wppandashop5'),
                        'default'   =>  '',
                    ),

                    array(
                        'id'        =>  'h_b_2_h4',
                        'type'      =>  'text',
                        'title'     =>  __('Заголовок баннера 2', 'wppandashop5'),
                        'default'   =>  '',
                    ),

                    array(
                        'id'        =>  'h_b_2_h2',
                        'type'      =>  'text',
                        'title'     =>  __('Дополнительный Заголовок баннера 2', 'wppandashop5'),
                        'default'   =>  '',
                    ),

                    array(
                        'id'        =>  'h_b_2_i',
                        'type'      =>  'media',
                        'title'     =>  __('Изображение баннера 2', 'wppandashop5'),
                        'default'   =>  '',
                    ),

                    array(
                        'id'        =>  'h_b_3_l',
                        'type'      =>  'text',
                        'title'     =>  __('Ссылка баннера 3', 'wppandashop5'),
                        'default'   =>  '',
                    ),

                    array(
                        'id'        =>  'h_b_3_h4',
                        'type'      =>  'text',
                        'title'     =>  __('Заголовок баннера 3', 'wppandashop5'),
                        'default'   =>  '',
                    ),

                    array(
                        'id'        =>  'h_b_3_h2',
                        'type'      =>  'text',
                        'title'     =>  __('Дополнительный Заголовок баннера 3', 'wppandashop5'),
                        'default'   =>  '',
                    ),

                    array(
                        'id'        =>  'h_b_3_i',
                        'type'      =>  'media',
                        'title'     =>  __('Изображение баннера 3', 'wppandashop5'),
                        'default'   =>  '',
                    ),


                    array(
                        'id'        =>  'n_new_block',
                        'type'      =>  'text',
                        'title'     =>  __('ID продуктов для блока новинки, через запятую', 'wppandashop5'),
                        'default'   =>  '',
                    ),

                    array(
                        'id'        =>  'home_bunner_d',
                        'type'      =>  'button_set',
                        'title'     =>  __('Включить  баннер делитель', 'wppandashop5'),
                        'desc'      =>  '',
                        'options'   =>  array(
                            'on'   =>  'Вкл',
                            'off'  =>  'Выкл',
                        ),
                        'default'   =>  'on',
                    ),

                    array(
                        'id'        =>  'h_b_4_l',
                        'type'      =>  'text',
                        'title'     =>  __('Ссылка баннера делителя', 'wppandashop5'),
                        'default'   =>  '',
                    ),

                    array(
                        'id'        =>  'h_b_4_h4',
                        'type'      =>  'text',
                        'title'     =>  __('Заголовок баннера делителя', 'wppandashop5'),
                        'default'   =>  '',
                    ),

                    array(
                        'id'        =>  'h_b_4_h2',
                        'type'      =>  'text',
                        'title'     =>  __('Дополнительный Заголовок баннера делителя', 'wppandashop5'),
                        'default'   =>  '',
                    ),

                    array(
                        'id'        =>  'h_b_4_i',
                        'type'      =>  'media',
                        'title'     =>  __('Изображение баннера делителя', 'wppandashop5'),
                        'default'   =>  '',
                    ),

                    array(
                        'id'        =>  'n_top_block',
                        'type'      =>  'text',
                        'title'     =>  __('ID продуктов для блока топ продаж, через запятую', 'wppandashop5'),
                        'default'   =>  '',
                    ),
                )
            );


            /*-----------------------------------------------------------------------------------*/
            /*  - Footer
            /*-----------------------------------------------------------------------------------*/
            $this->sections[] = array(
                'title'      =>  __('Футер', 'wppandashop5'),
                'desc'       =>  __('Control and configure of your footer area.', 'wppandashop5'),
                'icon'       =>  'font-icon-cone',
                'customizer' =>  false,
                'fields'     =>  array(

                    array(
                        'id'       => 'footer_layout',
                        'type'     => 'radio',
                        'title'    => __( 'Footer layout', 'redux-framework-demo' ),
                        'subtitle' => __( 'Selected footer layout.', 'redux-framework-demo' ),
                        //'desc'     => __( 'Selected header layout.', 'redux-framework-demo' ),
                        //Must provide key => value pairs for radio options
                        'options'  => array(
                            '1' => __( 'Footer 1', 'redux-framework-demo' ),
                            '2' => __( 'Footer 2', 'redux-framework-demo' ),
                            '3' => __( 'Footer 3', 'redux-framework-demo' ),
                            '4' => __( 'Footer 4', 'redux-framework-demo' ),
                            '5' => __( 'Footer 5', 'redux-framework-demo' )
                        ),
                        'default'  => '1'
                    ),

                   /* array(
                        'id'        =>  'global_footer_widget_visibility',
                        'type'      =>  'button_set',
                        'title'     =>  __('Global Footer Widgets Area', 'wppandashop5'),
                        'subtitle'  =>  __('Enable or Disable the Footer Widgets Area.<br/><br/><em>If you want can modify in each page/post the setting about the visibility about the footer widgets area.</em>', 'wppandashop5'),
                        'desc'      =>  '',
                        'options'   =>  array(
                            'show'  =>  'Show',
                            'hide'  =>  'Hide',
                        ),
                        'default'   =>  'hide',
                    ),

                    array(
                        'id'        =>  'footer_widget_area_color_type',
                        'type'      =>  'button_set',
                        'title'     =>  __('Footer Widgets Color Type', 'wppandashop5'),
                        'subtitle'  =>  __('The setting refers to which color type for footer widgets area will appear.', 'wppandashop5'),
                        'desc'      =>  '',
                        'options'   =>  array(
                            'light-type' =>  'Light',
                            'dark-type'  =>  'Dark',
                        ),
                        'default'   =>  'dark-type',
                    ),

                    array(
                        'id'        =>  'footer_widget_columns',
                        'type'      =>  'button_set',
                        'title'     =>  __('Footer Widget Columns', 'wppandashop5'),
                        'subtitle'  =>  __('Select the columns for footer widget area.', 'wppandashop5'),
                        'desc'      =>  '',
                        'options'   =>  array(
                            '2'     =>  '2 Columns',
                            '3'     =>  '3 Columns',
                            '4'     =>  '4 Columns'
                        ),
                        'default'   =>  '3',
                    ),

                    // Copyright/Credits Text
                   */
                    array(
                        'id'        =>  'footer_credits_text',
                        'type'      =>  'editor',
                        'title'     =>  __('Копирайт', 'wppandashop5'),
                       // 'subtitle'  =>  __('Optional. Please enter your custom credits/copyright section text.', 'wppandashop5'),
                        'desc'      =>  '',
                        'args'   => array(
                            'teeny'         => false,
                            'wpautop'       => true,
                            'media_buttons' => false
                        )
                    ),
                )
            );

            /*-----------------------------------------------------------------------------------*/
            /*  - Portfolio
            /*-----------------------------------------------------------------------------------*/
            $this->sections[] = array(
                'title'      =>  __('WooCommerce', 'wppandashop5'),
                //'desc'       =>  __('Control and configure the general setup of your portfolio.', 'wppandashop5'),
                'icon'       =>  'font-icon-grid',
                'customizer' =>  false,
                'fields'     =>  array( 

                    array(
                        'id'        =>  'main_banner',
                        'type'      =>  'media',
                        'title'     =>  __('Баннер Магазина', 'wppandashop5'),
                        'subtitle'  =>  __('Основной баннер магазина, если баннер для категории продуктов не определен выводится будет этот', 'wppandashop5'),
                        'desc'      => 'Загрузите баннер магазина'
                    ),

                    array(
                        'id'        =>  'main_banner_link',
                        'type'      =>  'text',
                        'title'     =>  __('Ссылка с баннера магазина', 'wppandashop5'),
                        'subtitle'  =>  __('Основная ссылка с баннера магазина, если ссылка для баннера категории не определена выводится будет эта', 'wppandashop5'),
                        'desc'      => 'Введите ссылку'
                    ),


                    array(
                        'id'        =>  'shipping_link',
                        'type'      =>  'text',
                        'title'     =>  __('Ссылка "Доставка Вовремя"', 'wppandashop5'),
                        'subtitle'  =>  __('Ссылка на страницу "Доставка Вовремя", если ссылка не введена, иконка не будет перенаправлять куда-либо', 'wppandashop5'),
                        'desc'      => 'Введите ссылку'
                    ),

                    array(
                        'id'        =>  'sale_link',
                        'type'      =>  'text',
                        'title'     =>  __('Ссылка "Нашли Дешевле?"', 'wppandashop5'),
                        'subtitle'  =>   __('Ссылка на страницу "Нашли Дешевле?", если ссылка не введена, иконка не будет перенаправлять куда-либо', 'wppandashop5'),
                        'desc'      => 'Введите ссылку'
                    ),

                    array(
                        'id'        =>  'shop_link',
                        'type'      =>  'text',
                        'title'     =>  __('Ссылка "Полный каталог"', 'wppandashop5'),
                        'subtitle'  =>  sprintf(__('Ссылка на страницу "Полный каталог", если ссылка не введена, будет выведена ссылка на страницу %s', 'wppandashop5'), get_home_url().'/shop/'),
                        'desc'      => 'Введите ссылку'
                    ),

                    array(
                        'id'        =>  'request_link',
                        'type'      =>  'text',
                        'title'     =>  __('Ссылка "30 дней на обмен"', 'wppandashop5'),
                        'subtitle'  =>  __('Ссылка на страницу "30 дней на обмен", если ссылка не введена, иконка не будет перенаправлять куда-либо', 'wppandashop5'),
                        'desc'      => 'Введите ссылку'
                    ),
                                            
                )
            );

            /*-----------------------------------------------------------------------------------*/
            /*  - Team
            /*-----------------------------------------------------------------------------------*/
        /*    $this->sections[] = array(
                'title'      =>  __('Team', 'wppandashop5'),
                'desc'       =>  __('Control and configure the general setup of your team.', 'wppandashop5'),
                'icon'       =>  'font-icon-group',
                'customizer' =>  false,
                'fields'     =>  array(
                    array(
                        'id'        =>  'team_rewrite_slug', 
                        'type'      =>  'text', 
                        'title'     =>  __('Custom Slug', 'wppandashop5'),
                        'subtitle'  =>  __('If you want your team post type to have a custom slug in the url, please enter it here.<br/><br/>
                                        <b>You will still have to refresh your permalinks after saving this!</b><br/><br/>
                                        This is done by going to <b>Settings -> Permalinks</b> and clicking save.', 'wppandashop5'),
                        'desc'      =>  ''
                    ), 

                    array(
                        'id'        =>  'navigation_team_mode',
                        'type'      =>  'button_set',
                        'title'     =>  __('Navigation Team Posts Mode', 'wppandashop5'),
                        'subtitle'  =>  __('Select your navigation team posts mode.<br/><br/>
                                            <strong>Normal:</strong><br/>You can navigate all single posts without limitation.<br/><br/>
                                            <strong>Disciplines:</strong><br/>You can navigate all single posts based on disciplines attributes.<br/><br/>It is recommended to use this navigation only if you have multiple team pages based on different disciplines.', 'wppandashop5'),
                        'desc'      =>  '',
                        'options'   =>  array(
                            'normal'        =>  'Normal',
                            'disciplines'   =>  'Disciplines'
                        ),
                        'default'   =>  'normal',
                    ),

                    array(
                        'id'        =>  'back_to_team',
                        'type'      =>  'switch',
                        'title'     =>  __('Back to Main Team Page on Navigation?', 'wppandashop5'),
                        'subtitle'  =>  __('Enable/Disable Back to Team Button.', 'wppandashop5'),
                        'desc'      =>  '',
                        'default'   =>  0
                    ),

                    array(
                        'id'        =>  'back_to_team_mode',
                        'type'      =>  'button_set',
                        'required'  =>  array('back_to_team','=','1'),
                        'title'     =>  __('Back To Team Mode', 'wppandashop5'),
                        'subtitle'  =>  __('Select your back to team button mode.<br/><br/>
                                            <strong>Simple:</strong><br/>You have a global link for all single team post.<br/><br/>
                                            <strong>Custom:</strong><br/>You can have a different URL for each single team post.<br/><br/>You need set the URL inside the single team post for each post in the respective metabox.<br/><br/>It is recommended to use this if you have multiple team pages based on different disciplines.', 'wppandashop5'),
                        'desc'      =>  '',
                        'options'   =>  array(
                            'general'   =>  'General',
                            'custom'    =>  'Custom'
                        ),
                        'default'   =>  'general',
                    ),

                    array(
                        'id'        =>  'back_to_team_url_general',
                        'type'      =>  'select',
                        'data'      =>  'pages',
                        'required'  =>  array('back_to_team_mode','=','general'),    
                        'title'     =>  __('Team Main Page', 'wppandashop5'),
                        'subtitle'  =>  __('Required. Select the page that is your main team index page. This is used to link to the page from the team post detail page..', 'wppandashop5'),
                        'desc'      =>  '',
                        'default'   =>  ''  
                    ),                         
                )
            );

            /*-----------------------------------------------------------------------------------*/
            /*  - Blog
            /*-----------------------------------------------------------------------------------*/
       /*     $this->sections[] = array(
                'title'      =>  __('Blog', 'wppandashop5'),
                'desc'       =>  __('Control and configure the general setup of your blog.', 'wppandashop5'),
                'icon'       =>  'font-icon-align-left',
                'customizer' =>  false,
                'fields'     =>  array(

                    array(
                        'id'        =>  'blog_layout_mode',
                        'type'      =>  'image_select',
                        'title'     =>  __('Blog Layout Mode', 'wppandashop5'),
                        'subtitle'  =>  __('Select the layout for the blog page.', 'wppandashop5'),
                        'desc'      =>  '',
                        'options'   =>  array(
                            'wide'    =>  array('title' => 'Wide', 'img' => ReduxFramework::$_url .'/assets/img/blog_wide.png'),
                            'grid'    =>  array('title' => 'Grid', 'img' => ReduxFramework::$_url .'/assets/img/blog_grid.png')
                        ),
                        'default'   =>  'wide'
                    ),

                    array(
                        'id'        =>  'blog_grid_columns',
                        'type'      =>  'button_set',
                        'required'  =>  array('blog_layout_mode','=','grid'), 
                        'title'     =>  __('Blog Grid Columns', 'wppandashop5'),
                        'subtitle'  =>  __('Select your columns for the blog grid layout only.', 'wppandashop5'),
                        'desc'      =>  '',
                        'options'   =>  array(
                            '1'     =>  '1 Column',
                            '2'     =>  '2 Columns',
                            '3'     =>  '3 Columns',
                            '4'     =>  '4 Columns'
                        ),
                        'default'   =>  '3',
                    ),

                    // Size Post Thumbnails
                    array(
                        'id'        => 'wide_post_thumb_size',
                        'type'      => 'text',
                        'required'  =>  array('blog_layout_mode','=','wide'), 
                        'title'     =>  __('Post Thumbnail Size: Wide Blog Layout', 'wppandashop5'),
                        'subtitle'  =>  __('Optional. Set your custom size of post thumbnail.<br/><em>Default is 1000x500</em>', 'wppandashop5'),
                        'desc'      =>  __('Insert only number value like this example: 200x100 (Width x Height).', 'wppandashop5'),
                        'default'   =>  '1000x500'
                    ),

                    array(
                        'id'        => 'grid_one_post_thumb_size',
                        'type'      => 'text',
                        'required'  => array(
                            array( 'blog_layout_mode', '=', 'grid' ),
                            array( 'blog_grid_columns', '=', '1' ),
                        ),
                        'title'     =>  __('Post Thumbnail Size: Grid Blog 1 Col', 'wppandashop5'),
                        'subtitle'  =>  __('Optional. Set your custom size of post thumbnail.<br/><em>Default is 1000x600</em>', 'wppandashop5'),
                        'desc'      =>  __('Insert only number value like this example: 200x100 (Width x Height).', 'wppandashop5'),
                        'default'   =>  '1000x600'
                    ),

                    array(
                        'id'        => 'grid_two_post_thumb_size',
                        'type'      => 'text',
                        'required'  => array(
                            array( 'blog_layout_mode', '=', 'grid' ),
                            array( 'blog_grid_columns', '=', '2' ),
                        ),
                        'title'     =>  __('Post Thumbnail Size: Grid Blog 2 Cols', 'wppandashop5'),
                        'subtitle'  =>  __('Optional. Set your custom size of post thumbnail.<br/><em>Default is 800x800</em>', 'wppandashop5'),
                        'desc'      =>  __('Insert only number value like this example: 200x100 (Width x Height).', 'wppandashop5'),
                        'default'   =>  '800x800'
                    ),

                    array(
                        'id'        => 'grid_three_post_thumb_size',
                        'type'      => 'text',
                        'required'  => array(
                            array( 'blog_layout_mode', '=', 'grid' ),
                            array( 'blog_grid_columns', '=', '3' ),
                        ), 
                        'title'     =>  __('Post Thumbnail Size: Grid Blog 3 Cols', 'wppandashop5'),
                        'subtitle'  =>  __('Optional. Set your custom size of post thumbnail.<br/><em>Default is 800x800</em>', 'wppandashop5'),
                        'desc'      =>  __('Insert only number value like this example: 200x100 (Width x Height).', 'wppandashop5'),
                        'default'   =>  '800x800'
                    ),

                    array(
                        'id'        => 'grid_four_post_thumb_size',
                        'type'      => 'text',
                        'required'  => array(
                            array( 'blog_layout_mode', '=', 'grid' ),
                            array( 'blog_grid_columns', '=', '4' ),
                        ), 
                        'title'     =>  __('Post Thumbnail Size: Grid Blog 4 Cols', 'wppandashop5'),
                        'subtitle'  =>  __('Optional. Set your custom size of post thumbnail.<br/><em>Default is 800x800</em>', 'wppandashop5'),
                        'desc'      =>  __('Insert only number value like this example: 200x100 (Width x Height).', 'wppandashop5'),
                        'default'   =>  '800x800'
                    ),

                    array(
                        'id'        =>  'blog_pagination_select',
                        'type'      =>  'button_set',
                        'title'     =>  __('Blog Pagination', 'wppandashop5'),
                        'subtitle'  =>  __('Choose your favourite pagination for your blog page.', 'wppandashop5'),
                        'desc'      =>  '',
                        'options'   =>  array(
                            'simple_blog_pagination'            =>  'Normal',
                            'infinite_scroll_blog_pagination'   =>  'Infinite Scroll',
                        ),
                        'default'   =>  'simple_blog_pagination',
                    ),

                    array(
                        'id'        =>  'back_to_posts',
                        'type'      =>  'switch',
                        'title'     =>  __('Back to Main Blog Page on Navigation?', 'wppandashop5'),
                        'subtitle'  =>  __('Enable/Disable Back to Posts Button.', 'wppandashop5'),
                        'desc'      =>  '',
                        'default'   =>  0
                    ),

                    array(
                        'id'        =>  'back_to_posts_url',
                        'type'      =>  'select',
                        'data'      =>  'pages',
                        'required'  =>  array('back_to_posts','=','1'),    
                        'title'     =>  __('Blog Main Page', 'wppandashop5'),
                        'subtitle'  =>  __('Required. Select the page that is your main blog index page. This is used to link to the page from the blog post detail page.', 'wppandashop5'),
                        'desc'      =>  '',
                        'default'   =>  ''  
                    ),

                )
            );

            /*-----------------------------------------------------------------------------------*/
            /*  - Misc
            /*-----------------------------------------------------------------------------------*/
        /*    $this->sections[] = array(
                'title'     =>  __('Misc', 'wppandashop5'),
                'desc'      =>  __('Control and configure the misc options available.', 'wppandashop5'),
                'icon'      =>  'font-icon-droplets',
            );

                // Error Page
                $this->sections[] = array(
                    'title'         =>  __('Error Page', 'wppandashop5'),
                    'subsection'    =>  true,
                    'icon'          =>  'font-icon-arrow-right-simple-thin-round',
                    'customizer'    =>  false,
                    'fields'        =>  array(

                        array(
                            'id'        =>  'error_preloader_visibility',
                            'type'      =>  'button_set',
                            'title'     =>  __('Error Preloader Setting', 'wppandashop5'),
                            'subtitle'  =>  __('Enable or Disable the Preloader for Error Page.<br/><br/>Work only if you have activated the Preloader Feature in General Tabs -> Preloader.', 'wppandashop5'),
                            'desc'      =>  '',
                            'options'   =>  array(
                                'show'  =>  'Show',
                                'hide'  =>  'Hide',
                            ),
                            'default'   =>  'hide',
                        ),

                        array(
                            'id'        =>  'error_logo_navi_type_color',
                            'type'      =>  'button_set',
                            'title'     =>  __('Error Logo/Navigation Type', 'wppandashop5'),
                            'subtitle'  =>  __('The setting refers to which type of logo/navigation will appear only for Error Page.', 'wppandashop5'),
                            'desc'      =>  '',
                            'options'   =>  array(
                                'light' =>  'Light',
                                'dark'  =>  'Dark',
                            ),
                            'default'   =>  'light',
                        ),

                        // Customize Error Page
                        array(
                            'id'        =>  'error_customize_settings',
                            'type'      =>  'switch',
                            'title'     =>  __('Error Customize Settings', 'wppandashop5'),
                            'subtitle'  =>  __('Enable/Disable the customize settings for Error Page.', 'wppandashop5'),
                            'desc'      =>  '',
                            'default'   =>  0
                        ),

                        array(
                            'id'        =>  'error_custom_title',
                            'type'      =>  'text',
                            'title'     =>  __( 'Error Title', 'wppandashop5' ),
                            'subtitle'  =>  __( 'Optional. Enter your custom error title text.', 'wppandashop5' ),
                            'desc'      =>  '',
                            'default'   =>  '',
                            'required'  =>  array('error_customize_settings','=','1'),
                        ),

                        array(
                            'id'        =>  'error_custom_subheading',
                            'type'      =>  'text',
                            'title'     =>  __( 'Error SubHeading', 'wppandashop5' ),
                            'subtitle'  =>  __( 'Optional. Enter your custom error subheading text.', 'wppandashop5' ),
                            'desc'      =>  '',
                            'default'   =>  '',
                            'required'  =>  array('error_customize_settings','=','1'),
                        ),

                        array(
                            'id'        =>  'error_custom_back_button',
                            'type'      =>  'text',
                            'title'     =>  __( 'Error Back Button', 'wppandashop5' ),
                            'subtitle'  =>  __( 'Optional. Enter your custom error button text.', 'wppandashop5' ),
                            'desc'      =>  '',
                            'default'   =>  '',
                            'required'  =>  array('error_customize_settings','=','1'),
                        ),

                        array(
                            'id'            =>  'error_left_side_bg',
                            'type'          =>  'color',
                            'title'         =>  __( 'Left Side: Background Color', 'wppandashop5' ),
                            'subtitle'      =>  __( 'Optional. Choose a background color for your left side container.', 'wppandashop5' ),
                            'output'        =>  false,
                            'validate'      =>  false,
                            'transparent'   =>  false,
                            'default'       =>  '',
                            'required'      =>  array( 'error_customize_settings', '=', '1' ),
                        ),

                        array(
                            'id'            =>  'error_left_side_title_color',
                            'type'          =>  'color',
                            'title'         =>  __( 'Left Side: Title Color', 'wppandashop5' ),
                            'subtitle'      =>  __( 'Optional. Choose a text color for your title.', 'wppandashop5' ),
                            'output'        =>  false,
                            'validate'      =>  false,
                            'transparent'   =>  false,
                            'default'       =>  '',
                            'required'      =>  array( 'error_customize_settings', '=', '1' ),
                        ),

                        array(
                            'id'            =>  'error_left_side_subheading_color',
                            'type'          =>  'color',
                            'title'         =>  __( 'Left Side: Subheading Color', 'wppandashop5' ),
                            'subtitle'      =>  __( 'Optional. Choose a text color for your subheading.', 'wppandashop5' ),
                            'output'        =>  false,
                            'validate'      =>  false,
                            'transparent'   =>  false,
                            'default'       =>  '',
                            'required'      =>  array( 'error_customize_settings', '=', '1' ),
                        ),

                        array(
                            'id'            =>  'error_right_side_bg',
                            'type'          =>  'color',
                            'title'         =>  __( 'Right Side: Background Color', 'wppandashop5' ),
                            'subtitle'      =>  __( 'Optional. Choose a background color for your right side container.', 'wppandashop5' ),
                            'output'        =>  false,
                            'validate'      =>  false,
                            'transparent'   =>  false,
                            'default'       =>  '',
                            'required'      =>  array( 'error_customize_settings', '=', '1' ),
                        ),

                        array(
                            'id'            =>  'error_right_side_button',
                            'type'          =>  'color',
                            'title'         =>  __( 'Right Side: Button Color', 'wppandashop5' ),
                            'subtitle'      =>  __( 'Optional. Choose a text color for your button back.', 'wppandashop5' ),
                            'output'        =>  false,
                            'validate'      =>  false,
                            'transparent'   =>  false,
                            'default'       =>  '',
                            'required'      =>  array( 'error_customize_settings', '=', '1' ),
                        ),
                      

                    )
                );

                // Archives Page
                $this->sections[] = array(
                    'title'         =>  __('Archives Page', 'wppandashop5'),
                    'subsection'    =>  true,
                    'icon'          =>  'font-icon-arrow-right-simple-thin-round',
                    'customizer'    =>  false,
                    'fields'        =>  array(

                        array(
                            'id'        =>  'archive_preloader_visibility',
                            'type'      =>  'button_set',
                            'title'     =>  __('Archive Preloader Setting', 'wppandashop5'),
                            'subtitle'  =>  __('Enable or Disable the Preloader for Archive Pages.<br/><br/>Work only if you have activated the Preloader Feature in General Tabs -> Preloader.', 'wppandashop5'),
                            'desc'      =>  '',
                            'options'   =>  array(
                                'show'  =>  'Show',
                                'hide'  =>  'Hide',
                            ),
                            'default'   =>  'hide',
                        ),

                        array(
                            'id'        =>  'archive_logo_navi_type_color',
                            'type'      =>  'button_set',
                            'title'     =>  __('Archive Logo/Navigation Type', 'wppandashop5'),
                            'subtitle'  =>  __('The setting refers to which type of logo/navigation will appear only for Archive Pages.', 'wppandashop5'),
                            'desc'      =>  '',
                            'options'   =>  array(
                                'light' =>  'Light',
                                'dark'  =>  'Dark',
                            ),
                            'default'   =>  'light',
                        ),

                        array(
                            'id'        =>  'archive_footer_widget_visibility',
                            'type'      =>  'button_set',
                            'title'     =>  __('Archive Footer Widgets Area', 'wppandashop5'),
                            'subtitle'  =>  __('Enable or Disable the Footer Widgets for Archive Pages.', 'wppandashop5'),
                            'desc'      =>  '',
                            'options'   =>  array(
                                'show'  =>  'Show',
                                'hide'  =>  'Hide',
                            ),
                            'default'   =>  'hide',
                        ),

                        array(
                            'id'        =>  'archive_layout_mode',
                            'type'      =>  'image_select',
                            'title'     =>  __('Archive Layout Mode', 'wppandashop5'),
                            'subtitle'  =>  __('Select the layout for the archive pages.', 'wppandashop5'),
                            'desc'      =>  '',
                            'options'   =>  array(
                                'wide'    =>  array('title' => 'Wide', 'img' => ReduxFramework::$_url .'/assets/img/blog_wide.png'),
                                'grid'    =>  array('title' => 'Grid', 'img' => ReduxFramework::$_url .'/assets/img/blog_grid.png')
                            ),
                            'default'   =>  'wide'
                        ),

                        array(
                            'id'        =>  'archive_grid_columns',
                            'type'      =>  'button_set',
                            'title'     =>  __('Archive Grid Columns', 'wppandashop5'),
                            'subtitle'  =>  __('Select your columns for the archive grid layout only.', 'wppandashop5'),
                            'desc'      =>  '',
                            'options'   =>  array(
                                '1'     =>  '1 Column',
                                '2'     =>  '2 Columns',
                                '3'     =>  '3 Columns',
                                '4'     =>  '4 Columns'
                            ),
                            'default'   =>  '3',
                            'required'  =>  array('archive_layout_mode','=','grid'), 
                        ),

                        array(
                            'id'        =>  'archive_title_header_visibility',
                            'type'      =>  'button_set',
                            'title'     =>  __('Archive Title Header', 'wppandashop5'),
                            'subtitle'  =>  __('Enable or Disable the Archive Title Header Area.', 'wppandashop5'),
                            'desc'      =>  '',
                            'options'   =>  array(
                                'show'  =>  'Show',
                                'hide'  =>  'Hide',
                            ),
                            'default'   =>  'show',
                        ),
                        
                        array(
                            'id'        =>  'archive_title_header_layout_container',
                            'type'      =>  'button_set',
                            'title'     =>  __('Archive Header Layout', 'wppandashop5'),
                            'subtitle'  =>  __('Select your layout for the archive title header pages.', 'wppandashop5'),
                            'desc'      =>  '',
                            'options'   =>  array(
                                'normal'      =>  'Normal',
                                'fullscreen'  =>  'Full Screen',
                            ),
                            'default'   =>  'normal',
                            'required'  =>  array('archive_title_header_visibility','=','show'),
                        ),

                        array(
                            'id'        =>  'archive_title_header_height',
                            'type'      =>  'text',
                            'title'     =>  __( 'Archive Title Header Height', 'wppandashop5' ),
                            'subtitle'  =>  __( 'Select your custom height for your archive title header pages.<br/>Default is 600px.', 'wppandashop5' ),
                            'desc'      =>  '',
                            'default'   =>  '',
                            'required'  =>  array('archive_title_header_layout_container','=','normal'),
                        ),

                        array(
                            'id'        =>  'archive_scroll_to_section',
                            'type'      =>  'button_set',
                            'title'     =>  __( 'Scroll Button To Next Section', 'wppandashop5' ),
                            'subtitle'  =>  __( 'Enable or Disable Scroll Button Feature.', 'wppandashop5' ),
                            'desc'      =>  '',
                            'options'   =>  array(
                                'enable'   =>  'Enable',
                                'disable'  =>  'Disable',
                            ),
                            'default'   =>  'disable',
                            'required'  =>  array('archive_title_header_layout_container','=','fullscreen'),
                        ),

                        array(
                            'id'        =>  'archive_title_header_module',
                            'type'      =>  'select',
                            'title'     =>  __('Archive Title Header Module', 'wppandashop5'),
                            'subtitle'  =>  __('Select your favorite Archive Title Header Module.', 'wppandashop5'),
                            'options'   =>  array(
                                'normal'            =>  __( 'Normal', 'wppandashop5' ),
                                'image'             =>  __( 'Image', 'wppandashop5' ),
                                'image_parallax'    =>  __( 'Image Parallax', 'wppandashop5' ),
                            ),
                            'default'   =>  'normal',
                            'required'  =>  array('archive_title_header_visibility', '=', 'show' ),
                        ),

                        array(
                            'id'            =>  'archive_title_header_normal_bg_color',
                            'type'          =>  'color',
                            'title'         =>  __( 'Archive Title Header Background Color', 'wppandashop5' ),
                            'subtitle'      =>  __( 'Optional. Choose a background color for your archive title header section.', 'wppandashop5' ),
                            'output'        =>  false,
                            'validate'      =>  false,
                            'transparent'   =>  false,
                            'default'       =>  '',
                            'required'      =>  array( 'archive_title_header_module', '=', 'normal' ),
                        ),

                        array(
                            'id'        =>  'archive_title_header_image',
                            'type'      =>  'media', 
                            'title'     =>  __('Archive Title Header Background Image', 'wppandashop5'),
                            'subtitle'  =>  __('Upload your image.', 'wppandashop5'),
                            'default'   =>  '',
                            'required'  =>  array( 'archive_title_header_module', '=', 'image' ),
                        ),

                        array(
                            'id'        =>  'archive_title_header_image_position',
                            'type'      =>  'select',
                            'title'     =>  __('Archive Title Header Image Position', 'wppandashop5'),
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
                            'required'  =>  array( 'archive_title_header_module', '=', 'image' ),
                        ),

                        array(
                            'id'        =>  'archive_title_header_image_repeat',
                            'type'      =>  'select',
                            'title'     =>  __('Archive Title Header Image Repeat', 'wppandashop5'),
                            'subtitle'  =>  __('Select your background image repeat.', 'wppandashop5'),
                            'options'   =>  array(
                                'no_repeat' =>  __( 'No Repeat', 'wppandashop5' ),
                                'repeat'    =>  __( 'Repeat', 'wppandashop5' ),
                                'repeat_x'  =>  __( 'Repeat Horizontally', 'wppandashop5' ),
                                'repeat_y'  =>  __( 'Repeat Vertically', 'wppandashop5' ),
                                'stretch'   =>  __( 'Stretch to fit', 'wppandashop5' ),
                            ),
                            'default'   =>  'stretch',
                            'required'  =>  array( 'archive_title_header_module', '=', 'image' ),
                        ),

                        array(
                            'id'        =>  'archive_title_header_image_parallax',
                            'type'      =>  'media', 
                            'title'     =>  __('Archive Title Header Background Image Parallax', 'wppandashop5'),
                            'subtitle'  =>  __('Upload your image.', 'wppandashop5'),
                            'default'   =>  '',
                            'required'  =>  array( 'archive_title_header_module', '=', 'image_parallax' ),
                        ),

                        array(
                            'id'        =>  'archive_title_header_mask_mode',
                            'type'      =>  'select',
                            'title'     =>  __('Archive Title Header Mask', 'wppandashop5'),
                            'subtitle'  =>  __('Select your favorite Archive Title Header Mask Mode.', 'wppandashop5'),
                            'options'   =>  array(
                                'none'                  =>  __( 'None', 'wppandashop5' ),
                                'mask_color'            =>  __( 'Mask Color', 'wppandashop5' ),
                                'mask_pattern'          =>  __( 'Mask Pattern', 'wppandashop5' ),
                                'mask_pattern_color'    =>  __( 'Mask Color and Pattern', 'wppandashop5' ),
                            ),
                            'default'   =>  'none',
                            'required'  => array( 'archive_title_header_module', '!=', 'normal' ),
                        ),

                        array(
                            'id'        =>  'archive_title_header_mask_pattern',
                            'type'      =>  'media', 
                            'title'     =>  __('Pattern Mask', 'wppandashop5'),
                            'subtitle'  =>  __('Optional. Upload your pattern image.', 'wppandashop5'),
                            'default'   =>  '',
                            'required'  => array(
                                array( 'archive_title_header_mask_mode', '!=', 'none' ),
                                array( 'archive_title_header_mask_mode', '!=', 'mask_color' ),
                            ),
                        ),

                        array(
                            'id'            =>  'archive_title_header_mask_pattern_opacity',
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
                                array( 'archive_title_header_mask_mode', '!=', 'none' ),
                                array( 'archive_title_header_mask_mode', '!=', 'mask_color' ),
                            ),
                        ),

                        array(
                            'id'            =>  'archive_title_header_mask_background',
                            'type'          =>  'color_rgba',  
                            'title'         =>  __( 'Color Mask', 'wppandashop5' ),
                            'subtitle'      =>  __( 'Optional. Select your custom hex color with opacity.', 'wppandashop5' ),
                            'default'       =>  array( 'color' => '#000000', 'alpha' => '0.55' ),
                            'validate'      =>  'colorrgba',
                            'transparent'   =>  false,
                            'required'  => array(
                                array( 'archive_title_header_mask_mode', '!=', 'none' ),
                                array( 'archive_title_header_mask_mode', '!=', 'mask_pattern' ),
                            ),
                        ),

                        array(
                            'id'            =>  'archive_title_header_text_color',
                            'type'          =>  'color',
                            'title'         =>  __( 'Archive Title Header Text Color', 'wppandashop5' ),
                            'subtitle'      =>  __( 'Optional. Choose a text color for your heading and subheading.', 'wppandashop5' ),
                            'output'        =>  false,
                            'validate'      =>  false,
                            'transparent'   =>  false,
                            'default'       =>  '',
                            'required'      =>  array( 'archive_title_header_visibility', '!=', 'hide' ),
                        ),
                        

                    )
                );

                // Search Page
                $this->sections[] = array(
                    'title'         =>  __('Search Page', 'wppandashop5'),
                    'subsection'    =>  true,
                    'icon'          =>  'font-icon-arrow-right-simple-thin-round',
                    'customizer'    =>  false,
                    'fields'        =>  array(

                        array(
                            'id'        =>  'search_preloader_visibility',
                            'type'      =>  'button_set',
                            'title'     =>  __('Search Preloader Setting', 'wppandashop5'),
                            'subtitle'  =>  __('Enable or Disable the Preloader for Search Page Results.<br/><br/>Work only if you have activated the Preloader Feature in General Tabs -> Preloader.', 'wppandashop5'),
                            'desc'      =>  '',
                            'options'   =>  array(
                                'show'  =>  'Show',
                                'hide'  =>  'Hide',
                            ),
                            'default'   =>  'hide',
                        ),

                        array(
                            'id'        =>  'search_logo_navi_type_color',
                            'type'      =>  'button_set',
                            'title'     =>  __('Search Logo/Navigation Type', 'wppandashop5'),
                            'subtitle'  =>  __('The setting refers to which type of logo/navigation will appear only for Serch Page Results.', 'wppandashop5'),
                            'desc'      =>  '',
                            'options'   =>  array(
                                'light' =>  'Light',
                                'dark'  =>  'Dark',
                            ),
                            'default'   =>  'light',
                        ),

                        array(
                            'id'        =>  'search_footer_widget_visibility',
                            'type'      =>  'button_set',
                            'title'     =>  __('Search Footer Widgets Area', 'wppandashop5'),
                            'subtitle'  =>  __('Enable or Disable the Footer Widgets for Search Page Results.', 'wppandashop5'),
                            'desc'      =>  '',
                            'options'   =>  array(
                                'show'  =>  'Show',
                                'hide'  =>  'Hide',
                            ),
                            'default'   =>  'hide',
                        ),

                        array(
                            'id'        =>  'search_layout_mode',
                            'type'      =>  'image_select',
                            'title'     =>  __('Search Layout Mode', 'wppandashop5'),
                            'subtitle'  =>  __('Select the layout for the search page.', 'wppandashop5'),
                            'desc'      =>  '',
                            'options'   =>  array(
                                'wide'    =>  array('title' => 'Wide', 'img' => ReduxFramework::$_url .'/assets/img/blog_wide.png'),
                                'grid'    =>  array('title' => 'Grid', 'img' => ReduxFramework::$_url .'/assets/img/blog_grid.png')
                            ),
                            'default'   =>  'wide'
                        ),

                        array(
                            'id'        =>  'search_grid_columns',
                            'type'      =>  'button_set',
                            'title'     =>  __('Search Grid Columns', 'wppandashop5'),
                            'subtitle'  =>  __('Select your columns for the search grid layout only.', 'wppandashop5'),
                            'desc'      =>  '',
                            'options'   =>  array(
                                '1'     =>  '1 Column',
                                '2'     =>  '2 Columns',
                                '3'     =>  '3 Columns',
                                '4'     =>  '4 Columns'
                            ),
                            'default'   =>  '3',
                            'required'  =>  array('search_layout_mode','=','grid'), 
                        ),

                        array(
                            'id'        =>  'search_title_header_visibility',
                            'type'      =>  'button_set',
                            'title'     =>  __('Search Title Header', 'wppandashop5'),
                            'subtitle'  =>  __('Enable or Disable the Search Title Header Area.', 'wppandashop5'),
                            'desc'      =>  '',
                            'options'   =>  array(
                                'show'  =>  'Show',
                                'hide'  =>  'Hide',
                            ),
                            'default'   =>  'show',
                        ),
                        
                        array(
                            'id'        =>  'search_title_header_layout_container',
                            'type'      =>  'button_set',
                            'title'     =>  __('Search Header Layout', 'wppandashop5'),
                            'subtitle'  =>  __('Select your layout for the search title header page.', 'wppandashop5'),
                            'desc'      =>  '',
                            'options'   =>  array(
                                'normal'      =>  'Normal',
                                'fullscreen'  =>  'Full Screen',
                            ),
                            'default'   =>  'normal',
                            'required'  =>  array('search_title_header_visibility','=','show'),
                        ),

                        array(
                            'id'        =>  'search_title_header_height',
                            'type'      =>  'text',
                            'title'     =>  __( 'Search Title Header Height', 'wppandashop5' ),
                            'subtitle'  =>  __( 'Select your custom height for your search title header page.<br/>Default is 600px.', 'wppandashop5' ),
                            'desc'      =>  '',
                            'default'   =>  '',
                            'required'  =>  array('search_title_header_layout_container','=','normal'),
                        ),

                        array(
                            'id'        =>  'search_scroll_to_section',
                            'type'      =>  'button_set',
                            'title'     =>  __( 'Scroll Button To Next Section', 'wppandashop5' ),
                            'subtitle'  =>  __( 'Enable or Disable Scroll Button Feature.', 'wppandashop5' ),
                            'desc'      =>  '',
                            'options'   =>  array(
                                'enable'   =>  'Enable',
                                'disable'  =>  'Disable',
                            ),
                            'default'   =>  'disable',
                            'required'  =>  array('search_title_header_layout_container','=','fullscreen'),
                        ),

                        array(
                            'id'        =>  'search_title_header_module',
                            'type'      =>  'select',
                            'title'     =>  __('Search Title Header Module', 'wppandashop5'),
                            'subtitle'  =>  __('Select your favorite Search Title Header Module.', 'wppandashop5'),
                            'options'   =>  array(
                                'normal'            =>  __( 'Normal', 'wppandashop5' ),
                                'image'             =>  __( 'Image', 'wppandashop5' ),
                                'image_parallax'    =>  __( 'Image Parallax', 'wppandashop5' ),
                            ),
                            'default'   =>  'normal',
                            'required'  =>  array('search_title_header_visibility', '=', 'show' ),
                        ),

                        array(
                            'id'            =>  'search_title_header_normal_bg_color',
                            'type'          =>  'color',
                            'title'         =>  __( 'Search Title Header Background Color', 'wppandashop5' ),
                            'subtitle'      =>  __( 'Optional. Choose a background color for your search title header section.', 'wppandashop5' ),
                            'output'        =>  false,
                            'validate'      =>  false,
                            'transparent'   =>  false,
                            'default'       =>  '',
                            'required'      =>  array( 'search_title_header_module', '=', 'normal' ),
                        ),

                        array(
                            'id'        =>  'search_title_header_image',
                            'type'      =>  'media', 
                            'title'     =>  __('Search Title Header Background Image', 'wppandashop5'),
                            'subtitle'  =>  __('Upload your image.', 'wppandashop5'),
                            'default'   =>  '',
                            'required'  =>  array( 'search_title_header_module', '=', 'image' ),
                        ),

                        array(
                            'id'        =>  'search_title_header_image_position',
                            'type'      =>  'select',
                            'title'     =>  __('Search Title Header Image Position', 'wppandashop5'),
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
                            'required'  =>  array( 'search_title_header_module', '=', 'image' ),
                        ),

                        array(
                            'id'        =>  'search_title_header_image_repeat',
                            'type'      =>  'select',
                            'title'     =>  __('Search Title Header Image Repeat', 'wppandashop5'),
                            'subtitle'  =>  __('Select your background image repeat.', 'wppandashop5'),
                            'options'   =>  array(
                                'no_repeat' =>  __( 'No Repeat', 'wppandashop5' ),
                                'repeat'    =>  __( 'Repeat', 'wppandashop5' ),
                                'repeat_x'  =>  __( 'Repeat Horizontally', 'wppandashop5' ),
                                'repeat_y'  =>  __( 'Repeat Vertically', 'wppandashop5' ),
                                'stretch'   =>  __( 'Stretch to fit', 'wppandashop5' ),
                            ),
                            'default'   =>  'stretch',
                            'required'  =>  array( 'search_title_header_module', '=', 'image' ),
                        ),

                        array(
                            'id'        =>  'search_title_header_image_parallax',
                            'type'      =>  'media', 
                            'title'     =>  __('Search Title Header Background Image Parallax', 'wppandashop5'),
                            'subtitle'  =>  __('Upload your image.', 'wppandashop5'),
                            'default'   =>  '',
                            'required'  =>  array( 'search_title_header_module', '=', 'image_parallax' ),
                        ),

                        array(
                            'id'        =>  'search_title_header_mask_mode',
                            'type'      =>  'select',
                            'title'     =>  __('Search Title Header Mask', 'wppandashop5'),
                            'subtitle'  =>  __('Select your favorite Search Title Header Mask Mode.', 'wppandashop5'),
                            'options'   =>  array(
                                'none'                  =>  __( 'None', 'wppandashop5' ),
                                'mask_color'            =>  __( 'Mask Color', 'wppandashop5' ),
                                'mask_pattern'          =>  __( 'Mask Pattern', 'wppandashop5' ),
                                'mask_pattern_color'    =>  __( 'Mask Color and Pattern', 'wppandashop5' ),
                            ),
                            'default'   =>  'none',
                            'required'  => array( 'search_title_header_module', '!=', 'normal' ),
                        ),

                        array(
                            'id'        =>  'search_title_header_mask_pattern',
                            'type'      =>  'media', 
                            'title'     =>  __('Pattern Mask', 'wppandashop5'),
                            'subtitle'  =>  __('Optional. Upload your pattern image.', 'wppandashop5'),
                            'default'   =>  '',
                            'required'  => array(
                                array( 'search_title_header_mask_mode', '!=', 'none' ),
                                array( 'search_title_header_mask_mode', '!=', 'mask_color' ),
                            ),
                        ),

                        array(
                            'id'            =>  'search_title_header_mask_pattern_opacity',
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
                                array( 'search_title_header_mask_mode', '!=', 'none' ),
                                array( 'search_title_header_mask_mode', '!=', 'mask_color' ),
                            ),
                        ),

                        array(
                            'id'            =>  'search_title_header_mask_background',
                            'type'          =>  'color_rgba',  
                            'title'         =>  __( 'Color Mask', 'wppandashop5' ),
                            'subtitle'      =>  __( 'Optional. Select your custom hex color with opacity.', 'wppandashop5' ),
                            'default'       =>  array( 'color' => '#000000', 'alpha' => '0.55' ),
                            'validate'      =>  'colorrgba',
                            'transparent'   =>  false,
                            'required'  => array(
                                array( 'search_title_header_mask_mode', '!=', 'none' ),
                                array( 'search_title_header_mask_mode', '!=', 'mask_pattern' ),
                            ),
                        ),

                        array(
                            'id'            =>  'search_title_header_text_color',
                            'type'          =>  'color',
                            'title'         =>  __( 'Search Title Header Text Color', 'wppandashop5' ),
                            'subtitle'      =>  __( 'Optional. Choose a text color for your heading and subheading.', 'wppandashop5' ),
                            'output'        =>  false,
                            'validate'      =>  false,
                            'transparent'   =>  false,
                            'default'       =>  '',
                            'required'      =>  array( 'search_title_header_visibility', '!=', 'hide' ),
                        ),
                        

                    )
                );

            /*-----------------------------------------------------------------------------------*/
            /*  - Social
            /*-----------------------------------------------------------------------------------*/
            $this->sections[] = array(
                'title'     =>  __('Соцсети', 'wppandashop5'),
                //'desc'      =>  __('Control and configure the general setup of your social profile.', 'wppandashop5'),
                'icon'      =>  'font-icon-social-twitter',
                'fields'    =>  array(
                    array(
                        'id'        =>  'facebook-url',
                        'type'      =>  'text',
                        'title'     =>  __('Facebook URL', 'wppandashop5'),
                        //'subtitle'  =>  __('Please enter in your Facebook URL.', 'wppandashop5'),
                        'desc'      =>  ''
                    ),
                    array(
                        'id'        =>  'google-plus-url',
                        'type'      =>  'text',
                        'title'     =>  __('Google Plus URL', 'wppandashop5'),
                        //'subtitle'  =>  __('Please enter in your Google Plus URL.', 'wppandashop5'),
                        'desc'      =>  ''
                    ),
                    array(
                        'id'        =>  'twitter-url',
                        'type'      =>  'text',
                        'title'     =>  __('Twitter URL', 'wppandashop5'),
                        //subtitle'  =>  __('Please enter in your Twitter URL.', 'wppandashop5'),
                        'desc'      =>  ''
                    ),
                    array(
                        'id'        =>  'youtube-url',
                        'type'      =>  'text',
                        'title'     =>  __('You Tube URL', 'wppandashop5'),
                        //'subtitle'  =>  __('Please enter in your You Tube URL.', 'wppandashop5'),
                        'desc'      =>  ''
                    ),
/*                    array(
                        'id'        =>  '500px-url', 
                        'type'      =>  'text', 
                        'title'     =>  __('500PX URL', 'wppandashop5'),
                        'subtitle'  =>  __('Please enter in your 500PX URL.', 'wppandashop5'),
                        'desc'      =>  ''
                    ),
                    array(
                        'id'        =>  'behance-url', 
                        'type'      =>  'text', 
                        'title'     =>  __('Behance URL', 'wppandashop5'),
                        'subtitle'  =>  __('Please enter in your Behance URL.', 'wppandashop5'),
                        'desc'      =>  ''
                    ),
                    array(
                        'id'        =>  'bebo-url', 
                        'type'      =>  'text', 
                        'title'     =>  __('Bebo URL', 'wppandashop5'),
                        'subtitle'  =>  __('Please enter in your Bebo URL.', 'wppandashop5'),
                        'desc'      =>  ''
                    ),
                    array(
                        'id'        =>  'blogger-url', 
                        'type'      =>  'text', 
                        'title'     =>  __('Blogger URL', 'wppandashop5'),
                        'subtitle'  =>  __('Please enter in your Blogger URL.', 'wppandashop5'),
                        'desc'      =>  ''
                    ),
                    array(
                        'id'        =>  'deviant-art-url', 
                        'type'      =>  'text', 
                        'title'     =>  __('Deviant Art URL', 'wppandashop5'),
                        'subtitle'  =>  __('Please enter in your Deviant Art URL.', 'wppandashop5'),
                        'desc'      =>  ''
                    ),
                    array(
                        'id'        =>  'digg-url', 
                        'type'      =>  'text', 
                        'title'     =>  __('Digg URL', 'wppandashop5'),
                        'subtitle'  =>  __('Please enter in your Digg URL.', 'wppandashop5'),
                        'desc'      =>  ''
                    ),
                    array(
                        'id'        =>  'dribbble-url', 
                        'type'      =>  'text', 
                        'title'     =>  __('Dribbble URL', 'wppandashop5'),
                        'subtitle'  =>  __('Please enter in your Dribbble URL.', 'wppandashop5'),
                        'desc'      =>  ''
                    ),
                    array(
                        'id'        =>  'email-url', 
                        'type'      =>  'text', 
                        'title'     =>  __('Email URL', 'wppandashop5'),
                        'subtitle'  =>  __('Please enter in your Email URL.<br><br>Example: mailto:someone@example.com', 'wppandashop5'),
                        'desc'      =>  ''
                    ),
                    array(
                        'id'        =>  'envato-url', 
                        'type'      =>  'text', 
                        'title'     =>  __('Envato URL', 'wppandashop5'),
                        'subtitle'  =>  __('Please enter in your Envato URL.', 'wppandashop5'),
                        'desc'      =>  ''
                    ),
                    array(
                        'id'        =>  'evernote-url', 
                        'type'      =>  'text', 
                        'title'     =>  __('Evernote URL', 'wppandashop5'),
                        'subtitle'  =>  __('Please enter in your Envernote URL.', 'wppandashop5'),
                        'desc'      =>  ''
                    ),
*/

                    /*
                    array(
                        'id'        =>  'flickr-url', 
                        'type'      =>  'text', 
                        'title'     =>  __('Flickr URL', 'wppandashop5'),
                        'subtitle'  =>  __('Please enter in your Flickr URL.', 'wppandashop5'),
                        'desc'      =>  ''
                    ),
                    array(
                        'id'        =>  'forrst-url', 
                        'type'      =>  'text', 
                        'title'     =>  __('Forrst URL', 'wppandashop5'),
                        'subtitle'  =>  __('Please enter in your Forrst URL.', 'wppandashop5'),
                        'desc'      =>  ''
                    ),
                    array(
                        'id'        =>  'github-url', 
                        'type'      =>  'text', 
                        'title'     =>  __('Github URL', 'wppandashop5'),
                        'subtitle'  =>  __('Please enter in your Github URL.', 'wppandashop5'),
                        'desc'      =>  ''
                    ),
                    */
                    /*
                    array(
                        'id'        =>  'grooveshark-url', 
                        'type'      =>  'text', 
                        'title'     =>  __('Grooveshark URL', 'wppandashop5'),
                        'subtitle'  =>  __('Please enter in your Grooveshark URL.', 'wppandashop5'),
                        'desc'      =>  ''
                    ),
                    array(
                        'id'        =>  'instagram-url', 
                        'type'      =>  'text', 
                        'title'     =>  __('Instagram URL', 'wppandashop5'),
                        'subtitle'  =>  __('Please enter in your Instagram URL.', 'wppandashop5'),
                        'desc'      =>  ''
                    ),
                    array(
                        'id'        =>  'last-fm-url', 
                        'type'      =>  'text', 
                        'title'     =>  __('Last FM URL', 'wppandashop5'),
                        'subtitle'  =>  __('Please enter in your Last FM URL.', 'wppandashop5'),
                        'desc'      =>  ''
                    ),
                    array(
                        'id'        =>  'linkedin-url', 
                        'type'      =>  'text', 
                        'title'     =>  __('Linked In URL', 'wppandashop5'),
                        'subtitle'  =>  __('Please enter in your Linked In URL.', 'wppandashop5'),
                        'desc'      =>  ''
                    ),
                    array(
                        'id'        =>  'paypal-url', 
                        'type'      =>  'text', 
                        'title'     =>  __('Paypal URL', 'wppandashop5'),
                        'subtitle'  =>  __('Please enter in your Paypal URL.<br><br>Example: mailto:someone@example.com', 'wppandashop5'),
                        'desc'      =>  ''
                    ),
                    array(
                        'id'        =>  'pinterest-url', 
                        'type'      =>  'text', 
                        'title'     =>  __('Pinterest URL', 'wppandashop5'),
                        'subtitle'  =>  __('Please enter in your Pinterest URL.', 'wppandashop5'),
                        'desc'      =>  ''
                    ),
                    array(
                        'id'        =>  'quora-url', 
                        'type'      =>  'text', 
                        'title'     =>  __('Quora URL', 'wppandashop5'),
                        'subtitle'  =>  __('Please enter in your Quora URL.', 'wppandashop5'),
                        'desc'      =>  ''
                    ),
                    array(
                        'id'        =>  'skype-url', 
                        'type'      =>  'text', 
                        'title'     =>  __('Skype URL', 'wppandashop5'),
                        'subtitle'  =>  __('Please enter in your Skype URL.<br><br>Example: skype:username?call', 'wppandashop5'),
                        'desc'      =>  ''
                    ),
                    array(
                        'id'        =>  'soundcloud-url', 
                        'type'      =>  'text', 
                        'title'     =>  __('Soundcloud URL', 'wppandashop5'),
                        'subtitle'  =>  __('Please enter in your Soundcloud URL.', 'wppandashop5'),
                        'desc'      =>  ''
                    ),
                    array(
                        'id'        =>  'stumbleupon-url', 
                        'type'      =>  'text', 
                        'title'     =>  __('Stumble Upon URL', 'wppandashop5'),
                        'subtitle'  =>  __('Please enter in your Stumble Upon URL.', 'wppandashop5'),
                        'desc'      =>  ''
                    ),
                    array(
                        'id'        =>  'tumblr-url', 
                        'type'      =>  'text', 
                        'title'     =>  __('Tumblr URL', 'wppandashop5'),
                        'subtitle'  =>  __('Please enter in your Tumblr URL.', 'wppandashop5'),
                        'desc'      =>  ''
                    ),*/
                    /*
                    array(
                        'id'        =>  'viddler-url', 
                        'type'      =>  'text', 
                        'title'     =>  __('Viddler URL', 'wppandashop5'),
                        'subtitle'  =>  __('Please enter in your Viddler URL.', 'wppandashop5'),
                        'desc'      =>  ''
                    ),
                    array(
                        'id'        =>  'vimeo-url', 
                        'type'      =>  'text', 
                        'title'     =>  __('Vimeo URL', 'wppandashop5'),
                        'subtitle'  =>  __('Please enter in your Vimeo URL.', 'wppandashop5'),
                        'desc'      =>  ''
                    ),
                    array(
                        'id'        =>  'virb-url', 
                        'type'      =>  'text', 
                        'title'     =>  __('Virb URL', 'wppandashop5'),
                        'subtitle'  =>  __('Please enter in your Virb URL.', 'wppandashop5'),
                        'desc'      =>  ''
                    ),
                    array(
                        'id'        =>  'wordpress-url', 
                        'type'      =>  'text', 
                        'title'     =>  __('Wordpress URL', 'wppandashop5'),
                        'subtitle'  =>  __('Please enter in your Wordpress URL.', 'wppandashop5'),
                        'desc'      =>  ''
                    ),
                    array(
                        'id'        =>  'xing-url', 
                        'type'      =>  'text', 
                        'title'     =>  __('Xing URL', 'wppandashop5'),
                        'subtitle'  =>  __('Please enter in your Xing URL.', 'wppandashop5'),
                        'desc'      =>  ''
                    ),
                    array(
                        'id'        =>  'yahoo-url', 
                        'type'      =>  'text', 
                        'title'     =>  __('Yahoo URL', 'wppandashop5'),
                        'subtitle'  =>  __('Please enter in your Yahoo URL.', 'wppandashop5'),
                        'desc'      =>  ''
                    ),
                    array(
                        'id'        =>  'yelp-url', 
                        'type'      =>  'text', 
                        'title'     =>  __('Yelp URL', 'wppandashop5'),
                        'subtitle'  =>  __('Please enter in your Yelp URL.', 'wppandashop5'),
                        'desc'      =>  ''
                    ),*/
                   /*
                    array(
                        'id'        =>  'zerply-url', 
                        'type'      =>  'text', 
                        'title'     =>  __('Zerply URL', 'wppandashop5'),
                        'subtitle'  =>  __('Please enter in your Zerply URL.', 'wppandashop5'),
                        'desc'      =>  ''
                    )*/
                )
            );

            /*-----------------------------------------------------------------------------------*/
            /*  - Automatic Updates
            /*-----------------------------------------------------------------------------------*/
        /*    $this->sections[] = array(
                'title'     =>  __('Theme Updates', 'wppandashop5'),
                'desc'      =>  __('Here you can enabled the Automatic Update for WP Panda Shop 5 Theme.', 'wppandashop5'),
                'icon'      =>  'font-icon-cycle',
                'fields'    =>  array(

                    array(
                        'id'        =>  'enable-auto-updates',
                        'type'      =>  'switch',
                        'title'     =>  __('Enable Auto Updates', 'wppandashop5'),
                        'subtitle'  =>  __('Enable/Disable the automatic updates for your theme.', 'wppandashop5'),
                        'desc'      =>  '',
                        'default'   =>  0
                    ),

                    array(
                        'id'        =>  'envato-license-key',
                        'type'      =>  'text',
                        'required'  =>  array('enable-auto-updates','=','1'),
                        'title'     =>  __('Item Purchase Code', 'wppandashop5'),
                        'subtitle'  =>  __('Enter your Envato license key here if you wish to receive auto updates for your theme.', 'wppandashop5'),
                        'default'   =>  'Insert here the License Key...'
                    ),
                )
            );

            $theme_info  = '<div class="redux-framework-section-desc">';
            $theme_info .= '<p class="redux-framework-theme-data description theme-uri">' . __('<strong>Theme URL:</strong> ', 'wppandashop5') . '<a href="' . $this->theme->get('ThemeURI') . '" target="_blank">' . $this->theme->get('ThemeURI') . '</a></p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-author">' . __('<strong>Author:</strong> ', 'wppandashop5') . $this->theme->get('Author') . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-version">' . __('<strong>Version:</strong> ', 'wppandashop5') . $this->theme->get('Version') . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-description">' . $this->theme->get('Description') . '</p>';
            $tabs = $this->theme->get('Tags');
            if (!empty($tabs)) {
                $theme_info .= '<p class="redux-framework-theme-data description theme-tags">' . __('<strong>Tags:</strong> ', 'wppandashop5') . implode(', ', $tabs) . '</p>';
            }
            $theme_info .= '</div>';

            if (file_exists(dirname(__FILE__) . '/../README.md')) {
                $this->sections['theme_docs'] = array(
                    'icon'      => 'el-icon-list-alt',
                    'title'     => __('Documentation', 'wppandashop5'),
                    'fields'    => array(
                        array(
                            'id'        => '17',
                            'type'      => 'raw',
                            'markdown'  => true,
                            'content'   => file_get_contents(dirname(__FILE__) . '/../README.md')
                        ),
                    ),
                );
            }
            
            $this->sections[] = array(
                'title'     => __('Import / Export', 'wppandashop5'),
                'desc'      => __('Import and Export your Redux Framework settings from file, text or URL.', 'wppandashop5'),
                'icon'      => 'font-icon-switch',
                'fields'    => array(
                    array(
                        'id'            => 'opt-import-export',
                        'type'          => 'import_export',
                        'title'         => 'Import Export',
                        'subtitle'      => 'Save and restore your Redux options',
                        'full_width'    => false,
                    ),
                ),
            );                     

            /*
            $this->sections[] = array(
                'icon'      => 'el-icon-info-sign',
                'title'     => __('Theme Information', 'wppandashop5'),
                'desc'      => __('<p class="description">This is the Description. Again HTML is allowed</p>', 'wppandashop5'),
                'fields'    => array(
                    array(
                        'id'        => 'opt-raw-info',
                        'type'      => 'raw',
                        'content'   => $item_info,
                    )
                ),
            );

            if (file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
                $tabs['docs'] = array(
                    'icon'      => 'el-icon-book',
                    'title'     => __('Documentation', 'wppandashop5'),
                    'content'   => nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
                );
            }
            */
        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-1',
                'title'     => __('Theme Information 1', 'wppandashop5'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'wppandashop5')
            );

            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-2',
                'title'     => __('Theme Information 2', 'wppandashop5'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'wppandashop5')
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'wppandashop5');
        }

        /**
         * All the possible arguments for Redux.
         * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'          => 'wps5_option',                 // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'      => $theme->get('Name'),     // Name that appears at the top of your panel
                'display_version'   => $theme->get('Version'),  // Version that appears at the top of your panel
                'menu_type'         => 'menu',                  // Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'    => true,                    // Show the sections below the admin menu item or not
                'menu_title'        => __('WP Panda Shop 5', 'wppandashop5'),
                'page_title'        => __('WP Panda Shop 5', 'wppandashop5'),
                
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key'    => 'AIzaSyAX_2L_UzCDPEnAHTG7zhESRVpMPS4ssII', // Must be defined to add google fonts to the typography module
                'google_update_weekly' => false,                // Set it you want google fonts to update weekly. A google_api_key value is required.
                'async_typography'  => true,                    // Use a asynchronous font on the front end or font string
                'admin_bar'         => true,                    // Show the panel pages on the admin bar
                'global_variable'   => '',                      // Set a different name for your global variable other than the opt_name
                'dev_mode'          => false,                   // Show the time the page took to load, etc
                'customizer'        => true,                    // Enable basic customizer support
                //'open_expanded'     => true,                  // Allow you to start the panel in an expanded way initially.
                //'disable_save_warn' => true,                  // Disable the save warning when a user changes a field

                // OPTIONAL -> Give you extra features
                'page_priority'     => null,                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'       => 'themes.php',            // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions'  => 'manage_options',        // Permissions needed to access the options panel.
                'menu_icon'         => '',                      // Specify a custom URL to an icon
                'last_tab'          => '',                      // Force your panel to always open to a specific tab (by id)
                'page_icon'         => 'icon-themes',           // Icon displayed in the admin panel next to your menu_title
                'page_slug'         => '_options',              // Page slug used to denote the panel
                'save_defaults'     => true,                    // On load save the defaults to DB before user clicks save or not
                'default_show'      => false,                   // If true, shows the default value next to each field that is not the default value.
                'default_mark'      => '',                      // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => true,                   // Shows the Import/Export panel when not used as a field.
                
                // CAREFUL -> These options are for advanced use only
                'transient_time'    => 60 * MINUTE_IN_SECONDS,
                'output'            => true,                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'        => true,                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.
                
                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database'              => '',                  // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info'           => false,               // REMOVE

                // HINTS
                'hints' => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'         => 'light',
                        'shadow'        => true,
                        'rounded'       => false,
                        'style'         => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show'          => array(
                            'effect'        => 'slide',
                            'duration'      => '500',
                            'event'         => 'mouseover',
                        ),
                        'hide'      => array(
                            'effect'    => 'slide',
                            'duration'  => '500',
                            'event'     => 'click mouseleave',
                        ),
                    ),
                )
            );


            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            $this->args['share_icons']['twitter'] = array(
                'link' => 'http://twitter.com/bluxart',
                'title' => 'Follow me on Twitter', 
                'icon' => 'font-icon-social-twitter'
            );
            $this->args['share_icons']['dribbble'] = array(
                'link' => 'http://dribbble.com/Bluxart',
                'title' => 'Find me on Dribbble', 
                'icon' => 'font-icon-social-dribbble'
            );
            $this->args['share_icons']['forrst'] = array(
                'link' => 'http://forrst.com/people/Bluxart',
                'title' => 'Find me on Forrst', 
                'icon' => 'font-icon-social-forrst'
            );
            $this->args['share_icons']['behance'] = array(
                'link' => 'http://www.behance.net/alessioatzeni',
                'title' => 'Find me on Behance', 
                'icon' => 'font-icon-social-behance'
            );
            $this->args['share_icons']['facebook'] = array(
                'link' => 'https://www.facebook.com/atzenialessio',
                'title' => 'Follow me on Facebook', 
                'icon' => 'font-icon-social-facebook'
            );
            $this->args['share_icons']['google_plus'] = array(
                'link' => 'https://plus.google.com/105500420878314068694/posts',
                'title' => 'Find me on Google Plus', 
                'icon' => 'font-icon-social-google-plus'
            );
            $this->args['share_icons']['linked_in'] = array(
                'link' => 'http://www.linkedin.com/in/alessioatzeni',
                'title' => 'Find me on LinkedIn', 
                'icon' => 'font-icon-social-linkedin'
            );
            $this->args['share_icons']['envato'] = array(
                'link' => 'http://themeforest.net/user/Bluxart',
                'title' => 'Find me on Themeforest', 
                'icon' => 'font-icon-social-envato'
            );

            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace('-', '_', $this->args['opt_name']);
                }
                $this->args['intro_text'] = sprintf(__('<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'wppandashop5'), $v);
            } else {
                $this->args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'wppandashop5');
            }

            // Add content after the form.
            // $this->args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'wppandashop5');
        }

    }
    
    global $reduxConfig;
    $reduxConfig = new Redux_Framework_sample_config();
}

/**
 * Custom function for the callback referenced above
 */
if (!function_exists('redux_my_custom_field')):
    function redux_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;

/**
 * Custom function for the callback validation referenced above
 * */
if (!function_exists('redux_validate_callback_function')):
    function redux_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';

        /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            $field['msg'] = 'your custom error message';
          }
         */

        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;
