<?php
if($_GET['td'] == 'hide') 
{
update_option('acx_widget_si_td', "hide");
?>
<style type='text/css'>
#acx_td
{
display:none;
}
</style>
<div class="error" style="background: none repeat scroll 0pt 0pt infobackground; border: 1px solid inactivecaption; padding: 5px;line-height:16px;">
Thanks again for using the plugin. we will never show the mesage again.
</div>
<?php
}
?>
<div id="acx_help_page">
<?php
socialicons_widget_comparison(1);
?>
<div align="center"><img style="border:1px solid gray;box-shadow:1px 1px 20px -9px black;border-radius: 8px 8px 8px 8px;" src="<?php echo plugins_url('images/money_back.jpg', __FILE__); ?>"></div>
</div>