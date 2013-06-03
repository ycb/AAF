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
                  <p><?php 
                  	if( $post_meta_data['slide_url'][0] ) {
                  		$readmorelink = '<a href="'. $post_meta_data['slide_url'][0] .'">Read More...</a>';
                  	} else {
                  		$postpermalink = get_permalink( $post_meta_data['slide_post_list'][0] );
                  		$readmorelink = '<a href="'. $postpermalink .'">Read More...</a>';
                  	}
                  	echo wp_trim_words( $post_meta_data['slide_carousel_text'][0], $num_words = 22, $readmorelink );
                  	?>
                  </p>
                </div>
			</div>

		<?php
			endwhile;
		?>
		  </div>
		  <!-- Carousel nav -->
		  <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
		  <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
		</div>
		
		<header class="span7">
			<h1 class="sectiontitle">Latest Update</h1>
		</header>
		<?php 	//latest updates arguments
			$args = array(
				'category_name' => 'news-updates',
				'posts_per_page' => 1
			);
		
			// The Query
			$querylatestupdates = new WP_Query( $args );
		
			// The Loop
			while ( $querylatestupdates->have_posts() ) :
				$querylatestupdates->the_post();
				get_template_part( 'content', 'front-page' );
			endwhile;
		?>
		
		<header class="span7">
			<h1 class="sectiontitle">Upcoming Events</h1>
		</header>
		<?php 	//latest upcoming events arguments
			$argsupevents = array(
				'post_type' => 'events',
				'category_name' => 'featured',
				'posts_per_page' => 1
			);
		
			// The Query
			$queryupevents = new WP_Query( $argsupevents );
		
			// The Loop
			while ( $queryupevents->have_posts() ) :
				$queryupevents->the_post();
				get_template_part( 'content', 'front-page' );
			endwhile;
		?>
		
		<header class="span7">
			<h1 class="sectiontitle">ALIVE &amp; FREE INFOGRAPHIC</h1>
		</header>
		<?php 	//latest featured arguments
			$argsfeatured = array(
				'category_name' => 'featured',
				'posts_per_page' => 1
			);
		
			// The Query
			$queryfeatured = new WP_Query( $argsfeatured );
		
			// The Loop
			while ( $queryfeatured->have_posts() ) :
				$queryfeatured->the_post();
				get_template_part( 'content', 'front-page' );
			endwhile;
		?>

    </div><!-- #content .site-content -->
</div><!-- #primary .content-area -->

<div class="hidden-desktop sidebarmobile span4"><?php get_sidebar('mobile'); ?></div>
<div class="visible-desktop sidebardesktop span4"><?php get_sidebar('desktop'); ?></div>
<?php get_footer(); ?>