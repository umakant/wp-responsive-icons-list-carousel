<?php
/**
* Plugin Name: WP Responsive Icons List Carousel
* Description: WP Responsive Icons List Carousel plugin is for Add Icons with this Shortcode '[Iconlist-icons]'.
* Version: 1.0.0
* Author: omikant
* Author URI: https://profiles.wordpress.org/omikant
* License: GPL2
*/

function Icon_list() {
  $labels = array(
    'name'               => _x( 'Icons', 'post type general name' ),
    'singular_name'      => _x( 'Icon', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'Icon' ),
    'add_new_item'       => __( 'Add New Icon' ),
    'edit_item'          => __( 'Edit Icon' ),
    'new_item'           => __( 'New Icon' ),
    'all_items'          => __( 'All Icons' ),
    'view_item'          => __( 'View Icon' ),
    'search_items'       => __( 'Search Icons' ),
    'not_found'          => __( 'No Icons found' ),
    'not_found_in_trash' => __( 'No Icons found in the Trash' ), 
    'menu_name'          => 'Icons List'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => 'Holds our Icons and Icon specific data',
    'public'        => true,
    'menu_position' => 5,
    'supports'      => array( 'title', 'editor', 'thumbnail' ),
    'has_archive'   => true,
  );
  register_post_type( 'Iconlist', $args ); 
}
add_action( 'init', 'Icon_list' );
add_image_size( 'iconlist_thumb', 120, 120, true);

// create shortcode to list all Iconlist icons which come in blue
add_shortcode( 'Iconlist-icons', 'technologies_logo' );
function technologies_logo( $atts ) {
    ob_start();
    $query = new WP_Query( array(
        'post_type' => 'Iconlist',
        'posts_per_page' => -1,
        'order' => 'ASC',
        'orderby' => 'title',
    ) );
    if ( $query->have_posts() ) { ?>
        <div id="owl-dataman" class="owl-carousel">
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
            <div class="item darkCyan"  id="post-<?php the_ID(); ?>">
                <?php the_post_thumbnail('iconlist_thumb'); ?>
				<h3><?php the_title(); ?></h3>
            </div>
            <?php endwhile;
            wp_reset_postdata(); ?>
        </div>
    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
}

add_action('wp_footer', 'wptech_register_scripts');
function wptech_register_scripts() {
    if (!is_admin()) {
        // register
        wp_register_script('wptechnology_icons_script', plugins_url('js/owl.carousel.min.js', __FILE__));
		// enqueue
        wp_enqueue_script('wptechnology_icons_script');
        wp_enqueue_script( 'jquery' );
    }
}

add_action('wp_footer', 'wptechscript_register_scripts');
function wptechscript_register_scripts() {
    if (!is_admin()) { ?>
       	<!-- Frontpage Demo -->
       <style>
		.inner-col1 .owl-buttons div {
			  top: 54%;
			}
			.owl-buttons .owl-prev {
			  left: -53px;
			}
			.owl-buttons div {
				
			  background: url("<?php plugins_url( '/images/arrow.png', __FILE__ ); ?>") no-repeat;
			  height: 45px;
			  margin-top: -30px;
			  outline: 0 none;
			  position: absolute;
			  text-indent: -9999px;
			  top: 50%;
			  width: 45px;
			  z-index: 9;
			}
			.owl-buttons .owl-next {
			  right: -53px;
			  background-position: -69px 0;
			}
			.owl-buttons div {
			  background: url("<?php plugins_url( '/images/arrow.png', __FILE__ ); ?>") no-repeat ;
			  height: 45px;
			  margin-top: -30px;
			  outline: 0 none;
			  position: absolute;
			  text-indent: -9999px;
			  top: 50%;
			  width: 45px;
			  z-index: 9;
			}
       </style>
    <script>
    $(document).ready(function($) {
       jQuery("#owl-dataman").owlCarousel({
        autoPlay: true,
        navigation: true,
        slideSpeed: 300,
        paginationSpeed: 400,
        pagination: false,
        items: 4,
        itemsCustom: [
            [0, 1],
            [450, 1],
            [600, 2],
            [700, 2],
            [768, 3],
            [1000, 3],
            [1200, 4],
            [1400, 4],
            [1600, 4]
        ]
    });
    jQuery("#owl-dataman .owl-controls .owl-prev").click(function() {
        var owl = jQuery("#owl-demo-product");
        owl.trigger('owl.prev');
    });
    jQuery("#owl-dataman .owl-controls .owl-next").click(function() {
        var owl = jQuery("#owl-demo-product");
        owl.trigger('owl.next');
    });
    });
    </script>
    <?php
    }
}

add_action('wp_footer', 'wptech_register_styles');
function wptech_register_styles() {
	// register
    wp_register_style('wptechnology_icons_styles', plugins_url('css/owl.carousel.css', __FILE__));
    wp_register_style('wptechnology_icons_styles_theme', plugins_url('css/owl.theme.css', __FILE__));
    // enqueue
    wp_enqueue_style('wptechnology_icons_styles');
    wp_enqueue_style('wptechnology_icons_styles_theme');
    }
?>
