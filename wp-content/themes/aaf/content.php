<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'obc' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
    </header><!-- .entry-header -->

    <div class="entry-meta">
        <?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>

            <?php obc_posted_on(); ?>
            <span class="sep"> | </span>

            <?php
            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list( __( ', ', 'obc' ) );
            if ( $categories_list ) :
                ?>
                <span class="cat-links">
                    <?php printf( __( '%1$s', 'obc' ), $categories_list ); ?>
                </span>
            <?php endif; // End if categories ?>

            <?php if ( !post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
                <span class="sep"> | </span>
                <span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'obc' ), __( '1 Comment', 'obc' ), __( '% Comments', 'obc' ) ); ?></span>
            <?php endif; ?>

            <?php edit_post_link( __( 'Edit', 'obc' ), '<span class="sep"> | </span><span class="edit-link"> ', '</span>' ); ?>

        <?php endif; // End if 'post' == get_post_type() ?>
    </div><!-- .entry-meta -->

    <?php if ( is_search() ) : // Only display Excerpts for Search ?>
        <div class="entry-summary">
            <?php the_excerpt(); ?>
        </div><!-- .entry-summary -->
    <?php else : ?>
        <div class="entry-content">
            <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'obc' ) ); ?>
            <?php wp_link_pages( array('before' => '<div class="page-links">' . __( 'Pages:', 'obc' ), 'after' => '</div>') ); ?>
        </div><!-- .entry-content -->
    <?php endif; ?>

</article><!-- #post-<?php the_ID(); ?> -->
