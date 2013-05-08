<?php
// Turn off all error reporting
error_reporting(0);

header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . 'GMT' );
header('Cache-Control: no-cache, must-revalidate' );
header('Pragma: no-cache' );
header('Content-type: application/json; charset=utf-8');

// include wp loader
$root = realpath(dirname(dirname(dirname(dirname(dirname(dirname($_SERVER['SCRIPT_FILENAME'])))))));

if (file_exists($root.'/wp-load.php')) {
	// WP 2.6
	require_once($root.'/wp-load.php');
} else {
	// Before 2.6
	require_once($root.'/wp-config.php');
}

// include required wordpress object
require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

// include plugin files
require_once ('../SygYouTube.php');
require_once ('../SygDao.php');
require_once ('../SygUtil.php');

// construct objects
$dao = new SygDao();
$youtube = new SygYouTube();

switch ($_GET['query']) {
	case 'videos':
		if($_GET['page_number']) {
			$page_number = $_GET['page_number'];
			$current_page = $page_number;
			$page_number -= 1;
			$per_page = $_GET['syg_option_pagenumrec']; // Per page records
			$start = $page_number * $per_page;
			
			$gallery = $dao->getSygGalleryById($_GET['id']);
			$cached = $gallery->isGalleryCached();
			$videos = $youtube->getVideoFeed($gallery, $start, $per_page);
			
			$videos_to_json = array();
			foreach ($videos as $entry) {
				$element['video_id'] = $entry->getVideoId();
				$element['video_cached'] = $cached;
				$element['video_description'] = $entry->getVideoDescription();
				$element['video_duration'] = SygUtil::formatDuration($entry->getVideoDuration());
				$element['video_watch_page_url'] = $entry->getVideoWatchPageUrl();
				$element['video_title'] = $entry->getVideoTitle();
				$element['video_category'] = $entry->getVideoCategory();
				// video tags (to be implemented after auth
				//$tags = array();
				//foreach ($entry->getCategory() as $category) {
				//	if ($category->getScheme() == 'http://gdata.youtube.com/schemas/2007/keywords.cat') {
				//		$tags[] = $category->getTerm();
				//	}
				//}
				//$element['video_tags'] = implode('|', $tags);
				// @todo auth user for real tags
				$element['video_tags'] = "none";
				$element['video_rating_info'] = $entry->getVideoRatingInfo();
				
				// modify the img path to match local files
				if ($_GET['mode'] == 'caching_mode') {
					$element['video_thumbshot'] = WP_PLUGIN_URL .
												'/sliding-youtube-gallery/' .
												'/cache/thumb/' .
												$gallery->getId() . 
												DIRECTORY_SEPARATOR . 
												$entry->getVideoId() . '.jpg';
				} else {
					// get thumbnails
					$thumbnails = $entry->getVideoThumbnails();
					$element['video_thumbshot'] = $thumbnails[$_GET['syg_option_which_thumb']]['url'];
				}
				array_push($videos_to_json, $element);
			}
			echo json_encode (array_reverse($videos_to_json));
		}
		break;
	default: 
		NULL; 
		break;
}
?>