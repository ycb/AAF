<?php
/*
Plugin Name: Photo Gallery Pearlbells
Plugin URI: http://pearlbells.co.uk/
Description: Image Lightbox Display Pearlbells
Version:  1.0
Author:Pearlbells
Author URI: http://pearlbells.co.uk/contact.html
License: GPL2
*/
/*
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version. 

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details. 

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.

*/
$pearl_lightbox_class = new pearl_lightbox_class();
class pearl_lightbox_class
{
	function pearl_lightbox_css()
	{
		$myStyleUrl = WP_PLUGIN_URL . '/photo-gallery-pearlbells/css/pearl_lightbox_css.css';
        $myStyleFile = WP_PLUGIN_DIR . '/photo-gallery-pearlbells/css/pearl_lightbox_css.css';
        if ( file_exists($myStyleFile) ) 
		{
            wp_register_style('myStyleSheets', $myStyleUrl);
            wp_enqueue_style( 'myStyleSheets');
        }
	}
	
	function pearl_lightbox_script()
	{
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js');
		wp_enqueue_script( 'jquery' );?>
		<script type="text/javascript">
		var $jquery = jQuery.noConflict(); 
		$jquery(document).ready(function(){
		
		setLightboxStyle();	
			
		$jquery('.lightbox').click(function(e){
		e.preventDefault();
		$jquery('.backdrop').animate({'opacity':'.50'},300,'linear');
		$jquery('.box').animate({'opacity':'1.0'},300,'linear');
		$jquery('.backdrop,.box').css('display','block');
		var myimage = $jquery(this).attr('href');
		var mytitle = $jquery(this).attr('title');
		
		$jquery('.box').prepend('<p>'+'<img src="'+myimage+'"  /><br/>'+mytitle+'</p>');
		$jquery(this).removeClass('lightbox');
		$jquery(this).addClass('active');
		
		
	});
	$jquery('.closepanel').click(function(){
		$jquery('.backdrop,.box').fadeOut(1000);
		$jquery('.box p').remove();
		$jquery('#pearl_lighbox a').removeClass('active').addClass('lightbox');
		clearInterval(refreshInterval);
	});
	$jquery('.nextpanel').click(function(){
		NextImage();
	});
	
	$jquery('.playpanel').click(function(){			
		refreshInterval = setInterval("PlayImage()",2000);
	});
	
	$jquery('.prevpanel').click(function(){
		PrevImage();
	});
	$jquery('.stoppanel').click(function(){
		clearInterval(refreshInterval);
	});
	
	function PrevImage()
	{
		var curimage = $jquery('a.active');
		var nextimage = curimage.closest('.pearl_lightbox_active').prev().find('.lightbox');
		
		if(nextimage.length==0)
		{
			var nextimage = curimage.closest('.pearl_lightbox_active').prevAll(':has(.lightbox):first').find('.lightbox');
			if(nextimage.length==0)
			{
			nextimage =$jquery('#pearl_lightbox a:last');
			}
		}
		curimage.removeClass('active').addClass('lightbox');
		nextimage.addClass('active').removeClass('lightbox');
		var myimage = nextimage.attr('href');
		var mytitle = nextimage.attr('title');
		$jquery('.box p').remove();
		$jquery('.box').prepend('<p>'+'<img src="'+myimage+'" /><br/>'+mytitle+'</p>');
		
	}
	
	function NextImage()
	{
		
		var curimage = $jquery('a.active');
		var nextimage = curimage.closest('.pearl_lightbox_active').next().find('.lightbox');
		
		if(nextimage.length==0)
		{
			var nextimage = curimage.closest('.pearl_lightbox_active').nextAll(':has(.lightbox):first').find('.lightbox');
			if(nextimage.length==0)
			{
			  nextimage =$jquery('#pearl_lightbox a:first');
			}
		}
		curimage.removeClass('active').addClass('lightbox');
		nextimage.addClass('active').removeClass('lightbox');
		var myimage = nextimage.attr('href');
		var mytitle = nextimage.attr('title');
		$jquery('.box p').remove();
		$jquery('.box').prepend('<p>'+'<img src="'+myimage+'"  /><br/>'+mytitle+'</p>');
	}

		
		});
		function setLightboxStyle()
		{
			// Get options to set thumbnail style
			var pearl_thumbnail_height ='<?php echo get_option('pearl_thumbnail_height');?>';
	        var pearl_thumbnail_width ='<?php echo get_option('pearl_thumbnail_width');?>';
			var pearl_thumbnail_margin ='<?php echo get_option('pearl_thumbnail_margin');?>';
			var pearl_thumbnail_border_color ='<?php echo get_option('pearl_thumbnail_border_color');?>';
			var pearl_thumbnail_border_width ='<?php echo get_option('pearl_thumbnail_border_width');?>';
			var pearl_thumbnail_padding ='<?php echo get_option('pearl_thumbnail_padding');?>';
			var pearl_thumbnail_bg_color ='<?php echo get_option('pearl_thumbnail_bg_color');?>';
			
			// Get options to set popup box style
			var pearl_popupbox_height ='<?php echo get_option('pearl_popupbox_height');?>';
	        var pearl_popupbox_width ='<?php echo get_option('pearl_popupbox_width');?>';
			var pearl_popupbox_bg_color ='<?php echo get_option('pearl_popupbox_bg_color');?>';
			var pearl_popupbox_border_color ='<?php echo get_option('pearl_popupbox_border_color');?>';
			var pearl_popupbox_border_width ='<?php echo get_option('pearl_popupbox_border_width');?>';
			
		   $jquery('#pearl_lightbox .pearl_lightbox_active').css({
           "margin":pearl_thumbnail_margin,
		   "width":pearl_thumbnail_width,
		   "height":pearl_thumbnail_height,
		   "border-width":pearl_thumbnail_border_width,
		   "border-style":"solid",
		   "border-color": pearl_thumbnail_border_color,
		   "background-color": pearl_thumbnail_bg_color,
		   "padding": pearl_thumbnail_padding});
		   
		    $jquery('.box').css({
           "background-color":pearl_popupbox_bg_color,
		   "width":pearl_popupbox_width,
		   "height":pearl_popupbox_height,
		   "border-width":pearl_popupbox_border_width,
		   "border-style":"solid",
		   "border-color": pearl_popupbox_border_color
		   });
			
		}
		function PlayImage()
	   {
		var curimage = $jquery('a.active');
		var nextimage = curimage.closest('.pearl_lightbox_active').next().find('.lightbox');
		
		if(nextimage.length==0)
		{
			var nextimage = curimage.closest('.pearl_lightbox_active').nextAll(':has(.lightbox):first').find('.lightbox');
			if(nextimage.length==0)
			{
			  nextimage =$jquery('#pearl_lightbox a:first');
			}
		}
		curimage.removeClass('active').addClass('lightbox');
		nextimage.addClass('active').removeClass('lightbox');
		var myimage = nextimage.attr('href');
		var mytitle = nextimage.attr('title');
		$jquery('.box p').remove().fadeOut(1000);
		$jquery('.box').prepend('<p>'+'<img src="'+myimage+'" /><br/>'+mytitle+'</p>').fadeIn(1000);
	   }
		
		</script>
		<?php
		
	}
	
	function pearl_lightbox_getImage($atts, $content = null)
	{
		$images =& get_children( 'post_type=attachment&post_mime_type=image&post_parent=' . get_the_id() );
		$i=1;
		$display_image = '<div id="pearl_lightbox">';
		$counter = 0;
		$no_of_col = get_option('pearl_lightbox_no_of_col');
		$no_of_character = get_option('pearl_lightbox_no_of_character');
		
	    foreach( $images as $imageID => $imagePost )
			{   
			if($i==1)
			{
				$i=0;
				$display_image .= '<div class="pearl_lightbox_active">';
				$counter++;
			}
			else
			{
				$display_image .= '<div class="pearl_lightbox_active">';
				$counter++;
			}
				$display_image .= '<a href="'.wp_get_attachment_url($imageID).'" class="lightbox" title="'.get_the_title($imageID).'" ><img src="'.wp_get_attachment_thumb_url($imageID).'" border="none"/></a>';
				$display_image .= '<div class="pearl_lightbox_title">';
				$title = get_the_title($imageID);
				$title_length =	strlen(get_the_title($imageID));
				$display_image .= substr($title,0,$no_of_character);
				if($title_length>$no_of_character)
				{
					$display_image .= '. . .';
					
				}
				$display_image .= '</div>';
				$display_image .= '</div>';
				if ( $counter %$no_of_col  == 0 ) 
	            {	  
	
		         $display_image .= '<div class="pearl_clear"></div>';	
	   
	            }
				
			}
			$display_image .= '<div class="pearl_clear"></div>';	
		$display_image .= '</div>';
		
		$display_image .= '<div class="backdrop"></div>';
		$display_image .= '<div class="box"><a href="#" class="prevpanel btnstyle">Previous</a><a href="#" class="nextpanel btnstyle">Next</a><a href="#" class="closepanel btnstyle">Close</a><a href="#" class="playpanel btnstyle">Play</a><a href="#" class="stoppanel btnstyle">Stop</a></div>';
		
		
		return $display_image;		
	}
	
	function pearl_lightbox_install()
	{
		// Add options to set thumbnail style
		add_option('pearl_thumbnail_width','150px','','yes');
		add_option('pearl_thumbnail_height','178px','','yes');
		add_option('pearl_thumbnail_border_color','#999999','','yes');
		add_option('pearl_thumbnail_border_width','1px','','yes');
		add_option('pearl_thumbnail_padding','5px','','yes');
		add_option('pearl_thumbnail_margin','5px','','yes');
		add_option('pearl_thumbnail_bg_color','#ffffff','','yes');
		add_option('pearl_lightbox_no_of_character','24','','yes');
		
		// Add options to set popup window style
		add_option('pearl_popupbox_width','430px','','yes');
		add_option('pearl_popupbox_height','378px','','yes');
		add_option('pearl_popupbox_border_color','#999999','','yes');
		add_option('pearl_popupbox_border_width','2px','','yes');
		add_option('pearl_popupbox_bg_color','#eeeeee','','yes');
				
		add_option('pearl_lightbox_no_of_col','3','','yes');
	}
	function pearl_lightbox_uninstall()
	{
		delete_option('pearl_thumbnail_width');
		delete_option('pearl_thumbnail_height');
		delete_option('pearl_thumbnail_border_color');
		delete_option('pearl_thumbnail_border_width');
		delete_option('pearl_thumbnail_padding');
		delete_option('pearl_thumbnail_margin');
		delete_option('pearl_thumbnail_bg_color');
		delete_option('pearl_lightbox_no_of_character');
		
		delete_option('pearl_popupbox_width');
		delete_option('pearl_popupbox_height');
		delete_option('pearl_popupbox_border_color');
		delete_option('pearl_popupbox_border_width');
		delete_option('pearl_popupbox_bg_color');
				
		delete_option('pearl_lightbox_no_of_col');
	}
	
	function pearl_lightbox_menu()
	{
		add_options_page('Lightbox','Lightbox','manage_options',__FILE__,array('pearl_lightbox_class','pearl_lightbox_menu_page'));  
	}
	function pearl_lightbox_menu_page()
	{
		?>
        <div class="wrap">
           <h2>Display Settings</h2>
           <?php
		       if($_REQUEST['submit'])
			   {
				   pearl_lightbox_class::pearl_lightbox_update_option();
			   }
			       pearl_lightbox_class::pearl_lightbox_print_option();
		   ?>
        </div>
        <?php
	}
	
	function pearl_lightbox_update_option()
	{
		$ok = false;
		
		if($_REQUEST['pearl_lightbox_no_of_character'])
		{
			update_option('pearl_lightbox_no_of_character',$_REQUEST['pearl_lightbox_no_of_character']);
			$ok = true;
			
		}	
		if($_REQUEST['pearl_lightbox_no_of_col'])
		{
			update_option('pearl_lightbox_no_of_col',$_REQUEST['pearl_lightbox_no_of_col']);
			$ok = true;
			
		}	
		
		// Update Thumbnail Options
			
		if($_REQUEST['pearl_thumbnail_height'])
		{
			update_option('pearl_thumbnail_height',$_REQUEST['pearl_thumbnail_height']);
			$ok = true;
			
		}
		if($_REQUEST['pearl_thumbnail_width'])
		{
			update_option('pearl_thumbnail_width',$_REQUEST['pearl_thumbnail_width']);
			$ok = true;
			
		}
		if($_REQUEST['pearl_thumbnail_border_color'])
		{
			update_option('pearl_thumbnail_border_color',$_REQUEST['pearl_thumbnail_border_color']);
			$ok = true;
			
		}
		if($_REQUEST['pearl_thumbnail_border_width'])
		{
			update_option('pearl_thumbnail_border_width',$_REQUEST['pearl_thumbnail_border_width']);
			$ok = true;
			
		}
		if($_REQUEST['pearl_thumbnail_margin'])
		{
			update_option('pearl_thumbnail_margin',$_REQUEST['pearl_thumbnail_margin']);
			$ok = true;
			
		}
		if($_REQUEST['pearl_thumbnail_padding'])
		{
			update_option('pearl_thumbnail_padding',$_REQUEST['pearl_thumbnail_padding']);
			$ok = true;
			
		}
		if($_REQUEST['pearl_thumbnail_bg_color'])
		{
			update_option('pearl_thumbnail_bg_color',$_REQUEST['pearl_thumbnail_bg_color']);
			$ok = true;
			
		}	
		
		// Update Popup Box Options
			
		if($_REQUEST['pearl_popupbox_height'])
		{
			update_option('pearl_popupbox_height',$_REQUEST['pearl_popupbox_height']);
			$ok = true;
			
		}
		if($_REQUEST['pearl_popupbox_width'])
		{
			update_option('pearl_popupbox_width',$_REQUEST['pearl_popupbox_width']);
			$ok = true;
			
		}
		if($_REQUEST['pearl_popupbox_border_color'])
		{
			update_option('pearl_popupbox_border_color',$_REQUEST['pearl_popupbox_border_color']);
			$ok = true;
			
		}
		if($_REQUEST['pearl_popupbox_border_width'])
		{
			update_option('pearl_popupbox_border_width',$_REQUEST['pearl_popupbox_border_width']);
			$ok = true;
			
		}
		if($_REQUEST['pearl_popupbox_bg_color'])
		{
			update_option('pearl_popupbox_bg_color',$_REQUEST['pearl_popupbox_bg_color']);
			$ok = true;
			
		}
			
		
		if($ok)
		{?>
           <div id="message" class="updated fade">
           <p>Options Saved</p>
           </div>
        <?php
		}
		else
		{
			?>
           <div id="message" class="error fade">
           <p>Failed to save options</p>
           </div>
        <?php
		}
	}
	
	function pearl_lightbox_print_option()
	{
		include 'pearl_lightbox_admin.php';
	}
	
}
add_action('admin_menu',array($pearl_lightbox_class,'pearl_lightbox_menu'));
add_action('wp_print_styles', array($pearl_lightbox_class,'pearl_lightbox_css'));
add_action('wp_head', array($pearl_lightbox_class,'pearl_lightbox_script'));
add_shortcode('pearl_lightbox_display', array($pearl_lightbox_class,'pearl_lightbox_getImage'));
register_activation_hook(__FILE__,array($pearl_lightbox_class,'pearl_lightbox_install'));
register_deactivation_hook(__FILE__,array($pearl_lightbox_class,'pearl_lightbox_uninstall'));
?>