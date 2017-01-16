<?php get_header(); ?>

	<section id="news-header" class="header-bg archive">

		<!-- RESPONSIVE.ELEMENTS -->
		<nav class="navbar navbar-default">
			<div class="container-fluid">

				<div class="container">
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div id="headnav">

						<div class="social-icons">
							<?php
							/* Gets all social links */
							$socialIcons = get_option( 'social-option' );
							if(!empty($socialIcons)):
								foreach($socialIcons as $name => $link):
									if( !empty($link) ):
										?>
										<a href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr(ucfirst($name)); ?>">
											<i class="fa fa-<?php echo esc_attr($name); ?>"></i>
										</a>
										<?php
									endif; // end if it is empty
								endforeach;
							endif; // end if icons is empty
							?>
						</div>

						<!-- /SOCIAL#RESPON -->
					</div><!-- /.navbar-collapse -->

				</div> <!-- /CONTAINER -->

			</div><!-- /.container-fluid -->
		</nav>
		<!-- /RESPONSIVE.ELEMENTS -->

		<!-- TOP POST MENU -->
		<div class="menu">
			<a href="<?php echo esc_url( home_url() ); ?>" rel="bookmark" class="active"><?php esc_html_e('Return to home', 'pixiehype') ?></a>
		</div>
		<!-- /TOP POST MENU -->
		<div class="clearfix"></div>

	</section> <!-- /SECTION.NEWS-HEADER -->

	<section id="news" class="archive">

		<div class="container">

			<h1 class="archive-sub"><?php esc_html_e( 'Categories for ', 'pixiehype' ); single_cat_title(); ?></h1>
			<?php
			// settings for news
			$showDate = ( get_option('news-show-date') == 1 ? 1 : 0 );
			$showComNum = ( get_option('news-show-count') == 1 ? 1 : 0 );
			$showShare = ( get_option('news-show-share') == 1 ? 1 : 0 );


			while ( have_posts() ) : the_post(); // while if have news posts
			?>
				<article <?php post_class( 'news-article', get_the_ID() ); ?> style="background-image: url(<?php the_post_thumbnail_url( get_the_ID(), 'pixie-thumbnail-size'); ?>);" >
					<div class="news-image">
						<?php if( has_post_thumbnail() ): ?>
							<img src="<?php esc_url(the_post_thumbnail_url( get_the_ID(), 'pixie-thumbnail-size' )); ?>" alt="<?php echo sanitize_title(get_the_title()); ?>">
						<?php endif; // end if check post thumbnail ?>
					</div>
					<div class="boxInfo">

						<div class="header">

							<?php

							// Show category
							$categories = get_the_category();
							if ( ! empty( $categories ) ) {
								echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '" class="post-category">' . esc_html( $categories[0]->name ) . '</a>';
							}
							?>

							<?php
							if( $showComNum ): // show comment number
								$comments = wp_count_comments( get_the_ID() );
								?>
								<div class="comment"><?php echo esc_attr($comments->total_comments); ?></div>
							<?php endif; // if sow comment number ?>

							<div class="clearfix"></div>
							<?php if( $showDate ): // if date is set  ?>
								<span><?php echo esc_attr(get_the_date()); ?></span>
							<?php endif; // showdate if ?>

						</div>

						<a href="<?php the_permalink(); ?>" class="title-link"><h2><?php echo esc_attr(short_title( 35, get_the_title() )); ?></h2></a>

						<p class="excerpt"><?php $trimexcerpt = get_the_excerpt();

							$shortexcerpt = wp_trim_words( $trimexcerpt, $num_words = 20, $more = '... ' );
							echo esc_html($shortexcerpt); ?></p>

						<!-- RESPONSIVE_POST -->
						<div class="footer header">

							<?php

							// Show category
							$categories = get_the_category();
							if ( ! empty( $categories ) ) {
								echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '" class="post-category">' . esc_html( $categories[0]->name ) . '</a>';
							}
							?>

							<?php
							if( $showComNum ): // show comment number
								$comments = wp_count_comments( get_the_ID() );
								?>
								<div class="comment"><?php echo esc_attr($comments->total_comments); ?></div>
							<?php endif; // if sow comment number ?>

							<div class="clearfix"></div>
							<?php if( $showDate ): // if date is set  ?>
								<span><?php echo esc_attr(get_the_date()); ?></span>
							<?php endif; // showdate if ?>

						</div>
						<!-- /RESPONSIVE_POST -->

						<div class="foot">
							<div class="pull-left">
								<a href="<?php the_permalink(); ?>" class="linear-effect"><?php esc_html_e('Read more', 'pixiehype'); ?></a>
							</div>

							<?php if( $showShare ): ?>
								<div class="social pull-right">
									<?php
									// all listed share button
									$listShare = get_option('news-show-social');


									if( !empty($listShare) ): // if is not empty
										foreach( $listShare as $name => $showIcon ):
											if( $showIcon == 1 ):
												?>
												<a href="<?php echo esc_url(pixie_share_links( $name, get_the_permalink(), get_the_title() )); ?>" target="_blank"><i class="fa fa-<?php echo esc_attr($name); ?>"></i></a>
											<?php       endif;
										endforeach; // foreach share button setted
									endif; // if is not empty
									?>
								</div>
							<?php endif; // end share ?>
						</div>
					</div>

					<div class="clearfix"></div>
				</article><!-- /NEWS.ITEM -->
			<?php endwhile; // end of posts ?>

			<?php get_template_part('pagination'); ?>
			<?php if ( have_posts() ) : ?>

				<!-- Add the pagination functions here. -->

				<div class="nav-previous alignleft"><?php next_posts_link( 'Older posts' ); ?></div>
				<div class="nav-next alignright"><?php previous_posts_link( 'Newer posts' ); ?></div>

			<?php endif; ?>
		</div><!-- /CONTAINER -->
		
	</section><!-- /SECTION.NEWS -->

<?php
if( esc_attr( get_option('show-donate') ) ) { // if donate is enabled
	get_template_part('donate');
}

get_footer();
?>

