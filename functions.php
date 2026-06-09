<?php
/**
 * ILBS Alumni Child Theme — functions.php
 * Twenty Twenty-One Child Theme
 */

defined( 'ABSPATH' ) || exit;

/* ==========================================================
   1. ENQUEUE PARENT + CHILD STYLES & SCRIPTS
   ========================================================== */
add_action( 'wp_enqueue_scripts', 'ilbs_enqueue_assets' );
function ilbs_enqueue_assets() {

// Bootstrap 5
	wp_enqueue_style(
		'bootstrap',
		'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
		[],
		'5.3.3'
	);

	
	// Bootstrap Icons
	wp_enqueue_style(
		'bootstrap-icons',
		'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css',
		[],
		'1.11.3'
	);


	
	// Swiper CSS
	wp_enqueue_style(
		'swiper',
		'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
		[],
		'11.0.0'
	);

	// Google Fonts
	wp_enqueue_style(
		'ilbs-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Manrope:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Playfair+Display:wght@600;700&display=swap',
		[],
		null
	);

	// Child theme stylesheet (theme header + bridge)
	wp_enqueue_style(
		'ilbs-alumni-style',
		get_stylesheet_uri(),
		[],
		wp_get_theme()->get( 'Version' )
	);

	// Premium design system
	wp_enqueue_style(
		'ilbs-main',
		get_stylesheet_directory_uri() . '/assets/css/main.css',
		[ 'ilbs-alumni-style', 'bootstrap', 'swiper' ],
		wp_get_theme()->get( 'Version' )
	);

	if ( is_front_page() || is_post_type_archive( 'ilbs_award' ) ) {
		wp_enqueue_style(
			'ilbs-home-ref',
			get_stylesheet_directory_uri() . '/assets/css/home-ref.css',
			[ 'ilbs-main' ],
			wp_get_theme()->get( 'Version' )
		);
	}



	


	// Bootstrap JS
	wp_enqueue_script(
		'bootstrap-js',
		'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
		[],
		'5.3.3',
		true
	);

	// Swiper JS
	wp_enqueue_script(
		'swiper-js',
		'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
		[],
		'11.0.0',
		true
	);

	// GSAP + ScrollTrigger
	wp_enqueue_script(
		'gsap',
		'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js',
		[],
		'3.12.5',
		true
	);
	wp_enqueue_script(
		'gsap-scrolltrigger',
		'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js',
		[ 'gsap' ],
		'3.12.5',
		true
	);

	// Child theme main JS
	wp_enqueue_script(
		'ilbs-alumni-js',
		get_stylesheet_directory_uri() . '/assets/js/main.js',
		[ 'bootstrap-js', 'swiper-js', 'gsap', 'gsap-scrolltrigger' ],
		wp_get_theme()->get( 'Version' ),
		true
	);

	// Pass AJAX URL to JS
	wp_localize_script( 'ilbs-alumni-js', 'ilbsData', [
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		'nonce'   => wp_create_nonce( 'ilbs_nonce' ),
		'siteUrl' => get_site_url(),
	] );
}


/**
 * Remove Twenty Twenty-One parent styles
 */
function ilbs_remove_parent_theme_styles() {
	wp_dequeue_style( 'twenty-twenty-one-style' );
	wp_deregister_style( 'twenty-twenty-one-style' );
	wp_dequeue_style( 'twenty-twenty-one-print-style' );
	wp_deregister_style( 'twenty-twenty-one-print-style' );
	wp_dequeue_style( 'twenty-twenty-one-custom-color-overrides' );
	wp_dequeue_style( 'global-styles' );
}
add_action( 'wp_enqueue_scripts', 'ilbs_remove_parent_theme_styles', 100 );
/* ==========================================================
   2. THEME SETUP
   ========================================================== */
add_action( 'after_setup_theme', 'ilbs_child_theme_setup' );
function ilbs_child_theme_setup() {
	// Navigation menus
	register_nav_menus( [
		'primary'  => __( 'Primary Navigation', 'ilbs-alumni' ),
		'footer_1' => __( 'Footer Quick Links', 'ilbs-alumni' ),
		'footer_2' => __( 'Footer Resources', 'ilbs-alumni' ),
		'footer_3' => __( 'Footer Community', 'ilbs-alumni' ),
	] );

	// Featured images
	add_theme_support( 'post-thumbnails' );

	// HTML5
	add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ] );

	// Title tag
	add_theme_support( 'title-tag' );

	// Custom logo
	add_theme_support( 'custom-logo', [
		'height'      => 80,
		'width'       => 200,
		'flex-height' => true,
		'flex-width'  => true,
	] );

	// Wide/full alignment
	add_theme_support( 'align-wide' );
}

/* ==========================================================
   3. CUSTOM POST TYPES
   ========================================================== */
add_action( 'init', 'ilbs_register_post_types' );
function ilbs_register_post_types() {

	$cpts = [
		'ilbs_member' => [
			'singular' => 'Member',
			'plural'   => 'Members',
			'menu_icon'=> 'dashicons-groups',
			'supports' => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
			'slug'     => 'members',
		],
		'ilbs_reunion' => [
			'singular' => 'Reunion',
			'plural'   => 'Reunions',
			'menu_icon'=> 'dashicons-heart',
			'supports' => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
			'slug'     => 'reunions',
		],
		'ilbs_award' => [
			'singular' => 'Award',
			'plural'   => 'Awards',
			'menu_icon'=> 'dashicons-awards',
			'supports' => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
			'slug'     => 'awards',
		],
		'ilbs_publication' => [
			'singular' => 'Publication',
			'plural'   => 'Publications',
			'menu_icon'=> 'dashicons-book-alt',
			'supports' => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
			'slug'     => 'publications',
		],
		
		'ilbs_news' => [
			'singular' => 'News',
			'plural'   => 'News',
			'menu_icon'=> 'dashicons-megaphone',
			'supports' => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
			'slug'     => 'news',
		],
		
	];

	foreach ( $cpts as $key => $args ) {
		$labels = [
			'name'               => $args['plural'],
			'singular_name'      => $args['singular'],
			'add_new'            => 'Add New',
			'add_new_item'       => 'Add New ' . $args['singular'],
			'edit_item'          => 'Edit ' . $args['singular'],
			'view_item'          => 'View ' . $args['singular'],
			'all_items'          => 'All ' . $args['plural'],
			'search_items'       => 'Search ' . $args['plural'],
			'not_found'          => 'No ' . strtolower( $args['plural'] ) . ' found.',
		];

		register_post_type( $key, [
			'labels'      => $labels,
			'public'      => true,
			'has_archive' => true,
			'show_in_rest'=> true,
			'menu_icon'   => $args['menu_icon'],
			'supports'    => $args['supports'],
			'rewrite'     => [ 'slug' => $args['slug'] ],
		] );
	}
}

/* ==========================================================
   4. TAXONOMIES
   ========================================================== */
add_action( 'init', 'ilbs_register_taxonomies' );
function ilbs_register_taxonomies() {

	// Batch (year of graduation) — shared
	register_taxonomy( 'ilbs_batch', [ 'ilbs_member', 'ilbs_reunion', 'ilbs_award' ], [
		'label'        => 'Batch',
		'hierarchical' => false,
		'rewrite'      => [ 'slug' => 'batch' ],
		'show_in_rest' => true,
	] );

	// Specialization
	register_taxonomy( 'ilbs_specialization', [ 'ilbs_member' ], [
		'label'        => 'Specialization',
		'hierarchical' => true,
		'rewrite'      => [ 'slug' => 'specialization' ],
		'show_in_rest' => true,
	] );

	// Location
	register_taxonomy( 'ilbs_location', [ 'ilbs_member' ], [
		'label'        => 'Location',
		'hierarchical' => false,
		'rewrite'      => [ 'slug' => 'location' ],
		'show_in_rest' => true,
	] );

	// Event type
	register_taxonomy( 'ilbs_event_type', ['ilbs_reunion', 'ilbs_lecture' ], [
		'label'        => 'Event Type',
		'hierarchical' => true,
		'rewrite'      => [ 'slug' => 'event-type' ],
		'show_in_rest' => true,
	] );

	// Publication type
	register_taxonomy( 'ilbs_pub_type', [ 'ilbs_publication' ], [
		'label'        => 'Publication Type',
		'hierarchical' => true,
		'rewrite'      => [ 'slug' => 'publication-type' ],
		'show_in_rest' => true,
	] );

	// Award category
	register_taxonomy( 'ilbs_award_cat', [ 'ilbs_award' ], [
		'label'        => 'Award Category',
		'hierarchical' => true,
		'rewrite'      => [ 'slug' => 'award-category' ],
		'show_in_rest' => true,
	] );

	// Gallery / Video category
	register_taxonomy( 'ilbs_media_cat', [ 'ilbs_gallery', 'ilbs_video' ], [
		'label'        => 'Media Category',
		'hierarchical' => true,
		'rewrite'      => [ 'slug' => 'media-category' ],
		'show_in_rest' => true,
	] );
}

/* ==========================================================
   5. ACF FIELD GROUPS (JSON sync path)
   ========================================================== */
add_filter( 'acf/settings/save_json', 'ilbs_acf_json_save' );
function ilbs_acf_json_save( $path ) {
	return get_stylesheet_directory() . '/acf-json';
}

add_filter( 'acf/settings/load_json', 'ilbs_acf_json_load' );
function ilbs_acf_json_load( $paths ) {
	$paths[] = get_stylesheet_directory() . '/acf-json';
	return $paths;
}

/* ==========================================================
   6. SEARCH FORM (accessible overlay input)
   ========================================================== */
add_filter( 'get_search_form', 'ilbs_custom_search_form' );
function ilbs_custom_search_form( $form ) {
	$form  = '<form role="search" method="get" class="search-form" action="' . esc_url( home_url( '/' ) ) . '">';
	$form .= '<label class="visually-hidden" for="siteSearch">' . esc_html__( 'Search for:', 'ilbs-alumni' ) . '</label>';
	$form .= '<input type="search" id="siteSearch" class="search-field search-input" placeholder="' . esc_attr__( 'Type to search…', 'ilbs-alumni' ) . '" value="' . esc_attr( get_search_query() ) . '" name="s" />';
	$form .= '</form>';
	return $form;
}

/* ==========================================================
   7. HELPER: RENDER HEADER PARTIAL
   ========================================================== */
function ilbs_get_header_html( $current_page = '' ) {
	$logo_url  = function_exists( 'get_custom_logo' ) && has_custom_logo()
		? wp_get_attachment_image_url( get_theme_mod( 'custom_logo' ), 'full' )
		: false;
	$home_url  = home_url( '/' );
	ob_start();
	include get_stylesheet_directory() . '/template-parts/header.php';
	return ob_get_clean();
}

/* ==========================================================
   8. HELPER: RENDER FOOTER PARTIAL
   ========================================================== */
function ilbs_get_footer_html() {
	ob_start();
	include get_stylesheet_directory() . '/template-parts/footer.php';
	return ob_get_clean();
}

/* ==========================================================
   9. AJAX: MEMBER DIRECTORY FILTER
   ========================================================== */
add_action( 'wp_ajax_ilbs_filter_members',        'ilbs_ajax_filter_members' );
add_action( 'wp_ajax_nopriv_ilbs_filter_members', 'ilbs_ajax_filter_members' );

function ilbs_ajax_filter_members() {
	check_ajax_referer( 'ilbs_nonce', 'nonce' );

	$search         = sanitize_text_field( $_POST['search'] ?? '' );
	$batch          = sanitize_text_field( $_POST['batch'] ?? '' );
	$specialization = sanitize_text_field( $_POST['specialization'] ?? '' );
	$location       = sanitize_text_field( $_POST['location'] ?? '' );

	$args = [
		'post_type'      => 'ilbs_member',
		'posts_per_page' => 20,
		's'              => $search,
		'tax_query'      => [ 'relation' => 'AND' ],
	];

	if ( $batch ) {
		$args['tax_query'][] = [ 'taxonomy' => 'ilbs_batch', 'field' => 'slug', 'terms' => $batch ];
	}
	if ( $specialization ) {
		$args['tax_query'][] = [ 'taxonomy' => 'ilbs_specialization', 'field' => 'slug', 'terms' => $specialization ];
	}
	if ( $location ) {
		$args['tax_query'][] = [ 'taxonomy' => 'ilbs_location', 'field' => 'slug', 'terms' => $location ];
	}

	$query = new WP_Query( $args );
	$html  = '';

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			ob_start();
			include get_stylesheet_directory() . '/template-parts/member-card.php';
			$html .= ob_get_clean();
		}
		wp_reset_postdata();
	} else {
		$html = '<p class="text-muted" style="grid-column:1/-1;">' . esc_html__( 'No members found matching your filters.', 'ilbs-alumni' ) . '</p>';
	}

	wp_send_json_success( [ 'html' => $html ] );
}

/* ==========================================================
   9. HELPERS — SEARCH
   ========================================================== */

/**
 * Post types included in site search results.
 */
function ilbs_get_search_post_types() {
	$types = [
		'post',
		'page',
		'ilbs_member',
		'ilbs_award',
		'ilbs_reunion',
		'ilbs_news',
		'ilbs_publication',
	];
	return apply_filters( 'ilbs_search_post_types', $types );
}

/**
 * Human label + icon for a searchable post type.
 *
 * @return array{label:string,icon:string}
 */
function ilbs_get_search_type_meta( $post_type ) {
	$map = [
		'post'             => [ 'label' => __( 'Blog', 'ilbs-alumni' ),             'icon' => 'bi-journal-text' ],
		'page'             => [ 'label' => __( 'Page', 'ilbs-alumni' ),             'icon' => 'bi-file-earmark-text' ],
		'ilbs_member'      => [ 'label' => __( 'Alumni Member', 'ilbs-alumni' ),    'icon' => 'bi-person-badge' ],
		'ilbs_award'       => [ 'label' => __( 'Award', 'ilbs-alumni' ),           'icon' => 'bi-trophy' ],
		'ilbs_reunion'     => [ 'label' => __( 'Reunion', 'ilbs-alumni' ),         'icon' => 'bi-calendar-event' ],
		'ilbs_news'        => [ 'label' => __( 'News', 'ilbs-alumni' ),            'icon' => 'bi-megaphone' ],
		'ilbs_publication' => [ 'label' => __( 'Publication', 'ilbs-alumni' ),     'icon' => 'bi-journal-medical' ],
	];
	return $map[ $post_type ] ?? [ 'label' => __( 'Result', 'ilbs-alumni' ), 'icon' => 'bi-search' ];
}

/* ==========================================================
   10. HELPERS — HOMEPAGE DATA (ACF + fallbacks)
   ========================================================== */

/**
 * Homepage stats — ACF stats_strip or placeholder defaults.
 */
function ilbs_get_home_stats() {
	if ( function_exists( 'have_rows' ) && have_rows( 'stats_strip' ) ) {
		$stats = [];
		while ( have_rows( 'stats_strip' ) ) {
			the_row();
			$stats[] = [
				'number' => get_sub_field( 'number' ),
				'label'  => get_sub_field( 'label' ),
				'icon'   => get_sub_field( 'icon' ) ?: 'bi-graph-up-arrow',
			];
		}
		return $stats;
	}
	return [
		[ 'number' => 1500, 'label' => __( 'Registered Alumni', 'ilbs-alumni' ),       'icon' => 'bi-people-fill' ],
		[ 'number' => 50,   'label' => __( 'Global Chapters', 'ilbs-alumni' ),         'icon' => 'bi-globe2' ],
		[ 'number' => 230,  'label' => __( 'Research Publications', 'ilbs-alumni' ),    'icon' => 'bi-journal-medical' ],
		[ 'number' => 16,   'label' => __( 'Active Programs', 'ilbs-alumni' ),         'icon' => 'bi-award-fill' ],
	];
}

/**
 * Gallery preview images from gallery page ACF repeater.
 */
function ilbs_get_gallery_preview_images( $limit = 8 ) {
	$images = [];
	$gallery_page = get_page_by_path( 'gallery' );
	if ( $gallery_page && function_exists( 'get_field' ) ) {
		$galleries = get_field( 'galleries', $gallery_page->ID );
		if ( $galleries && is_array( $galleries ) ) {
			foreach ( $galleries as $item ) {
				$photo = $item['photo'] ?? '';
				$url   = '';
				$alt   = $item['Name'] ?? ( $item['title'] ?? '' );
				if ( is_array( $photo ) ) {
					$url = $photo['url'] ?? '';
					$alt = $photo['alt'] ?? $alt;
				} elseif ( is_numeric( $photo ) ) {
					$url = wp_get_attachment_image_url( (int) $photo, 'large' );
				} else {
					$url = (string) $photo;
				}
				if ( $url ) {
					$images[] = [ 'url' => $url, 'alt' => $alt, 'link' => $item['gallery_link'] ?? get_permalink( $gallery_page ) ];
				}
				if ( count( $images ) >= $limit ) {
					break;
				}
			}
		}
	}
	return apply_filters( 'ilbs_gallery_preview_images', $images, $limit );
}

/**
 * Homepage resource cards — ACF repeater `home_resources` or defaults.
 */
function ilbs_get_home_resources() {
	if ( function_exists( 'have_rows' ) && have_rows( 'home_resources' ) ) {
		$items = [];
		while ( have_rows( 'home_resources' ) ) {
			the_row();
			$items[] = [
				'title' => get_sub_field( 'title' ),
				'desc'  => get_sub_field( 'description' ),
				'link'  => get_sub_field( 'link' ),
				'icon'  => get_sub_field( 'icon' ) ?: 'bi-folder2-open',
			];
		}
		return $items;
	}
	$gallery = get_page_by_path( 'gallery' );
	return [
		[ 'title' => __( 'Alumni Directory', 'ilbs-alumni' ),  'desc' => __( 'Search and connect with ILBS graduates worldwide.', 'ilbs-alumni' ), 'link' => get_post_type_archive_link( 'ilbs_member' ), 'icon' => 'bi-people' ],
		[ 'title' => __( 'Membership Forms', 'ilbs-alumni' ),  'desc' => __( 'Join the alumni network and update your profile.', 'ilbs-alumni' ),       'link' => get_post_type_archive_link( 'ilbs_member' ), 'icon' => 'bi-file-earmark-person' ],
		[ 'title' => __( 'Publications', 'ilbs-alumni' ),      'desc' => __( 'Research papers, newsletters and annual reports.', 'ilbs-alumni' ),        'link' => get_post_type_archive_link( 'ilbs_publication' ), 'icon' => 'bi-journal-text' ],
		[ 'title' => __( 'Photo Gallery', 'ilbs-alumni' ),     'desc' => __( 'Convocation ceremonies, reunions and campus memories.', 'ilbs-alumni' ),   'link' => $gallery ? get_permalink( $gallery ) : '#', 'icon' => 'bi-images' ],
	];
}

/**
 * Render a single award/publication card (archive + homepage).
 */
function ilbs_render_award_card( $post_id = 0 ) {
	$post_id = $post_id ?: get_the_ID();
	include get_stylesheet_directory() . '/template-parts/home-award-card.php';
}

/**
 * Resolve a display year for awards and publication CPT entries.
 */
function ilbs_get_award_item_year( $post_id ) {
	if ( function_exists( 'get_field' ) ) {
		foreach ( [ 'award_year', 'publication_year', 'year', 'published_year' ] as $field ) {
			$value = get_field( $field, $post_id );
			if ( $value ) {
				return preg_match( '/(20\d{2}|19\d{2})/', (string) $value, $m ) ? $m[1] : (string) $value;
			}
		}
	}
	$date = get_the_date( 'Y', $post_id );
	return $date ?: '';
}

/**
 * Whether an archive card should render as a publication experience.
 */
function ilbs_is_publication_item( $post_id ) {
	return 'ilbs_publication' === get_post_type( $post_id ) || ilbs_award_is_publication( $post_id );
}

/**
 * Combined award + publication query used by the premium year-filter interfaces.
 *
 * @return array<int, WP_Post>
 */
function ilbs_get_award_publication_items( $limit = -1 ) {
	$query = new WP_Query( [
		'post_type'      => [ 'ilbs_award', 'ilbs_publication' ],
		'posts_per_page' => $limit,
		'post_status'    => 'publish',
		'orderby'        => 'date',
		'order'          => 'DESC',
	] );
	$items = $query->posts;
	wp_reset_postdata();

	usort( $items, function ( $a, $b ) {
		return (int) ilbs_get_award_item_year( $b->ID ) <=> (int) ilbs_get_award_item_year( $a->ID );
	} );

	return $items;
}

/* ==========================================================
   11. HELPERS — VIDEO PAGE, AWARDS, CONTENT
   ========================================================== */

/**
 * Configurable video page ID for homepage slider.
 * Override via: add_filter( 'ilbs_video_page_id', fn() => 123 );
 */
function ilbs_get_video_page_id() {
	$page_id = 0;
	$video_page = get_page_by_path( 'video' );
	if ( $video_page ) {
		$page_id = (int) $video_page->ID;
	}
	return (int) apply_filters( 'ilbs_video_page_id', $page_id );
}

/**
 * Extract Vimeo ID and embed URL from a raw URL string.
 */
function ilbs_parse_vimeo_url( $url ) {
	if ( ! $url ) {
		return [ 'id' => '', 'embed' => '', 'thumb' => '' ];
	}
	$vimeo_id = '';
	if ( preg_match( '/player\.vimeo\.com\/video\/(\d+)/i', $url, $m ) ) {
		$vimeo_id = $m[1];
	} elseif ( preg_match( '/vimeo\.com\/(\d+)/i', $url, $m ) ) {
		$vimeo_id = $m[1];
	}
	$hash = '';
	if ( $vimeo_id && preg_match( '/[?&]h=([a-f0-9]+)/i', $url, $hm ) ) {
		$hash = '?h=' . $hm[1] . '&autoplay=1';
	}
	$embed = $vimeo_id ? 'https://player.vimeo.com/video/' . $vimeo_id . ( $hash ?: '?autoplay=1' ) : '';
	$thumb = $vimeo_id ? 'https://vumbnail.com/' . $vimeo_id . '.jpg' : '';
	return [ 'id' => $vimeo_id, 'embed' => $embed, 'thumb' => $thumb ];
}

/**
 * Extract YouTube ID and embed URL from a raw URL string.
 */
function ilbs_parse_youtube_url( $url ) {
	if ( ! $url ) {
		return [ 'id' => '', 'embed' => '', 'thumb' => '' ];
	}
	$yt_id = '';
	if ( preg_match( '/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/i', $url, $m ) ) {
		$yt_id = $m[1];
	}
	$embed = $yt_id ? 'https://www.youtube.com/embed/' . $yt_id . '?autoplay=1&rel=0' : '';
	$thumb = $yt_id ? 'https://img.youtube.com/vi/' . $yt_id . '/maxresdefault.jpg' : '';
	return [ 'id' => $yt_id, 'embed' => $embed, 'thumb' => $thumb ];
}

/**
 * Fetch videos from the configured video page (ACF repeater + content embeds).
 *
 * @return array<int, array{title:string,embed:string,thumb:string,duration:string,description:string,category:string}>
 */
function ilbs_get_videos_from_page( $page_id = 0 ) {
	if ( ! $page_id ) {
		$page_id = ilbs_get_video_page_id();
	}
	if ( ! $page_id ) {
		return [];
	}

	$videos = [];

	if ( function_exists( 'get_field' ) ) {
		$acf_videos = get_field( 'videos', $page_id );
		if ( $acf_videos && is_array( $acf_videos ) ) {
			foreach ( $acf_videos as $video ) {
				$title    = $video['title'] ?? '';
				$vimeo    = $video['vimeo_url'] ?? '';
				$youtube  = $video['youtube_url'] ?? ( $video['youtube'] ?? '' );
				$thumb    = $video['thumbnail'] ?? '';
				$duration = $video['duration'] ?? '';
				$desc     = $video['description'] ?? '';
				$category = $video['category'] ?? '';
				$embed    = '';

				if ( $vimeo ) {
					$parsed = ilbs_parse_vimeo_url( $vimeo );
					$embed  = $parsed['embed'];
					if ( ! $thumb ) {
						$thumb = $parsed['thumb'];
					}
				} elseif ( $youtube ) {
					$parsed = ilbs_parse_youtube_url( $youtube );
					$embed  = $parsed['embed'];
					if ( ! $thumb ) {
						$thumb = $parsed['thumb'];
					}
				}

				if ( $title || $embed ) {
					$videos[] = compact( 'title', 'embed', 'thumb', 'duration', 'desc', 'category' );
				}
			}
		}
	}

	$content = get_post_field( 'post_content', $page_id );
	if ( $content ) {
		if ( preg_match_all( '/<iframe[^>]+src=["\']([^"\']+)["\'][^>]*>/i', $content, $iframes ) ) {
			foreach ( $iframes[1] as $src ) {
				$parsed_yt = ilbs_parse_youtube_url( $src );
				$parsed_vm = ilbs_parse_vimeo_url( $src );
				$embed     = $parsed_yt['embed'] ?: $parsed_vm['embed'];
				$thumb     = $parsed_yt['thumb'] ?: $parsed_vm['thumb'];
				if ( $embed ) {
					$videos[] = [
						'title'       => '',
						'embed'       => $embed,
						'thumb'       => $thumb,
						'duration'    => '',
						'desc'        => '',
						'category'    => '',
					];
				}
			}
		}
		if ( preg_match_all( '#https?://(?:www\.)?(?:youtube\.com/watch\?v=|youtu\.be/)([a-zA-Z0-9_-]{11})#i', $content, $yt_links ) ) {
			foreach ( $yt_links[1] as $yt_id ) {
				$url   = 'https://www.youtube.com/watch?v=' . $yt_id;
				$parsed = ilbs_parse_youtube_url( $url );
				$videos[] = [
					'title'       => '',
					'embed'       => $parsed['embed'],
					'thumb'       => $parsed['thumb'],
					'duration'    => '',
					'desc'        => '',
					'category'    => '',
				];
			}
		}
	}

	return $videos;
}

/**
 * Distinct award years from ACF meta.
 */
function ilbs_get_award_years() {
	$years = [];
	foreach ( ilbs_get_award_publication_items() as $item ) {
		$year = ilbs_get_award_item_year( $item->ID );
		if ( $year ) {
			$years[] = (string) $year;
		}
	}
	$years = array_values( array_unique( array_filter( $years ) ) );
	rsort( $years, SORT_NUMERIC );
	return $years;
}

/**
 * Whether an award post is a publication (by taxonomy slug/name).
 */
function ilbs_award_is_publication( $post_id ) {
	$terms = wp_get_post_terms( $post_id, 'ilbs_award_cat' );
	if ( ! $terms || is_wp_error( $terms ) ) {
		return false;
	}
	foreach ( $terms as $term ) {
		if ( stripos( $term->slug, 'publication' ) !== false || stripos( $term->name, 'publication' ) !== false ) {
			return true;
		}
	}
	return false;
}

/**
 * Resolve recipient / author display name from ACF.
 */
function ilbs_get_award_recipient_name( $post_id ) {
	if ( ! function_exists( 'get_field' ) ) {
		return '';
	}
	$recipient = get_field( 'recipient_member', $post_id );
	if ( $recipient ) {
		if ( is_object( $recipient ) ) {
			return get_the_title( $recipient->ID );
		}
		if ( is_numeric( $recipient ) ) {
			return get_the_title( (int) $recipient );
		}
		return (string) $recipient;
	}
	$authors = get_field( 'authors', $post_id );
	if ( $authors ) {
		return is_array( $authors ) ? implode( ', ', $authors ) : (string) $authors;
	}
	$winners = get_field( 'winners', $post_id );
	if ( $winners && is_array( $winners ) && ! empty( $winners[0] ) ) {
		$w = $winners[0];
		return $w['student_name'] ?? $w['name'] ?? $w['recipient_name'] ?? '';
	}
	return '';
}

/**
 * Department / affiliation from ACF.
 */
function ilbs_get_award_department( $post_id ) {
	if ( ! function_exists( 'get_field' ) ) {
		return '';
	}
	$dept = get_field( 'department_name', $post_id ) ?: get_field( 'department', $post_id );
	if ( $dept ) {
		return (string) $dept;
	}
	$winners = get_field( 'winners', $post_id );
	if ( $winners && is_array( $winners ) && ! empty( $winners[0]['department'] ) ) {
		return (string) $winners[0]['department'];
	}
	return '';
}

/* ==========================================================
   10. FLUSH REWRITE RULES ON ACTIVATION
   ========================================================== */
add_action( 'after_switch_theme', 'ilbs_flush_rewrites' );
function ilbs_flush_rewrites() {
	ilbs_register_post_types();
	ilbs_register_taxonomies();
	flush_rewrite_rules();
}

/* ==========================================================
   10. REMOVE TWENTY TWENTY-ONE DEFAULT HEADER/FOOTER FROM OUTPUT
   ========================================================== */
add_action( 'init', 'ilbs_disable_parent_header_footer' );
function ilbs_disable_parent_header_footer() {
	remove_action( 'twentytwentyone_header', 'twentytwentyone_header_markup' );
}

/**
 * Disable standalone award detail pages; the archive is the primary experience.
 */
add_action( 'template_redirect', 'ilbs_redirect_single_awards_to_archive' );
function ilbs_redirect_single_awards_to_archive() {
	if ( ! is_singular( 'ilbs_award' ) ) {
		return;
	}

	$archive_url = get_post_type_archive_link( 'ilbs_award' );
	if ( ! $archive_url ) {
		$archive_url = home_url( '/' );
	}

	$year = ilbs_get_award_item_year( get_queried_object_id() );
	if ( $year ) {
		$archive_url = add_query_arg( 'award_year', $year, $archive_url );
	}

	wp_safe_redirect( $archive_url, 301 );
	exit;
}
