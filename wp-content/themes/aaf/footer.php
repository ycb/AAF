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
                <div class="span8">
                    <a href="https://maps.google.com/maps?f=q&source=embed&hl=en&geocode=&q=Omega+Boys+Club,+1060+Tennessee+Street,+San+Francisco,+CA&aq=0&oq=ome&sll=37.269174,-119.306607&sspn=12.3355,20.061035&ie=UTF8&hq=Omega+Boys+Club,+1060+Tennessee+Street,+San+Francisco,+CA&hnear=&radius=15000&ll=37.758517,-122.389434&spn=0.095815,0.130291&t=m&z=13&iwloc=A&cid=6160364427089974319"><img class="pull-left map" src="<?php bloginfo('stylesheet_directory'); ?>/images/map.png"></a>
                    <h3>Alive &amp; Free is located in San Francisco</h3> in the Dog Patch neighborhood<br /> near 22nd St, near one block above 3rd St. 
                    <br>1060 Tennessee st, San Francisco, CA 
                    <br>(415) 826-8674 (415) 826-8674
                </div>
            
            <span class="span4 pull-right noleftmargin">
                    <ul class="socialbtns">
                        <li class="facebook"><a href="#"></a></li>
                        <li class="twitter"><a href="#"></a></li>
                        <li class="instagram"><a href="#"></a></li>
                    </ul>
                    <?php get_search_form(); ?>
                </span>

                <nav class="span6 pull-right">

                    <?php wp_nav_menu( array('theme_location' => 'footer', 'container_id' => 'footer-navigation', 'container_class' => 'nav footer-menu') ); ?>

                </nav>

                <nav class="span4 pull-left">

                    <?php wp_nav_menu( array('theme_location' => 'sub-footer', 'link_after' => '<span class="sep"> |</span>', 'container_id' => 'sub-footer-navigation', 'container_class' => 'nav sub-footer-menu') ); ?>
                           
                </nav>

                <div class="site-info span12">

                    <span class="pull-left span5 copyright">&copy; <?php echo date( 'Y' ) ?> Omega Boys Club</span>
                    
                    <span class="pull-right span5 credits">WordPress Consultant: <a href="http://youtcustomblog.com">YourCustomBlog</a></span>

                    <?php echo AAF_get_option( 'footer_text', 'tp_settings' ); ?>
                </div><!-- .site-info -->
            </div>
        </div><!-- .row -->
</footer><!-- #colophon .site-footer -->
</div><!-- #page .hfeed .site -->

<?php wp_footer(); ?>

</body>
</html>
