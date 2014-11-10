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
        <div class="ad span12">
            <img src="http://fakeimg.pl/350x200/00CED1/FFF/?text=large+ad">
        </div>
        <div class="span12">    
            <div class="span8 map visible-desktop">
                <!-- <a href="https://maps.google.com/maps?f=q&source=embed&hl=en&geocode=&q=Omega+Boys+Club,+1060+Tennessee+Street,+San+Francisco,+CA&aq=0&oq=ome&sll=37.269174,-119.306607&sspn=12.3355,20.061035&ie=UTF8&hq=Omega+Boys+Club,+1060+Tennessee+Street,+San+Francisco,+CA&hnear=&radius=15000&ll=37.758517,-122.389434&spn=0.095815,0.130291&t=m&z=13&iwloc=A&cid=6160364427089974319"><img class="pull-left map" src="<?php bloginfo('stylesheet_directory'); ?>/images/map.png"></a>
                <h3>Alive &amp; Free is located in San Francisco</h3> in the Dog Patch neighborhood<br /> @ 22nd St, one block above 3rd St. 
                <br>1060 Tennessee St, San Francisco, CA 94107
                <br>p: (415) 826-8664 f: (415) 826-8673 -->
            </div>
        
            <span class="span4 social-search pull-right noleftmargin hidden-phone">
                <!-- <ul class="socialbtns">
                    <li class="facebook"><a target="_blank" href="http://www.facebook.com/StayAliveAndFree"></a></li>
                    <li class="twitter"><a target="_blank" href="http://twitter.com/1800soldier"></a></li>
                    <li class="youtube"><a target="_blank" href="http://www.youtube.com/user/streetsoldiersradio"></a></li>
                    <li class="flickr"><a target="_blank" href="http://www.flickr.com/photos/92986769@N02/"></a></li>
                </ul> -->
                <div class="visible-desktop">
                    <?php get_search_form(); ?>
                </div>
            </span>

            <nav class="span6 pull-right footer-menu-container">

                <?php wp_nav_menu( array('theme_location' => 'footer', 'container_id' => 'footer-navigation', 'container_class' => 'nav footer-menu') ); ?>

            </nav>

            <nav class="span4 pull-left visible-desktop">

                <?php wp_nav_menu( array('theme_location' => 'sub-footer', 'link_after' => '<span class="sep"> |</span>', 'container_id' => 'sub-footer-navigation', 'container_class' => 'nav sub-footer-menu') ); ?>
                       
            </nav>

            <div class="site-info span12">

                <span class="pull-left span5 copyright">&copy; <?php echo date( 'Y' ) ?> Richmond Pulse</span>
                
                <span class="pull-right span5 credits">WordPress Consultant: <a href="http://youtcustomblog.com">YourCustomBlog</a></span>

                <?php echo AAF_get_option( 'footer_text', 'tp_settings' ); ?>
            </div><!-- .site-info -->
        </div>
    </div><!-- .row -->
</footer><!-- #colophon .site-footer -->
</div><!-- #page .hfeed .site -->

<?php wp_footer(); ?>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-41573530-1', '174.132.145.219');
  ga('send', 'pageview');
</script>

</body>
</html>