<?php

/**
 * @name SygValidateException
 * @category Sliding Youtube Gallery Custom Exception Class
 * @since 1.3.0
 * @author: Luca Martini @ webEng
 * @license: GNU GPLv3 - http://www.gnu.org/copyleft/gpl.html
 * @version: 1.4.4
 */

class SygValidateException extends Exception {

	private $problems;

	/**
	 * @name __construct
	 * @category construct SygValidateException object
	 * @since 1.3.0
	 * @param $problems
	 * @param $message
	 * @param $code
	 * @param $previous
	 */
	public function __construct($problems, $message, $code = 0,
			Exception $previous = null) {
		$this->setProblems($problems);

		if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
			parent::__construct($message, $code, $previous);
		} else {
			parent::__construct($message, $code);
		}
	}

	/**
	 * @name __toString
	 * @category return a string map which is representation of the object
	 * @since 1.3.0
	 * @throws Exception
	 * @return string $this
	 */
	public function __toString() {
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}

	/**
	 * @name getProblems
	 * @category getters and setters
	 * @since 1.3.0
	 * @return array $problemFound
	 */
	public function getProblems() {
		return $this->problems;
	}

	/**
	 * @name setProblems
	 * @category getters and setters
	 * @since 1.3.0
	 * @param $problemFound
	 */
	public function setProblems($problems) {
		$this->problems = $problems;
	}
}

/**
 * @name SygGalleryNotFoundException
 * @category Sliding Youtube Gallery Custom Exception Class
 * @since 1.3.0
 * @author: Luca Martini @ webEng
 * @license: GNU GPLv3 - http://www.gnu.org/copyleft/gpl.html
 * @version: 1.3.4
 */

class SygGalleryNotFoundException extends Exception {

	/**
	 * @name __construct
	 * @category construct SygValidateException object
	 * @since 1.3.4
	 * @param $problems
	 * @param $message
	 * @param $code
	 * @param $previous
	 */
	public function __construct($message, $code = 0, Exception $previous = null) {

		if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
			parent::__construct($message, $code, $previous);
		} else {
			parent::__construct($message, $code);
		}
	}

	/**
	 * @name __toString
	 * @category return a string map which is representation of the object
	 * @since 1.3.4
	 * @throws Exception
	 * @return string $this
	 */
	public function __toString() {
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}
}

/**
 * @name SygValidate
 * @category Sliding Youtube Gallery Validate Class
 * @since 1.2.5
 * @author: Luca Martini @ webEng
 * @license: GNU GPLv3 - http://www.gnu.org/copyleft/gpl.html
 * @version: 1.2.5
 */

class SygValidate {
	/**
	 * @name validateStyle
	 * @category style validation function
	 * @since 1.3.0
	 * @param $data array of style params to validate
	 * @throws SygValidateException
	 */
	public static function validateStyle($data) {
		// unserialize data
		$data = unserialize($data);

		// validation code
		$problemFound = array();

		// syg_style_name string
		if (!(preg_match('/^\s*\S.*$/', $data['syg_style_name']))) {
			array_push($problemFound,
					array('field' => SygUtil::getLabel('syg_style_name'),
							'msg' => SygConstant::BE_VALIDATE_STRING_NOT_EMPTY));
		}
		
		// syg_thumbnail_height integer
		if (!(preg_match('/^\d+$/', $data['syg_thumbnail_height']))) {
			array_push($problemFound,
					array('field' => SygUtil::getLabel('syg_thumbnail_height'),
							'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_NOT_A_INTEGER, $data['syg_thumbnail_height'])));
		}

		// syg_thumbnail_width integer
		if (!(preg_match('/^\d+$/', $data['syg_thumbnail_width']))) {
			array_push($problemFound,
					array('field' => SygUtil::getLabel('syg_thumbnail_width'),
							'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_NOT_A_INTEGER, $data['syg_thumbnail_width'])));
		}

		// syg_thumbnail_bordersize integer <= 10		
		if (!(preg_match('/^\d+$/', $data['syg_thumbnail_bordersize'])
				&& strval($data['syg_thumbnail_bordersize'] <= 10))) {
			if (!(preg_match('/^\d+$/', $data['syg_thumbnail_bordersize']))) {
				array_push($problemFound,
						array('field' => SygUtil::getLabel('syg_thumbnail_bordersize'),
								'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_NOT_A_INTEGER, $data['syg_thumbnail_bordersize'])));
			} else {
				if (!(strval($data['syg_thumbnail_bordersize']) <= 10)) {
					array_push($problemFound,
							array('field' => SygUtil::getLabel('syg_thumbnail_bordersize'),
									'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_NOT_LESS_VALUE, $data['syg_thumbnail_bordersize'], 10)));
				}
			}
		}

		// syg_thumbnail_borderradius integer <=20
		if (!(preg_match('/^\d+$/', $data['syg_thumbnail_borderradius'])
				&& strval($data['syg_thumbnail_borderradius'] <= 20))) {
			if (!(preg_match('/^\d+$/', $data['syg_thumbnail_bordersize']))) {
				array_push($problemFound,
						array('field' => SygUtil::getLabel('syg_thumbnail_borderradius'),
								'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_NOT_A_INTEGER, $data['syg_thumbnail_borderradius'])));
			} else {
				if (!(strval($data['syg_thumbnail_bordersize']) <= 20)) {
					array_push($problemFound,
							array('field' => SygUtil::getLabel('syg_thumbnail_borderradius'),
									'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_NOT_LESS_VALUE, $data['syg_thumbnail_bordersize'], 20)));
				}
			}
		}

		// syg_thumbnail_distance integer
		if (!(preg_match('/^\d+$/', $data['syg_thumbnail_distance']))) {
			array_push($problemFound,
					array('field' => SygUtil::getLabel('syg_thumbnail_distance'),
							'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_NOT_A_INTEGER, $data['syg_thumbnail_distance'])));
		}

		// syg_thumbnail_buttonopacity float tra 0 e 1
		if (!(preg_match('/\d+(\.\d{1,2})?/',
				$data['syg_thumbnail_buttonopacity'])
				&& strval($data['syg_thumbnail_buttonopacity']) >= 0
				&& strval($data['syg_thumbnail_buttonopacity']) <= 1)) {
			if (!(preg_match('/\d+(\.\d{1,2})?/',
					$data['syg_thumbnail_buttonopacity']))) {
				array_push($problemFound,
						array('field' => SygUtil::getLabel('syg_thumbnail_buttonopacity'),
								'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_NOT_A_FLOAT, $data['syg_thumbnail_buttonopacity'])));
			} else {
				if (!(strval($data['syg_thumbnail_buttonopacity']) >= 0
						&& strval($data['syg_thumbnail_buttonopacity']) <= 1)) {
					array_push($problemFound,
							array('field' => SygUtil::getLabel('syg_thumbnail_buttonopacity'),
									'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_NOT_IN_RANGE, $data['syg_thumbnail_buttonopacity'], 0, 1)));
				}
			}
		}

		// syg_box_width integer
		if (!(preg_match('/^\d+$/', $data['syg_box_width']))) {
			array_push($problemFound,
					array('field' => SygUtil::getLabel('syg_box_width'),
							'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_NOT_A_INTEGER, $data['syg_box_width'])));
		}

		// syg_box_radius integer <=20
		if (!(preg_match('/^\d+$/', $data['syg_box_radius'])
				&& (strval($data['syg_box_radius']) <= 20))) {
			if (!(preg_match('/^\d+$/', $data['syg_box_radius']))) {
				array_push($problemFound,
						array('field' => SygUtil::getLabel('syg_box_radius'),
								'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_NOT_A_INTEGER, $data['syg_box_radius'])));
			} else {
				if (!(strval($data['syg_box_radius']) <= 20)) {
					array_push($problemFound,
							array('field' => SygUtil::getLabel('syg_box_radius'),
									'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_NOT_LESS_VALUE, $data['syg_box_radius'], 20)));
				}
			}
		}

		// syg_box_padding integer
		if (!(preg_match('/^\d+$/', $data['syg_box_padding']))) {
			array_push($problemFound,
					array('field' => SygUtil::getLabel('syg_box_padding'),
							'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_NOT_A_INTEGER, $data['syg_box_padding'])));
		}

		// syg_description_fontsize integer
		if (!(preg_match('/^\d+$/', $data['syg_description_fontsize']))) {
			array_push($problemFound,
					array('field' => SygUtil::getLabel('syg_description_fontsize'),
							'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_NOT_A_INTEGER, $data['syg_description_fontsize'])));
		}
		
		// check overlay button proportion related to height
		if (!($data['syg_thumbnail_height'] - $data['syg_thumbnail_overlaysize'] >= 10)) {
			array_push($problemFound,
					array('field' => SygUtil::getLabel('syg_thumbnail_overlaysize'),
							'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_OVERLAY_BAD_DIMENSION, $data['syg_thumbnail_overlaysize'], SygUtil::getLabel('syg_thumbnail_height'), $data['syg_thumbnail_height'])));
		}
		
		// check overlay button proportion related to width
		if (!($data['syg_thumbnail_width'] - $data['syg_thumbnail_overlaysize'] >= 10)) {
			array_push($problemFound,
					array('field' => SygUtil::getLabel('syg_thumbnail_overlaysize'),
							'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_OVERLAY_BAD_DIMENSION, $data['syg_thumbnail_overlaysize'], SygUtil::getLabel('syg_thumbnail_width'), $data['syg_thumbnail_width'])));
		}

		if (count($problemFound) > 0) {
			// throws exception
			$exc = new SygValidateException($problemFound,
					SygConstant::MSG_EX_STYLE_NOT_VALID,
					SygConstant::COD_EX_STYLE_NOT_VALID);
			throw $exc;
		} else {
			return true;
		}
	}

	/**
	 * @name validateGallery
	 * @category style validation function
	 * @since 1.3.0
	 * @param $data array of galleries to validate
	 * @throws SygValidateException
	 */
	public static function validateGallery($data) {
		// unserialize data
		$data = unserialize($data);

		// validation code
		$problemFound = array();

		// create youtube object for validation
		$youtube = new SygYouTube();
		
		// validazione congiunta syg_gallery_type e syg_youtube_src
		switch ($data['syg_gallery_type']) {
			case "feed":
				// check youtube user
				$profile = $youtube->getUserProfile($data['syg_youtube_src']);
				if (!$profile) {
					array_push($problemFound,
							array('field' => SygUtil::getLabel('syg_youtube_src_feed'),
									'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_NOT_A_VALID_YT_USER, $data['syg_youtube_src'])));
				}
				break;
			case "list":
				// check for every video
				$list_of_videos = preg_split('/\r\n|\r|\n/', $data['syg_youtube_src']);
				// remove empty elements
				$list_of_videos = array_filter($list_of_videos, 'strlen');
				
				foreach ($list_of_videos as $key => $value) {
					$qsUrl = $list_of_videos[$key];
					
					if (preg_match('/^(http:\/\/)?(?:www\.)?youtube.com\/watch\?(?=.*v=\w+)(?:\S+)?$/', $qsUrl)) {
						// parse query string
						$qsArr = array();
						parse_str (parse_url($qsUrl, PHP_URL_QUERY), $qsArr);
						
						// get video id
						$videoId = $qsArr['v'];
						
						try {
							// get video entry
							if (!empty($videoId)) $videoEntry = $youtube->getVideoEntry($videoId);
						} catch (Zend_Gdata_App_HttpException $ex) {
							array_push($problemFound,
								array('field' => SygUtil::getLabel('syg_youtube_src_list'),
										'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_NOT_A_VALID_VIDEO, $list_of_videos[$key])));
						} catch (Exception $ex) {
							array_push($problemFound,
								array('field' => SygUtil::getLabel('syg_youtube_src_list'),
										'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_NOT_A_VALID_VIDEO_EXT, $list_of_videos[$key], $ex->getMessage()))
							);
						}
					} else {
						array_push($problemFound,
							array('field' => SygUtil::getLabel('syg_youtube_src_list'),
									'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_NOT_A_VALID_YT_URL, $qsUrl)));
					}
				}
				break;
			case "playlist":
				if (filter_var($data['syg_youtube_src'], FILTER_VALIDATE_URL)) {
					$qsUrl = $data['syg_youtube_src'];
					
					// parse query string
					$qsArr = array();
					parse_str (parse_url($qsUrl, PHP_URL_QUERY), $qsArr);
					
					// get video id
					$pId = $qsArr['list'];
					
					// check for the playlist http://www.youtube.com/playlist?list=PLB53095C7A4A6F63D
					// $playlist_id = str_replace('list=PL', '', parse_url($data['syg_youtube_src'], PHP_URL_QUERY));
					$content = json_decode(
							file_get_contents(
									'http://gdata.youtube.com/feeds/api/playlists/'
											. $pId
											. '/?v=2&alt=json&feature=plcp'));
					$feed_to_object = $content->feed->entry;
					if (!$feed_to_object) {
						array_push($problemFound,
								array('field' => SygUtil::getLabel('syg_youtube_src_playlist'),
										'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_NOT_A_VALID_PLAYLIST, $data['syg_youtube_src'])));
					}
				} else {
					array_push($problemFound,
								array('field' => SygUtil::getLabel('syg_youtube_src_playlist'),
										'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_NOT_A_VALID_PLAYLIST_URL, $data['syg_youtube_src'])));
				}
				break;
			default:
				break;
		}

		// syg_youtube_maxvideocount intero 
		if ((preg_match('/^\d+$/', $data['syg_youtube_maxvideocount'])) && ($data['syg_youtube_maxvideocount'] > SygConstant::SYG_OPTION_YT_QUERY_RESULTS)) {
			array_push($problemFound,
				array('field' => SygUtil::getLabel('syg_youtube_maxvideocount'),
						'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_NOT_LESS_VALUE, $data['syg_youtube_maxvideocount'], SygConstant::SYG_OPTION_YT_QUERY_RESULTS)));
		} else if (!(preg_match('/^\d+$/', $data['syg_youtube_maxvideocount']))) {
			array_push($problemFound,
					array('field' => SygUtil::getLabel('syg_youtube_maxvideocount'),
							'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_NOT_A_INTEGER, $data['syg_youtube_maxvideocount'])));
		}
		
		// throws exception
		if (count($problemFound) > 0) {
			// throws exception
			$exc = new SygValidateException($problemFound,
					SygConstant::MSG_EX_GALLERY_NOT_VALID,
					SygConstant::COD_EX_GALLERY_NOT_VALID);
			throw $exc;
		} else {
			return true;
		}
	}

	/**
	 * @name validateSettings
	 * @category settings validation function
	 * @since 1.3.0
	 * @param $data array of settings to validate
	 * @throws SygValidateException
	 */
	public static function validateSettings($data) {
		// unserialize data
		$data = unserialize($data);
		
		// validation code
		$problemFound = array();
		
		// syg_option_numrec int
		if (!(preg_match('/^\d+$/', $data['syg_option_numrec']))) {
			array_push($problemFound,
				array('field' => SygUtil::getLabel('syg_option_numrec'),
						'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_NOT_A_INTEGER, $data['syg_option_numrec'])));
		} else {
			if ($data['syg_option_numrec'] < 2) {
				array_push($problemFound,
					array('field' => SygUtil::getLabel('syg_option_numrec'),
							'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_LESS_VALUE, 2)));
			}
		}
		
		// syg_option_pagenumrec int
		if (!(preg_match('/^\d+$/', $data['syg_option_pagenumrec']))) {
			array_push($problemFound,
				array('field' => SygUtil::getLabel('syg_option_pagenumrec'),
						'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_NOT_A_INTEGER, $data['syg_option_pagenumrec'])));
		} else {
			if ($data['syg_option_pagenumrec'] < 2) {
				array_push($problemFound,
					array('field' => SygUtil::getLabel('syg_option_pagenumrec'),
							'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_LESS_VALUE, 2)));
			}
		}
		
		// validation fancybox2
		if ($data['syg_option_use_fb2']) {
			// validate url
			if (!filter_var($data['syg_option_use_fb2_url'], FILTER_VALIDATE_URL)) {
				array_push($problemFound,
					array('field' => SygUtil::getLabel('syg_option_use_fb2_url'),
							'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_NOT_A_VALID_URL, $data['syg_option_use_fb2_url'])));
			} else {
				
				// create a baseurl stripping filename from url and adding the trail slashes
				$last_slash = strrpos($data['syg_option_use_fb2_url'], '/');
				if (($last_slash + 1) == strlen($data['syg_option_use_fb2_url'])) {
					$url_path = $data['syg_option_use_fb2_url'];
				} else {
					$url_path = substr($data['syg_option_use_fb2_url'], 0, $last_slash+1);
				}
				
				// check if fancbox2 files are present
				if (!(file_get_contents($url_path.'jquery.fancybox.pack.js') ||
						file_get_contents($url_path.'jquery.fancybox.js') ||
						file_get_contents($url_path.'jquery.fancybox.css'))) {
					array_push($problemFound,
					array('field' => SygUtil::getLabel('syg_option_use_fb2_url'),
					'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_FANCYBOX2_NOT_FOUND, $url_path)));
				}
			}
		}
		
		// syg_option_paginator_borderradius int
		if (!(preg_match('/^\d+$/', $data['syg_option_paginator_borderradius']))) {
			array_push($problemFound,
				array('field' => SygUtil::getLabel('syg_option_paginator_borderradius'),
					'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_NOT_A_INTEGER, $data['syg_option_paginator_borderradius'])));
		}
		
		// syg_option_paginator_bordersize int
		if (!(preg_match('/^\d+$/', $data['syg_option_paginator_bordersize']))) {
			array_push($problemFound,
			array('field' => SygUtil::getLabel('syg_option_paginator_bordersize'),
			'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_NOT_A_INTEGER, $data['syg_option_paginator_bordersize'])));
		}
		
		// syg_option_paginator_shadowsize int
		if (!(preg_match('/^\d+$/', $data['syg_option_paginator_shadowsize']))) {
			array_push($problemFound,
			array('field' => SygUtil::getLabel('syg_option_paginator_shadowsize'),
			'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_NOT_A_INTEGER, $data['syg_option_paginator_shadowsize'])));
		}
		
		// syg_option_paginator_fontsize int
		if (!(preg_match('/^\d+$/', $data['syg_option_paginator_fontsize']))) {
			array_push($problemFound,
			array('field' => SygUtil::getLabel('syg_option_paginator_fontsize'),
			'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_NOT_A_INTEGER, $data['syg_option_paginator_fontsize'])));
		}
		
		// syg_option_carousel_speed float tra 0 e 1
		if (!(preg_match('/\d+(\.\d{1,2})?/',
				$data['syg_option_carousel_speed'])
				&& strval($data['syg_option_carousel_speed']) > 0
				&& strval($data['syg_option_carousel_speed']) <= 1)) {
			if (!(preg_match('/\d+(\.\d{1,2})?/',
					$data['syg_option_carousel_speed']))) {
				array_push($problemFound,
				array('field' => SygUtil::getLabel('syg_option_carousel_speed'),
				'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_NOT_A_FLOAT, $data['syg_option_carousel_speed'])));
			} else {
				if (!(strval($data['syg_option_carousel_speed']) > 0
						&& strval($data['syg_option_carousel_speed']) <= 1)) {
					array_push($problemFound,
					array('field' => SygUtil::getLabel('syg_option_carousel_speed'),
					'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_NOT_IN_RANGE, $data['syg_option_carousel_speed'], 0.1, 1)));
				}
			}
		}
		
		// syg_option_carousel_reflheight >= 0
		if (!(preg_match('/^\d+$/', $data['syg_option_carousel_reflheight'])
				&& strval($data['syg_option_carousel_reflheight'] >= 0))) {
			if (!(preg_match('/^\d+$/', $data['syg_option_carousel_reflheight']))) {
				array_push($problemFound,
				array('field' => SygUtil::getLabel('syg_option_carousel_reflheight'),
				'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_NOT_A_INTEGER, $data['syg_option_carousel_reflheight'])));
			} else {
				if (!(strval($data['syg_option_carousel_reflheight']) >= 0)) {
					array_push($problemFound,
					array('field' => SygUtil::getLabel('syg_option_carousel_reflheight'),
					'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_NOT_MAJOR_VALUE, $data['syg_option_carousel_reflheight'], 10)));
				}
			}
		}
		
		// syg_option_carousel_reflgap >= 10
		if (!(preg_match('/^\d+$/', $data['syg_option_carousel_reflgap'])
				&& strval($data['syg_option_carousel_reflgap'] >= 0))) {
			if (!(preg_match('/^\d+$/', $data['syg_option_carousel_reflgap']))) {
				array_push($problemFound,
				array('field' => SygUtil::getLabel('syg_option_carousel_reflgap'),
				'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_NOT_A_INTEGER, $data['syg_option_carousel_reflgap'])));
			} else {
				if (!(strval($data['syg_option_carousel_reflgap']) >= 0)) {
					array_push($problemFound,
					array('field' => SygUtil::getLabel('syg_option_carousel_reflgap'),
					'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_NOT_MAJOR_VALUE, $data['syg_option_carousel_reflgap'], 10)));
				}
			}
		}
		
		// syg_option_carousel_reflopacity
		if (!(preg_match('/\d+(\.\d{1,2})?/',
				$data['syg_option_carousel_reflopacity'])
				&& strval($data['syg_option_carousel_reflopacity']) >= 0
				&& strval($data['syg_option_carousel_reflopacity']) <= 1)) {
			if (!(preg_match('/\d+(\.\d{1,2})?/',
					$data['syg_option_carousel_reflopacity']))) {
				array_push($problemFound,
				array('field' => SygUtil::getLabel('syg_option_carousel_reflopacity'),
				'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_NOT_A_FLOAT, $data['syg_option_carousel_reflopacity'])));
			} else {
				if (!(strval($data['syg_option_carousel_reflopacity']) >= 0
						&& strval($data['syg_option_carousel_reflopacity']) <= 1)) {
					array_push($problemFound,
					array('field' => SygUtil::getLabel('syg_option_carousel_reflopacity'),
					'msg' => SygUtil::injectValues(SygConstant::BE_VALIDATE_NOT_IN_RANGE, $data['syg_option_carousel_reflopacity'], 0, 1)));
				}
			}
		}
		
		// throws exception
		if (count($problemFound) > 0) {
			// throws exception
			$exc = new SygValidateException($problemFound,
					SygConstant::MSG_EX_SETTING_NOT_VALID,
					SygConstant::COD_EX_SETTING_NOT_VALID);
			throw $exc;
		} else {
			return true;
		}
	}
}
?>