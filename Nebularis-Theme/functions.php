<?php
/**
 * Theme functions and definitions
 *
 * @package School_Zone
 */

/**
 * After setup theme hook
 */
function school_zone_theme_setup(){
    /*
     * Make chile theme available for translation.
     * Translations can be filed in the /languages/ directory.
     */
    load_child_theme_textdomain( 'school-zone', get_stylesheet_directory() . '/languages' );

    /**
     * Add support for core custom logo.
     *
     * @link https://codex.wordpress.org/Theme_Logo
     */
    add_theme_support( 'custom-logo', array(
        'header-text' => array( 'site-title', 'site-description' ),
    ) );
    
    $header_args = array(
        'default-image'    => get_stylesheet_directory_uri().'/images/banner-image.jpg',
        'width'            => 1920,
        'height'           => 692,
        'header-text'      => false,
        'video'            => true,
    );

    add_theme_support( 'custom-header', $header_args );

    /**
     * Register a selection of default headers to be displayed by the custom header admin UI.
     *
     * @link https://codex.wordpress.org/Function_Reference/register_default_headers
     */
    register_default_headers( array(
        'child' => array(
            'url'           => '%2$s/images/banner-image.jpg',
            'thumbnail_url' => '%2$s/images/banner-image.jpg',
            'description'   => __( 'Default Header Image', 'school-zone' ),
        ),
    ) );
}
add_action( 'after_setup_theme', 'school_zone_theme_setup' );

/**
 * Load assets.
 *
 */
function school_zone_enqueue_styles() {
    $my_theme = wp_get_theme();
    $version = $my_theme['Version'];
    
    wp_enqueue_style( 'education-zone-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'school-zone-style', get_stylesheet_directory_uri() . '/style.css', array( 'education-zone-style' ), $version );

    wp_enqueue_script( 'school-zone-custom-js', get_stylesheet_directory_uri() . '/js/custom.js', array('jquery'), $version, true );
}
add_action( 'wp_enqueue_scripts', 'school_zone_enqueue_styles' );

//Remove a function from the parent theme
function remove_parent_filters(){ //Have to do it after theme setup, because child theme functions are loaded first
    remove_filter( 'body_class', 'education_zone_body_classes');
    remove_action( 'customize_register', 'education_zone_customizer_theme_info' );
}
add_action( 'init', 'remove_parent_filters' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function school_zone_body_classes( $classes ) {
    global $post;

    $page_class        = education_zone_sidebar_layout_class();
    $ed_banner_section = get_theme_mod( 'school_zone_ed_slider_section', 'post_banner' );

    // Adds a class of group-blog to blogs with more than 1 published author.
    if ( is_multi_author() ) {
        $classes[] = 'group-blog';
    }

    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    if( 'no_banner' == $ed_banner_section ){
        $classes[] = 'no-banner';
    }
    
    // Adds a class of custom-background-image to sites with a custom background image.
    if ( get_background_image() ) {
        $classes[] = 'custom-background-image';
    }
    
    // Adds a class of custom-background-color to sites with a custom background color.
    if ( get_background_color() != 'ffffff' ) {
        $classes[] = 'custom-background-color';
    }
    
    if( ! is_active_sidebar( 'right-sidebar' ) || is_page_template( 'template-home.php' ) || $page_class == 'no-sidebar' ){
        $classes[] = 'full-width';
    }

    if( education_zone_is_woocommerce_activated() && ( is_shop() || is_product_category() || is_product_tag() || 'product' === get_post_type() ) && ! is_active_sidebar( 'shop-sidebar' ) ){
        $classes[] = 'full-width';
    }
 
    return $classes;
}
add_filter( 'body_class', 'school_zone_body_classes' );

/**
 * Primary Navigation
*/
function school_zone_primary_nav(){ ?>
    <div id="mobile-header">
        <a id="responsive-menu-button" href="#sidr-main"><i class="fa fa-bars"></i></a>
    </div>    
    <nav id="site-navigation" class="main-navigation" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
        <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
    </nav><!-- #site-navigation -->
    <?php    
}

/**
 * Disable customizer fields from parent and add custom settings/controls
 */
add_action( 'customize_register', 'school_zone_customize_register', 50 );

function school_zone_customize_register( $wp_customize ){

    $wp_customize->add_section( 'theme_info' , array(
        'title'       => __( 'Demo and Documentation' , 'school-zone' ),
        'priority'    => 6,
    ));

    $wp_customize->add_setting('theme_info_theme',array(
        'default' => '',
        'sanitize_callback' => 'wp_kses_post',
    ));
    
    $theme_info = '';
   
    $theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'Theme Documentation', 'school-zone' ) . ': </label><a href="' . esc_url( 'http://raratheme.com/documentation/school-zone/' ) . '" target="_blank">' . __( 'Click here', 'school-zone' ) . '</a></span><br />';
    
    $theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'Theme Demo', 'school-zone' ) . ': </label><a href="' . esc_url( 'http://demo.raratheme.com/school-zone' ) . '" target="_blank">' . __( 'Click here', 'school-zone' ) . '</a></span><br />';

    $theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'Theme info', 'school-zone' ) . ': </label><a href="' . esc_url( 'https://raratheme.com/wordpress-themes/school-zone/' ) . '" target="_blank">' . __( 'Click here', 'school-zone' ) . '</a></span><br />';

    $theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'Support Ticket', 'school-zone' ) . ': </label><a href="' . esc_url( 'https://raratheme.com/support-ticket/' ) . '" target="_blank">' . __( 'Click here', 'school-zone' ) . '</a></span><br />';

    $theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'More WordPress Themes', 'school-zone' ) . ': </label><a href="' . esc_url( 'https://raratheme.com/wordpress-themes/' ) . '" target="_blank">' . __( 'Click here', 'school-zone' ) . '</a></span><br />';

    $wp_customize->add_control( new Education_Zone_Theme_Info( $wp_customize ,'theme_info_theme',array(
        'label' => __( 'About School Zone' , 'school-zone' ),
        'section' => 'theme_info',
        'description' => $theme_info
    )));

    $wp_customize->add_setting('theme_info_more_theme',array(
        'default' => '',
        'sanitize_callback' => 'wp_kses_post',
    ));

    // Top header
    $wp_customize->get_section( 'education_zone_top_header_settings' )->title  = __( 'Header Settings', 'school-zone' );
    $wp_customize->remove_setting( 'education_zone_top_menu_label');
    $wp_customize->remove_control( 'education_zone_top_menu_label');
    $wp_customize->remove_setting( 'education_zone_ed_slider_section' );
    $wp_customize->remove_control( 'education_zone_ed_slider_section' );


    // Move default section
    $wp_customize->get_section( 'header_image' )->panel    = 'education_zone_home_page_settings';
    $wp_customize->get_section( 'header_image' )->title    = __( 'Banner Section', 'school-zone' );
    $wp_customize->get_section( 'header_image' )->priority = 10;
    $wp_customize->get_control( 'header_image' )->active_callback = 'school_zone_banner_ac';
    $wp_customize->get_control( 'header_video' )->active_callback = 'school_zone_banner_ac';
    $wp_customize->get_control( 'external_header_video' )->active_callback = 'school_zone_banner_ac';
    $wp_customize->get_section( 'header_image' )->description = '';                                               
    $wp_customize->get_setting( 'header_image' )->transport = 'refresh';
    $wp_customize->get_setting( 'header_video' )->transport = 'refresh';
    $wp_customize->get_setting( 'external_header_video' )->transport = 'refresh';

    $wp_customize->get_control( 'education_zone_banner_post' )->section = 'header_image';
    $wp_customize->get_control( 'education_zone_banner_read_more' )->section = 'header_image';
    $wp_customize->get_control( 'education_zone_banner_post' )->active_callback = 'school_zone_banner_ac';
    $wp_customize->get_control( 'education_zone_banner_read_more' )->active_callback = 'school_zone_banner_ac';

    // Selective referesh for parent theme header email
    $wp_customize->get_setting( 'education_zone_email' )->transport = 'postMessage';
    $wp_customize->selective_refresh->add_partial( 'education_zone_email', array(
        'selector'        => '.site-header .info-box a.header-email',
        'render_callback' => 'school_zone_get_header_email',
    ) );

    // Selective referesh for parent theme header phone
    $wp_customize->get_setting( 'education_zone_phone' )->transport = 'postMessage';
    $wp_customize->selective_refresh->add_partial( 'education_zone_phone', array(
        'selector'        => '.site-header .info-box a.header-phone',
        'render_callback' => 'school_zone_get_header_phone',
    ) );

    /** Address Field */
    $wp_customize->add_setting(
        'school_zone_header_address',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'school_zone_header_address',
        array(
            'section'     => 'education_zone_top_header_settings',
            'label'       => __( 'Address', 'school-zone' ),
            'type'        => 'text'
        )
    );

    // Selective referesh for header address
    $wp_customize->selective_refresh->add_partial( 'school_zone_header_address', array(
        'selector'        => '.site-header .info-box span.header-address',
        'render_callback' => 'school_zone_get_header_address',
    ) );

    /** CTA Label */
    $wp_customize->add_setting(
        'school_zone_header_cta_label',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'school_zone_header_cta_label',
        array(
            'section'     => 'education_zone_top_header_settings',
            'label'       => __( 'CTA Label', 'school-zone' ),
            'type'        => 'text'
        )
    );

    // Selective referesh for header address
    $wp_customize->selective_refresh->add_partial( 'school_zone_header_cta_label', array(
        'selector'        => '.site-header .header-m a.apply-btn',
        'render_callback' => 'school_zone_get_header_cta_label',
    ) );

    /** CTA  Link */
    $wp_customize->add_setting(
        'school_zone_header_cta_link',
        array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    
    $wp_customize->add_control(
        'school_zone_header_cta_link',
        array(
            'section'     => 'education_zone_top_header_settings',
            'label'       => __( 'CTA Link', 'school-zone' ),
            'type'        => 'url'
        )
    );

    /** Banner Options */
    $wp_customize->add_setting(
        'school_zone_ed_slider_section',
        array(
            'default'           => 'static_banner_cta',
            'sanitize_callback' => 'education_zone_sanitize_select'
        )
    );

    $wp_customize->add_control(
        'school_zone_ed_slider_section',
        array(
            'label'       => __( 'Banner Options', 'school-zone' ),
            'description' => __( 'Choose banner as static image/video.', 'school-zone' ),
            'section'     => 'header_image',
            'choices'     => array(
                'no_banner'         => __( 'Disable Banner Section', 'school-zone' ),
                'static_banner_cta' => __( 'Static/Video CTA Banner', 'school-zone' ),
                'post_banner'       => __( 'Post Banner', 'school-zone' ),
            ),
            'priority'    => 5,
            'type'        => 'select'
        )            
    );

    /** Banner title */
    $wp_customize->add_setting(
        'school_zone_banner_title',
        array(
            'default'           => __( 'Better Education for a Better World', 'school-zone' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'school_zone_banner_title',
        array(
            'section'         => 'header_image',
            'label'           => __( 'Banner Title', 'school-zone' ),
            'active_callback' => 'school_zone_banner_ac'
        )
    );

    // banner title selective refresh
    $wp_customize->selective_refresh->add_partial( 'school_zone_banner_title', array(
        'selector'            => '.banner .banner-text h2.title',
        'render_callback'     => 'school_zone_banner_title_selective_refresh',
        'container_inclusive' => false,
        'fallback_refresh'    => true,
    ) );

    /** Banner description */
    $wp_customize->add_setting(
        'school_zone_banner_description',
        array(
            'default'           => __( 'Maecenas perspiciatis eleifend mollitia esse etiam rem harum? Sunt incididunt, sollicitudin earum anim quidem laoreet nibh, facilisis eiusmod!', 'school-zone' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'school_zone_banner_description',
        array(
            'section'         => 'header_image',
            'label'           => __( 'Banner Description', 'school-zone' ),
            'active_callback' => 'school_zone_banner_ac'
        )
    );

    // Banner description selective refresh
    $wp_customize->selective_refresh->add_partial( 'school_zone_banner_description', array(
        'selector'            => '.banner .banner-text p.wow',
        'render_callback'     => 'school_zone_banner_description_selective_refresh',
        'container_inclusive' => false,
        'fallback_refresh'    => true,
    ) );

    /** Banner link one label */
    $wp_customize->add_setting(
        'school_zone_banner_link_one_label',
        array(
            'default'           => __( 'Get Started Now', 'school-zone' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'school_zone_banner_link_one_label',
        array(
            'section'         => 'header_image',
            'label'           => __( 'Link One Label', 'school-zone' ),
            'active_callback' => 'school_zone_banner_ac'
        )
    );

    // Selective refresh for banner link one label
    $wp_customize->selective_refresh->add_partial( 'school_zone_banner_link_one_label', array(
        'selector'            => '.banner .banner-text .btn-holder a.btn-free-inquiry',
        'render_callback'     => 'school_zone_banner_link_one_label_selective_refresh',
        'container_inclusive' => false,
        'fallback_refresh'    => true,
    ) );

    /** Banner link one url */
    $wp_customize->add_setting(
        'school_zone_banner_link_one_url',
        array(
            'default'           => '#',
            'sanitize_callback' => 'esc_url_raw',
        )
    );

    $wp_customize->add_control(
        'school_zone_banner_link_one_url',
        array(
            'section'         => 'header_image',
            'label'           => __( 'Link One Url', 'school-zone' ),
            'type'            => 'url',
            'active_callback' => 'school_zone_banner_ac'
        )
    );

    /** Banner link two label */
    $wp_customize->add_setting(
        'school_zone_banner_link_two_label',
        array(
            'default'           => __( 'Enquiry', 'school-zone' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'school_zone_banner_link_two_label',
        array(
            'section'         => 'header_image',
            'label'           => __( 'Link Two Label', 'school-zone' ),
            'active_callback' => 'school_zone_banner_ac'
        )
    );

    // Selective refresh for banner link two label.
    $wp_customize->selective_refresh->add_partial( 'school_zone_banner_link_two_label', array(
        'selector'            => '.banner .btn-holder a.btn-view-service',
        'render_callback'     => 'school_zone_banner_link_two_label_selective_refresh',
        'container_inclusive' => false,
        'fallback_refresh'    => true,
    ) );

    /** Banner link two url */
    $wp_customize->add_setting(
        'school_zone_banner_link_two_url',
        array(
            'default'           => '#',
            'sanitize_callback' => 'esc_url_raw',
        )
    );

    $wp_customize->add_control(
        'school_zone_banner_link_two_url',
        array(
            'section'         => 'header_image',
            'label'           => __( 'Link Two Url', 'school-zone' ),
            'type'            => 'url',
            'active_callback' => 'school_zone_banner_ac'
        )
    );

}

/**
 * Partial refresh functions for header email
 */
function school_zone_get_header_email(){
    $header_email =  get_theme_mod( 'education_zone_email' );

    if( ! empty( $header_email ) ){
        return $header_email;
    }

    return false;
}

/**
 * Partial refresh functions for header phone
 */
function school_zone_get_header_phone(){
    $header_phone =  get_theme_mod( 'education_zone_phone' );

    if( ! empty( $header_phone ) ){
        return $header_phone;
    }

    return false;
}

/**
 * Partial refresh functions for header address
 */
function school_zone_get_header_address(){
    $header_address =  get_theme_mod( 'school_zone_header_address' );

    if( ! empty( $header_address ) ){
        return $header_address;
    }

    return false;
}

/**
 * Partial refresh functions for header cta button
 */
function school_zone_get_header_cta_label(){
    $header_cta =  get_theme_mod( 'school_zone_header_cta_label' );

    if( ! empty( $header_cta ) ){
        return $header_cta;
    }

    return false;
}

/**
 * Partial refresh functions for banner title
 */
function school_zone_banner_title_selective_refresh(){
    $banner_title =  get_theme_mod( 'school_zone_banner_title', __( 'Better Education for a Better World', 'school-zone' ) );

    if( ! empty( $banner_title ) ){
        return $banner_title;
    }

    return false;
}

/**
 * Partial refresh functions for banner description
 */
function school_zone_banner_description_selective_refresh(){
    $banner_description =  get_theme_mod( 'school_zone_banner_description', __( 'Maecenas perspiciatis eleifend mollitia esse etiam rem harum? Sunt incididunt, sollicitudin earum anim quidem laoreet nibh, facilisis eiusmod!', 'school-zone' ) );

    if( ! empty( $banner_description ) ){
        return $banner_description;
    }

    return false;
}

/**
 * Partial refresh functions for banner link one label
 */
function school_zone_banner_link_one_label_selective_refresh(){
    $link_one_label =  get_theme_mod( 'school_zone_banner_link_one_label', __( 'Get Started Now', 'school-zone' ) );

    if( ! empty( $link_one_label ) ){
        return $link_one_label;
    }

    return false;
}

/**
 * Partial refresh functions for banner link two label
 */
function school_zone_banner_link_two_label_selective_refresh(){
    $link_two_label =  get_theme_mod( 'school_zone_banner_link_two_label', __( 'Enquiry', 'school-zone' ) );

    if( ! empty( $link_two_label ) ){
        return $link_two_label;
    }

    return false;
}

/**
 * Active Callback
 */
function school_zone_banner_ac( $control ){
    $banner      = $control->manager->get_setting( 'school_zone_ed_slider_section' )->value();
    $control_id  = $control->id;
    
    // static banner controls
    if ( $control_id == 'header_image' && $banner == 'static_banner_cta' ) return true;
    if ( $control_id == 'header_video' && $banner == 'static_banner_cta' ) return true;
    if ( $control_id == 'external_header_video' && $banner == 'static_banner_cta' ) return true;

    // banner title and description controls
    if ( $control_id == 'school_zone_banner_title' && $banner == 'static_banner_cta' ) return true;
    if ( $control_id == 'school_zone_banner_description' && $banner == 'static_banner_cta' ) return true;

    // Link button controls
    if ( $control_id == 'school_zone_banner_link_one_label' && $banner == 'static_banner_cta' ) return true;
    if ( $control_id == 'school_zone_banner_link_one_url' && $banner == 'static_banner_cta' ) return true;
    if ( $control_id == 'school_zone_banner_link_two_label' && $banner == 'static_banner_cta' ) return true;
    if ( $control_id == 'school_zone_banner_link_two_url' && $banner == 'static_banner_cta' ) return true;

    // Post banner controls
    if ( $control_id == 'education_zone_banner_post' && $banner == 'post_banner' ) return true;
    if ( $control_id == 'education_zone_banner_read_more' && $banner == 'post_banner' ) return true;

    return false;
}

function school_zone_get_sections(){

    $sections = array(
        'slider-section' => array(
           'id' => 'slider',
           'class' => 'banner'
            ),
        'info-section' => array(
           'id' => 'info',
           'class' => 'information'
            ),
         'welcome-section' => array(
          'id' => 'welcome',
          'class' => 'welcome-note'
          ),
         'courses-section' => array(
          'id' => 'courses',
          'class' => 'featured-courses'
          ),
         'extra-info-section' => array(
          'id' => 'extra_info',
          'class' => 'theme'
          ),
        'choose-section' => array(
          'id' => 'choose',
          'class' => 'choose-us'
          ),
        'testimonial-section' => array(
          'id' => 'testimonials',
          'class' => 'student-stories'
          ),
        'blog-section' => array(
          'id' => 'blog',
          'class' => 'latest-events'
          ),
        'gallery-section'=> array(
          'id' => 'gallery',
          'class' => 'photo-gallery'
          ),
        'search-section' => array(
          'id' => 'search',
          'class' => 'search-section'
          ),
    );

    $enabled_section = array();

    if ( get_theme_mod( 'education_zone_ed_slider_section' ) != 'no_banner' ){
            $enabled_section[] = array(
                'id'    => 'slider',
                'class' => 'banner'
            );
    }

    foreach ( $sections as $section ) {
        if ( get_theme_mod( 'education_zone_ed_' . $section['id'] . '_section' ) == 1 ){
            $enabled_section[] = array(
                'id'    => $section['id'],
                'class' => $section['class']
            );
        }
    }
    return $enabled_section;
}