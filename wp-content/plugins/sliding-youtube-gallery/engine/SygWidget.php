<?php
/**
 * @name SygWidget
 * @category Sliding Youtube Gallery widget
 * @since 1.4.4
 * @author: Luca Martini @ webEng
 * @license: GNU GPLv3 - http://www.gnu.org/copyleft/gpl.html
 * @version: 1.4.4
 */
class SygWidget extends WP_Widget{
	function SygWidget() {  
        $widget_ops = array( 'classname' => 'SygWidget', 'description' => __('Widget does not work yet, it will be available in the next version', 'syg-widget') );  
        $control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'syg-widget' );  
        $this->WP_Widget( 'example-widget', __('Sliding Youtube Gallery', 'syg-widget'), $widget_ops, $control_ops );  
    }  
	
	public function widget( $args, $instance ) {
		// outputs the content of the widget
	}
	
	public function form( $instance ) {
		// outputs the options form on admin
	}
	
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
	}
}
?>