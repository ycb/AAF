<?php 
require( dirname( __FILE__ ) . '../../../../wp-config.php' );
$action = mysql_real_escape_string($_POST['action']); 
$social_widget_icon_array_order = $_POST['recordsArray'];
if (current_user_can('manage_options')) {
if ($action == "updateRecordsListings")
{
	$social_widget_icon_array_order = serialize($social_widget_icon_array_order);
	update_option('social_widget_icon_array_order', $social_widget_icon_array_order);
	echo "<div id='acurax_notice' align='center' style='width: 420px; font-family: arial; font-weight: normal; font-size: 22px;'>";
	echo "Social Media Icon's Order Saved";
	echo "</div><br>";
}
}
?>