<?php 
/**********************************************/
$total_themes = ACX_SOCIALMEDIA_WIDGET_TOTAL_THEMES; // DEFINE NUMBER OF THEMES HERE
$total_themes = ($total_themes+1); // DO NOT EDIT THIS
/**********************************************/
if($_POST['acurax_social_widget_icon_hidden'] == 'Y') 
{	//Form data sent
	$acx_widget_si_theme = $_POST['acx_widget_si_theme'];
	update_option('acx_widget_si_theme', $acx_widget_si_theme);

	$acx_widget_si_twitter = $_POST['acx_widget_si_twitter'];
	update_option('acx_widget_si_twitter', $acx_widget_si_twitter);

	$acx_widget_si_facebook = $_POST['acx_widget_si_facebook'];
	update_option('acx_widget_si_facebook', $acx_widget_si_facebook);

	$acx_widget_si_youtube = $_POST['acx_widget_si_youtube'];
	update_option('acx_widget_si_youtube', $acx_widget_si_youtube);

	$acx_widget_si_linkedin = $_POST['acx_widget_si_linkedin'];
	update_option('acx_widget_si_linkedin', $acx_widget_si_linkedin);

	$acx_widget_si_gplus = $_POST['acx_widget_si_gplus'];
	update_option('acx_widget_si_gplus', $acx_widget_si_gplus);

	$acx_widget_si_credit = $_POST['acx_widget_si_credit'];
	update_option('acx_widget_si_credit', $acx_widget_si_credit);

	$acx_widget_si_icon_size = $_POST['acx_widget_si_icon_size'];
	update_option('acx_widget_si_icon_size', $acx_widget_si_icon_size);

	$acx_widget_si_pinterest = $_POST['acx_widget_si_pinterest'];
	update_option('acx_widget_si_pinterest', $acx_widget_si_pinterest);
	
	$acx_widget_si_feed = $_POST['acx_widget_si_feed'];
	update_option('acx_widget_si_feed', $acx_widget_si_feed);

	$social_widget_icon_array_order = get_option('social_widget_icon_array_order');
	$acx_si_smw_hide_advert = get_option('acx_si_smw_hide_advert');

		?>
		<div class="updated"><p><strong><?php _e('Acurax Social Icon Widget Settings Saved!.' ); ?></strong></p></div>
		<?php
}
	else
{	//Normal page display
$acx_widget_si_installed_date = get_option('acx_widget_si_installed_date');
if ($acx_widget_si_installed_date=="") { $acx_widget_si_installed_date = time();
update_option('acx_widget_si_installed_date', $acx_widget_si_installed_date);
}
	$acx_widget_si_theme = get_option('acx_widget_si_theme');
	$acx_widget_si_twitter = get_option('acx_widget_si_twitter');
	$acx_widget_si_facebook = get_option('acx_widget_si_facebook');
	$acx_widget_si_youtube = get_option('acx_widget_si_youtube');
	$acx_widget_si_linkedin = get_option('acx_widget_si_linkedin');
	$acx_widget_si_pinterest = get_option('acx_widget_si_pinterest');
	$acx_widget_si_feed = get_option('acx_widget_si_feed');
	$acx_widget_si_gplus = get_option('acx_widget_si_gplus');
	$acx_widget_si_credit = get_option('acx_widget_si_credit');
	$acx_widget_si_icon_size = get_option('acx_widget_si_icon_size');
	$social_widget_icon_array_order = get_option('social_widget_icon_array_order');
	$acx_si_smw_hide_advert = get_option('acx_si_smw_hide_advert');
	// Setting Defaults
	if ($acx_widget_si_credit == "") {	$acx_widget_si_credit = "no"; }
	if ($acx_widget_si_icon_size == "") { $acx_widget_si_icon_size = "32"; }
	if ($acx_widget_si_theme == "") { $acx_widget_si_theme = "1"; }
	if ($acx_si_smw_hide_advert == "") {	$acx_si_smw_hide_advert = "no"; }


	if ($social_widget_icon_array_order == "") 
	{
		$social_widget_icon_array_order = array(0,1,2,3,4,5,6);
		$social_widget_icon_array_order = serialize($social_widget_icon_array_order);
		update_option('social_widget_icon_array_order', $social_widget_icon_array_order);
		$acx_widget_si_current_version = "1.2";  // Current Version
		update_option('acx_widget_si_current_version', $acx_widget_si_current_version);
	} else 
	{
		// Counting and Adding New Keys (UPGRADE PURPOSE)
		$total_arrays = 7; // Number Of Services
		$social_widget_icon_array_order = get_option('social_widget_icon_array_order');
		$social_widget_icon_array_order = unserialize($social_widget_icon_array_order);
		$social_widget_icon_array_count = count($social_widget_icon_array_order); 
		if ($social_widget_icon_array_count < $total_arrays) 
		{
			for( $i = $social_widget_icon_array_count; $i < $total_arrays; $i++ )
			{
				array_push($social_widget_icon_array_order,$i);
			} // for
		} // Condition ($social_widget_icon_array_count != $total_arrays)
		
		$social_widget_icon_array_order = serialize($social_widget_icon_array_order);
		update_option('social_widget_icon_array_order', $social_widget_icon_array_order);
		$acx_si_smw_hide_advert = get_option('acx_si_smw_hide_advert');
		
		// Counting and Adding New Keys Ends Here
	} //Normal page display else
} //Main else

?>

	<!--  To Update Drag and Drop -->
	<script type="text/javascript">
	jQuery(document).ready(function()
	{
		jQuery(function() 
		{
			jQuery("#contentLeft ul").sortable(
			{ 
				opacity: 0.5, cursor: 'move', update: function() 
				{
					var order = jQuery(this).sortable("serialize") + '&action=updateRecordsListings'; 
					jQuery.post("<?php echo plugins_url( 'save_order.php' , (__FILE__) ); ?>", order, function(theResponse)
					{
						jQuery("#contentRight").html(theResponse);
					}); 															 
				}								  
			});
		});
	});	
	</script>
	
	
<div class="wrap">
<?php
$acx_si_smw_acx_service_banners = get_option('acx_si_smw_acx_service_banners');
if ($acx_si_smw_acx_service_banners != "no") { ?>
<p class="widefat" style="padding:8px;width:99%;height: 75px;">
<b>Acurax Services >> </b><br>
<a href="http://www.acurax.com/services/wordpress-designing-experts.php?utm_source=plugin-page&utm_medium=banner&utm_campaign=fsmi" target="_blank" id="wtd" style="background:url(<?php echo plugins_url('images/wtd.jpg', __FILE__);?>);"></a>

<a href="http://www.acurax.com/services/web-designing.php?utm_source=plugin-page&utm_medium=banner&utm_campaign=fsmi" target="_blank" id="wd" style="background:url(<?php echo plugins_url('images/wd.jpg', __FILE__);?>);"></a>
<a href="http://www.acurax.com/social-media-marketing-optimization/social-profile-design.php?utm_source=plugin-page&utm_medium=banner&utm_campaign=fsmi" target="_blank" id="spd" style="background:url(<?php echo plugins_url('images/spd.jpg', __FILE__);?>);"></a>
<a href="http://www.acurax.com/services/website-redesign.php?utm_source=plugin-page&utm_medium=banner&utm_campaign=fsmi" target="_blank" id="wrd" style="background:url(<?php echo plugins_url('images/wr.jpg', __FILE__);?>);"></a>
</p>
<?php } else { ?>
<p class="widefat" style="padding:8px;width:99%;">
<b>Acurax Services >> </b>
<a href="http://www.acurax.com/services/blog-design.php" target="_blank">Wordpress Theme Design</a> | 
<a href="http://www.acurax.com/services/web-designing.php" target="_blank">Website Design</a> | 
<a href="http://www.acurax.com/social-media-marketing-optimization/social-profile-design.php" target="_blank">Social Profile Design</a> | 
<a href="http://www.acurax.com/social-media-marketing-optimization/twitter-background-design.php" target="_blank">Twitter Background Design</a> | 
<a href="http://www.acurax.com/social-media-marketing-optimization/facebook-page-design.php" target="_blank">Facebook Page Design</a>
</p>
<?php } ?>
<?php if($acx_si_smw_hide_advert == "no")
{ ?>
<div id="acx_fsmi_premium">
<a style="margin: 8px 0px 0px 10px; float: left; font-size: 16px; font-weight: bold;" href="http://clients.acurax.com/floating-socialmedia.php?utm_source=plugin&utm_medium=highlight&utm_campaign=widget_plugin" target="_blank">Fully Featured - Premium Acurax Social Media Widget</a>
<a style="margin: -14px 0px 0px 10px; float: left;" href="http://clients.acurax.com/floating-socialmedia.php?utm_source=plugin&utm_medium=highlight_yellow&utm_campaign=widget_plugin" target="_blank"><img src="<?php echo plugins_url('images/yellow.png', __FILE__);?>"></a>
</div> <!-- acx_fsmi_premium -->
<?php } ?>
<?php echo "<h2>" . __( 'Acurax Social Icons Options', 'acx_widget_si_config' ) . "</h2>"; ?>

<form name="acurax_si_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input type="hidden" name="acurax_social_widget_icon_hidden" value="Y">



	<?php    echo "<h4>" . __( 'Select an icon style', 'acx_widget_si_config' ) . "</h4>"; ?>
		
	<p class="widefat" style="padding:8px;width:99%;">
		<?php	echo "Your Current Theme is <b>Theme" . $acx_widget_si_theme."</b>"; ?>
		<div class="image_div" style="margin-top:8px;">
			<img src="<?php echo plugins_url('images/themes/'.$acx_widget_si_theme.'/twitter.png', __FILE__);?>" style="height:<?php 
			echo $acx_widget_si_icon_size;?>px;">
			<img src="<?php echo plugins_url('images/themes/'.$acx_widget_si_theme.'/facebook.png', __FILE__);?>" style="height:
			<?php echo $acx_widget_si_icon_size;?>px;">
			<img src="<?php echo plugins_url('images/themes/'.$acx_widget_si_theme.'/googleplus.png', __FILE__);?>" style="height:
			<?php echo $acx_widget_si_icon_size;?>px;">
			<img src="<?php echo plugins_url('images/themes/'.$acx_widget_si_theme.'/pinterest.png', __FILE__);?>" style="height:
			<?php echo $acx_widget_si_icon_size;?>px;">
			<img src="<?php echo plugins_url('images/themes/'.$acx_widget_si_theme.'/youtube.png', __FILE__);?>" style="height:<?php
			echo $acx_widget_si_icon_size;?>px;">
			<img src="<?php echo plugins_url('images/themes/'.$acx_widget_si_theme.'/linkedin.png', __FILE__);?>" style="height:
			<?php echo $acx_widget_si_icon_size;?>px;">
			<img src="<?php echo plugins_url('images/themes/'.$acx_widget_si_theme.'/feed.png', __FILE__);?>" style="height:
			<?php echo $acx_widget_si_icon_size;?>px;">
		</div>
	</p>
	<?php
	$social_widget_icon_array_order = unserialize($social_widget_icon_array_order);
	// Starting The Theme List
	echo "<div id='acx_widget_si_theme_display' class='widefat'>";
	for ($i=1; $i < $total_themes; $i++)
	{ ?>
		<label class="acx_widget_si_single_theme_display <?php if ($acx_widget_si_theme == $i) { echo "selected"; } ?>" id="icon_selection">
		<div class="acx_widget_si_single_label">Theme <?php echo $i; ?><br><input type="radio" name="acx_widget_si_theme" value="<?php echo $i; ?>"<?php if ($acx_widget_si_theme == $i) { echo " checked"; } ?>></div>
		<div class="image_div">
			<?php
				foreach ($social_widget_icon_array_order as $key => $value)
				{
					if ($value == 0) 
					{
						echo "<img src=" . plugins_url('images/themes/'. $i .'/twitter.png', __FILE__) . ">"; 
					} 	else 

					if ($value == 1) 
					{
						echo "<img src=" . plugins_url('images/themes/'. $i .'/facebook.png', __FILE__) . ">"; 
					}	else 

					if ($value == 2) 
					{
						echo "<img src=" . plugins_url('images/themes/'. $i .'/googleplus.png', __FILE__) . ">"; 
					}	else
	 
					if ($value == 3) 
					{
						echo "<img src=" . plugins_url('images/themes/'. $i .'/pinterest.png', __FILE__) . ">"; 
					}	else

					if ($value == 4) 
					{
						echo "<img src=" . plugins_url('images/themes/'. $i .'/youtube.png', __FILE__) . ">"; 
					}	else 

					if ($value == 5) 
					{
						echo "<img src=" . plugins_url('images/themes/'. $i .'/linkedin.png', __FILE__) . ">"; 
					}
					
					if ($value == 6) 
					{
						echo "<img src=" . plugins_url('images/themes/'. $i .'/feed.png', __FILE__) . ">"; 
					}

				}
			?>			
		</div>
		</label>
	<?php
	}
	echo "</div> <!-- acx_widget_si_theme_display -->";
	// Ending The Theme List
	?>

	<p class="widefat" style="padding:8px;width:99%;margin-top:8px;">	<?php _e("Social Icon Size: " ); ?>
		<select name="acx_widget_si_icon_size">
			<option value="16"<?php if ($acx_widget_si_icon_size == "16") { echo 'selected="selected"'; } ?>>16px X 16px </option>
			<option value="25"<?php if ($acx_widget_si_icon_size == "25") { echo 'selected="selected"'; } ?>>25px X 25px </option>
			<option value="32"<?php if ($acx_widget_si_icon_size == "32") { echo 'selected="selected"'; } ?>>32px X 32px </option>
			<option value="40"<?php if ($acx_widget_si_icon_size == "40") { echo 'selected="selected"'; } ?>>40px X 40px </option>
			<option value="48"<?php if ($acx_widget_si_icon_size == "48") { echo 'selected="selected"'; } ?>>48px X 48px </option>
			<option value="55"<?php if ($acx_widget_si_icon_size == "55") { echo 'selected="selected"'; } ?>>55px X 55px </option>
		</select>
		<?php _e("Select a social icon size" ); ?>
	</p>

		<?php    echo "<h4>" . __( 'Social Media Icon Display Order - Drag and Drop to Reorder', 'acx_widget_si_config' ) . "</h4>"; ?>
	<div class="widefat" style="padding:8px;width:99%;margin-top:8px;">
		<div id="contentLeft">
			<ul>
			<?php

			foreach ($social_widget_icon_array_order as $key => $value)
			{
				?>
				<li id="recordsArray_<?php echo $value; ?>">
				<?php 

				if ($value == 0) 
				{
					echo "<img src=" . plugins_url('images/themes/'. $acx_widget_si_theme .'/twitter.png', __FILE__) . " 
					border='0'><br> Twitter"; 
				} 	else 



				if ($value == 1) 
				{
					echo "<img src=" . plugins_url('images/themes/'. $acx_widget_si_theme .'/facebook.png', __FILE__) . " 
					border='0'><br> Facebook"; 
				}	else 



				if ($value == 2) 
				{
					echo "<img src=" . plugins_url('images/themes/'. $acx_widget_si_theme .'/googleplus.png', __FILE__) . " 
					border='0'><br> Google Plus"; 
				}	else


				 
				if ($value == 3) 
				{
					echo "<img src=" . plugins_url('images/themes/'. $acx_widget_si_theme .'/pinterest.png', __FILE__) . " 
					border='0'><br> Pinterest"; 
				}	else



				if ($value == 4) 
				{
					echo "<img src=" . plugins_url('images/themes/'. $acx_widget_si_theme .'/youtube.png', __FILE__) . " 
					border='0'><br> Youtube"; 
				}	else 



				if ($value == 5) 
				{
					echo "<img src=" . plugins_url('images/themes/'. $acx_widget_si_theme .'/linkedin.png', __FILE__) . " 
					border='0'><br> Linkedin"; 
				}
				
				if ($value == 6) 
				{
					echo "<img src=" . plugins_url('images/themes/'. $acx_widget_si_theme .'/feed.png', __FILE__) . " 
					border='0'><br> Rss Feed"; 
				}

					?>
					</li>	<?php
			}	?>

			</ul>
		</div>
		<div id="contentRight"></div> <!-- contentRight -->
		<?php _e("Drag and Reorder Icons (It will automatically save on reorder)" ); ?>
	</div>

<hr />
		
	<?php    echo "<h4>" . __( 'Social Media Settings', 'acx_widget_si_config' ) . "</h4>"; ?>	
	
	<p class="widefat" style="padding:8px;width:99%;">
		<?php _e("Twitter Username: " ); ?>
			<input type="text" name="acx_widget_si_twitter" value="<?php echo $acx_widget_si_twitter; ?>" size="50">
		<?php _e("<b>Eg:</b> acuraxdotcom" ); ?>
	</p>

	<p class="widefat" style="padding:8px;width:99%;">
		<?php _e("Facebook Page/Profile URL: " ); ?>
			<input type="text" name="acx_widget_si_facebook" value="<?php echo $acx_widget_si_facebook; ?>" size="50">
		<?php _e("<b>Eg:</b> http://www.facebook.com/AcuraxInternational" ); ?>
	</p>

	<p class="widefat" style="padding:8px;width:99%;">
		<?php _e("Google Plus URL: " ); ?>
			<input type="text" name="acx_widget_si_gplus" value="<?php echo $acx_widget_si_gplus; ?>" size="50">
		<?php _e("Enter Your Complete Google Plus Url Starting With http://" ); ?>
	</p>

	<p class="widefat" style="padding:8px;width:99%;">
		<?php _e("Pinterest URL: " ); ?>
			<input type="text" name="acx_widget_si_pinterest" value="<?php echo $acx_widget_si_pinterest; ?>" size="50">
		<?php _e("Enter Your Complete Pinterest Url Starting With http://" ); ?>
	</p>

	<p class="widefat" style="padding:8px;width:99%;">
		<?php _e("Youtube URL: " ); ?>
			<input type="text" name="acx_widget_si_youtube" value="<?php echo $acx_widget_si_youtube; ?>" size="50">
		<?php _e("<b>Eg:</b> http://www.youtube.com/user/acuraxdotcom" ); ?>
	</p>

	<p class="widefat" style="padding:8px;width:99%;">
		<?php _e("Linkedin URL: " ); ?>
			<input type="text" name="acx_widget_si_linkedin" value="<?php echo $acx_widget_si_linkedin; ?>" size="50">
		<?php _e("<b>Eg:</b> http://www.linkedin.com/company/acurax-international" ); ?>
	</p>
	
	<p class="widefat" style="padding:8px;width:99%;">
		<?php _e("Feed URL: " ); ?>
			<input type="text" name="acx_widget_si_feed" value="<?php echo $acx_widget_si_feed; ?>" size="50">
		<?php _e("<b>Eg:</b> http://www.yourwebsite.com/feed" ); ?>
	</p>

	<p class="submit">
		<input type="submit" name="Submit" value="<?php _e('Update Acurax Social Icon', 'acx_widget_si_config' ) ?>" />
		<a name="updated">.</a>
	</p>

</form>


<?php if($_GET["status"] == "updated") { ?>
<div style="display: block; background-color: rgb(255, 255, 224); padding: 10px; border: 1px solid rgb(230, 219, 85); font-family: arial; font-size: 13px; font-weight: bold; text-align: center; border-radius: 10px 10px 10px 10px;">Acurax Social Media Widget Update Successfully Completed - Thank You</div>
<?php
$acx_widget_si_current_version = "1.2";  // Current Version
update_option('acx_widget_si_current_version', $acx_widget_si_current_version);
} ?>

<hr/>
<?php if($acx_si_smw_hide_advert == "no")
{ 
socialicons_widget_comparison(1); 
}
?> 

<br>
	<p class="widefat" style="padding:8px;width:99%;">
		Something Not Working Well? Have a Doubt? Have a Suggestion? - <a href="http://www.acurax.com/contact.php" target="_blank">Contact us now</a> | Need a Custom Designed Theme For your Blog or Website? Need a Custom Header Image? - <a href="http://www.acurax.com/contact.php" target="_blank">Contact us now</a>
	</p>
</div>