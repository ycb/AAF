<?php 
if($_POST['acurax_social_widget_icon_hidden'] == 'Y') 
{	//Form data sent
$acx_si_smw_menu_highlight = $_POST['acx_si_smw_menu_highlight'];
update_option('acx_si_smw_menu_highlight', $acx_si_smw_menu_highlight);

$acx_si_smw_acx_service_banners = $_POST['acx_si_smw_acx_service_banners'];
update_option('acx_si_smw_acx_service_banners', $acx_si_smw_acx_service_banners);

$acx_si_smw_float_fix = $_POST['acx_si_smw_float_fix'];
update_option('acx_si_smw_float_fix', $acx_si_smw_float_fix);

$acx_si_smw_hide_advert = $_POST['acx_si_smw_hide_advert'];
update_option('acx_si_smw_hide_advert', $acx_si_smw_hide_advert);

?>
<div class="updated"><p><strong><?php _e('Acurax Widgets Misc Settings Saved!.' ); ?></strong></p></div>
<?php
}
else
{	//Normal page display
$acx_si_smw_menu_highlight = get_option('acx_si_smw_menu_highlight');
$acx_si_smw_acx_service_banners = get_option('acx_si_smw_acx_service_banners');
$acx_si_smw_float_fix = get_option('acx_si_smw_float_fix');
$acx_si_smw_hide_advert = get_option('acx_si_smw_hide_advert');

// Setting Defaults
if ($acx_si_smw_menu_highlight == "") {	$acx_si_smw_menu_highlight = "yes"; }
if ($acx_si_smw_acx_service_banners == "") {	$acx_si_smw_acx_service_banners = "yes"; }
if ($acx_si_smw_float_fix == "") {	$acx_si_smw_float_fix = "no"; }
if ($acx_si_smw_hide_advert == "") {	$acx_si_smw_hide_advert = "no"; }
} //Main else

?>
<div class="wrap">
<?php
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
<a style="margin: 8px 0px 0px 10px; float: left; font-size: 16px; font-weight: bold;" href="http://clients.acurax.com/floating-socialmedia.php?utm_source=plugin&utm_medium=highlight&utm_campaign=fsmi" target="_blank">Fully Featured - Premium Floating Social Media Icon</a>
<a style="margin: -14px 0px 0px 10px; float: left;" href="http://clients.acurax.com/floating-socialmedia.php?utm_source=plugin&utm_medium=highlight_yellow&utm_campaign=fsmi" target="_blank"><img src="<?php echo plugins_url('images/yellow.png', __FILE__);?>"></a>
</div> <!-- acx_fsmi_premium -->
<?php } ?>

<?php echo "<h2>" . __( 'Acurax Social Widget Misc Settings', 'acx_si_config' ) . "</h2>"; ?>

<form name="acurax_si_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
<input type="hidden" name="acurax_social_widget_icon_hidden" value="Y">

<p class="widefat" style="padding:8px;width:99%;margin-top:8px;">	<?php _e("Menu Highlight: " ); ?>
<select name="acx_si_smw_menu_highlight">
<option value="yes"<?php if ($acx_si_smw_menu_highlight == "yes") { echo 'selected="selected"'; } ?>>Yes, Highlight Plugin Menu </option>
<option value="no"<?php if ($acx_si_smw_menu_highlight == "no") { echo 'selected="selected"'; } ?>>No, Dont Highlight Plugin Menu </option>
</select>
<?php _e("Show Plugin Menu In Green" ); ?>
</p>


<p class="widefat" style="padding:8px;width:99%;margin-top:8px;">	<?php _e("Acurax Service Banners: " ); ?>
<select name="acx_si_smw_acx_service_banners">
<option value="yes"<?php if ($acx_si_smw_acx_service_banners == "yes") { echo 'selected="selected"'; } ?>>Yes, Show Them </option>
<option value="no"<?php if ($acx_si_smw_acx_service_banners == "no") { echo 'selected="selected"'; } ?>>No, Hide Them </option>
</select>
<?php _e("Show Acurax Service Banners On Plugin Settings Page?" ); ?>
</p>

<p class="widefat" style="padding:8px;width:99%;margin-top:8px;">	<?php _e("Hide Premium Version Adverts: " ); ?>
<select name="acx_si_smw_hide_advert">
<option value="yes"<?php if ($acx_si_smw_hide_advert == "yes") { echo 'selected="selected"'; } ?>>Yes </option>
<option value="no"<?php if ($acx_si_smw_hide_advert == "no") { echo 'selected="selected"'; } ?>>No </option>
</select>
<?php _e("Would you like to hide the feature comparison advertisement of basic and premium version from plugin settings pages?" ); ?>
</p>

<p class="widefat" style="padding:8px;width:99%;margin-top:8px;">	<?php _e("Social Media Widget Theme Conflict Fix: " ); ?>
<select name="acx_si_smw_float_fix">
<option value="yes"<?php if ($acx_si_smw_float_fix == "yes") { echo 'selected="selected"'; } ?>>Enable </option>
<option value="no"<?php if ($acx_si_smw_float_fix == "no") { echo 'selected="selected"'; } ?>>Disable </option>
</select>
<?php _e("If your widget/shortcode icons are in Vertical, then enable this to make it Horizontal" ); ?>
</p>


<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Update Acurax Social Icon', 'acx_si_config' ) ?>" />
</p>

</form>

<hr/>
<?php if($acx_si_smw_hide_advert == "no")
{ 
socialicons_widget_comparison(1); 
} ?> 

<br>
<p class="widefat" style="padding:8px;width:99%;">
Something Not Working Well? Have a Doubt? Have a Suggestion? - <a href="http://www.acurax.com/contact.php" target="_blank">Contact us now</a> | Need a Custom Designed Theme For your Blog or Website? Need a Custom Header Image? - <a href="http://www.acurax.com/contact.php" target="_blank">Contact us now</a>
</p>
</div>