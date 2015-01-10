<?php

/**
 * AAF - 2013 functions and definitions
 *
 * @package AAF
 * @package AAF - 2013 1.0
 */

/**
 * Bootstrap Theme Class
 *
 * @package AAF - 2013 1.0
 */
class AAF {

    function __construct() {
        add_action( 'after_setup_theme', array($this, 'setup_theme') );
        add_action( 'wp_enqueue_scripts', array($this, 'enqueue_scripts') );
        add_action( 'wp_footer', array($this, 'footer_scripts'), 99 );
        add_action( 'widgets_init', array($this, 'widgets_init') );
        remove_action( 'wp_head', 'wp_generator' );
    }

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which runs
     * before the init hook. The init hook is too late for some features, such as indicating
     * support post thumbnails.
     *
     * @package AAF - 2013 1.0
     */
    function setup_theme() {

        /**
         * Custom template tags for this theme.
         */
        require_once dirname( __FILE__ ) . '/lib/template-tags.php';

        /**
         * Custom Theme Options
         */
        if ( is_admin() ) {
            require_once dirname( __FILE__ ) . '/lib/admin.php';
        }

        /**
         * Load bootstrap menu walker class
         */
        require_once dirname( __FILE__ ) . '/lib/bootstrap-walker.php';

        /**
         * Make theme available for translation
         * Translations can be filed in the /languages/ directory
         * If you're building a theme based on _Bootstrap, use a find and replace
         * to change 'tp' to the name of your theme in all the template files
         */
        load_theme_textdomain( 'AAF', get_template_directory() . '/languages' );

        /**
         * Add default posts and comments RSS feed links to head
         */
        add_theme_support( 'automatic-feed-links' );

        /**
         * Enable support for Post Thumbnails
         */
        add_theme_support( 'post-thumbnails' );

        /**
         * This theme uses wp_nav_menu() in one location.
         */
        register_nav_menus( array(
            'primary' => __( 'Primary Menu', 'AAF' ),
            'footer' => __( 'Footer Menu', 'AAF' ),
            'sub-footer' => __( 'Sub-Footer', 'AAF' ),
        ) );

        /**
         * Add support for the Aside Post Formats
         */
        add_theme_support( 'post-formats', array('aside',) );
    }

    /**
     * Enqueue scripts and styles
     */
    function enqueue_scripts() {
        // cache the directory path, maybe helpful?
        $template_directory = get_template_directory_uri();

        // all styles
        wp_enqueue_style( 'bootstrap', $template_directory . '/css/bootstrap.css' );
        wp_enqueue_style( 'bootstrap-responsive', $template_directory . '/css/bootstrap-responsive.css' );
        wp_enqueue_style( 'font-awesome', $template_directory . '/css/font-awesome.css' );
        wp_enqueue_style( 'prettyPhoto', $template_directory . '/css/prettyPhoto.css' );
        wp_enqueue_style( 'style', $template_directory . '/css/style.css' );
        wp_enqueue_style( 'AAFstyle', $template_directory . '/style.css' );

        // all scripts
        wp_enqueue_script( 'bootstrap', $template_directory . '/js/bootstrap.min.js', array('jquery'), '20120206', true );

        // comment reply on single posts
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }

        if ( is_singular() && wp_attachment_is_image() ) {
            wp_enqueue_script( 'keyboard-image-navigation', $template_directory . '/js/keyboard-image-navigation.js', array('jquery'), '20120202', true );
        }

        if ( is_front_page() || is_home() ) {
            wp_enqueue_script( 'constant-contact', $template_directory . 'http://www.formstack.com/forms/js.php?1497776-APKw90qniK-v3', array(), '20130612', true );
        }

        wp_enqueue_script( 'jquery-prettyphoto', $template_directory . '/js/jquery.prettyPhoto.js', array('jquery', 'theme-script'), '20120202', true );
        wp_enqueue_script( 'theme-script', $template_directory . '/js/scripts.js', array('jquery'), '20120206', true );
    }

    /**
     * Register widgetized area and update sidebar with default widgets
     *
     * @package AAF - 2013 1.0
     */
    function widgets_init() {
        register_sidebar( array(
            'name' => __( 'Sidebar Desktop', 'AAF' ),
            'id' => 'desktop',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ) );

        register_sidebar( array(
            'name' => __( 'Sidebar Mobile', 'AAF' ),
            'id' => 'mobile',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ) );

    }

    /**
     * Print custom JS and CSS codes in theme footer
     *
     * @return void
     */
    function footer_scripts() {
        $css = AAF_get_option( 'footer_css', 'tp_settings' );
        $js = AAF_get_option( 'footer_js', 'tp_settings' );

        if ( $css ) {
            echo '<style type="text/css">' . $css . '</style>' . "\r\n";
        }

        if ( $js ) {
            echo '<script type="text/javascript">' . $js . '</script>' . "\r\n";
        }
    }

}

$AAF = new AAF();

/**
 * Get the value of a settings field
 *
 * @param string $option settings field name
 * @param string $section the section name this field belongs to
 * @param string $default default text if it's not found
 * @return mixed
 */
function AAF_get_option( $option, $section, $default = '' ) {

    $options = get_option( $section );

    if ( isset( $options[$option] ) ) {
        return $options[$option];
    }

    return $default;
}

include_once("inc/sliders_cpt.php");

//our own breadcrumbs
function aaf_breadcrumbs() {  
    /* === Args === */  
    $text['home']     = 'Home'; // text for the 'Home' link  
    $text['category'] = '%s'; // text for a category page  
    $text['search']   = 'Search Results for "%s" Query'; // text for a search results page  
    $text['tag']      = 'Posts Tagged "%s"'; // text for a tag page  
    $text['author']   = 'Articles Posted by %s'; // text for an author page  
    $text['404']      = 'Error 404'; // text for the 404 page  
  
    $show_current   = 1; // 1 - show current post/page/category title in breadcrumbs, 0 - don't show  
    $show_on_home   = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show  
    $show_home_link = 1; // 1 - show the 'Home' link, 0 - don't show  
    $show_title     = 1; // 1 - show the title for the links, 0 - don't show  
    $delimiter      = ' <span class="divider">/</span> '; // delimiter between crumbs  
    $before         = '<span class="active">'; // tag before the active crumb  
    $after          = '</span>'; // tag after the active crumb  
    /* === END OF ARGS === */  
  
    global $post;  
    $home_link    = home_url('/');  
    $link_before  = '<span>';  
    $link_after   = '</span>';  
    $link_attr    = ' rel="breadcrumb" ';  
    $link         = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;  
    $parent_id    = $parent_id_2 = $post->post_parent;  
    $frontpage_id = get_option('page_on_front');  
  
    if (is_home() || is_front_page()) {  
        if ($show_on_home == 1) echo '<div class="breadcrumb"><li><a href="' . $home_link . '">' . $text['home'] . '</a></li></div>';  
  
    } else {  
  
        echo '<div class="breadcrumb">';  
        if ($show_home_link == 1) {  
            echo sprintf($link, $home_link, $text['home']);  
            if ($frontpage_id == 0 || $parent_id != $frontpage_id) echo $delimiter;  
        }  
  
        if ( is_category() ) {  
            $this_cat = get_category(get_query_var('cat'), false);  
            if ($this_cat->parent != 0) {  
                $cats = get_category_parents($this_cat->parent, TRUE, $delimiter);  
                if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);  
                $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);  
                $cats = str_replace('</a>', '</a>' . $link_after, $cats);  
                if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);  
                echo $cats;  
            }  
            if ($show_current == 1) echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;  
  
        } elseif ( is_search() ) {  
            echo $before . sprintf($text['search'], get_search_query()) . $after;  
  
        } elseif ( is_day() ) {  
            echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;  
            echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;  
            echo $before . get_the_time('d') . $after;  
  
        } elseif ( is_month() ) {  
            echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;  
            echo $before . get_the_time('F') . $after;  
  
        } elseif ( is_year() ) {  
            echo $before . get_the_time('Y') . $after;  
  
        } elseif ( is_single() && !is_attachment() ) {  
            if ( get_post_type() != 'post' ) {  
                $post_type = get_post_type_object(get_post_type());  
                $slug = $post_type->rewrite;  
                printf($link, $home_link . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);  
                if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;  
            } else {  
                $cat = get_the_category(); $cat = $cat[0];  
                $cats = get_category_parents($cat, TRUE, $delimiter);  
                if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);  
                $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);  
                $cats = str_replace('</a>', '</a>' . $link_after, $cats);  
                if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);  
                echo $cats;  
                if ($show_current == 1) echo $before . get_the_title() . $after;  
            }  
  
        } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {  
            $post_type = get_post_type_object(get_post_type());  
            echo $before . $post_type->labels->singular_name . $after;  
  
        } elseif ( is_attachment() ) {  
            $parent = get_post($parent_id);  
            $cat = get_the_category($parent->ID); $cat = $cat[0];  
            $cats = get_category_parents($cat, TRUE, $delimiter);  
            $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);  
            $cats = str_replace('</a>', '</a>' . $link_after, $cats);  
            if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);  
            echo $cats;  
            printf($link, get_permalink($parent), $parent->post_title);  
            if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;  
  
        } elseif ( is_page() && !$parent_id ) {  
            if ($show_current == 1) echo $before . get_the_title() . $after;  
  
        } elseif ( is_page() && $parent_id ) {  
            if ($parent_id != $frontpage_id) {  
                $breadcrumbs = array();  
                while ($parent_id) {  
                    $page = get_page($parent_id);  
                    if ($parent_id != $frontpage_id) {  
                        $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));  
                    }  
                    $parent_id = $page->post_parent;  
                }  
                $breadcrumbs = array_reverse($breadcrumbs);  
                for ($i = 0; $i < count($breadcrumbs); $i++) {  
                    echo $breadcrumbs[$i];  
                    if ($i != count($breadcrumbs)-1) echo $delimiter;  
                }  
            }  
            if ($show_current == 1) {  
                if ($show_home_link == 1 || ($parent_id_2 != 0 && $parent_id_2 != $frontpage_id)) echo $delimiter;  
                echo $before . get_the_title() . $after;  
            }  
  
        } elseif ( is_tag() ) {  
            echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;  
  
        } elseif ( is_author() ) {  
            global $author;  
            $userdata = get_userdata($author);  
            echo $before . sprintf($text['author'], $userdata->display_name) . $after;  
  
        } elseif ( is_404() ) {  
            echo $before . $text['404'] . $after;  
        }  
  
        if ( get_query_var('paged') ) {  
            if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';  
            echo __('Page') . ' ' . get_query_var('paged');  
            if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';  
        }  
  
        echo '</div><!-- .breadcrumb -->';  
  
    }  
} // end aaf_breadcrumbs()

function show_template() {
    global $template;
    echo "<!-- Template in use";
    print_r($template);
    echo "-->";
}
add_action('wp_head', 'show_template');

//nav menu
function nav_menu_first_last( $items ) {
 $pos = strrpos($items, 'class="menu-item', -1);
 $items=substr_replace($items, 'menu-item-last ', $pos+7, 0);
 $pos = strpos($items, 'class="menu-item');
 $items=substr_replace($items, 'menu-item-first ', $pos+7, 0);
 return $items;
}
add_filter( 'wp_nav_menu_items', 'nav_menu_first_last' );

//sidebar shortcode
add_filter('widget_text', 'do_shortcode');

/**
 * Attach a class to linked images' parent anchors
 * e.g. a img => a.img img
 */
function add_linked_images_class($html, $id, $caption, $title, $align, $url, $size, $alt = '' ){
    $classes = 'thickbox'; // separated by spaces, e.g. 'img image-link'

    // check if there are already classes assigned to the anchor
    if ( preg_match('/<a.*? class=".*?">/', $html) ) {
        $html = preg_replace('/(<a.*? class=".*?)(".*?>)/', '$1 ' . $classes . '$2', $html);
    } else {
        $html = preg_replace('/(<a.*?)>/', '$1 class="' . $classes . '" >', $html);
    }
    return $html;
}
add_filter('image_send_to_editor','add_linked_images_class',10,8);

function ycb_gallery_shortcode($attr) {
    global $post, $wp_query;
    $post = get_post();

    static $instance = 0;
    $instance++;

    if ( ! empty( $attr['ids'] ) ) {
        // 'ids' is explicitly ordered, unless you specify otherwise.
        if ( empty( $attr['orderby'] ) )
            $attr['orderby'] = 'post__in';
        $attr['include'] = $attr['ids'];
    }

    // Allow plugins/themes to override the default gallery template.
    $output = apply_filters('post_gallery', '', $attr);
    if ( $output != '' )
        return $output;

    // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if ( !$attr['orderby'] )
            unset( $attr['orderby'] );
    }

    extract(shortcode_atts(array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post->ID,
        'itemtag'    => 'dl',
        'icontag'    => 'dt',
        'captiontag' => 'dd',
        'columns'    => 3,
        'size'       => 'full',
        'include'    => '',
        'exclude'    => ''
    ), $attr));

    $id = intval($id);
    if ( 'RAND' == $order )
        $orderby = 'none';

    if ( !empty($include) ) {
        $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( !empty($exclude) ) {
        $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    } else {
        $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    }

    if ( empty($attachments) )
        return '';

    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment )
            $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
        return $output;
    }

    $itemtag = tag_escape($itemtag);
    $captiontag = tag_escape($captiontag);
    $icontag = tag_escape($icontag);
    $valid_tags = wp_kses_allowed_html( 'post' );
    if ( ! isset( $valid_tags[ $itemtag ] ) )
        $itemtag = 'dl';
    if ( ! isset( $valid_tags[ $captiontag ] ) )
        $captiontag = 'dd';
    if ( ! isset( $valid_tags[ $icontag ] ) )
        $icontag = 'dt';

    $columns = intval($columns);
    $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
    $float = is_rtl() ? 'right' : 'left';

    $selector = "gallery-{$instance}";

    $gallery_style = $gallery_div = '';
    if ( apply_filters( 'use_default_gallery_style', true ) )
        $gallery_style = "
        <style type='text/css'>
            #{$selector} {
                margin: auto;
            }
            #{$selector} .gallery-item {
                float: {$float};
                margin-top: 10px;
                text-align: center;
                width: {$itemwidth}%;
            }
            #{$selector} img {
                border: 2px solid #cfcfcf;
            }
            #{$selector} .gallery-caption {
                margin-left: 0;
            }
        </style>
        <!-- see gallery_shortcode() in wp-includes/media.php --> ";
    $size_class = sanitize_html_class( $size );
    $gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
    $output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );

    $i = 0;
    foreach ( $attachments as $id => $attachment ) {
        $link = wp_get_attachment_link($id, $size, false, false);

        $output .= "<{$itemtag} class='gallery-item'>";
        $output .= "
            <{$icontag} class='gallery-icon'>
                $link
            </{$icontag}>";
        if ( $captiontag && trim($attachment->post_excerpt) ) {
            $output .= "
                <{$captiontag} class='wp-caption-text gallery-caption'>
                " . wptexturize($attachment->post_excerpt) . "
                </{$captiontag}>";
        }
        $output .= "</{$itemtag}>";
        if ( $columns > 0 && ++$i % $columns == 0 )
            $output .= '<br style="clear: both" />';
    }

    $output .= "
            <br style='clear: both;' />
        </div>\n";

    return $output;
}
add_shortcode( 'gallery', 'ycb_gallery_shortcode' );
