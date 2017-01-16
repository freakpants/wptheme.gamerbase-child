<?php get_header(); ?>

        
        <section id="header" class="topmenu header-bg">

            <?php 

            // Get Menu
            $locations = get_nav_menu_locations();
            $menuitems = [];
            if(isset($locations['header_menu'])) {
                $menu = wp_get_nav_menu_object( $locations['header_menu'] );
                if(!empty($menu)) {
                    $menuitems = wp_get_nav_menu_items( $menu->term_id, array( 'order' => 'DESC' ) );
                }
            }

            if(!empty($menuitems)):
            ?>

            <nav class="navbar navbar-default">
                <div class="container-fluid">
					
                    <div class="container">
                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div id="headnav">

                            <ul id="mainnav" class="nav main-nav navbar-nav navbar-right">
                                <?php 
                                    foreach($menuitems as $item): 
                                ?>
                                <li>
                                    <a href="<?php echo esc_url($item->url) ?>"><i class="fa fa-plus"></i> <?php echo esc_attr($item->title) ?></a>
                                </li>
                                <?php 
                                    endforeach; 
                                ?>
                            </ul>

                            <!-- SOCIAL # RESPON -->
                            <div class="social-icons">

                                <?php
                                        $socialIcons = get_option( 'social-option' );
                                        if(!empty($socialIcons)):
                                            foreach($socialIcons as $name => $link):
                                                if(!empty($link)):
                                    ?>
                                    <a href="<?php echo esc_url($link); ?>" rel="external" title="<?php echo esc_attr(ucfirst($name)); ?>">
                                        <i class="fa fa-<?php echo esc_attr($name); ?>"></i>
                                    </a>
                                <?php 
                                            endif; // end empty link check 
                                        endforeach;
                                    endif; // end empty icons check
                                ?>

                            </div>

                            <!-- /SOCIAL#RESPON --> 
                        </div>
                    </div> <!-- /CONTAINER -->

                </div><!-- /.container-fluid -->
            </nav>
            <?php 
                endif; // end check - menu items
            ?>
            <!-- RESPONSIVE.ELEMENTS -->
            <div class="home-page sponsors-list">
                <div id="responsive-slider">
                    <?php
                        $allSponsors = new WP_Query(array(
                            'post_type' => 'pixie-sponsors',
                            'posts_per_page' => -1
                        ));
                        // while there is posts
                        while($allSponsors->have_posts()): $allSponsors->the_post();
                            $link = get_post_meta( get_the_ID(), '_post_sponsor_link_key', true);
                            // if there is thumbnail
                            if( has_post_thumbnail() ):
                    ?>
                        <a href="<?php echo empty($link) ? '#' : esc_url($link) ; ?>" id="sponsor-<?php the_ID(); ?>" target="_blank" <?php post_class( 'item' ); ?> rel="external">
                            <img src="<?php esc_url(the_post_thumbnail_url()); ?>" class="sponsor-img" alt="<?php echo sanitize_title(get_the_title()); ?>">
                        </a>
                    <?php
                            endif; // end check post thumbnail
                        endwhile;
                        wp_reset_postdata(); 
                    ?>
                </div>
            </div>

            <!-- SLIDER -->
            <div class="container">
                <div class="slides">
                    <?php 
                        $allSlides = new WP_Query( array(
                                'post_type' => 'pixie-slides',
                                'posts_per_page' => -1
                            ) );

                        if( $allSlides->have_posts() ): // if there is slides
                    ?>
                    <div id="slider">
                        <?php
                            

                            while($allSlides->have_posts()): // get through all slides
                                $allSlides->the_post();

                                // get meta data 
                                $topLine = get_post_meta( get_the_ID(), '_post_slides_topline_key', true);
                                $midLine = get_post_meta( get_the_ID(), '_post_slides_midline_key', true);
                                $botLine = get_post_meta( get_the_ID(), '_post_slides_botline_key', true);

                                $showBtn = get_post_meta( get_the_ID(), '_post_slides_btnshow_key', true);
                                $showBtn = ( $showBtn == 1 );
                                $textBtn = get_post_meta( get_the_ID(), '_post_slides_btntext_key', true);
                                $linkBtn = get_post_meta( get_the_ID(), '_post_slides_btnlink_key', true);
                        ?>
                        <!-- SLIDE_ITEM -->
                        <article id="slide-<?php the_ID(); ?>" <?php post_class('item col-xs-12 col-md-10 col-lg-10 center-block'); ?> >
                            <?php 
                            if( !empty( $topLine ) ): 
                            ?>
                                <h3 class="anim1"><?php echo esc_attr($topLine); ?></h3>
                            <?php 
                            endif;  // end top line if

                            if( !empty($midLine) ): // if there is mid line
                            ?>
                                <h1 class="anim2"><?php echo esc_attr($midLine); ?></h1>
                            <?php
                            endif; // end mid line if
                            if( !empty($botLine) ):
                            ?>
                                <h2 class="indent-last anim3"><?php echo esc_attr($botLine); ?></h2>
                            <?php 
                            endif; // end if there is mid line
                            
                            if( $showBtn ): // if btn is shown
                            ?>
                                <a href="<?php echo empty($linkBtn) ? '#' : esc_url($linkBtn); ?>" target="_blank" class="btn btn-purple-wicon anim4">
                                    <?php echo esc_attr($textBtn); ?> <i class="fa fa-plus"></i>
                                </a>
                            <?php 
                            endif; // end of show btn
                            ?>
                        </article>
                        <!-- /SLIDE_ITEM -->
                        <?php
                            endwhile; // end list of slides
                        ?>
                        
                    </div><!-- /#SLIDER -->

                    <?php
                        endif; // end if there is posts
                    ?>


                </div><!-- /SLIDES -->
            </div>
            <!-- /SLIDER -->

            <?php
                if( get_option('upcoming-match-enable') ) { // if it's enabled
                    get_template_part('upcoming-match'); // Include section upcoming match
                }
            ?>
            <div class="clearfix"></div>

        </section><!-- /SECTION.HEADER -->

        <section id="news" class="<?php echo ( get_option('upcoming-match-enable') == 1 ? '' : 'no-um'); ?>">

            <div class="container">
                <?php
                    // settings for news
                    $showDate = ( get_option('news-show-date') == 1 ? 1 : 0 );
                    $showComNum = ( get_option('news-show-count') == 1 ? 1 : 0 );
                    $showShare = ( get_option('news-show-share') == 1 ? 1 : 0 );

                    // top two most recent posts
                    $topNews = new WP_Query( array(
                        'post_type' => 'post',
                        'posts_per_page' => 2,
                        'orderby' => 'date',
                        'order' => 'DESC'
                    ) );
                
                while( $topNews->have_posts() ): // while if have news posts
                    $topNews->the_post(); // sets up new post
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
                            // Sticky
                            if(is_sticky(get_the_ID())) {
                                echo '<span class="sticky_post"><i class="fa fa-thumb-tack" aria-hidden="true"></i>' . esc_html__('Sticky', 'pixiehype') . '</span>';
                            }
                            // Show category
                            $categories = get_the_category();
                            if ( ! empty( $categories ) ) {
                                if(is_sticky(get_the_ID())) {
                                    echo ' / ';
                                }
                                foreach ( $categories as $category ){
                                	echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" class="post-category">' . esc_html( $category->name ) . '</a>  ';
                                }
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

                        <a href="<?php the_permalink(); ?>" class="title-link"><h2><?php echo esc_attr( get_the_title() ); ?></h2></a>

                        <p class="excerpt"><?php 
						
                        echo esc_html( get_the_excerpt() ); ?></p>

                        <!-- RESPONSIVE_POST -->
                        <div class="footer header">

                            <?php
                            // Sticky
                            if(is_sticky(get_the_ID())) {
                                echo '<span class="sticky_post"><i class="fa fa-thumb-tack" aria-hidden="true"></i>' . esc_html__('Sticky', 'pixiehype') . '</span>';
                            }

                            // Show category
                            $categories = get_the_category();
                            if ( ! empty( $categories ) ) {
                                if(is_sticky(get_the_ID())) {
                                    echo ' / ';
                                }
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
            

                <div class="news-article list">
                    <?php 
                        // 3 posts after most recent two
                        $listPosts = new WP_Query(array(
                                'post_type' => 'post',
                                'posts_per_page' => 3,
                                'ignore_sticky_posts' => 1,
                                'offset' => 2,
                                'orderby' => 'date',
                                'order' => 'DESC'
                            ));
                        
                        while( $listPosts->have_posts() ): // whaile have list posts
                            $listPosts->the_post();
                    ?>
                    <article class="news-mini" style="background-image: url(<?php if( has_post_thumbnail() ) the_post_thumbnail_url( get_the_ID(), 'pixie-thumbnail-size'); // post thumbnail?>)">

                        <div class="boxInfo">
                            <div class="inner">
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

                                <a href="<?php the_permalink(); ?>" class="title-link"><h2><?php echo esc_attr( get_the_title() ); ?></h2></a>
                                
                                <p class="excerpt">
                                <?php 
                                echo esc_html( get_the_excerpt() );
                                ?>
                                </p>
                                
                                <!-- RESPONSIVE_POST -->
                                <div class="footer header">
                                    <?php
		                            // Show category
		                            $categories = get_the_category();
		                            if ( ! empty( $categories ) ) {
		                                echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '" class="post-category">' . esc_html( $categories[0]->name ) . '</a>';
		                            }
		                            ?>
                                    <?php if( $showDate ): // if date is set  ?>
		                                <span><?php echo esc_attr(get_the_date()); ?></span>
		                            <?php endif; // showdate if ?>
		                            <?php
		                            if( $showComNum ): // show comment number
		                                $comments = wp_count_comments( get_the_ID() );
		                            ?>
		                                <div class="comment"><?php echo esc_attr($comments->total_comments); ?></div>
		                            <?php endif; // if sow comment number ?>
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

                                            if(!empty($listShare)):
                                                foreach( $listShare as $name => $showIcon ):
                                                    if( $showIcon == 1 ):
                                        ?>
                                            <a target="_blank" href="<?php echo esc_url(pixie_share_links( $name, get_the_permalink(), get_the_title() )); ?>"><i class="fa fa-<?php echo esc_attr($name); ?>"></i></a>
                                        <?php
                                                    endif;
                                                endforeach; // foreach share button setted
                                            endif; // if is not empty
                                        ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div> <!-- NEWS.ITEM -->

                    </article> <!-- NEWS.LIST -->
                    <?php endwhile; // end of list posts ?>

                    <div class="clearfix"></div>
                </div><!-- /NEWS.LIST -->

            </div><!-- /CONTAINER -->

        </section><!-- /SECTION.NEWS -->

        <?php get_template_part('teams'); // Including Teams ?>


        <?php get_template_part('products'); // Including Products ?>
        
        
        <?php 
            if( esc_attr( get_option('show-about') ) ){ // if is set up to be displayed
                get_template_part('aboutus'); // Including About us
            }
        ?>

        <?php 
            if( esc_attr( get_option('show-donate') ) ){ // if donate is enabled
                get_template_part('donate'); // Including donate section
            }
        ?>
<?php get_footer(); ?>
			