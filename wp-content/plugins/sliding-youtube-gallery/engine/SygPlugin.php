<?php

/**
 * @name Sliding Youtube Gallery Plugin Controller
 * @category Plugin mvc controller
 * @since 1.0.1
 * @author: Luca Martini @ webEng
 * @license: GNU GPLv3 - http://www.gnu.org/copyleft/gpl.html
 * @version: 1.4.4
 * 
 * @todo Background image (milestone v1.4.0)
 * @todo widget wordpress + Implementare scroll verticale (milestone v1.4.0)
 */

include_once 'Zend/Loader.php';

if (!class_exists('SanityPluginFramework')) require_once(SYG_PATH . 'engine/lib/Sanity/sanity.php');

class SygPlugin extends SanityPluginFramework {

	private static $instance = null;

	/**
	 * @name getInstance
	 * @category pattern
	 * @since 1.2.5
	 * @return $instance
	 */
	public static function getInstance() {
		if (self::$instance == null) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}

	private $homeRoot;
	private $pluginRoot;
	private $jsRoot;
	private $cssRoot;
	private $imgRoot;
	
	// this attribute set the json query interface script url (data.php)
	private $jsonQueryIfUrl;
	private $jsonQueryIfAdminUrl;

	private $syg = array();

	private $sygYouTube;
	private $sygDao;

	/*************************/
	/* CONFIGURATION METHODS */
	/*************************/
	/**
	 * @name __construct
	 * @category construct SygPlugin object
	 * @since 1.0.1
	 */
	public function __construct() {
		$me = SYG_PATH . '/engine/SlidingYouTubeGalleryPlugin.php';

		parent::__construct(dirname($me));

		// set environment
		$this->setEnvironment();
	}

	/**
	 * @name setEnvironment
	 * @category configuration
	 * @since 1.0.1
	 */
	private function setEnvironment() {
		// set home root
		$this->homeRoot = site_url();

		// set the plugin path
		$this->setPluginRoot(WP_PLUGIN_URL . SygConstant::WP_PLUGIN_PATH);

		// set the css path
		$this->setCssRoot(WP_PLUGIN_URL . SygConstant::WP_CSS_PATH);

		// set the js path
		$this->setJsRoot(WP_PLUGIN_URL . SygConstant::WP_JS_PATH);

		// set the img path
		$this->setImgRoot(WP_PLUGIN_URL . SygConstant::WP_IMG_PATH);

		// set json query interface url
		$this->setJsonQueryIfUrl(WP_PLUGIN_URL . SygConstant::WP_JQI_URL);
		
		// set json query interface admin url
		$this->setJsonQueryIfAdminUrl(WP_PLUGIN_URL . SygConstant::WP_JQI_ADMIN_URL);

		// set local object
		$this->sygYouTube = new SygYouTube();
		$this->sygDao = new SygDao();
	}

	/**
	 * @name setDefaultOption
	 * @category configuration
	 * @since 1.3.0
	 * @todo gestire le opzioni in opportuna mappa per ciclarla
	 */
	public static function setDefaultOption() {
		/********************
		 * General settings *
		 ********************/
		if (!get_option('syg_option_askcache'))
			add_option('syg_option_askcache',
					SygConstant::SYG_OPTION_DEFAULT_ASKCACHE);
		if (!get_option('syg_option_description_length'))
			add_option('syg_option_description_length',
					SygConstant::SYG_OPTION_DEFAULT_DESCRIPTION_LENGTH);
		if (!get_option('syg_option_numrec'))
			add_option('syg_option_numrec',
					SygConstant::SYG_OPTION_DEFAULT_NUM_REC);
		if (!get_option('syg_option_use_fb2')) 
			add_option('syg_option_use_fb2',
				SygConstant::SYG_OPTION_DEFAULT_USE_FB2);
		
		/********************
		 * YouTube settings *
		*********************/
		if (!get_option('syg_option_which_thumb'))
			add_option('syg_option_which_thumb',
					SygConstant::SYG_OPTION_DEFAULT_WHICH_THUMB);
		
		/*********************************
		 * Video page component settings *
		**********************************/
		if (!get_option('syg_option_pagenumrec'))
			add_option('syg_option_pagenumrec',
					SygConstant::SYG_OPTION_DEFAULT_PAGENUM_REC);
		if (!get_option('syg_option_paginationarea'))
			add_option('syg_option_paginationarea',
					SygConstant::SYG_OPTION_DEFAULT_PAGINATION_AREA);
		if (!get_option('syg_option_paginator_borderradius'))
			add_option('syg_option_paginator_borderradius',
					SygConstant::SYG_OPTION_DEFAULT_PAGINATOR_BORDERRADIUS);
		if (!get_option('syg_option_paginator_bordersize'))
			add_option('syg_option_paginator_bordersize',
					SygConstant::SYG_OPTION_DEFAULT_PAGINATOR_BORDERSIZE);
		if (!get_option('syg_option_paginator_bordercolor'))
			add_option('syg_option_paginator_bordercolor',
					SygConstant::SYG_OPTION_DEFAULT_PAGINATOR_BORDERCOLOR);
		if (!get_option('syg_option_paginator_bgcolor'))
			add_option('syg_option_paginator_bgcolor',
					SygConstant::SYG_OPTION_DEFAULT_PAGINATOR_BGCOLOR);
		if (!get_option('syg_option_paginator_shadowcolor'))
			add_option('syg_option_paginator_shadowcolor',
					SygConstant::SYG_OPTION_DEFAULT_PAGINATOR_SHADOWCOLOR);
		if (!get_option('syg_option_paginator_shadowsize'))
			add_option('syg_option_paginator_shadowsize',
					SygConstant::SYG_OPTION_DEFAULT_PAGINATOR_SHADOWSIZE);
		if (!get_option('syg_option_paginator_fontcolor'))
			add_option('syg_option_paginator_fontcolor',
					SygConstant::SYG_OPTION_DEFAULT_PAGINATOR_FONTCOLOR);
		if (!get_option('syg_option_paginator_fontsize'))
			add_option('syg_option_paginator_fontsize',
					SygConstant::SYG_OPTION_DEFAULT_PAGINATOR_FONTSIZE);
		
		/******************************
		 * 3d cloud carousel settings *
		*******************************/
		if (!get_option('syg_option_carousel_autorotate'))
			add_option('syg_option_carousel_autorotate',
					SygConstant::SYG_OPTION_DEFAULT_CAROUSEL_AUTOROTATE);
		if (!get_option('syg_option_carousel_delay'))
			add_option('syg_option_carousel_delay',
					SygConstant::SYG_OPTION_DEFAULT_CAROUSEL_DELAY);
		if (!get_option('syg_option_carousel_fps'))
			add_option('syg_option_carousel_fps',
					SygConstant::SYG_OPTION_DEFAULT_CAROUSEL_FPS);
		if (!get_option('syg_option_carousel_speed'))
			add_option('syg_option_carousel_speed',
					SygConstant::SYG_OPTION_DEFAULT_CAROUSEL_SPEED);
		if (!get_option('syg_option_carousel_minscale'))
			add_option('syg_option_carousel_minscale',
					SygConstant::SYG_OPTION_DEFAULT_CAROUSEL_MINSCALE);
		if (!get_option('syg_option_carousel_reflheight'))
			add_option('syg_option_carousel_reflheight',
					SygConstant::SYG_OPTION_DEFAULT_CAROUSEL_REFLHEIGHT);
		if (!get_option('syg_option_carousel_reflgap'))
			add_option('syg_option_carousel_reflgap',
					SygConstant::SYG_OPTION_DEFAULT_CAROUSEL_REFLGAP);
		if (!get_option('syg_option_carousel_reflopacity'))
			add_option('syg_option_carousel_reflopacity',
					SygConstant::SYG_OPTION_DEFAULT_CAROUSEL_REFLOPACITY);
	}

	/**
	 * @name removeOldOption
	 * @category configuration
	 * @since 1.2.5
	 */
	public static function removeOldOption() {
		global $wpdb;

		if ($wpdb->insert_id) {
			delete_option('syg_youtube_username');
			delete_option('syg_youtube_videoformat');
			delete_option('syg_youtube_maxvideocount');
			delete_option('syg_thumbnail_height');
			delete_option('syg_thumbnail_width');
			delete_option('syg_thumbnail_bordersize');
			delete_option('syg_thumbnail_bordercolor');
			delete_option('syg_thumbnail_borderradius');
			delete_option('syg_thumbnail_top');
			delete_option('syg_thumbnail_left');
			delete_option('syg_thumbnail_distance');
			delete_option('syg_thumbnail_overlaysize');
			delete_option('syg_thumbnail_image');
			delete_option('syg_thumbnail_buttonopacity');
			delete_option('syg_description_width');
			delete_option('syg_description_fontsize');
			delete_option('syg_description_fontcolor');
			delete_option('syg_description_show');
			delete_option('syg_description_showduration');
			delete_option('syg_description_showtags');
			delete_option('syg_description_showratings');
			delete_option('syg_description_showcategories');
			delete_option('syg_box_width');
			delete_option('syg_box_background');
			delete_option('syg_box_radius');
			delete_option('syg_box_padding');
			delete_option('syg_submit_hidden');
		}
	}

	/**
	 * @name getViewCtx
	 * @category admin forward
	 * @since 1.0.1
	 * @param $id
	 * @return array $context
	 */
	public function getViewCtx($id = null) {
		if (is_int((int) $id)) {
			$dao = new SygDao();
			$this->data['gallery'] = $dao->getSygGalleryById($id);
			$this->prepareHeader($this->data, SygConstant::SYG_CTX_FE);
			return $this->data;
		}
		return false;
	}

	/*****************************/
	/* END CONFIGURATION METHODS */
	/*****************************/

	/********************************/
	/* WORDPRESS PLUGIN ACTION HOOK */
	/********************************/

	public function rebuildCache($start = 0, $end = PHP_INT_MAX) {
		$galleries = $this->sygDao->getAllCachedGallery('OBJECT', $start, $end);
		foreach ($galleries as $gallery) {
			$gallery->cacheGallery();
		}
	}
	
	/**
	 * @name sygNotice
	 * @category display admin notices in wordpress dashboard
	 * @since 1.3.3
	 * @todo aggiungere check permission filesystem
	 */
	public function sygNotice() {
		global $pagenow;
		//$this->printTasks();
		if (($pagenow == 'admin.php')
				&& (($_GET['page'] == SygConstant::BE_ACTION_MANAGE_STYLES)
					|| ($_GET['page'] == SygConstant::BE_ACTION_MANAGE_GALLERIES)
					|| ($_GET['page'] == SygConstant::BE_ACTION_MANAGE_SETTINGS)
					|| ($_GET['page'] == SygConstant::BE_ACTION_CONTACTS)) 
				&& !(isset($_POST['syg_submit_hidden'])	&& $_POST['syg_submit_hidden'] == 'Y')) {

			$checkStyles = (bool) $this->sygDao->getStylesCount();
			$checkGallery = (bool) $this->sygDao->getGalleriesCount();
			$checkFSPermission = (bool) (is_writable(WP_PLUGIN_DIR . SygConstant::WP_CACHE_DIR) && 
										 is_writable(WP_PLUGIN_DIR . SygConstant::WP_PLUGIN_PATH . SygConstant::WP_CACHE_HTML_REL_DIR) && 
										 is_writable(WP_PLUGIN_DIR . SygConstant::WP_PLUGIN_PATH . SygConstant::WP_CACHE_THUMB_REL_DIR) &&
										 is_writable(WP_PLUGIN_DIR . SygConstant::WP_PLUGIN_PATH . SygConstant::WP_CACHE_JSON_REL_DIR) && 
										 is_writable(WP_PLUGIN_DIR . SygConstant::WP_PLUGIN_PATH . SygConstant::WP_CACHE_JS_REL_DIR));
			
			// define a warning array
			$warning = array();
			
			// check if gallery exist
			if (!$checkGallery) {
				array_push($warning, array('field' => '', 'msg' => SygConstant::BE_NO_GALLERY_FOUND_ADM_WRN));
			}
			
			// check if style exist
			if (!$checkStyles) {
				array_push($warning, array('field' => '', 'msg' => SygConstant::BE_NO_STYLES_FOUND_ADM_WRN));
			}
			
			if (!$checkFSPermission) {
				array_push($warning, array('field' => '', 'msg' => SygConstant::BE_FS_NOT_WRITEABLE));
			}
			
			// place warnings in the view
			$this->data['warning'] = $warning;
			
			// try to validate options
			try {
				$checkOptions = (bool) SygValidate::validateSettings(serialize(SygPlugin::getInstance()->getOptions()));
			} catch (SygValidateException $ex) {
				// set the error
				$this->data['exception'] = true;
				$this->data['exception_message'] = $ex->getMessage();
				$this->data['exception_detail'] = $ex->getProblems();
			} catch (Exception $ex) {
				// set the error
				$this->data['exception'] = true;
				$this->data['exception_message'] = $ex->getMessage();
			}
		}
	}

	public function printTasks() {
		print_r(_get_cron_array());
	}
	
	/**
	 * @name checkUpdateProcess
	 * @category check update process
	 * @since 1.3.3
	 */
	public static function checkUpdateProcess() {
		global $wpdb;
		global $syg_db_version;
		// set db version
		$target_syg_db_version = SygConstant::SYG_VERSION;
		
		// get the current db version
		$installed_ver = get_option("syg_db_version");
		
		// chmod all the cache directories to ensure that is writeable
		$stat = stat(WP_PLUGIN_DIR . SygConstant::WP_CACHE_DIR);

		if ((getmygid() == $stat['gid']) || ($stat['gid'] == 0)) {
			chmod ( WP_PLUGIN_DIR . SygConstant::WP_CACHE_DIR, 0755 );
			chmod ( WP_PLUGIN_DIR . SygConstant::WP_PLUGIN_PATH . SygConstant::WP_CACHE_HTML_REL_DIR, 0755 );
			chmod ( WP_PLUGIN_DIR . SygConstant::WP_PLUGIN_PATH . SygConstant::WP_CACHE_THUMB_REL_DIR, 0755 );
			chmod ( WP_PLUGIN_DIR . SygConstant::WP_PLUGIN_PATH . SygConstant::WP_CACHE_JSON_REL_DIR, 0755 );
			chmod ( WP_PLUGIN_DIR . SygConstant::WP_PLUGIN_PATH . SygConstant::WP_CACHE_JS_REL_DIR, 0755);
		}
		
		if ($installed_ver != $target_syg_db_version) {
			try {
				// create a brand new dao
				$dao = new SygDao();
		
				// update database structure
				$dao->updateVersion($installed_ver, $target_syg_db_version);
		
				// add or update db version option
				(!get_option("syg_db_version")) ? add_option("syg_db_version",
						$target_syg_db_version)
						: update_option("syg_db_version",
								$target_syg_db_version);
			} catch (Exception $ex) {
				// set the error
				$this->data['exception'] = true;
				$this->data['exception_message'] = $ex->getMessage();
			}
		}
	}
	
	/**
	 * @name uninstall
	 * @category uninstall plugin hook
	 * @since 1.0.1
	 */
	public static function uninstall() {
		global $wpdb;
		
		// check if admin
		if (is_admin()) {
			// get table name
			$galleryTable = $wpdb->prefix . 'syg';
			$styleTable = $wpdb->prefix . 'syg_OLD_V12X';
			$backupTable = $wpdb->prefix . 'syg_styles';
	
			// remove table
			$dao = new SygDao();
			$dao->removeTable($galleryTable);
			$dao->removeTable($styleTable);
			$dao->removeTable($backupTable);
	
			// remove options
			delete_option("syg_db_version");
		}
	}

	/**
	 * @name deactivation
	 * @category deactivation plugin hook
	 * @since 1.0.1
	 */
	public static function deactivation() {
		// check if admin
		if (is_admin()) {
			null;
		}
	}

	/**
	 * @name activation
	 * @category deactivation plugin hook
	 * @since 1.0.1
	 */
	public static function activation() {
		// check if admin
		if (is_admin()) {
			self::checkUpdateProcess();
		}
	}

	/************************************/
	/* END WORDPRESS PLUGIN ACTION HOOK */
	/************************************/

	/***********************/
	/* GETTERS AND SETTERS */
	/***********************/
	/**
	 * @name setHomeRoot
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $homeRoot
	 */
	private function setHomeRoot($homeRoot) {
		$this->homeRoot = $homeRoot;
	}

	/**
	 * @name setPluginRoot
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $pluginRoot
	 */
	private function setPluginRoot($pluginRoot) {
		$this->pluginRoot = $pluginRoot;
	}

	/**
	 * @name setJsRoot
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $jsRoot
	 */
	private function setJsRoot($jsRoot) {
		$this->jsRoot = $jsRoot;
	}

	/**
	 * @name setCssRoot
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $cssRoot
	 */
	private function setCssRoot($cssRoot) {
		$this->cssRoot = $cssRoot;
	}

	/**
	 * @name setImgRoot
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $imgRoot
	 */
	private function setImgRoot($imgRoot) {
		$this->imgRoot = $imgRoot;
	}

	/**
	 * @name setJsonQueryIfUrl
	 * @category getters and setters
	 * @since 1.3.0
	 * @param $jsonQueryIfUrl
	 */
	private function setJsonQueryIfUrl($jsonQueryIfUrl) {
		$this->jsonQueryIfUrl = $jsonQueryIfUrl;
	}

	/**
	 * @param field_type $jsonQueryIfAdminUrl
	 */
	public function setJsonQueryIfAdminUrl($jsonQueryIfAdminUrl) {
		$this->jsonQueryIfAdminUrl = $jsonQueryIfAdminUrl;
	}

	/**
	 * @name getHomeRoot
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $homeRoot
	 */
	public function getHomeRoot() {
		return $this->homeRoot;
	}

	/**
	 * @name getPluginRoot
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $homeRoot
	 */
	public function getPluginRoot() {
		return $this->pluginRoot;
	}

	/**
	 * @name getJsRoot
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $jsRoot
	 */
	public function getJsRoot() {
		return $this->jsRoot;
	}

	/**
	 * @name getCssRoot
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $cssRoot
	 */
	public function getCssRoot() {
		return $this->cssRoot;
	}

	/**
	 * @name getImgRoot
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $imgRoot
	 */
	public function getImgRoot() {
		return $this->imgRoot;
	}

	/**
	 * @name getJsonQueryIfUrl
	 * @category getters and setters
	 * @since 1.3.0
	 * @return the $jsonQueryIfUrl
	 */
	public function getJsonQueryIfUrl() {
		return $this->jsonQueryIfUrl;
	}
	
	/**
	 * @return the $jsonQueryIfAdminUrl
	 */
	public function getJsonQueryIfAdminUrl() {
		return $this->jsonQueryIfAdminUrl;
	}
	
	/**
	 * @name getCurrentUserRole
	 * @category returns the translated role of the current user
	 * @return string The name of the current role
	 */
	public static function getCurrentUserRole() {
		global $wp_roles;
		$current_user = wp_get_current_user();
		$roles = $current_user->roles;
		$role = array_shift($roles);
		return isset($wp_roles->role_names[$role]) ? $wp_roles->role_names[$role] : false;
	}

	/***************************/
	/* END GETTERS AND SETTER  */
	/***************************/

	/**************************/
	/* FRONT END CORE METHODS */
	/**************************/

	/**
	 * @name Get gallery settings returning its DTO
	 * @param $id 
	 * @return array $settings
	 */
	public function getGallerySettings($id = null) {
		// cast id to an int
		$id = (int) $id;

		if ($id == 0) {
			// generate a fake gallery
			$gallery = new SygGallery();
		} else {
			// get the gallery
			$dao = new SygDao();
			$gallery = $dao->getSygGalleryById($id);
		}
		
		// return gallery in dto format
		$settings = $gallery->toDto(true);
		return $settings;
	}

	/**
	 * @name getGallery
	 * @category get a sliding youtube gallery
	 * @since 1.0.1
	 * @param $attributes
	 * @return $output
	 */
	public function getGallery($attributes, $mode = SygConstant::SYG_PLUGIN_FE_NORMAL_MODE) {
		foreach ($attributes as $key => $var) {
			$attributes[$key] = (int) $var;
		}
		
		extract(shortcode_atts(array('id' => null), $attributes));

		if (!empty($id)) {
			try {
				// get the gallery
				$dao = new SygDao();
				$gallery = $dao->getSygGalleryById($id);
				
				// put the gallery settings in the view
				$this->data['gallery'] = $gallery;
				
				// put component type in the view (javascript optimization)
				$this->data['component_type'] = SygConstant::SYG_PLUGIN_COMPONENT_GALLERY;
				
				// put mode option in the view context
				$this->data['mode'] = $mode;
				
				// put the options in the view context
				$this->data['options'] = $this->getOptions();
				
				if ($gallery->isGalleryCached() && $mode == SygConstant::SYG_PLUGIN_FE_NORMAL_MODE) {					
					// set front end option
					$this->prepareHeader($this->data, SygConstant::SYG_CTX_FE);
					
					// render cache files
					return $this->cacheRender($gallery->getId(), SygConstant::SYG_PLUGIN_COMPONENT_GALLERY);
				} else {
					// put the feed in the view
					$this->data['feed'] = $this->sygYouTube->getVideoFeed($gallery);
		
					// set front end option
					$this->prepareHeader($this->data, SygConstant::SYG_CTX_FE);
					
					// render gallery snippet code
					return $this->render(SygConstant::SYG_PLUGIN_COMPONENT_GALLERY);
				}
			} catch (SygGalleryNotFoundException $ex) {
				$this->data['exception'] = true;
				$this->data['exception_message'] = $ex->getMessage();
				// set front end option
				$this->prepareHeader($this->data, SygConstant::SYG_CTX_FE);
				return $this->render('exception');
			} catch (Exception $ex) {
				$this->data['exception'] = true;
				$this->data['exception_message'] = $ex->getMessage();
				// set front end option
				$this->prepareHeader($this->data, SygConstant::SYG_CTX_FE);
				return $this->render('exception');
			}
		}
	}

	/**
	 * @name getVideoPage
	 * @category get a video page
	 * @since 1.0.1
	 * @param $attributes
	 * @return $output
	 */
	public function getVideoPage($attributes, $mode = SygConstant::SYG_PLUGIN_FE_NORMAL_MODE) {
		foreach ($attributes as $key => $var) {
			$attributes[$key] = (int) $var;
		}

		extract(shortcode_atts(array('id' => null), $attributes));

		if (!empty($id)) {
			try {
				// get the gallery
				$dao = new SygDao();
				$gallery = $dao->getSygGalleryById($id);

				// put the gallery settings in the view
				$this->data['gallery'] = $gallery;
				
				// get options
				$options = $this->getOptions();
				
				// number of pages
				$this->data['options'] = $options;
					
				// calculate pages
				$this->data['pages'] = ceil(
						$gallery->countGalleryEntry()
						/ $options['syg_option_pagenumrec']);
					
				// put component type in the view (javascript optimization)
				$this->data['component_type'] = SygConstant::SYG_PLUGIN_COMPONENT_PAGE;
					
				// set front end option
				$this->prepareHeader($this->data, SygConstant::SYG_CTX_FE);
				
				if ($gallery->isGalleryCached() && $mode == SygConstant::SYG_PLUGIN_FE_NORMAL_MODE) {
					return $this->cacheRender($gallery->getId(), SygConstant::SYG_PLUGIN_COMPONENT_PAGE);
				} else {					
					// render gallery snippet code
					return $this->render(SygConstant::SYG_PLUGIN_COMPONENT_PAGE);
				}
			}  catch (SygGalleryNotFoundException $ex) {
				$this->data['exception'] = true;
				$this->data['exception_message'] = $ex->getMessage();
				// set front end option
				$this->prepareHeader($this->data, SygConstant::SYG_CTX_FE);
				return $this->render('exception');
			} catch (Exception $ex) {
				$this->data['exception'] = true;
				$this->data['exception_message'] = $ex->getMessage();
				// set front end option
				$this->prepareHeader($this->data, SygConstant::SYG_CTX_FE);
				return $this->render('exception');
			}
		}
	}

	/**
	 * @name getVideoCarousel
	 * @category get a video carousel
	 * @since 1.0.1
	 * @param $attributes
	 * @return $output
	 */
	public function getVideoCarousel($attributes, $mode = SygConstant::SYG_PLUGIN_FE_NORMAL_MODE) {
		foreach ($attributes as $key => $var) {
			$attributes[$key] = (int) $var;
		}
		
		extract(shortcode_atts(array('id' => null), $attributes));
		
		if (!empty($id)) {
			try {
				// get the gallery
				$dao = new SygDao();
				$gallery = $dao->getSygGalleryById($id);
		
				// put the gallery settings in the view
				$this->data['gallery'] = $gallery;
		
				// put component type in the view (javascript optimization)
				$this->data['component_type'] = SygConstant::SYG_PLUGIN_COMPONENT_CAROUSEL;
		
				// put mode option in the view context
				$this->data['mode'] = $mode;
		
				// put the options in the view context
				$this->data['options'] = $this->getOptions();
				
				if ($gallery->isGalleryCached() && $mode == SygConstant::SYG_PLUGIN_FE_NORMAL_MODE) {
					// set front end option
					$this->prepareHeader($this->data, SygConstant::SYG_CTX_FE);
						
					// render cache files
					return $this->cacheRender($gallery->getId(), SygConstant::SYG_PLUGIN_COMPONENT_CAROUSEL);
				} else if ($mode == SygConstant::SYG_PLUGIN_FE_CACHING_MODE) {
					return $this->render(SygConstant::SYG_PLUGIN_COMPONENT_CAROUSEL);
				} else {
					$this->data['exception'] = true;
					$this->data['exception_message'] = SygConstant::MSG_EX_GALLERY_NOT_CACHED;
					// set front end option
					$this->prepareHeader($this->data, SygConstant::SYG_CTX_FE);
					return $this->render('exception');
				}
			} catch (SygGalleryNotFoundException $ex) {
				$this->data['exception'] = true;
				$this->data['exception_message'] = $ex->getMessage();
				// set front end option
				$this->prepareHeader($this->data, SygConstant::SYG_CTX_FE);
				return $this->render('exception');
			} catch (Exception $ex) {
				$this->data['exception'] = true;
				$this->data['exception_message'] = $ex->getMessage();
				// set front end option
				$this->prepareHeader($this->data, SygConstant::SYG_CTX_FE);
				return $this->render('exception');
			}
		}
	}
	
	/**
	 * @name prepareHeader
	 * @category prepare header with the right js and css inclusion
	 * @since 1.0.1
	 * @param &$view
	 * @param $context
	 */
	private function prepareHeader(&$view, $context = SygConstant::SYG_CTX_FE) {
		// define resources path
		$view['cssPath'] = $this->getCssRoot();
		$view['imgPath'] = $this->getImgRoot();
		$view['jsPath'] = $this->getJsRoot();
		$view['pluginUrl'] = $this->getPluginRoot();
		
		// get options
		$options = $this->getOptions();
		
		// detect if client is a mobile browser
		$detect = new Mobile_Detect();
		$mobile = $detect->isMobile();
		
		// fancybox 2 resources url
		$view['fancybox_js_url'] = $options['syg_option_use_fb2_url'] . 'jquery.fancybox.pack.js';
		$view['mousewheel_js_url'] = $options['syg_option_use_fb2_url'] . 'jquery.mousewheel-3.0.6.pack.js';
		$view['fancybox_css_url'] = $options['syg_option_use_fb2_url'] . 'jquery.fancybox.css';
		
		// fancybox resources url
		$view['fancybox_js_url'] = $view['jsPath'] . '/3rdParty/fancybox/jquery.fancybox-1.3.4.pack.js';
		$view['easing_js_url'] = $view['jsPath'] . '/3rdParty/fancybox/jquery.easing-1.3.pack.js';
		$view['mousewheel_js_url'] = $view['jsPath'] . '/3rdParty/fancybox/jquery.mousewheel-3.0.4.pack.js';
		$view['fancybox_css_url'] = $view['jsPath']	. '/3rdParty/fancybox/jquery.fancybox-1.3.4.css';
		
		// jquery 
		$view['jquery-cookie-master_js_url'] = $view['jsPath'] . '3rdParty/jquery-cookie-master/jquery.cookie.js';
		
		switch ($context) {
			case SygConstant::SYG_CTX_BE:
				/********************************
				 * include css in the view file *
				 ********************************/
				// css to include admin
				$view['cssAdminUrl'] = $view['cssPath'] . 'admin.css';
				// css to include colorpicker
				$view['cssColorPicker'] = $view['cssPath'] . 'colorpicker.css';
	
				/***********************
				 * wp jquery injection *
				 ***********************/
				wp_enqueue_script('jquery');
	
				/*******************************
				 * syg admin library inclusion *
				 *******************************/
				wp_register_script('sliding-youtube-gallery-admin', $view['jsPath'] . 'core/lib/syg.lib.admin.min.js.php', array(), SygConstant::SYG_VERSION, true);
				wp_enqueue_script('sliding-youtube-gallery-admin');
	
				/*****************************
				 * color picker js inclusion *
				 *****************************/
				wp_register_script('sliding-youtube-gallery-colorpicker', $view['jsPath'] . '3rdParty/colorPicker/colorpicker.js', array(), SygConstant::SYG_VERSION, true);
				wp_enqueue_script('sliding-youtube-gallery-colorpicker');
	
				/**********************
				 * fancybox inclusion *
				 **********************/
				if ($options['syg_option_use_fb2'] == '1') { // use fancybox 2
					// include css
					wp_register_style('fancybox', $view['fancybox_css_url'], array(), '2.1.2', 'screen');
					wp_enqueue_style('fancybox');
					
					// include fancybox
					wp_register_script('fancybox', $view['fancybox_js_url'], array('jquery'), '2.1.3', true);
					wp_enqueue_script('fancybox');
						
					// include jquery mousewheel
					wp_register_script('mousewheel', $view['mousewheel_js_url'], array('jquery'), '3.0.6', true);
					wp_enqueue_script('mousewheel');
				} else { // use fancybox 1
					// include css
					wp_register_style('fancybox', $view['fancybox_css_url'], array(), '1.3.4', 'screen');
					wp_enqueue_style('fancybox');
					
					// include fancybox
					wp_register_script('fancybox', $view['fancybox_js_url'], array('jquery'), '1.3.4', true);
					wp_enqueue_script('fancybox');
					
					// include jquery easing
					wp_register_script('easing', $view['easing_js_url'], array('jquery'), '1.3.0', true);
					wp_enqueue_script('easing');
					
					// include jquery mousewheel
					wp_register_script('mousewheel', $view['mousewheel_js_url'], array('jquery'), '3.0.4', true);
					wp_enqueue_script('mousewheel');
				}
				
				/********************************
				 * include jquery cookie master *
				 ********************************/
				wp_register_script('jquery-cookie-master', $view['jquery-cookie-master_js_url'], array(), SygConstant::SYG_VERSION, true);
				wp_enqueue_script('jquery-cookie-master');
				
				break;
			case SygConstant::SYG_CTX_FE:
				// fix index
				if (empty($view['gallery'])) {
					$galleryId = 0;
				} else {
					$gallery = $view['gallery'];
					$galleryId = $gallery->getId();
				}
					
				/***************************
				 * gallery style injection *
				 ***************************/
				// indexed css
				$view['sygCssUrl_' . $galleryId] = $view['cssPath']	. 'SlidingYoutubeGallery.css.php?id=' . $galleryId;
				wp_register_style('sliding-youtube-gallery-' . $galleryId, $view['sygCssUrl_' . $galleryId], array(), SygConstant::SYG_VERSION, 'screen');
				wp_enqueue_style('sliding-youtube-gallery-' . $galleryId);
				
				/***********************
				 * wp jquery injection *
				 ***********************/
				wp_enqueue_script('jquery');
				
				/***************************
				 * jquery mobile inclusion *
				 ***************************/
				if ($mobile) {
					wp_register_script('jquery.mobile', $view['jsPath'] . '3rdParty/jquery-mobile/jquery.mobile-1.2.1.min.js', array('jquery'), '1.2.1', true);
					wp_enqueue_script('jquery.mobile');
					wp_register_style('jquery.mobile', $view['jsPath'] . '3rdParty/jquery-mobile/jquery.mobile-1.2.1.min.css', array(), '1.2.1', 'screen');
					wp_enqueue_style('jquery.mobile');
				}
				
				/********************************
				 * syg client library inclusion *
				 ********************************/
				// syg client library
				$view['sygJsUrl'] = $view['jsPath'] . 'core/lib/syg.lib.client.min.js.php';
				wp_register_script('sliding-youtube-gallery', $view['sygJsUrl'], array(), SygConstant::SYG_VERSION, true);
				wp_enqueue_script('sliding-youtube-gallery');
				
				/**********************
				 * fancybox inclusion *
				**********************/
				if ($options['syg_option_use_fb2'] == '1') { // use fancybox 2
					// include css
					wp_register_style('fancybox', $view['fancybox_css_url'], array(), '2.1.2', 'screen');
					wp_enqueue_style('fancybox');
						
					// include fancybox
					wp_register_script('fancybox', $view['fancybox_js_url'], array('jquery'), '2.1.3', true);
					wp_enqueue_script('fancybox');
				
					// include jquery mousewheel
					wp_register_script('mousewheel', $view['mousewheel_js_url'], array('jquery'), '3.0.6', true);
					wp_enqueue_script('mousewheel');
				} else { // use fancybox 1
					// include css
					wp_register_style('fancybox', $view['fancybox_css_url'], array(), '1.3.4', 'screen');
					wp_enqueue_style('fancybox');
						
					// include fancybox
					wp_register_script('fancybox', $view['fancybox_js_url'], array('jquery'), '1.3.4', true);
					wp_enqueue_script('fancybox');
						
					// include jquery easing
					wp_register_script('easing', $view['easing_js_url'], array('jquery'), '1.3.0', true);
					wp_enqueue_script('easing');
						
					// include jquery mousewheel
					wp_register_script('mousewheel', $view['mousewheel_js_url'], array('jquery'), '3.0.4', true);
					wp_enqueue_script('mousewheel');
				}
				
				/****************************
				 * cloud carousel inclusion *
				 ****************************/
				// carousel resources url
				$view['carousel_js_url'] = $view['jsPath'] . '3rdParty/cloudCarousel/cloud-carousel.1.0.5.min.js';
				wp_register_script('carousel', $view['carousel_js_url'], array(), '1.0.5', true);
				wp_enqueue_script('carousel');
				
				break;
			case SygConstant::SYG_CTX_WS:
				break;
			default:
				break;
		}
	}

	/******************************/
	/* END FRONT END CORE METHODS */
	/******************************/

	/**************************/
	/* ADMIN SECTION FORWARDS */
	/**************************/

	/**
	 * @name forwardToGalleries
	 * @category admin forward
	 * @since 1.0.1
	 * @param $updated
	 * @return $output
	 */
	public function forwardToGalleries($updated = false) {
		// if we've updated a record set action to null
		if ($updated == true) { 
			$action = 'redirect';
		} elseif (isset($_GET['action'])) { 
			$action = $_GET['action'];
		} else {
			$action = 'default';
		}

		// determine wich action to call
		switch ($action) {
			case 'add':
				return $this->forwardToAddGallery();
			case 'edit':
				return $this->forwardToEditGallery();
			case 'delete':
				return $this->forwardToDeleteGallery();
			case 'cache':
				return $this->forwardToCacheGallery();
			case 'redirect':
				$this->data['redirect_url'] = '?page=' . SygConstant::BE_ACTION_MANAGE_GALLERIES . '&modified='.$_GET['id'];
				return $this->render('redirect');
			default:
				// prepare header
				$this->prepareHeader($this->data, SygConstant::SYG_CTX_BE);
	
				// put galleries in the view
				$galleries = $this->sygDao->getAllSygGalleries();
	
				// put galleries in the view
				$this->data['galleries'] = $galleries;
	
				// number of pages
				$options = $this->getOptions();
				$this->data['pages'] = ceil(
						$this->sygDao->getGalleriesCount()
								/ $options['syg_option_numrec']);
	
				// render adminStyles view
				return $this->render('adminGalleries');
		}
	}

	/**
	 * @name forwardToStyles
	 * @category admin forward
	 * @since 1.0.1
	 * @param $updated
	 * @return $output
	 */
	public function forwardToStyles($updated = false) {
		// if we've updated a record set action to null
		if ($updated == true) { 
			$action = 'redirect';
		} elseif (isset($_GET['action'])) { 
			$action = $_GET['action'];
		} else {
			$action = 'default';
		}

		// determine wich action to call
		switch ($action) {
			case 'add':
				return $this->forwardToAddStyle();
			case 'edit':
				return $this->forwardToEditStyle();
			case 'delete':
				return $this->forwardToDeleteStyle();
			case 'cache':
				// get the style id
				$id = (int) $_GET['id'];
				$galleries = $this->sygDao->getSygCachedGalleriesByStyleId($id);
				
				for ($i=0; $i<count($galleries); $i++) {
					$gallery = $galleries[$i];
					if ($gallery->getCacheOn()) {
						$gallery->cacheGallery();
					}
				}
		
				break;
			case 'redirect':
				$this->data['redirect_url'] = '?page='
						. SygConstant::BE_ACTION_MANAGE_STYLES . '&modified='.$_GET['id'];
				return $this->render('redirect');
			default:
				// prepare header
				$this->prepareHeader($this->data, SygConstant::SYG_CTX_BE);
	
				// put galleries in the view
				$styles = $this->sygDao->getAllSygStyles();
	
				// put galleries in the view
				$this->data['styles'] = $styles;
	
				// number of pages
				$options = $this->getOptions();
				$this->data['pages'] = ceil(
						$this->sygDao->getStylesCount()
								/ $options['syg_option_numrec']);
	
				// render adminStyles view
				return $this->render('adminStyles');
		}
	}

	/**
	 * @name forwardToSettings
	 * @category admin forward
	 * @since 1.0.1
	 * @param $updated
	 * @return $output
	 */
	public function forwardToSettings($updated = false) {
		if (is_admin()) {
			// if we've updated a record set action to null
			$action = ($updated == true) ? 'redirect' : (isset( $_GET['action']) ? $_GET['action'] : 'default');
			// determine wich action to call
			switch ($action) {
				case 'cache':
					// update cached gallery
					$galleries = $this->sygDao->getAllCachedGallery();
					for ($i=0; $i<count($galleries); $i++) {
						$gallery = $galleries[$i];
						$gallery->cacheGallery();
					}
					break;
				default:
					if (isset($_POST['syg_submit_hidden'])
							&& $_POST['syg_submit_hidden'] == 'Y') {
						// database add/edit settings procedure
						// get posted values
						$data = serialize($_POST);
						try {
							// validate data
							$valid = SygValidate::validateSettings($data);
					
							(get_option('syg_option_which_thumb') === false) ? add_option(
									'syg_option_which_thumb',
									$_POST['syg_option_which_thumb'])
									: update_option('syg_option_which_thumb',
											$_POST['syg_option_which_thumb']);
							
							(get_option('syg_option_askcache') === false) ? add_option(
									'syg_option_askcache',
									$_POST['syg_option_askcache'])
									: update_option('syg_option_askcache',
											$_POST['syg_option_askcache']);
					
							(get_option('syg_option_numrec') === false) ? add_option(
									'syg_option_numrec',
									$_POST['syg_option_numrec'])
									: update_option('syg_option_numrec',
											$_POST['syg_option_numrec']);
														
							(get_option('syg_option_use_fb2') === false) ? add_option(
									'syg_option_use_fb2',
									$_POST['syg_option_use_fb2'])
									: update_option('syg_option_use_fb2',
											$_POST['syg_option_use_fb2']);
							
							(get_option('syg_option_use_fb2_url') === false) ? add_option(
									'syg_option_use_fb2_url',
									$_POST['syg_option_use_fb2_url'])
									: update_option('syg_option_use_fb2_url',
											$_POST['syg_option_use_fb2_url']);
					
							(get_option('syg_option_pagenumrec') === false) ? add_option(
									'syg_option_pagenumrec',
									$_POST['syg_option_pagenumrec'])
									: update_option('syg_option_pagenumrec',
											$_POST['syg_option_pagenumrec']);
							
							(get_option('syg_option_paginationarea') === false) ? add_option(
									'syg_option_paginationarea',
									$_POST['syg_option_paginationarea'])
									: update_option('syg_option_paginationarea',
											$_POST['syg_option_paginationarea']);
							
							(get_option('syg_option_description_length') === false) ? add_option(
									'syg_option_description_length',
									$_POST['syg_option_description_length'])
									: update_option('syg_option_description_length',
											$_POST['syg_option_description_length']);
					
							(get_option('syg_option_paginator_borderradius') === false) ? add_option(
									'syg_option_paginator_borderradius',
									$_POST['syg_option_paginator_borderradius'])
									: update_option('syg_option_paginator_borderradius',
											$_POST['syg_option_paginator_borderradius']);
							
							(get_option('syg_option_paginator_bordersize') === false) ? add_option(
									'syg_option_paginator_bordersize',
									$_POST['syg_option_paginator_bordersize'])
									: update_option('syg_option_paginator_bordersize',
											$_POST['syg_option_paginator_bordersize']);
							
							(get_option('syg_option_paginator_bordercolor') === false) ? add_option(
									'syg_option_paginator_bordercolor',
									$_POST['syg_option_paginator_bordercolor'])
									: update_option('syg_option_paginator_bordercolor',
											$_POST['syg_option_paginator_bordercolor']);
							
							(get_option('syg_option_paginator_bgcolor') === false) ? add_option(
									'syg_option_paginator_bgcolor',
									$_POST['syg_option_paginator_bgcolor'])
									: update_option('syg_option_paginator_bgcolor',
											$_POST['syg_option_paginator_bgcolor']);
							
							(get_option('syg_option_paginator_shadowcolor') === false) ? add_option(
									'syg_option_paginator_shadowcolor',
									$_POST['syg_option_paginator_shadowcolor'])
									: update_option('syg_option_paginator_shadowcolor',
											$_POST['syg_option_paginator_shadowcolor']);
							
							(get_option('syg_option_paginator_shadowsize') === false) ? add_option(
									'syg_option_paginator_shadowsize',
									$_POST['syg_option_paginator_shadowsize'])
									: update_option('syg_option_paginator_shadowsize',
											$_POST['syg_option_paginator_shadowsize']);
							
							(get_option('syg_option_paginator_fontcolor') === false) ? add_option(
									'syg_option_paginator_fontcolor',
									$_POST['syg_option_paginator_fontcolor'])
									: update_option('syg_option_paginator_fontcolor',
											$_POST['syg_option_paginator_fontcolor']);
							
							(get_option('syg_option_paginator_fontsize') === false) ? add_option(
									'syg_option_paginator_fontsize',
									$_POST['syg_option_paginator_fontsize'])
									: update_option('syg_option_paginator_fontsize',
											$_POST['syg_option_paginator_fontsize']);
							
							// 3d carousel section
							(get_option('syg_option_carousel_autorotate') === false) ? add_option(
									'syg_option_carousel_autorotate',
									$_POST['syg_option_carousel_autorotate'])
									: update_option('syg_option_carousel_autorotate',
											$_POST['syg_option_carousel_autorotate']);
							
							(get_option('syg_option_carousel_delay') === false) ? add_option(
									'syg_option_carousel_delay',
									$_POST['syg_option_carousel_delay'])
									: update_option('syg_option_carousel_delay',
											$_POST['syg_option_carousel_delay']);
							
							(get_option('syg_option_carousel_fps') === false) ? add_option(
									'syg_option_carousel_fps',
									$_POST['syg_option_carousel_fps'])
									: update_option('syg_option_carousel_fps',
											$_POST['syg_option_carousel_fps']);
							
							(get_option('syg_option_carousel_speed') === false) ? add_option(
									'syg_option_carousel_speed',
									$_POST['syg_option_carousel_speed'])
									: update_option('syg_option_carousel_speed',
											$_POST['syg_option_carousel_speed']);
							
							(get_option('syg_option_carousel_minscale') === false) ? add_option(
									'syg_option_carousel_minscale',
									$_POST['syg_option_carousel_minscale'])
									: update_option('syg_option_carousel_minscale',
											$_POST['syg_option_carousel_minscale']);
							
							(get_option('syg_option_carousel_reflheight') === false) ? add_option(
									'syg_option_carousel_reflheight',
									$_POST['syg_option_carousel_reflheight'])
									: update_option('syg_option_carousel_reflheight',
											$_POST['syg_option_carousel_reflheight']);
							
							(get_option('syg_option_carousel_reflgap') === false) ? add_option(
									'syg_option_carousel_reflgap',
									$_POST['syg_option_carousel_reflgap'])
									: update_option('syg_option_carousel_reflgap',
											$_POST['syg_option_carousel_reflgap']);
							
							(get_option('syg_option_carousel_reflopacity') === false) ? add_option(
									'syg_option_carousel_reflopacity',
									$_POST['syg_option_carousel_reflopacity'])
									: update_option('syg_option_carousel_reflopacity',
											$_POST['syg_option_carousel_reflopacity']);
							
							$this->data['redirect_url'] = '?page='
							. SygConstant::BE_ACTION_MANAGE_SETTINGS . '&modified=true';
							
							// render adminStyles view
							return $this->render('redirect');
						} catch (SygValidateException $ex) {
							// set the error
							$this->data['exception'] = true;
							$this->data['exception_message'] = $ex->getMessage();
							$this->data['exception_detail'] = $ex->getProblems();
						} catch (Exception $ex) {
							// set the error
							$this->data['exception'] = true;
							$this->data['exception_message'] = $ex->getMessage();
						}
					}
					break;	
			}
			
			// prepare header
			$this->prepareHeader($this->data, SygConstant::SYG_CTX_BE);
	
			// get settings
			$options = $this->getOptions();
	
			// put settings in the view
			$this->data['options'] = $options;
	
			// render adminSettings view
			return $this->render('adminSettings');
		}
	}

	/**
	 * @name forwardToAddGallery
	 * @category admin forward
	 * @since 1.0.1
	 * @return $output
	 */
	public function forwardToAddGallery() {
		$updated = false;
		if (!empty($_POST) && check_admin_referer('gallery','nonce_field')) {
			if (isset($_POST['syg_submit_hidden'])	&& $_POST['syg_submit_hidden'] == 'Y') {
				// database add gallery procedure
				// get posted values
				$data = serialize($_POST);
	
				try {
					// validate data
					$valid = SygValidate::validateGallery($data);
	
					// create a new gallery
					$gallery = new SygGallery($data);
	
					// update db
					$id = $this->sygDao->addSygGallery($gallery);
	
					// reload the gallery
					$gallery = $this->sygDao->getSygGalleryById($id);
					
					// updated flag
					$updated = true;
	
					// updated flag
					$this->data['updated'] = $updated;
	
					if ($gallery->getCacheOn()) {
						// cache gallery
						$gallery->cacheGallery();
					}
					
					// render adminGallery view
					return $this->forwardToGalleries($updated);
				} catch (SygValidateException $ex) {
					// set the error
					$this->data['exception'] = true;
					$this->data['exception_message'] = $ex->getMessage();
					$this->data['exception_detail'] = $ex->getProblems();
				} catch (Exception $ex) {
					// set the error
					$this->data['exception'] = true;
					$this->data['exception_message'] = $ex->getMessage();
				}
			}
		}
			
		// gallery administration form section
		// prepare header
		$this->prepareHeader($this->data, SygConstant::SYG_CTX_BE);

		// put an empty gallery in the view
		$this->data['gallery'] = new SygGallery();

		// put styles to populate combo
		$this->data['styles'] = $this->sygDao->getAllSygStyles();

		// render adminGallery view
		return $this->render('adminGallery');
	}

	/**
	 * @name forwardToAddStyle
	 * @category admin forward
	 * @since 1.0.1
	 * @return $output
	 */
	public function forwardToAddStyle() {
		$updated = false;
		if (!empty($_POST) && check_admin_referer('style','nonce_field')) {
			if (isset($_POST['syg_submit_hidden']) && $_POST['syg_submit_hidden'] == 'Y') {
				// database add style procedure
				// get posted values
				$data = serialize($_POST);
	
				try {
					// validate data
					$valid = SygValidate::validateStyle($data);
	
					// create a new gallery
					$style = new SygStyle($data);
	
					// update db
					$this->sygDao->addSygStyle($style);
	
					// updated flag
					$updated = true;
	
					// updated flag
					$this->data['updated'] = $updated;
	
					// render adminGallery view
					return $this->forwardToStyles($updated);
				} catch (SygValidateException $ex) {
					// set the error
					$this->data['exception'] = true;
					$this->data['exception_message'] = $ex->getMessage();
					$this->data['exception_detail'] = $ex->getProblems();
				} catch (Exception $ex) {
					// set the error
					$this->data['exception'] = true;
					$this->data['exception_message'] = $ex->getMessage();
				}
			}
		}
		// gallery administration form section
		// prepare header
		$this->prepareHeader($this->data, SygConstant::SYG_CTX_BE);

		// put an empty gallery in the view
		$this->data['style'] = new SygStyle();

		// render adminGallery view
		return $this->render('adminStyle');
	}

	/**
	 * @name forwardToEditGallery
	 * @category admin forward
	 * @since 1.0.1
	 * @return $output
	 */
	public function forwardToEditGallery() {
		$updated = false;
		if (!empty($_POST) && check_admin_referer('gallery','nonce_field')) {
			if (isset($_POST['syg_submit_hidden'])	&& $_POST['syg_submit_hidden'] == 'Y') {
				// database update procedure
				// get posted values
				$data = serialize($_POST);
	
				try {
					// validate data
					$valid = SygValidate::validateGallery($data);
	
					// create a new gallery
					$gallery = new SygGallery($data);
					
					// update db
					$this->sygDao->updateSygGallery($gallery);
	
					// updated flag
					$updated = true;
	
					// updated flag
					$this->data['updated'] = $updated;
					
					if ($gallery->getCacheOn()) {
						// cache gallery
						$gallery->cacheGallery();
					} else {
						$gallery->removeFromCache();
					}
					
					// render adminGallery view
					return $this->forwardToGalleries($updated);
				} catch (SygValidateException $ex) {
					// set the error
					$this->data['exception'] = true;
					$this->data['exception_message'] = $ex->getMessage();
					$this->data['exception_detail'] = $ex->getProblems();
				} catch (Exception $ex) {
					// set the error
					$this->data['exception'] = true;
					$this->data['exception_message'] = $ex->getMessage();
				}
			}
		}
		// get the gallery id
		$id = (int) $_GET['id'];

		// prepare header
		$this->prepareHeader($this->data, SygConstant::SYG_CTX_BE);

		// put gallery in the view
		$this->data['gallery'] = $this->sygDao->getSygGalleryById($id);

		// put styles to populate combo
		$this->data['styles'] = $this->sygDao->getAllSygStyles();

		// render adminGallery view
		return $this->render('adminGallery');
	}

	/**
	 * @name forwardToEditStyle
	 * @category admin forward
	 * @since 1.0.1
	 * @return $output
	 */
	public function forwardToEditStyle() {
		$updated = false;
		if (!empty($_POST) && check_admin_referer('style','nonce_field')) {
			if (isset($_POST['syg_submit_hidden'])	&& $_POST['syg_submit_hidden'] == 'Y') {
				// database update procedure
				// get posted values
				$data = serialize($_POST);
	
				try {
					// validate data
					$valid = SygValidate::validateStyle($data);
	
					// create a new gallery
					$style = new SygStyle($data);
	
					// update db
					$this->sygDao->updateSygStyle($style);
	
					// updated flag
					$updated = true;
	
					// updated flag
					$this->data['updated'] = $updated;
	
					// render adminStyle view
					return $this->forwardToStyles($updated);
	
				} catch (SygValidateException $ex) {
					// set the error
					$this->data['exception'] = true;
					$this->data['exception_message'] = $ex->getMessage();
					$this->data['exception_detail'] = $ex->getProblems();
				} catch (Exception $ex) {
					// set the error
					$this->data['exception'] = true;
					$this->data['exception_message'] = $ex->getMessage();
				}
			}
		}
		// get the style id
		$id = (int) $_GET['id'];

		// prepare header
		$this->prepareHeader($this->data, SygConstant::SYG_CTX_BE);

		// put style in the view
		$this->data['style'] = $this->sygDao->getSygStyleById($id);

		// render adminStyle view
		return $this->render('adminStyle');

	}

	/**
	 * @name forwardToDeleteGallery
	 * @category admin forward
	 * @since 1.0.1
	 */
	public function forwardToDeleteGallery() {
		if (current_user_can('delete_pages')) {
			// get the gallery id
			$id = (int) $_GET['id'];
			
			// get the gallery
			$gallery = $this->sygDao->getSygGalleryById($id);
			
			// remove file from cache
			$gallery->removeFromCache();
			
			// delete gallery
			$this->sygDao->deleteSygGallery($gallery);
			
			die();
		}
	}
	
	/**
	 * @name forwardToCacheGallery
	 * @category admin forward
	 * @since 1.4.0
	 */
	public function forwardToCacheGallery() {
		if (current_user_can('edit_posts')) {
			// get the gallery id
			$id = (int) $_GET['id'];
			
			// get the gallery
			$gallery = $this->sygDao->getSygGalleryById($id);
			
			// cache gallery
			$gallery->cacheGallery();
			
			die();
		}
	}

	/**
	 * @name forwardToDeleteStyle
	 * @category admin forward
	 * @since 1.0.1
	 */
	public function forwardToDeleteStyle() {
		if (current_user_can('delete_pages')) {
			// get the gallery id
			$id = (int) $_GET['id'];
	
			// delete gallery
			$this->sygDao->deleteSygStyle($this->sygDao->getSygStyleById($id));
	
			die();
		}
	}

	/**
	 * @name forwardToSupport
	 * @category admin forward
	 * @since 1.0.1
	 * @return $output
	 */
	public function forwardToSupport() {
		if (current_user_can('edit_posts')) {
			// prepare header
			$this->prepareHeader($this->data, SygConstant::SYG_CTX_BE);
	
			// render contact view
			return $this->render('adminSupport');
		}
	}

	/******************************/
	/* END ADMIN SECTION FORWARDS */
	/******************************/

	/********************/
	/* SECURITY METHODS */
	/********************/

	/**
	 * @name getOptions
	 * @category get plugin options
	 * @since 1.3.0
	 * @return array $options
	 */
	public function getOptions() {
		$options = array();
		
		/********************
		 * General settings *
		********************/
		$options['syg_option_askcache'] = get_option('syg_option_askcache');
		$options['syg_option_description_length'] = get_option('syg_option_description_length');
		$options['syg_option_numrec'] = get_option('syg_option_numrec');
		$options['syg_option_use_fb2'] = get_option('syg_option_use_fb2');
		$options['syg_option_use_fb2_url'] = get_option('syg_option_use_fb2_url');
		
		/********************
		 * YouTube settings *
		********************/
		$options['syg_option_apikey'] = SygConstant::SYG_DEV_KEY;
		$options['syg_option_which_thumb'] = get_option('syg_option_which_thumb');

		/*********************************
		 * Video page component settings *
		**********************************/
		$options['syg_option_pagenumrec'] = get_option('syg_option_pagenumrec');
		$options['syg_option_paginationarea'] = get_option('syg_option_paginationarea');
		$options['syg_option_paginator_borderradius'] = get_option('syg_option_paginator_borderradius');
		$options['syg_option_paginator_bordersize'] = get_option('syg_option_paginator_bordersize');
		$options['syg_option_paginator_bordercolor'] = get_option('syg_option_paginator_bordercolor');
		$options['syg_option_paginator_bgcolor'] = get_option('syg_option_paginator_bgcolor');
		$options['syg_option_paginator_shadowcolor'] = get_option('syg_option_paginator_shadowcolor');
		$options['syg_option_paginator_fontcolor'] = get_option('syg_option_paginator_fontcolor');
		$options['syg_option_paginator_shadowsize'] = get_option('syg_option_paginator_shadowsize');
		$options['syg_option_paginator_fontsize'] = get_option('syg_option_paginator_fontsize');

		/******************************
		 * 3d cloud carousel settings *
		*******************************/
		$options['syg_option_carousel_autorotate'] = get_option('syg_option_carousel_autorotate');
		$options['syg_option_carousel_delay'] = get_option('syg_option_carousel_delay');
		$options['syg_option_carousel_fps'] = get_option('syg_option_carousel_fps');
		$options['syg_option_carousel_speed'] = get_option('syg_option_carousel_speed');
		$options['syg_option_carousel_minscale'] = get_option('syg_option_carousel_minscale');
		$options['syg_option_carousel_reflheight'] = get_option('syg_option_carousel_reflheight');
		$options['syg_option_carousel_reflgap'] = get_option('syg_option_carousel_reflgap');
		$options['syg_option_carousel_reflopacity'] = get_option('syg_option_carousel_reflopacity');
		
		/*********************************
		 * additional javascript options *
		**********************************/
		$options['syg_option_plugin_url'] = WP_PLUGIN_URL;
		
		return $options;
	}
	
	public function getJsOptions() {
		$this->data['syg_options'] = json_encode($this->getOptions());
		// render jsOption view
		return $this->render('jsOption');
	}

	/************************/
	/* END SECURITY METHODS */
	/************************/
}
?>