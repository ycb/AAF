<?php
/**
 * The template for displaying search forms in Tareq\'s Planet - 2013
 *
 * @package _bootstraps
 * @package _bootstraps - 2013 1.0
 */
?>
<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
    <label for="s" class="assistive-text"><?php _e( 'Search', 'obc' ); ?></label>
    <input type="text" class="field" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" id="s" placeholder="<?php esc_attr_e( 'Search &hellip;', 'obc' ); ?>" />
    <input type="submit" class="submit btn" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'obc' ); ?>" />
</form>
