<div id="acx_help_page">
<?php
$acx_si_smw_hide_advert = get_option('acx_si_smw_hide_advert');
if($acx_si_smw_hide_advert == "no")
{
?>
<div id="acx_fsmi_premium">
<a style="margin: 8px 0px 0px 10px; float: left; font-size: 16px; font-weight: bold;" href="http://clients.acurax.com/floating-socialmedia.php?utm_source=plugin&utm_medium=help&utm_campaign=widget_plugin" target="_blank">Fully Featured - Premium Acurax Social Media Widget</a>
<a style="margin: -14px 0px 0px 10px; float: left;" href="http://clients.acurax.com/floating-socialmedia.php?utm_source=plugin&utm_medium=help_yellow&utm_campaign=widget_plugin" target="_blank"><img src="<?php echo plugins_url('images/yellow.png', __FILE__);?>"></a>
</div> <!-- acx_fsmi_premium -->
<?php } ?>
<h2>Acurax Social Media Widget - Wordpress Plugin - Help/Support</h2>

<p>Thank you for using Acurax Social Media Widget Plugin For Your Wordpress Social Media Profile Linking Need.</p>

<h3><a href="http://wordpress.org/extend/plugins/acurax-social-media-widget/faq" target="_blank">Click here to open the FAQ and Help Page</a></h3>

<?php 
if($acx_si_smw_hide_advert == "no")
{
socialicons_widget_comparison(1);
}
?>

</div> <!-- acx_help_page -->