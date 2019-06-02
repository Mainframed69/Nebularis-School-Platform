 <?php
 /**
  * Banner Section
 */ 

$banner_control      = get_theme_mod( 'school_zone_ed_slider_section', 'static_banner_cta' );
$title               = get_theme_mod( 'school_zone_banner_title', __( 'Better Education for a Better World', 'school-zone' ) );
$description         = get_theme_mod( 'school_zone_banner_description', __( 'Maecenas perspiciatis eleifend mollitia esse etiam rem harum? Sunt incididunt, sollicitudin earum anim quidem laoreet nibh, facilisis eiusmod!', 'school-zone' ) );
$link_one_label      = get_theme_mod( 'school_zone_banner_link_one_label', __( 'Get Started Now', 'school-zone' ) );
$link_one_url        = get_theme_mod( 'school_zone_banner_link_one_url', '#' );
$link_two_label      = get_theme_mod( 'school_zone_banner_link_two_label', __( 'Enquiry', 'school-zone' ) );
$link_two_url        = get_theme_mod( 'school_zone_banner_link_two_url', '#' );
$class               = has_header_video() ? ' video-banner' : '';

$banner_post         = get_theme_mod( 'education_zone_banner_post' );
$read_more           = get_theme_mod( 'education_zone_banner_read_more', __( 'Read More', 'school-zone' ) );

if( 'post_banner' == $banner_control ){
    if( $banner_post ){
        $qry = new WP_Query( "p=$banner_post" );

        echo '<div class="banner-wrapper'. esc_attr( $class ).'">';

        if( $qry->have_posts() ){ 
            while( $qry->have_posts() ){   
                $qry->the_post();
                if( has_post_thumbnail() ){ 
                    the_post_thumbnail( 'education-zone-banner' ); ?>  
                    <div class="banner-text">
                        <div class="container">
                            <div class="text">
                                <span><?php the_title(); ?></span>
                                <?php if( $read_more ): ?>
                                <a href="<?php the_permalink(); ?>" class="course-link"><?php echo esc_html( $read_more ); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            wp_reset_postdata();
        }
        echo '</div><!-- .banner-wrapper -->';
    } 
} elseif( has_custom_header() && 'static_banner_cta' == $banner_control ){ 
                                                                              
    echo '<div class="banner-wrapper'. esc_attr( $class ).'">';

        the_custom_header_markup(); ?>                                                                
        <div class="banner-text">
            <div class="container">
                <div class="text">
                    <?php
                        if ( $title || $description ){
                            if ( $title ) echo '<h2 class="title">'. esc_html( $title ).'</h2>';
                            if ( $description ) echo '<p class="wow">'. esc_html( $description ) .'</p>';
                        }

                        if ( ( $link_one_label && $link_one_url ) || ( $link_two_label && $link_two_url ) ) {
                            ?>
                            <div class="btn-holder">
                                <?php
                                    if ( $link_one_label && $link_one_url ) echo  '<a href="'. esc_url( $link_one_url ) .'" class="btn-free-inquiry">'. esc_html( $link_one_label ) .'</a>'; 
                                    if ( $link_two_label && $link_two_url ) echo '<a href="'. esc_url( $link_two_url ) .'" class="btn-view-service">'. esc_html( $link_two_label ) .'</a>';
                                ?>
                            </div>
                        <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </div><!-- .banner-wrapper -->
<?php
}