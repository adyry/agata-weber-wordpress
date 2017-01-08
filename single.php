<?php
get_header();
?>
<div class="content">
	<div class="container">
		<div class="post_content">
			<div class="archive_title">
				<div class="back-home"><a href="http://agataweber.pl/"><i class="fa fa-home fa-2x"></i></a></div>
				<h2><?php the_terms($post->ID, 'jetpack-portfolio-type'); ?></h2>
			</div>
			<?php while ( have_posts() ) : the_post(); ?>
				<article class="post_box" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<h1><?php the_title(); ?></h1>
					<?php the_content(); ?>
					<?php
					wp_link_pages(array(
						'before' => '<div class="link_pages">'.__('Pages', 'aweber'),
						'after' => '</div>',
						'link_before' => '<span>',
						'link_after' => '</span>'
					));
					?>
					<?php the_tags( '<div class="post_tags">'.__('Tags','aweber').': ', ', ', '</div>' ); ?>
					<div class="post-nav"><div class="nav-previous">
						<?php the_terms($post->ID, 'jetpack-portfolio-type', '←'); ?>
					</div></div>
				</article>
				<div class="clear"></div>
				<?php if ( comments_open() || '0' != get_comments_number() ) : ?>
					<div class="home_blog_box">
						<div class="comments_cont">
							<?php
							comments_template( '', true );
							?>
						</div>
					</div>
				<?php endif;
			endwhile;
			?>
		</div>
	</div>
</div>
<?php
get_footer();
?>
