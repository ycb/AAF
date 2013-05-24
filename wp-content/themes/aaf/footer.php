<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package AAF
 * @package AAF - 2013 1.0
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

                    &copy; 2008-<?php echo date( 'Y' ) ?> WordPress Consultant<a href="http://youtcustomblog.com">YourCustomBlog</a>. All rights are reserved.

                    <?php echo AAF_get_option( 'footer_text', 'tp_settings' ); ?>
                </div><!-- .site-info -->
            </div>
        </div><!-- .row -->
    </div><!-- .container -->
</footer><!-- #colophon .site-footer -->
</div><!-- #page .hfeed .site -->

<?php wp_footer(); ?>

</body>
</html>
