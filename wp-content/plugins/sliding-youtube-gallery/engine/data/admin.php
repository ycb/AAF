<?php
// Turn off all error reporting
error_reporting(0);

$seconds_to_cache = 3600;
$ts = gmdate("D, d M Y H:i:s", time() + $seconds_to_cache) . " GMT";

// set http headers
header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . 'GMT' );
header('Cache-Control: no-cache, must-revalidate' );
header('Pragma: no-cache' );
header('Content-type: application/json; charset=utf-8');

// include wp loader
$root = realpath(dirname(dirname(dirname(dirname(dirname(dirname($_SERVER['SCRIPT_FILENAME'])))))));

if (file_exists($root.'/wp-load.php')) {
	// WP 2.6
	require($root.'/wp-load.php');
} else {
	// Before 2.6
	require($root.'/wp-config.php');
}

// include plugin files
require_once ('../SygDao.php');

if ($_GET['table']) {
	switch ($_GET['table']) {
		case 'galleries': 
			if($_GET['page_number']) {
				$page_number = $_GET['page_number'];
				$current_page = $page_number;
				$page_number -= 1;
				$per_page = $_GET['syg_option_numrec']; // Per page records
				$start = $page_number * $per_page;
				$dao = new SygDao();
				$galleries = $dao->getAllSygGalleries('OBJECT', $start, $per_page);
				$gallery_to_json = array();
				foreach ($galleries as $gallery) {
					array_push($gallery_to_json, $gallery->getJsonData());
				}
				echo json_encode ($gallery_to_json);
			}
			break;
		case 'styles':
			if($_GET['page_number']) {
				$page_number = $_GET['page_number'];
				$current_page = $page_number;
				$page_number -= 1;
				$per_page = $_GET['syg_option_numrec']; // Per page records
				$start = $page_number * $per_page;
				$dao = new SygDao();
				$styles = $dao->getAllSygStyles('OBJECT', $start, $per_page);
				$style_to_json = array();
				foreach ($styles as $style) {
					array_push($style_to_json, $style->getJsonData());
				}
				echo json_encode ($style_to_json);
			}
			break;
	}
}
?>