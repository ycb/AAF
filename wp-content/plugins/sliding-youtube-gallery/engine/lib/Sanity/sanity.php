<?php
class SanityPluginFramework {

    // Container variables
    var $view = '';
    var $data = array();
    var $wpdb;
    var $nonce;

    // Assets to load
    var $admin_css = array();
    var $admin_js = array();
    var $plugin_css = array();
    var $plugin_js = array();

    // Paths
    var $css_path = 'css';
    var $js_path = 'js';
    var $plugin_dir = '';
    var $plugin_dir_name = '';

    // AJAX actions
    var $ajax_actions = array(
        'admin' => array(),
        'plugin' => array()
    );
    
    function __construct($here = __FILE__) {
        global $wpdb;
        $this->add_ajax_actions();
        $this->wpdb = $wpdb;
        if(empty($this->plugin_dir)) {
            $this->plugin_dir = SYG_PATH;
        }
        $this->plugin_dir_name = basename(dirname($here));
        $this->css_path = WP_PLUGIN_URL.'/'.$this->plugin_dir_name.'/css/';
        $this->js_path = WP_PLUGIN_URL.'/'.$this->plugin_dir_name.'/js/';
        add_action('wp_loaded', array(&$this, 'create_nonce'));
        if(!empty($this->admin_css) || !empty($this->admin_js) ) {
            add_action('admin_enqueue_scripts', array(&$this, 'load_admin_scripts'));
        }
        if(!empty($this->plugin_css) || !empty($this->plugin_js) ) {
            // TODO: enqueue plugin scripts
        }
    }
    
    /*
    *       load_admin_scripts()
    *       =====================
    *       Loads admin-facing CSS and JS.
    */
    function load_admin_scripts() {
        foreach($this->admin_css as $css) {
            wp_enqueue_style($css, $this->css_path.$css.'.css');
        }
        foreach($this->admin_js as $js) {
            wp_enqueue_script($js, $this->js_path.$js.'.js');
        }
    }

    /*
    *       load_plugin_scripts()
    *       =====================
    *       Loads front-facing CSS and JS.
    */
    function load_plugin_scripts() {
        foreach($this->plugin_css as $css) {
            wp_enqueue_style($css, $this->css_path.$css.'.css');
        }
        foreach($this->plugin_js as $js) {
            wp_enqueue_script($js, $this->js_path.$js.'.js');
        }
    }

    /*
    *       create_nonce()
    *       ==============
    *       A security feature that Sanity presumes you should use. Please
    *       refer to: http://codex.wordpress.org/WordPress_Nonces
    */
    function create_nonce() {
        $this->nonce = wp_create_nonce('sanity-nonce');
    }

    /*
    *       add_ajax_actions()
    *       ==================
    *       Loops through $this->ajax_actions['admin'] and $this->ajax_actions['plugin'] and
    *       registers ajax actions. This makes the actions available in the client plugin.
    */
    function add_ajax_actions() {
        if(!empty($this->ajax_actions['admin'])) {
            foreach($this->ajax_actions['admin'] as $action) {
                add_action("wp_ajax_$action", array(&$this, $action));
            }
        }
        if(!empty($this->ajax_actions['plugin'])) {
            foreach($this->ajax_actions['plugin'] as $action) {
                add_action("wp_ajax_nopriv_$action", array(&$this, $action));
            }
        }               
    }

    /*
    *       render($view)
    *       =============
    *       Loads a view from within the /plugin/views folder. Keep in mind
    *       that any data you need should be passed through the $this->data array.
    *       A few examples:
    *
    *           Load /Plugin/views/example.php
    *           $this->render('example');
    *
    *           Load /Plugin/views/subfolder/example.php
    *           $this->render('subfolder/example);
    *
    */
    function render($view) {
        $template_path = $this->plugin_dir.'/views/'.$view.'.php';
        ob_start();
        include ($template_path);
        $output = ob_get_clean();        
        return $output;
    }
    
    function cacheRender($id, $component) {
    	$template_path = $this->plugin_dir.'/cache/html/'.$id.'/'.$component.'-'.$id.'.html';
    	ob_start();
        include ($template_path);
        $output = ob_get_clean();
        // @todo gestire sovrapposizione tra script registrati quando i componenti
        // sono uguali o tra galleria e pagina
        if (SygConstant::SYG_PLUGIN_COMPONENT_GALLERY == $component) {
	        // js to include
	        $url = WP_PLUGIN_URL.'/sliding-youtube-gallery/js/core/ui/ready/syg.client.min.js.php?id='.$id.'&cache=on'.'&ui='.SygConstant::SYG_PLUGIN_COMPONENT_GALLERY;
	        wp_register_script('syg-client-'.$id.'-'.SygConstant::SYG_PLUGIN_COMPONENT_GALLERY, $url, array(), SygConstant::SYG_VERSION, true);
	        wp_enqueue_script('syg-client-'.$id.'-'.SygConstant::SYG_PLUGIN_COMPONENT_GALLERY);
	        // js to include
	        $url = WP_PLUGIN_URL.'/sliding-youtube-gallery/js/core/ui/loading/gallery.min.js.php?id='.$id;
	        wp_register_script('syg-action-'.$id, $url, array(), SygConstant::SYG_VERSION, true);
	        wp_enqueue_script('syg-action-'.$id);
        } else if (SygConstant::SYG_PLUGIN_COMPONENT_PAGE == $component) {
        	// js to include
        	$url = WP_PLUGIN_URL.'/sliding-youtube-gallery/js/core/ui/ready/syg.client.min.js.php?id='.$id.'&cache=on'.'&ui='.SygConstant::SYG_PLUGIN_COMPONENT_PAGE;
        	wp_register_script('syg-client-'.$id.'-'.SygConstant::SYG_PLUGIN_COMPONENT_PAGE, $url, array(), SygConstant::SYG_VERSION, true);
        	wp_enqueue_script('syg-client-'.$id.'-'.SygConstant::SYG_PLUGIN_COMPONENT_PAGE);
        	// js to include
        	$url = WP_PLUGIN_URL.'/sliding-youtube-gallery/js/core/ui/loading/page.min.js.php?id='.$id;
        	wp_register_script('syg-action-'.$id, $url, array(), SygConstant::SYG_VERSION, true);
        	wp_enqueue_script('syg-action-'.$id);
        } elseif (SygConstant::SYG_PLUGIN_COMPONENT_CAROUSEL == $component) {
        	// js to include
        	$url = WP_PLUGIN_URL.'/sliding-youtube-gallery/js/core/ui/ready/syg.client.min.js.php?id='.$id.'&cache=on'.'&ui='.SygConstant::SYG_PLUGIN_COMPONENT_CAROUSEL;
        	wp_register_script('syg-client-'.$id.'-'.SygConstant::SYG_PLUGIN_COMPONENT_CAROUSEL, $url, array(), SygConstant::SYG_VERSION, true);
        	wp_enqueue_script('syg-client-'.$id.'-'.SygConstant::SYG_PLUGIN_COMPONENT_CAROUSEL);
        	// js to include
        	$url = WP_PLUGIN_URL.'/sliding-youtube-gallery/js/core/ui/loading/carousel.min.js.php?id='.$id;
        	wp_register_script('syg-carousel-'.$id, $url, array(), SygConstant::SYG_VERSION, true);
        	wp_enqueue_script('syg-carousel-'.$id);
        }
        return $output;
    }
}
?>