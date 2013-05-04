<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package _bootstraps
 * @package _bootstraps - 2013 1.0
 */
?>
</div><!-- .row -->
</div><!-- .container -->
</div><!-- #main .site-main -->

<footer id="colophon" class="site-footer" role="contentinfo">
    <div class="container">
        <div class="row">
            <div class="span12">
                <div class="site-info">
                    <?php do_action( 'tp_credits' ); ?>

                    &copy; 2008-<?php echo date( 'Y' ) ?> <a href="http://darionovoa.info">Dario Novoa</a>. All rights are reserved.
                    Powered by <a href="http://wordpress.org/" target="_blank" title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', 'obc' ); ?>" rel="generator"><?php printf( __( '%s', 'obc' ), 'WordPress' ); ?></a>.

                    <?php echo obc_get_option( 'footer_text', 'tp_settings' ); ?>
                </div><!-- .site-info -->
            </div>
        </div><!-- .row -->
    </div><!-- .container -->
</footer><!-- #colophon .site-footer -->
</div><!-- #page .hfeed .site -->

<?php wp_footer(); ?>

</body>
</html>
