<?php
/*
Plugin Name: AAF Impact Widget
Plugin URI: http://darionovoa.info
Description: AAF Impact information
Version: 1.0
Author: Dario Novoa
Author URI: http://darionovoa.info
Author Email: darionovoa@ideartte.com
Network: false
*/

/**
 * Adds AAF_Impact widget.
 */
class AAF_Impact extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
	 		'aaf_impact', // Base ID
			'AAF_Impact', // Name
			array( 
				'description' => __( 'Our Impact Stats', 'aaf' ),
				'classname'		=>	'widget-name-class' 
			) // Args
		);
	}
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$fact1 = apply_filters( 'the_content', $instance['fact1'] );
		$fact2 = apply_filters( 'the_content', $instance['fact2'] );
		$fact3 = apply_filters( 'the_content', $instance['fact3'] );
		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
		?>		 
		<div class="tab-content">
		  <div class="tab-pane active" id="fact1"><?php echo "fact1"; ?></div>
		  <div class="tab-pane" id="fact2"><?php echo "fact2"; ?></div>
		  <div class="tab-pane" id="fact3"><?php echo "fact3"; ?></div>
		</div>

		<ul class="nav nav-tabs" id="afffacts">
		  <li class="active"><a href="#fact1">&nbsp;</a></li>
		  <li><a href="#fact2">&nbsp;</a></li>
		  <li><a href="#fact3">&nbsp;</a></li>
		</ul>
		 
		<script>
		  jQuery(function () {
		    //activate one
		    jQuery('#afffacts a:last').tab('show');
		    //bind the rest.
		    jQuery('#afffacts a').click(function (e) {
			  e.preventDefault();
			  jQuery(this).tab('show');
			})
		  })
		</script>
		<?php
		echo $after_widget;
	}
	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['fact1'] = strip_tags( $new_instance['fact1'] );
		$instance['fact2'] = strip_tags( $new_instance['fact2'] );
		$instance['fact3'] = strip_tags( $new_instance['fact3'] );
		return $instance;
	}
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'aaf' );
		}

		if ( isset( $instance[ 'fact1' ] ) ) {
			$fact1 = $instance[ 'fact1' ];
		}

		if ( isset( $instance[ 'fact2' ] ) ) {
			$fact2 = $instance[ 'fact2' ];
		}

		if ( isset( $instance[ 'fact3' ] ) ) {
			$fact3 = $instance[ 'fact3' ];
		}
		?>

		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		<label for="<?php echo $this->get_field_id( 'fact1' ); ?>"><?php _e( 'Fact 1:' ); ?></label>
		<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id( 'fact1' ); ?>" name="<?php echo $this->get_field_name( 'fact1' ); ?>"><?php echo esc_attr( $fact1 ); ?></textarea>
		<label for="<?php echo $this->get_field_id( 'fact2' ); ?>"><?php _e( 'Fact 2:' ); ?></label>
		<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id( 'fact2' ); ?>" name="<?php echo $this->get_field_name( 'fact2' ); ?>"><?php echo esc_attr( $fact2 ); ?></textarea>
		<label for="<?php echo $this->get_field_id( 'fact3' ); ?>"><?php _e( 'Fact 3:' ); ?></label>
		<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id( 'fact3' ); ?>" name="<?php echo $this->get_field_name( 'fact3' ); ?>"><?php echo esc_attr( $fact3 ); ?></textarea>
		<?php
	}
} // class AAF_Impact
add_action( 'widgets_init', create_function( '', 'register_widget("AAF_Impact");' ) );