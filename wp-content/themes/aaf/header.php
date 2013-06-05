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
</head>

<body <?php body_class(); ?>>
    <div class="container navbar-static-top utilitynav visible-desktop">
        <div class="span6 newsletter">Follow us as we grow&nbsp;&nbsp;<input type="text" id="appendedInputButton" class="span2" placeholder="ENTER YOUR EMAIL"><input type="submit" class="submit btn" name="submit" id="searchsubmit" value="GO"></div><div class="span3 donate"><a href="<?php bloginfo('url'); ?>/?page_id=23">Donate Now</a></div><div class="span3 news"><a href="<?php bloginfo('url'); ?>/?cat=13">Latest News</a></div>
    </div>
    <div id="page" class="hfeed site">
        <?php do_action( 'before' ); ?>
        <div id="phonenav" class="navbar hidden-desktop">
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
        </div>
        <header class="hidden-desktop">
            <div class="row-fluid">
                <div class="span12 socialbtns-container">
                    <ul class="socialbtns">
                        <li class="facebook"><a href="#"></a></li>
                        <li class="twitter"><a href="#"></a></li>
                        <li class="instagram"><a href="#"></a></li>
                    </ul>
                </div>
            </div>
        </header>

        <header id="masthead" class="site-header visible-desktop" role="banner">
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

        <div id="main" class="site-main">
            <div class="container content-wrap">
                <div class="row-fluid breadcrumbs-container">
                    <div class="span12"><?php if (function_exists('aaf_breadcrumbs')) aaf_breadcrumbs(); ?></div>
                </div>
                <div class="row-fluid">
