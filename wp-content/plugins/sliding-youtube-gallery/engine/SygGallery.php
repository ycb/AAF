<?php

/**
 * @name Sliding Youtube Gallery Plugin Gallery Data Bean
 * @category Sliding Youtube Gallery Object
 * @since 1.0.1
 * @author: Luca Martini @ webEng
 * @license: GNU GPLv3 - http://www.gnu.org/copyleft/gpl.html
 * @version: 1.4.4
 */

class SygGallery {
	// plugin objects
	private $sygYouTube;
	private $sygDao;
	private $sygStyle;
	private $userProfile;

	// set path for caching
	private $jsonPath;
	private $thumbnailsPath;
	private $htmlPath;
	private $jsPath;
	
	// this object attributes
	private $galleryName;
	private $galleryDetails;
	private $galleryType;
	private $cacheExists;
	private $ytVideoFormat;
	private $ytMaxVideoCount;
	private $ytDisableRelatedVideo;
	private $ytSrc;
	private $styleId;
	private $descShow;
	private $descShowDuration;
	private $descShowTags;
	private $descShowRatings;
	private $descShowCategories;
	private $cacheOn;
	private $id;
	
	// other attributes
	private $thumbUrl;
	
	// recordset type
	public static $rsType = array('%s','%s','%s','%d','%d','%d','%d','%d','%d','%s','%s','%d','%d','%d','%d');
	
	// attribute to exclude in serialization
	public $exclude = array('sygYouTube', 'sygDao', 'userProfile', 'jsonPath', 'thumbnailsPath', 'htmlPath', 'jsPath', 'rsType', 'exclude');
	
	/**
	 * @name __construct
	 * @category construct SygGallery object
	 * @since 1.0.1
	 * @param $key
	 */
	public function __construct($key = null) {
		if (is_string($key)) $key = unserialize ($key);
		$this->sygYouTube = new SygYouTube();
		$this->sygDao = new SygDao();		
		$this->mapThis($key);
	}

	/**
	 * @name mapThis
	 * @category data object mapping from resultset 
	 * @since 1.0.1
	 * @param $result
	 */
	private function mapThis($result = null) {
		$result = (object) $result;
		
		// id
		$this->setId($result->id);
		
		$this->setGalleryName($result->syg_gallery_name);
		$this->setGalleryDetails($result->syg_gallery_details);
		
		// youtube option values
		$this->setYtMaxVideoCount($result->syg_youtube_maxvideocount);
		$this->setYtVideoFormat($result->syg_youtube_videoformat);
		$this->setYtDisableRelatedVideo($result->syg_youtube_disablerel);
		$this->setYtSrc($result->syg_youtube_src);
		// running with caching?
		$this->setCacheOn($result->syg_youtube_cacheon);
		
		// set youtube user profile
		($result->syg_gallery_type) ? $this->setGalleryType($result->syg_gallery_type) : $this->setGalleryType('feed');
		
		if ((($this->getGalleryType() == 'feed') && (!$this->getId())) || ($this->getGalleryType() != 'feed')) {
			$this->setUserProfile(null);
		} else {
			$this->setUserProfile($this->sygYouTube->getUserProfile($this->getYtSrc()));
		}
		
		// description option values
		$this->setDescShow($result->syg_description_show);
		$this->setDescShowCategories($result->syg_description_showcategories);
		$this->setDescShowDuration($result->syg_description_showduration);
		$this->setDescShowRatings($result->syg_description_showratings);
		$this->setDescShowTags($result->syg_description_showtags);
		
		// set style id
		$this->setStyleId($result->syg_style_id);
		
		// load style setting
		$this->sygStyle = $this->sygDao->getSygStyleById($this->getStyleId());
		
		// load the caching path
		$this->setThumbnailsPath(realpath(dirname(dirname(__FILE__))) . SygConstant::WP_CACHE_THUMB_REL_DIR . $this->getId() . DIRECTORY_SEPARATOR);
		$this->setHtmlPath(realpath(dirname(dirname(__FILE__))) . SygConstant::WP_CACHE_HTML_REL_DIR . $this->getId() . DIRECTORY_SEPARATOR);
		$this->setJsonPath(realpath(dirname(dirname(__FILE__))) . SygConstant::WP_CACHE_JSON_REL_DIR . $this->getId() . DIRECTORY_SEPARATOR);
		$this->setJsPath(realpath(dirname(dirname(__FILE__))) . SygConstant::WP_CACHE_JS_REL_DIR . $this->getId() . DIRECTORY_SEPARATOR);
		
		// see if exists cache directory
		if ($this->isGalleryCached()) {
			$this->setCacheExists('YES');
		} else {
			$this->setCacheExists('NO');
		}
	}
	
	/**
	 * @name countGalleryEntry
	 * @category count feed element for this gallery
	 * @since 1.3.0
	 * @return int $count
	 */
	public function countGalleryEntry() {
		return $this->sygYouTube->countVideoEntry ($this);
	}
	
	/**
	 * @name getJsonData 
	 * @category object data parser
	 * @since 1.0.1
	 * @return string $json
	 */
	function getJsonData(){
		// get object attributes
		$var = get_object_vars($this);
		
		// json data to return
		$jsonData = array();
		
		// get excluded data from serialization
		$exclude = $this->getExclude();
		
		// walk over array and unset keys located in the exclude array
		foreach ($var as $key => $value) {
			if (!in_array($key, $exclude)) {
				if ($value instanceof SygStyle) {
					$jsonData[$key] = $value->getJsonData();
				} else {
					$jsonData[$key] = $value;
				}
			} 
		}		
		
		$json = $jsonData;
		return $json;
	}
	
	/**
	 * @name 
	 * @category object data parser
	 * @since 1.0.1
	 * @param $full, if true export gallery with its owned style
	 * @return array $dto
	 */
	public function toDto($full = false) {
		$dto = array(
				'syg_gallery_name'					=> $this->getGalleryName(),
				'syg_gallery_details'				=> $this->getGalleryDetails(),
				'syg_gallery_type'					=> $this->getGalleryType(),
				'syg_description_show'				=> $this->getDescShow(),
				'syg_description_showcategories'	=> $this->getDescShowCategories(),
				'syg_description_showduration'		=> $this->getDescShowDuration(),
				'syg_description_showratings'		=> $this->getDescShowRatings(),
				'syg_description_showtags' 			=> $this->getDescShowTags(),
				'syg_youtube_maxvideocount'			=> $this->getYtMaxVideoCount(),
				'syg_youtube_videoformat'			=> $this->getYtVideoFormat(),
				'syg_youtube_src'					=> $this->getYtSrc(),
				'syg_style_id'						=> $this->getStyleId(),
				'syg_youtube_cacheon'				=> $this->getCacheOn(),
				'syg_youtube_disablerel'			=> $this->getYtDisableRelatedVideo(),
				'id'								=> $this->getId());
		
		if ($full) {
			$full_array = $dto;
			
			$full_array['syg_box_background'] = $this->getSygStyle()->getBoxBackground();
			$full_array['syg_box_padding'] = $this->getSygStyle()->getBoxPadding();
			$full_array['syg_box_radius'] = $this->getSygStyle()->getBoxRadius();
			$full_array['syg_box_width'] = $this->getSygStyle()->getBoxWidth();
			$full_array['syg_description_fontcolor'] = $this->getSygStyle()->getDescFontColor();
			$full_array['syg_description_fontsize']	= $this->getSygStyle()->getDescFontSize();
			$full_array['syg_description_width'] = $this->getSygStyle()->getDescWidth();
			$full_array['syg_thumbnail_bordercolor'] = $this->getSygStyle()->getThumbBorderColor();
			$full_array['syg_thumbnail_borderradius'] = $this->getSygStyle()->getThumbBorderRadius();
			$full_array['syg_thumbnail_bordersize']	= $this->getSygStyle()->getThumbBorderSize();
			$full_array['syg_thumbnail_buttonopacity'] = $this->getSygStyle()->getThumbButtonOpacity();
			$full_array['syg_thumbnail_distance'] = $this->getSygStyle()->getThumbDistance();
			$full_array['syg_thumbnail_height']	= $this->getSygStyle()->getThumbHeight();
			$full_array['syg_thumbnail_image'] = $this->getSygStyle()->getThumbImage();
			$full_array['syg_thumbnail_width'] = $this->getSygStyle()->getThumbWidth();
			$full_array['syg_thumbnail_overlaysize'] = $this->getSygStyle()->getThumbOverlaySize();
			$full_array['syg_thumbnail_top'] = $this->getSygStyle()->getThumbTop();
			$full_array['syg_thumbnail_left'] = $this->getSygStyle()->getThumbLeft();
			$full_array['syg_thumbnail_url'] = $this->getSygStyle()->getThumbUrl();
			
			$dto = $full_array;
		}

		return $dto;
	}
	
	/**
	 * @name isGalleryCached
	 * @category check if a gallery is cached
	 * @since 1.4.0
	 * @return bool
	 */
	public function isGalleryCached() {
		return ((is_dir($this->getThumbnailsPath())) && (is_dir($this->getHtmlPath())) && (is_dir($this->getJsonPath()))) ? true : false;
	}
	
	/**
	 * @name cacheGallery
	 * @category cache thumbnails and html into file system
	 * @since 1.4.0
	 * @param SygGallery $gallery
	 */
	public function cacheGallery() {		
		// local plugin instance
		$syg = SygPlugin::getInstance();
		
		// get the style 
		$style = $this->getSygStyle();
		
		// get the id of the button
		$thumbImg = $style->getThumbImage();
		
		// get overlay button
		$overlaySrc = (!empty($thumbImg)) ? $syg->getImgRoot() . '/button/'.$style->getThumbOverlaySize().'/play-' . $thumbImg .'.png' : $syg->getImgRoot() . '/button/'.$style->getThumbOverlaySize().'/play-1.png';
		
		// get the feed
		$feed = $this->sygYouTube->getVideoFeed($this);
		
		// get the options
		$options = $syg->getOptions();
		
		// create directory if not exist
		if (!$this->isGalleryCached()) {
			// create directory
			mkdir($this->getJsonPath());
			chmod($this->getJsonPath(), 0755);
			// create directory
			mkdir($this->getThumbnailsPath());
			chmod($this->getThumbnailsPath(), 0755);
			// create directory
			mkdir($this->getHtmlPath());
			chmod($this->getHtmlPath(), 0755);
		}
		
		// cache video thumbnails from youtube
		foreach ($feed as $element) {
			$videoThumbnails = $element->getVideoThumbnails();
			$imgUrl = $videoThumbnails[$options['syg_option_which_thumb']]['url'];
			$localFN = $element->getVideoId().".jpg";
			
			if (extension_loaded('gd') && function_exists('gd_info')) {				
				// write resized image
				SygUtil::writeResizedImage($imgUrl, $this->getThumbnailsPath().$localFN, null, $style->getThumbWidth().'x'.$style->getThumbHeight());
				
				// add play button overlay
				SygUtil::addOverlayButton($this->getThumbnailsPath().$localFN, $overlaySrc, $style);
			} else if (SygUtil::isCurlInstalled()) {
				// curl enabled
				$ch = curl_init($imgUrl);
				$fp = fopen($this->getThumbnailsPath().$localFN, 'wb');
				curl_setopt($ch, CURLOPT_FILE, $fp);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_exec($ch);
				curl_close($ch);
				fclose($fp);
			} else if (ini_get('allow_url_fopen')) {
				// allow url fopen
				file_put_contents($this->getThumbnailsPath().$localFN, file_get_contents($imgUrl));
			} else { null; }
			
			// chmod file
			chmod ($this->getThumbnailsPath().$localFN, 0755);
		}
	
		// get the plugin singleton
		$syg = SygPlugin::getInstance();
		
		// cache the html of the gallery
		$galleryHtml = $syg->getGallery(array('id' => $this->getId()), SygConstant::SYG_PLUGIN_FE_CACHING_MODE);
		$localFN = SygConstant::SYG_PLUGIN_COMPONENT_GALLERY.'-'.$this->getId().".html";
		file_put_contents($this->getHtmlPath().$localFN, $galleryHtml);
		chmod ($this->getHtmlPath().$localFN, 0755);
		
		// cache the html of the carousel
		$carouselHtml = $syg->getVideoCarousel(array('id' => $this->getId()), SygConstant::SYG_PLUGIN_FE_CACHING_MODE);
		$localFN = SygConstant::SYG_PLUGIN_COMPONENT_CAROUSEL.'-'.$this->getId().".html";
		file_put_contents($this->getHtmlPath().$localFN, $carouselHtml);
		chmod ($this->getHtmlPath().$localFN, 0755);
		
		// cache the html of the page
		$galleryPage = $syg->getVideoPage(array('id' => $this->getId()), SygConstant::SYG_PLUGIN_FE_CACHING_MODE);
		$localFN = SygConstant::SYG_PLUGIN_COMPONENT_PAGE.'-'.$this->getId().".html";
		file_put_contents($this->getHtmlPath().$localFN, $galleryPage);
		chmod ($this->getHtmlPath().$localFN, 0755);
		
		// cache json page
		$options = $syg->getOptions();
		$per_page = $options['syg_option_pagenumrec']; // Per page records
		$maxVideoCount = $this->getYtMaxVideoCount();
		$numVid = $this->sygYouTube->countVideoEntry($this);
	
		$no_of_paginations = ceil ($numVid / $per_page);
		for ($i=1;$i<=$no_of_paginations;$i++) {
			$url = $syg->getJsonQueryIfUrl().'?query=videos&page_number='.$i.'&id='.$this->getId().'&syg_option_which_thumb='.$options['syg_option_which_thumb'].'&syg_option_pagenumrec='.$per_page.'&mode='.SygConstant::SYG_PLUGIN_FE_CACHING_MODE;
			$localFN = $i.'.json';
			file_put_contents($this->getJsonPath().$localFN, file_get_contents($url));
			chmod ($this->getJsonPath().$localFN, 0755);
		}
		
		// delete javascript cache
		SygUtil::removeDirectory($this->getJsPath());
	}
	
	/**
	 * @name removeFromCache
	 * @category cache thumbnails and html into file system
	 * @since 1.4.0
	 * @param SygGallery $gallery
	 */
	public function removeFromCache($what = 'all') {
		// remove directory
		if ($what == 'all' || $what == 'json') SygUtil::removeDirectory($this->getJsonPath());
		// remove directory
		if ($what == 'all' || $what == 'thumb') SygUtil::removeDirectory($this->getThumbnailsPath());
		// remove directory
		if ($what == 'all' || $what == 'html') SygUtil::removeDirectory($this->getHtmlPath());
		// remove directory
		if ($what == 'all' || $what == 'js') SygUtil::removeDirectory($this->getJsPath());
	}
	
	/**
	 * @name sanitizeYouTubeSource
	 * @category sanitize a given youtube resource (url)
	 * @since 1.3.3
	 */
	public function sanitizeYouTubeSource() {
		switch ($this->getGalleryType()) {
			case "feed":
				// null
				break;
			case "list":
				// check for every video
				$list_of_videos = preg_split('/\r\n|\r|\n/', $this->getYtSrc());
				
				// init buffer
				$buffer = '';
				// init counter
				$i = 1;
				// remove empty elements
				$list_of_videos = array_filter($list_of_videos, 'strlen');
				// count videos
				$count = count($list_of_videos);
				
				foreach ($list_of_videos as $key => $value) {
					$qsUrl = $list_of_videos[$key];
						
					// parse query string
					$qsArr = array();
					parse_str (parse_url($qsUrl, PHP_URL_QUERY), $qsArr);

					// parse host 
					$host = parse_url($qsUrl, PHP_URL_HOST);
					
					// parse path
					$path = parse_url($qsUrl, PHP_URL_PATH);
					
					// get video id
					$videoId = $qsArr['v'];
					
					if (!empty($videoId)) {
						$qs = '?v='.$videoId;
					
						// set the sane url into buffer
						$saneUrl = $host.$path.$qs;
						$buffer .= ($i < $count) ? $saneUrl.PHP_EOL : $saneUrl;
					}
					
					$i++;
				}
				
				// override youtube src with sanitized one
				$this->setYtSrc($buffer);
				
				break;
			case "playlist":
				$qsUrl = $this->getYtSrc();
						
				// parse query string
				$qsArr = array();
				parse_str (parse_url($qsUrl, PHP_URL_QUERY), $qsArr);
						
				// get video id
				$pId = $qsArr['list'];
						
				// check for the playlist http://www.youtube.com/playlist?list=PLB53095C7A4A6F63D
				// $playlist_id = str_replace('list=PL', '', parse_url($data['syg_youtube_src'], PHP_URL_QUERY));
				$stdPlUrl = 'http://www.youtube.com/playlist?list='.$pId;
				
				$this->setYtSrc($stdPlUrl);
				
				break;
			default:
				break;
		}
	}
	
	/**
	 * @name getRsType
	 * @category getters and setters
	 * @since 1.0.1
	 * @return array $rsType
	 */
	public static function getRsType() {
		return SygGallery::$rsType;
	}
	
	/**
	 * @name getSygStyle
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $sygStyle
	 */
	public function getSygStyle() {
		return $this->sygStyle;
	}

	/**
	 * @name setSygStyle
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $sygStyle
	 */
	public function setSygStyle($sygStyle) {
		$this->sygStyle = $sygStyle;
	}

	/**
	 * @name getUserProfile
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $userProfile
	 */
	public function getUserProfile() {
		return $this->userProfile;
	}

	/**
	 * @name setUserProfile
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $userProfile
	 */
	public function setUserProfile($userProfile) {
		$this->userProfile = $userProfile;
		if ($this->userProfile) { 
			$this->thumbUrl = $userProfile->getThumbnail()->getUrl();
		} else {
			$this->thumbUrl = content_url() . SygConstant::BE_ICON_VIDEO_GALLERY;
		}
	}

	/**
	 * @name getYtVideoFormat
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $ytVideoFormat
	 */
	public function getYtVideoFormat() {
		return $this->ytVideoFormat;
	}

	/**
	 * @name setYtVideoFormat
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $ytVideoFormat
	 */
	public function setYtVideoFormat($ytVideoFormat) {
		$this->ytVideoFormat = $ytVideoFormat;
	}

	/**
	 * @name getYtMaxVideoCount
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $ytMaxVideoCount
	 */
	public function getYtMaxVideoCount() {
		return $this->ytMaxVideoCount;
	}

	/**
	 * @name setYtMaxVideoCount
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $ytMaxVideoCount
	 */
	public function setYtMaxVideoCount($ytMaxVideoCount) {
		$this->ytMaxVideoCount = $ytMaxVideoCount;
	}

	/**
	 * @name getYtSrc
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $ytSrc
	 */
	public function getYtSrc() {
		return $this->ytSrc;
	}

	/**
	 * @name setYtSrc
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $ytSrc
	 */
	public function setYtSrc($ytSrc) {
		$this->ytSrc = $ytSrc;
	}

	/**
	 * @name getStyleId
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $styleId
	 */
	public function getStyleId() {
		return $this->styleId;
	}

	/**
	 * @name setStyleId
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $styleId
	 */
	public function setStyleId($styleId) {
		$this->styleId = $styleId;
	}

	/**
	 * @name getYtSrc
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $ytSrc
	 */
	public function getDescShow() {
		return $this->descShow;
	}

	/**
	 * @name setDescShow
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $descShow
	 */
	public function setDescShow($descShow) {
		$this->descShow = $descShow;
	}

	/**
	 * @name getDescShowDuration
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $descShowDuration
	 */
	public function getDescShowDuration() {
		return $this->descShowDuration;
	}

	/**
	 * @name setDescShowDuration
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $descShowDuration
	 */
	public function setDescShowDuration($descShowDuration) {
		$this->descShowDuration = $descShowDuration;
	}

	/**
	 * @name getDescShowTags
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $descShowTags
	 */
	public function getDescShowTags() {
		return $this->descShowTags;
	}

	/**
	 * @name setDescShowTags
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $descShowTags
	 */
	public function setDescShowTags($descShowTags) {
		$this->descShowTags = $descShowTags;
	}

	/**
	 * @name getDescShowRatings
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $descShowRatings
	 */
	public function getDescShowRatings() {
		return $this->descShowRatings;
	}

	/**
	 * @name setDescShowRatings
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $descShowRatings
	 */
	public function setDescShowRatings($descShowRatings) {
		$this->descShowRatings = $descShowRatings;
	}

	/**
	 * @name getDescShowCategories
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $descShowCategories
	 */
	public function getDescShowCategories() {
		return $this->descShowCategories;
	}

	/**
	 * @name setDescShowCategories
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $descShowCategories
	 */
	public function setDescShowCategories($descShowCategories) {
		$this->descShowCategories = $descShowCategories;
	}

	/**
	 * @name getGalleryType
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $galleryType
	 */
	public function getGalleryType() {
		return $this->galleryType;
	}

	/**
	 * @name setGalleryType
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $galleryType
	 */
	public function setGalleryType($galleryType) {
		$this->galleryType = $galleryType;
	}

	/**
	 * @name getGalleryCached
	 * @category getters and setters
	 * @since 1.4.0
	 * @return the $galleryCached
	 */
	public function getCacheExists() {
		return $this->cacheExists;
	}

	/**
	 * @name setGalleryCached
	 * @param field_type $galleryCached
	 * @since 1.4.0
	 */
	public function setCacheExists($cacheExists) {
		$this->cacheExists = $cacheExists;
	}

	/**
	 * @name getId
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @name setId
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $id
	 */
	public function setId($id) {
		$this->id = $id;
	}
	
	/**
	 * @name getGalleryName
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $galleryName
	 */
	public function getGalleryName() {
		return $this->galleryName;
	}

	/**
	 * @name setGalleryName
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $galleryName
	 */
	public function setGalleryName($galleryName) {
		$this->galleryName = $galleryName;
	}

	/**
	 * @name getGalleryDetails
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $galleryDetails
	 */
	public function getGalleryDetails() {
		return $this->galleryDetails;
	}

	/**
	 * @name setGalleryDetails
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $galleryDetails
	 */
	public function setGalleryDetails($galleryDetails) {
		$this->galleryDetails = $galleryDetails;
	}
	
	/**
	 * @name getThumbUrl
	 * @category getters and setters
	 * @since 1.0.1
	 * @return the $thumbUrl
	 */
	public function getThumbUrl() {
		return $this->thumbUrl;
	}

	/**
	 * @name setThumbUrl
	 * @category getters and setters
	 * @since 1.0.1
	 * @param $thumbUrl
	 */
	public function setThumbUrl($thumbUrl) {
		$this->thumbUrl = $thumbUrl;
	}
	
	/**
	 * @name getYtDisableRelatedVideo
	 * @category getters and setters
	 * @since 1.3.0
	 * @return $ytDisableRelatedVideo
	 */
	public function getYtDisableRelatedVideo() {
		return $this->ytDisableRelatedVideo;
	}

	/**
	 * @name setYtDisableRelatedVideo
	 * @category getters and setters
	 * @since 1.3.0
	 * @param $ytDisableRelatedVideo
	 */
	public function setYtDisableRelatedVideo($ytDisableRelatedVideo) {
		$this->ytDisableRelatedVideo = $ytDisableRelatedVideo;
	}
	
	/**
	 * @name getJsonPath
	 * @category getters and setters
	 * @since 1.4.0
	 * @return the $jsonPath
	 */
	public function getJsonPath() {
		return $this->jsonPath;
	}
	
	/**
	 * @name setJsonPath
	 * @category getters and setters
	 * @since 1.4.0
	 * @param field_type $jsonPath
	 */
	private function setJsonPath($jsonPath) {
		$this->jsonPath = $jsonPath;
	}
	
	/**
	 * @name getThumbnailsPath
	 * @category getters and setters
	 * @since 1.4.0
	 * @return the $thumbnailsPath
	 */
	public function getThumbnailsPath() {
		return $this->thumbnailsPath;
	}
	
	/**
	 * @name setThumbnailsPath
	 * @category getters and setters
	 * @since 1.4.0
	 * @param field_type $thumbnailsPath
	 */
	private function setThumbnailsPath($thumbnailsPath) {
		$this->thumbnailsPath = $thumbnailsPath;
	}
	
	/**
	 * @name getHtmlPath
	 * @category getters and setters
	 * @since 1.4.0
	 * @return the $htmlPath
	 */
	public function getHtmlPath() {
		return $this->htmlPath;
	}
	
	/**
	 * @name setHtmlPath
	 * @category getters and setters
	 * @since 1.4.0
	 * @param field_type $htmlPath
	 */
	private function setHtmlPath($htmlPath) {
		$this->htmlPath = $htmlPath;
	}
	
	/**
	 * @return the $jsPath
	 */
	public function getJsPath() {
		return $this->jsPath;
	}

	/**
	 * @param field_type $jsPath
	 */
	public function setJsPath($jsPath) {
		$this->jsPath = $jsPath;
	}

	/**
	 * @return the $cacheOn
	 */
	public function getCacheOn() {
		return $this->cacheOn;
	}

	/**
	 * @param field_type $cacheOn
	 */
	public function setCacheOn($cacheOn) {
		$this->cacheOn = $cacheOn;
	}
	
	/**
	 * @return the $exclude
	 */
	public function getExclude() {
		return $this->exclude;
	}

	// magic functions
	
	public function __toString () {
		//@todo
	}
	
	public function __wakeup() {
		//@todo
	}
	
	public function __sleep() {
		//@todo
	}
}
?>