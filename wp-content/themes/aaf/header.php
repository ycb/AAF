<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package AAF
 * @package AAF - 2013 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'AAF' ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

<?php wp_head(); ?>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-21899380-1', 'auto');
  ga('send', 'pageview');

</script>


</head>

<body <?php body_class(); ?>>
    <div class="container navbar-static-top utilitynav visible-desktop">
        <div class="span6 newsletter">
            <form method="post" novalidate="" action="http://www.formstack.com/forms/index.php" class="fsForm fsFormFree fsSingleColumn fsMaxCol1" id="fsForm1497776">
                <input type="hidden" name="form" value="1497776">
                <input type="hidden" name="viewkey" value="APKw90qniK">
                <input type="hidden" name="hidden_fields" id="hidden_fields1497776" value="">
                <input type="hidden" name="fspublicsession" id="session_id1497776" value="">
                <input type="hidden" name="incomplete" id="incomplete1497776" value="">
                <input type="hidden" name="incomplete_email" id="incomplete_email1497776" value="">
                <input type="hidden" name="referrer" id="referrer1497776" value="">
                <input type="hidden" name="referrer_type" id="referrer_type1497776" value="link">
                <input type="hidden" name="_submit" value="1">
                <input type="hidden" name="style_version" value="3">
                Stay in Touch &nbsp;&nbsp;
                <input type="email" id="appendedInputButton" name="field20239471" required="required" class="span2" placeholder="ENTER YOUR EMAIL" title="Email">
                <input type="submit" class="submit btn fsSubmitButton" name="submit" id="searchsubmit" value="GO">
            </form>
        </div>
        <div class="span3 donate"><a href="<?php bloginfo('url'); ?>/?page_id=23">Donate</a></div><div class="span3 news"><a href="<?php bloginfo('url'); ?>/?cat=12">Latest News</a></div>
    </div>
    <div id="page" class="hfeed site">
        <?php do_action( 'before' ); ?>
        <div id="phonenav" class="navbar visible-phone">
          <div class="navbar-inner">
            <div class="container">
         
              <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
              <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </a>
         
              <!-- Be sure to leave the brand out there if you want it shown -->
              <a class="brand logo" href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"></a>
              <h2 class="site-title"><?php// bloginfo( 'name' ); ?> <?php bloginfo( 'description' ); ?></h2>

              <!-- Everything you want hidden at 940px or less, place within here -->
              <div class="nav-collapse collapse">
                <!-- .nav, .navbar-search, .navbar-form, etc -->
                <?php wp_nav_menu( array('theme_location' => 'primary', 'container_id' => 'navigation', 'container_class' => 'nav site-main-menu', 'walker' => new AFF_Walker_Nav_Menu()) ); ?>
              </div>
         
            </div>
          </div>
        </div><!--  end phone menu -->

        <header id="masthead" class="site-header hidden-phone" role="banner">
            <div class="container">
                <div class="row-fluid">
                    <div class="span12">
                        <hgroup>
                            
                            <h1 class="logo pull-left"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"></a></h1>
                            <h2 class="site-title"><?php// bloginfo( 'name' ); ?> <?php bloginfo( 'description' ); ?></h2>
                        </hgroup>
                    </div><!-- .span12 -->
                </div><!-- .row-fluid -->
            </div><!-- .container -->

            <div class="menu-container">
                <div class="container">
                    <div class="row-fluid">
                        <div class="span12 pull-right">
                            <nav role="navigation" class="site-navigation main-navigation clearfix">
                                <h1 class="assistive-text"><i class="icon-reorder"></i> <?php _e( 'Menu', 'AAF' ); ?></h1>
                                <div class="assistive-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'AAF' ); ?>"><?php _e( 'Skip to content', 'AAF' ); ?></a></div>

                                <?php wp_nav_menu( array('theme_location' => 'primary', 'container_id' => 'navigation', 'container_class' => 'site-main-menu corner-left corner-right', 'walker' => new AFF_Walker_Nav_Menu()) ); ?>
                            </nav><!-- .site-navigation .main-navigation -->
                        </div><!-- .span12 -->
                    </div><!-- .row-fluid -->
                </div><!-- .container -->
            </div> <!-- .menu-container -->
        </header><!-- #masthead .site-header -->

        <header class="visible-phone">
            <div class="row-fluid">
                <div class="span12 socialbtns-container">
                    <ul class="socialbtns">
                        <li class="facebook"><a target="_blank" href="http://www.facebook.com/pages/Richmond-Pulse/191090144262742"></a></li>
                        <li class="twitter"><a target="_blank" href="http://twitter.com/#!/richmondpulse"></a></li>
                        <li class="youtube"><a target="_blank" href="http://www.instagram.com/richmondpulse.com"></a></li>
                        <li class="flickr"><a target="_blank" href="http://vimeo.com/channels/183122/"></a></li>
                    </ul>
                </div>
            </div>
        </header>

        <div id="main" class="site-main">
            <div class="container content-wrap">
                <div class="row-fluid breadcrumbs-container visible-desktop">
                    <div class="span12"><?php if (function_exists('aaf_breadcrumbs')) aaf_breadcrumbs(); ?></div>
                </div>
                <div class="row-fluid">
