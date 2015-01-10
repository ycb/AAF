<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package AAF
 * @package AAF - 2013 1.0
 */
?>
<?php global $more; $more = 0; ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<aside class="front-thumb">
		<?php the_post_thumbnail('medium');  ?>
	</aside>
    <header class="entry-header">
        <h1 class="entry-title graybg"><?php the_title(); ?></h1>
    </header><!-- .entry-header -->

    <div class="entry-content">
        <?php 
        	$content = get_the_content('');
        	echo wp_trim_words( $content, $num_words = 55, '' ) . '<br><br><a href="' . get_permalink() . '"><span class="meta-nav btn pull-right">READ MORE</span></a>';
        ?>
        <div class="socialposticons visible-desktop">
            <span class='st_facebook_hcount' displayText='Facebook'></span>&nbsp;&nbsp;&nbsp;&nbsp;
            <span class='st_twitter_hcount' displayText='Tweet'></span>
        </div>
        <?php wp_link_pages( array('before' => '<div class="page-links">' . __( 'Pages:', 'AAF' ), 'after' => '</div>') ); ?>
        <?php edit_post_link( __( 'Edit', 'AAF' ), '<span class="edit-link">', '</span>' ); ?>
    </div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
