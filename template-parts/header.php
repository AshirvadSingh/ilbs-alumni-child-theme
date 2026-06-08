<?php
/**
 * ILBS Alumni — Premium Header
 */
$home_url = home_url( '/' );
?>
<header class="ilbs-site-header site-header" role="banner">
	<nav class="navbar navbar-expand-xl container" aria-label="<?php esc_attr_e( 'Primary navigation', 'ilbs-alumni' ); ?>">

		<a class="navbar-brand" href="<?php echo esc_url( $home_url ); ?>">
			<?php if ( has_custom_logo() ) :
				the_custom_logo();
			else : ?>
				<span class="ilbs-brand-accent">ILBS</span> Alumni
			<?php endif; ?>
		</a>

		<div class="d-flex align-items-center gap-2 order-xl-3 ms-auto ms-xl-0">
			<button class="icon-btn" type="button" data-search-open aria-label="<?php esc_attr_e( 'Open search', 'ilbs-alumni' ); ?>">
				<i class="bi bi-search" aria-hidden="true"></i>
			</button>
			<a class="ilbs-btn ilbs-btn--primary ilbs-join-btn d-none d-md-inline-flex" href="<?php echo esc_url( get_post_type_archive_link( 'ilbs_member' ) ); ?>">
				<?php esc_html_e( 'Join Network', 'ilbs-alumni' ); ?>
			</a>
			<button class="ilbs-hamburger d-xl-none" type="button"
				aria-controls="ilbsMainNav"
				aria-expanded="false"
				aria-label="<?php esc_attr_e( 'Toggle navigation', 'ilbs-alumni' ); ?>">
				<span></span><span></span><span></span>
			</button>
		</div>

		<div class="collapse navbar-collapse order-xl-2" id="ilbsMainNav">
			<ul class="navbar-nav ms-xl-auto align-items-xl-center">

				<li class="nav-item">
					<a class="nav-link <?php echo is_front_page() ? 'active' : ''; ?>" href="<?php echo esc_url( $home_url ); ?>"><?php esc_html_e( 'Home', 'ilbs-alumni' ); ?></a>
				</li>

				<li class="nav-item">
					<?php $about_page = get_page_by_path( 'about' ); ?>
					<a class="nav-link <?php echo $about_page && is_page( $about_page->ID ) ? 'active' : ''; ?>" href="<?php echo esc_url( $about_page ? get_permalink( $about_page ) : $home_url ); ?>"><?php esc_html_e( 'About Us', 'ilbs-alumni' ); ?></a>
				</li>

				<li class="nav-item">
					<a class="nav-link" href="<?php echo esc_url( get_post_type_archive_link( 'ilbs_reunion' ) ); ?>"><?php esc_html_e( 'Reunions', 'ilbs-alumni' ); ?></a>
				</li>

				<li class="nav-item dropdown has-mega">
					<a class="nav-link dropdown-toggle" href="<?php echo esc_url( get_post_type_archive_link( 'ilbs_member' ) ); ?>" data-bs-toggle="dropdown"><?php esc_html_e( 'Members', 'ilbs-alumni' ); ?></a>
					<div class="dropdown-menu mega-menu">
						<a href="<?php echo esc_url( get_post_type_archive_link( 'ilbs_member' ) ); ?>"><?php esc_html_e( 'Alumni Directory', 'ilbs-alumni' ); ?></a>
						<a href="<?php echo esc_url( get_post_type_archive_link( 'ilbs_member' ) ); ?>"><?php esc_html_e( 'Search Alumni', 'ilbs-alumni' ); ?></a>
						<a href="<?php echo esc_url( get_post_type_archive_link( 'ilbs_member' ) ); ?>"><?php esc_html_e( 'Batch Filter', 'ilbs-alumni' ); ?></a>
					</div>
				</li>

				<li class="nav-item dropdown has-mega">
					<a class="nav-link dropdown-toggle" href="<?php echo esc_url( get_post_type_archive_link( 'ilbs_award' ) ); ?>" data-bs-toggle="dropdown"><?php esc_html_e( 'Awards', 'ilbs-alumni' ); ?></a>
					<div class="dropdown-menu mega-menu">
						<a href="<?php echo esc_url( get_post_type_archive_link( 'ilbs_award' ) ); ?>"><?php esc_html_e( 'Awards & Publications', 'ilbs-alumni' ); ?></a>
						<a href="<?php echo esc_url( get_post_type_archive_link( 'ilbs_publication' ) ); ?>"><?php esc_html_e( 'Publications', 'ilbs-alumni' ); ?></a>
						<a href="<?php echo esc_url( get_post_type_archive_link( 'ilbs_publication' ) ); ?>?type=research"><?php esc_html_e( 'Research Papers', 'ilbs-alumni' ); ?></a>
						<a href="<?php echo esc_url( get_post_type_archive_link( 'ilbs_publication' ) ); ?>?type=newsletter"><?php esc_html_e( 'Newsletters', 'ilbs-alumni' ); ?></a>
					</div>
				</li>

				<li class="nav-item dropdown has-mega">
					<?php $blog_page = get_page_by_path( 'blog' ); ?>
					<a class="nav-link dropdown-toggle" href="<?php echo esc_url( $blog_page ? get_permalink( $blog_page ) : get_post_type_archive_link( 'ilbs_news' ) ); ?>" data-bs-toggle="dropdown"><?php esc_html_e( 'Blog', 'ilbs-alumni' ); ?></a>
					<div class="dropdown-menu mega-menu">
						<?php if ( $blog_page ) : ?>
							<a href="<?php echo esc_url( get_permalink( $blog_page ) ); ?>"><?php esc_html_e( 'Blog Listing', 'ilbs-alumni' ); ?></a>
						<?php endif; ?>
						<a href="<?php echo esc_url( get_post_type_archive_link( 'ilbs_news' ) ); ?>"><?php esc_html_e( 'News & Announcements', 'ilbs-alumni' ); ?></a>
					</div>
				</li>

				<li class="nav-item dropdown has-mega">
					<?php
					$gallery_page = get_page_by_path( 'gallery' );
					$video_page   = get_page_by_path( 'video' );
					$lectures     = get_page_by_path( 'lectures' );
					?>
					<a class="nav-link dropdown-toggle" href="<?php echo esc_url( $gallery_page ? get_permalink( $gallery_page ) : '#' ); ?>" data-bs-toggle="dropdown"><?php esc_html_e( 'Media', 'ilbs-alumni' ); ?></a>
					<div class="dropdown-menu mega-menu">
						<?php if ( $gallery_page ) : ?>
							<a href="<?php echo esc_url( get_permalink( $gallery_page ) ); ?>"><?php esc_html_e( 'Photo Gallery', 'ilbs-alumni' ); ?></a>
						<?php endif; ?>
						<?php if ( $video_page ) : ?>
							<a href="<?php echo esc_url( get_permalink( $video_page ) ); ?>"><?php esc_html_e( 'Video Library', 'ilbs-alumni' ); ?></a>
						<?php endif; ?>
						<?php if ( $lectures ) : ?>
							<a href="<?php echo esc_url( get_permalink( $lectures ) ); ?>"><?php esc_html_e( 'Lecture Series', 'ilbs-alumni' ); ?></a>
						<?php endif; ?>
					</div>
				</li>

				<li class="nav-item">
					<?php $contact_page = get_page_by_path( 'contact' ); ?>
					<a class="nav-link <?php echo $contact_page && is_page( $contact_page->ID ) ? 'active' : ''; ?>" href="<?php echo esc_url( $contact_page ? get_permalink( $contact_page ) : $home_url ); ?>"><?php esc_html_e( 'Contact', 'ilbs-alumni' ); ?></a>
				</li>

				<li class="nav-item d-md-none mt-2">
					<a class="ilbs-btn ilbs-btn--primary w-100" href="<?php echo esc_url( get_post_type_archive_link( 'ilbs_member' ) ); ?>"><?php esc_html_e( 'Join Network', 'ilbs-alumni' ); ?></a>
				</li>

			</ul>
		</div>

	</nav>
</header>

<div class="search-overlay" data-search-overlay role="dialog" aria-label="<?php esc_attr_e( 'Site search', 'ilbs-alumni' ); ?>">
	<button class="icon-btn search-close" type="button" data-search-close aria-label="<?php esc_attr_e( 'Close search', 'ilbs-alumni' ); ?>">
		<i class="bi bi-x-lg" aria-hidden="true"></i>
	</button>
	<div class="container">
		<label class="ilbs-eyebrow" for="siteSearch" style="color:rgba(255,255,255,.55);"><?php esc_html_e( 'Search the portal', 'ilbs-alumni' ); ?></label>
		<?php get_search_form(); ?>
		<div class="quick-results">
			<a href="<?php echo esc_url( get_post_type_archive_link( 'ilbs_member' ) ); ?>"><?php esc_html_e( 'Alumni Directory', 'ilbs-alumni' ); ?></a>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'ilbs_reunion' ) ); ?>"><?php esc_html_e( 'Upcoming Reunions', 'ilbs-alumni' ); ?></a>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'ilbs_award' ) ); ?>"><?php esc_html_e( 'Awards', 'ilbs-alumni' ); ?></a>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'ilbs_publication' ) ); ?>"><?php esc_html_e( 'Publications', 'ilbs-alumni' ); ?></a>
		</div>
	</div>
</div>
