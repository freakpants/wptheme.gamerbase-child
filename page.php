<?php
get_header();

// settings for news
$showCategory = ( get_option('news-show-category') == 1 ? 1 : 0 );
$showDate = ( get_option('news-show-date') == 1 ? 1 : 0 );
$showComNum = ( get_option('news-show-count') == 1 ? 1 : 0 );
$showShare = ( get_option('news-show-share') == 1 ? 1 : 0 );


if( have_posts() ): 
	the_post(); // get post
    $postID = array( get_the_ID() ); // id in array for excluding post
?>

		<section id="news-header" class="header-bg">

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
			

                <a href="#" rel="next"> </a>
            </div>
			<!-- /TOP POST MENU -->


            <!-- RESPONSIVE.ELEMENTS -->
            <div class="sponsors-list">
                <div id="responsive-slider">
                    <?php
                        $allSponsors = new WP_Query(array(
                            'post_type' => 'pixie-sponsors',
                            'posts_per_page' => -1
                        ));
                        // while there is posts
                        while($allSponsors->have_posts()): $allSponsors->the_post();
                            $link = esc_url(get_post_meta( get_the_ID(), '_post_sponsor_link_key', true));
                            // if there is thumbnail
                            if( has_post_thumbnail() ):
                    ?>
                        <a href="<?php echo empty($link) ? '#' : esc_url($link) ; ?>" id="sponsor-<?php the_ID(); ?>" target="_blank" <?php post_class( 'item' ); ?> rel="external">
                            <img src="<?php the_post_thumbnail_url(); ?>" class="sponsor-img" alt="<?php echo sanitize_title(get_the_title()); ?>">
                        </a>
                    <?php
                            endif; // end check post thumbnail
                        endwhile;
                        wp_reset_postdata(); 
                    ?>
                </div>
            </div>
            <div class="container">
                <div class="header" <?php if( has_post_thumbnail() ): ?>style="background-image: url(<?php the_post_thumbnail_url( get_the_ID(), 'pixie-thumbnail-size'); ?>)" <?php endif; // end empty link check  ?>>


                </div><!-- /HEADER -->
            </div>
            <!-- /RESPONSIVE.ELEMENTS -->
            <div class="clearfix"></div>
        </section> <!-- /SECTION.NEWS-HEADER -->
		
        <section id="news-post">

          <div class="container">

            <div class="content">
				<h4>
                <?php
                    $cat = get_the_category(); // Get categories
                    $categories = ''; // Default = '';

                    if(!empty($cat)) {
                        foreach( $cat as $catItem ){

                            $categories .= '<a href="' . esc_url(get_category_link($catItem->term_id)) . '">' .esc_attr($catItem->name). '</a>, ';

                        }
                    } // if is not empty

                    // Show Categories && Trim separator
                    echo trim($categories, ', ');

                    if( $showDate ){ // if it is set up date to be displayed

                        if(!empty($categories)) {
                            echo ' / '; // Separator
                        } // if is not empty


                        // Show post date
                        the_date();
                    }
                ?>
				</h4>
                <div class="post-title">
                    <h1>
                        <?php the_title(); ?>
                    </h1>
                </div>

				<?php if( $showShare): // if is set up to be displayed ?>
                <div class="social-icons">
					<?php 
                    	// all listed share button
                    	$listShare = get_option('news-show-social');

                        if( !empty($listShare) ):
						    foreach( $listShare as $name => $showIcon ):
                    		    if( $showIcon == 1 ):
                    ?>
                    	<a href="<?php echo esc_url(pixie_share_links( $name, get_the_permalink(), get_the_title() )); ?>" target="_blank" class="social-btn <?php echo esc_attr($name); ?>"><i class="fa fa-<?php echo esc_attr($name); ?>"></i> <?php echo esc_attr(ucfirst( $name )); ?></a>
                    <?php   	
                                endif; 
                    	    endforeach; // foreach share button setted 
                        endif; // if is not empty
					?>
                </div>
				<?php endif; // endif show share ?>

                <div class="page-content">
                    <?php the_content(); ?>
                </div>


            </div><!-- /CONTENT -->

          </div><!-- /CONTAINER -->

        </section> <!-- /SECTION.NEWS-POST -->

<?php
endif; // end if post exists
?>

<?php
    if( esc_attr( get_option('show-donate') ) ) { // if donate is enabled
        get_template_part('donate');
    }

    get_footer();
?>
