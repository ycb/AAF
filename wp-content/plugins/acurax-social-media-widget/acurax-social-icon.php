<?php
/* 
Plugin Name: Acurax Social Media Widget
Plugin URI: http://www.acurax.com/products/floating-social-media-icon-plugin-wordpress/
Description: A Simple Wordpress Plugin Which Allow You To Add Widget Which Links Social Media Icons to Your Social Media Profiles Twitter,Facebook,Pinterest,Youtube,Rss Feed,Linkedin,google plus. You can define icon style size for each widget.
Author: Acurax 
Version: 1.2
Author URI: http://www.acurax.com 
License: GPLv2 or later
*/

/*

Copyright 2008-current  Acurax International  ( website : www.acurax.com )

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/ 
define('ACX_SOCIALMEDIA_WIDGET_TOTAL_THEMES', 24);
?>
<?php
//*************** Include JS in Header ********
function enqueue_acx_social_widget_icon_script()
{
	wp_enqueue_script ( 'jquery' );
}	add_action( 'get_header', 'enqueue_acx_social_widget_icon_script' );
//*************** Include JS in Header Ends Here ********


//*********** Include Additional Menu ********************
function Acurax_Widget_Links($links, $file) {
	$plugin = plugin_basename(__FILE__);
	// create link
	if ($file == $plugin) {
	
		return array_merge( $links, array( 
			'<div id="plugin_page_links"><a href="http://www.acurax.com?utm_source=wp&utm_medium=link&utm_campaign=plugin-page" target="_blank">' . __('Acurax International') . '</a>',
			'<a href="https://twitter.com/#!/acuraxdotcom" target="_blank">' . __('Acurax on Twitter') . '</a>',
			'<a href="http://www.facebook.com/AcuraxInternational" target="_blank">' . __('Acurax on Facebook') . '</a>',
			'<a href="http://www.acurax.com/services/web-designing.php?utm_source=wp&utm_medium=link&utm_campaign=plugin-page" target="_blank">' . __('Wordpress Theme Design') . '</a>',
			'<a href="http://www.acurax.com/services/blog-design.php?utm_source=wp&utm_medium=link&utm_campaign=plugin-page" target="_blank">' . __('Wordpress Blog Design') . '</a>',
			'<a href="http://www.acurax.com/contact.php?utm_source=wp&utm_medium=link&utm_campaign=plugin-page" target="_blank" style="border:0px;">' . __('Contact Acurax') . '</a></div>' 
		));
	}
	return $links;
}	add_filter('plugin_row_meta', 'Acurax_Widget_Links', 10, 2 );
//*********************************************************

include('function.php');

//*************** Admin function ***************
function acx_social_widget_icon_admin() 
{
	include('social-icon.php');
}
function acx_social_widget_icon_help() 
{
	include('social-help.php');
}

function acx_social_widget_icon_premium() 
{
	include('premium.php');
}

function acx_social_widget_icon_misc() 
{
	include('smw-misc.php');
}

function acx_social_widget_icon_admin_actions()
{
	add_menu_page(  'Acx Social Media Widget Configuration', 'Acx Social Media Widget Settings', 8, 'Acurax-Social-Widget-Settings','acx_social_widget_icon_admin',plugin_dir_url( __FILE__ ).'/images/admin.ico' ); // 8 for admin
	
	add_submenu_page('Acurax-Social-Widget-Settings', 'Acurax Social Icon Premium', 'Premium', 8, 'Acurax-Social-Widget-Premium' ,'acx_social_widget_icon_premium');
	
	add_submenu_page('Acurax-Social-Widget-Settings', 'Acurax Social Icon Misc Settings', 'Misc', 8, 'Acurax-Social-Widget-Misc' ,'acx_social_widget_icon_misc');
	
	add_submenu_page('Acurax-Social-Widget-Settings', 'Acurax Social Widget Help and Support', 'Help', 8, 'Acurax-Social-Widget-Help' ,'acx_social_widget_icon_help');
}
	
if ( is_admin() )
{
	add_action('admin_menu', 'acx_social_widget_icon_admin_actions');
}
	
// Adding WUM Starts Here
function acurax_social_widget_icon_update( $plugin_data, $r )
{
	// Get Current Plugin Data () Starts Here
	function current_plugin_info($value) 
	{
		if ( ! function_exists( 'get_plugins' ) )
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		$plugin_folder = get_plugins( '/' . plugin_basename( dirname( __FILE__ ) ) );
		$plugin_file = basename( ( __FILE__ ) );
		return $plugin_folder[$plugin_file][$value];
	} // Get Current Plugin Data () Starts Here
	
	$curr_ver   = current_plugin_info('Version');
	define ( 'CURRENT_VERSION', $curr_ver );
	$folder = basename( dirname( __FILE__ ) );
	// readme contents
	$data = file_get_contents( 'http://plugins.trac.wordpress.org/browser/'.$folder.'/trunk/readme.txt?format=txt' );
	if ($data)
	{
		$matches = null;
		$regexp = '~==\s*Changelog\s*==\s*=\s*[0-9.]+\s*=(.*)(=\s*' . preg_quote ( CURRENT_VERSION ) . '\s*=|$)~Uis';
		if ( preg_match ( $regexp, $data, $matches) )
		{
			$changelog = (array) preg_split ( '~[\r\n]+~', trim ( $matches[1] ) );
			$ret = '<div style="color: #c00;font-size: small; margin-top:8px;margin-bottom:8px">The Floating Social Media Plugin has been updated. Here is a change list, so you can see what\'s been changed or fixed:</div>';
			$ret .= '<div style="font-weight: normal;">';
			$ret .= '<p style="margin: 5px 0; font-weight:bold; font-size:small">= Latest Version =</p>';
			$ul = false;
			$first = false;
			foreach ( $changelog as $index => $line )
			{
				if ( preg_match ( '~^\s*\*\s*~', $line) )
				{
					if ( !$ul )
					{
						$ret .= '<ul style="list-style: disc; margin-left: 20px;">';
						$ul = true;
						$first = true;
					}
					$line = preg_replace ( '~^\s*\*\s*~', '', $line );
					if ( $first )
					{
						$ret .= '<li style="list-style-type:none;margin-left: -1.5em; font-weight:bold">Release Date:' . $line . '</li>';
						$first = false;
					}
					else
					{
						$ret .= '<li>' . $line . '</li>';
					}
				}
				else
				{
					if ( $ul )
					{
						$ret .= '</ul><div style="clear: left;"></div>';
						$ul = false;
					}
					$ret .= '<p style="margin: 5px 0; font-weight:bold; font-size:small">' . $line . '</p>';
				}
			}
			if ( $ul )
			{
				$ret .= '</ul>';
			}
			$ret .= '</div>';
		}
	}
	echo $ret;	
}
/**
* Add update messages that can be attached to the CURRENT release (not
* this one), but only for 2.8+
*/
global $wp_version;
if ( version_compare('2.8', $wp_version, '<=') ) 
{
	global $pagenow;
	if ( 'plugins.php' === $pagenow )
	{
		// Better update message
		$file   = basename( __FILE__ );
		$folder = basename( dirname( __FILE__ ) );
		$acx_add = "in_plugin_update_message-{$folder}/{$file}";
		add_action( $acx_add, 'acurax_social_widget_icon_update', 20, 2 );
	}
}
// Adding WUM Ends Here
?>