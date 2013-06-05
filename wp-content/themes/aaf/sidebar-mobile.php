<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package AAF
 * @package AAF - 2013 1.0
 */
?>
<div id="secondary" class="sidebar" role="complementary">
    <div class="widget-area">

        <?php do_action( 'before_sidebar' ); ?>
        <?php if ( !dynamic_sidebar( 'mobile' ) ) : ?>

        <?php endif; // end sidebar widget area ?>
        <aside id="nav_menu-3" class="widget widget_nav_menu">
            <div class="menu-mobile-bottom-nav-container">
                <ul id="menu-mobile-bottom-nav" class="menu">
                    <li><a href="#">GET INVOLVED</a></li>
                    <li><a href="http://174.132.145.219/~omega25/wp/?page_id=23">DONATE NOW</a></li>
                    <li><a href="tel://-800-765-3437">CALL:  1-800-SOLDIER</a></li>
                    <li><a href="https://maps.google.com/maps?f=q&source=embed&hl=en&geocode=&q=Omega+Boys+Club,+1060+Tennessee+Street,+San+Francisco,+CA&aq=0&oq=ome&sll=37.269174,-119.306607&sspn=12.3355,20.061035&ie=UTF8&hq=Omega+Boys+Club,+1060+Tennessee+Street,+San+Francisco,+CA&hnear=&radius=15000&ll=37.758517,-122.389434&spn=0.095815,0.130291&t=m&z=13&iwloc=A&cid=6160364427089974319">GET DIRECTIONS</a><br /><small>OMEGA BOYS CLUB IS LOCATED AT <br />1060 TENNESSEE STREET, SAN FRANCISCO, CA 94107</small></li>
                </ul>
            </div>
        </aside>
    </div>
</div><!-- #secondary .widget-area -->