<?php
/**
 * Template Name: ILBS — Executive Committee
 * Template Post Type: page
 *
 * Maps to: pages/committee.html
 */
get_header();

// ACF Repeater: committee_members — fields: name, role, description, photo (image URL)
$members = function_exists('get_field') ? get_field('committee_members') : [];
?>

<section class="page-hero">
	<div class="container">
		<div class="ilbs-breadcrumb">
			<a href="<?php echo esc_url( home_url() ); ?>">Home</a> &rsaquo;
			<a href="<?php echo esc_url( get_permalink( get_page_by_path('about') ) ); ?>">About</a> &rsaquo;
			<?php the_title(); ?>
		</div>
		<span class="eyebrow text-warning">Governance</span>
		<h1>Executive Committee</h1>
		<p class="lead">Elected roles, responsibilities and alumni office coordination.</p>
	</div>
</section>

<section class="ilbs-section">
	<div class="container">
		<div class="directory-grid">
			<?php if ( $members && is_array( $members ) ) :
				foreach ( $members as $m ) : ?>
				<article class="member-card">
					<?php if ( ! empty( $m['photo'] ) ) : ?>
						<img src="<?php echo esc_url( $m['photo'] ); ?>"
							alt="<?php echo esc_attr( $m['name'] ); ?>"
							style="width:82px;height:82px;object-fit:cover;border-radius:8px;margin-bottom:16px;">
					<?php else : ?>
						<div class="avatar"><i class="bi bi-person-fill"></i></div>
					<?php endif; ?>
					<h3><?php echo esc_html( $m['name'] ?? '' ); ?></h3>
					<span><?php echo esc_html( $m['role'] ?? '' ); ?></span>
					<?php if ( ! empty( $m['description'] ) ) : ?>
						<p style="margin-top:8px;"><?php echo esc_html( $m['description'] ); ?></p>
					<?php endif; ?>
				</article>
				<?php endforeach;
			else :
				// Fallback static roles
				$roles = [
					[ 'role' => 'President',         'desc' => 'Alumni strategy, reunions and institutional coordination.' ],
					[ 'role' => 'Secretary',         'desc' => 'Operations, meeting records and member communications.' ],
					[ 'role' => 'Treasurer',         'desc' => 'Sponsorships, event budgets and annual reporting.' ],
					[ 'role' => 'Publication Lead',  'desc' => 'Newsletters, research archive and annual reports.' ],
					[ 'role' => 'Events Lead',       'desc' => 'Reunions, lectures, meetings and Foundation Day events.' ],
					[ 'role' => 'Membership Lead',   'desc' => 'Directory verification, onboarding and alumni support.' ],
				];
				foreach ( $roles as $r ) : ?>
				<article class="member-card">
					<div class="avatar"><i class="bi bi-person-fill"></i></div>
					<h3><?php echo esc_html( $r['role'] ); ?></h3>
					<p><?php echo esc_html( $r['desc'] ); ?></p>
				</article>
				<?php endforeach;
			endif; ?>
		</div>
	</div>
</section>

<?php get_footer(); ?>
