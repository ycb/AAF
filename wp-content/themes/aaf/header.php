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
    <div id="page" class="hfeed site">
        <?php do_action( 'before' ); ?>
        <div id="phonenav" class="hidden-desktop">
            <div class="container">
                    <div class="row">
                        <div class="span12">
                            <nav role="navigation" class="site-navigation main-navigation clearfix">
                                <h1 class="assistive-text"><i class="icon-reorder"></i> <?php _e( 'Menu', 'AAF' ); ?></h1>
                                <div class="assistive-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'AAF' ); ?>"><?php _e( 'Skip to content', 'AAF' ); ?></a></div>

                                <?php wp_nav_menu( array('theme_location' => 'primary', 'container_id' => 'navigation', 'container_class' => 'site-main-menu', 'walker' => new AFF_Walker_Nav_Menu()) ); ?>
                            </nav><!-- .site-navigation .main-navigation -->
                        </div><!-- .span12 -->
                    </div><!-- .row -->
                </div><!-- .container -->
            </div> <!-- .menu-container -->
        </div>

        <header id="masthead" class="site-header" role="banner">
            <div class="container">
                <div class="row">
                    <div class="span12">
                        <hgroup>
                            
                            <h1 class="logo pull-left"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"></a></h1>
                            <h2 class="site-title"><?php// bloginfo( 'name' ); ?> <?php bloginfo( 'description' ); ?></h2>
                        </hgroup>
                    </div><!-- .span12 -->
                </div><!-- .row -->
            </div><!-- .container -->

            <div class="menu-container visible-desktop">
                <div class="container">
                    <div class="row">
                        <div class="span12">
                            <nav role="navigation" class="site-navigation main-navigation clearfix">
                                <h1 class="assistive-text"><i class="icon-reorder"></i> <?php _e( 'Menu', 'AAF' ); ?></h1>
                                <div class="assistive-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'AAF' ); ?>"><?php _e( 'Skip to content', 'AAF' ); ?></a></div>

                                <?php wp_nav_menu( array('theme_location' => 'primary', 'container_id' => 'navigation', 'container_class' => 'site-main-menu', 'walker' => new AFF_Walker_Nav_Menu()) ); ?>
                            </nav><!-- .site-navigation .main-navigation -->
                        </div><!-- .span12 -->
                    </div><!-- .row -->
                </div><!-- .container -->
            </div> <!-- .menu-container -->
        </header><!-- #masthead .site-header -->

        <div id="main" class="site-main">
            <div class="container content-wrap">
                <div class="row">
