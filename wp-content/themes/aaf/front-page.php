<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package AAF
 * @package AAF - 2013 1.0
 */
get_header();
?>

<div id="primary" class="content-area span8">
    <div id="content" class="site-content" role="main">

        <?php while (have_posts()) : the_post(); ?>

            <?php get_template_part( 'content', 'front-page' ); ?>

        <?php endwhile; // end of the loop. ?>
		
		<div id="myCarousel" class="carousel slide">
		  <ol class="carousel-indicators">
			<?php
	    	//arguments
	    	$args = 'post_type=slide';

			// The Query
			$query = new WP_Query( $args );

			// The Loop
			while ( $query->have_posts() ) :
				$query->the_post();

			?>
		    <li data-target="#myCarousel" data-slide-to="1"></li>
		    <?php
		    endwhile;
		    ?>
		  </ol>
		  <!-- Carousel items -->
		  <div class="carousel-inner">
        <?php

			// The Loop
			while ( $query->have_posts() ) :
				$query->the_post();
				$post_meta_data = get_post_custom($query->post->ID);
		?>
			<div class="item <?php echo ($query->found_posts <= 1 ? 'active' : 'not') ?>">
				<?php 	
					$custom_image = $post_meta_data['slide_storyimage'][0];  
					echo wp_get_attachment_image($custom_image, 'full');  
				?>
				<div class="carousel-caption">
                  <h4><?php echo get_the_title( $query->post->ID ) ?></h4>
                  <p>This needs to be finished to print and trim the content here, and add the link to the post or URL Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                </div>
			</div>

		<?php
		print_r($post_meta_data);
			endwhile;
		?>
		  </div>
		  <!-- Carousel nav -->
		  <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
		  <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
		</div>

    </div><!-- #content .site-content -->
</div><!-- #primary .content-area -->

<div class="hidden-desktop sidebarmobile"><?php get_sidebar('mobile'); ?></div>
<div class="visible-desktop sidebardesktop"><?php get_sidebar('desktop'); ?></div>
<?php get_footer(); ?>