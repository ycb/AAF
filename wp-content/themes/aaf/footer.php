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

<footer id="colophon" class="site-footer container" role="contentinfo">
        <div class="row">
            <div class="span12">
                <div class="span9"></div>
                <div class="span2 offset1"></div>

                <nav class="span3 pull-left"></nav>
                <nav class="span8 pull-right offset1"></nav>

                <div class="site-info span12">
                    <span class="pull-left span5">
                        <?php do_action( 'tp_credits' ); ?>
                    </span>

                    <span class="pull-right span5 offset1">&copy; 2008-<?php echo date( 'Y' ) ?> WordPress Consultant <a href="http://youtcustomblog.com">YourCustomBlog</a>.</span>

                    <?php echo AAF_get_option( 'footer_text', 'tp_settings' ); ?>
                </div><!-- .site-info -->
            </div>
        </div><!-- .row -->
</footer><!-- #colophon .site-footer -->
</div><!-- #page .hfeed .site -->

<?php wp_footer(); ?>

</body>
</html>
