<?php

/**
 * @name SygYouTube
 * @category Sliding YouTube Gallery Plugin YouTube Interface
 * @since 1.0.1
 * @author: Luca Martini @ webEng
 * @license: GNU GPLv3 - http://www.gnu.org/copyleft/gpl.html
 * @version: 1.4.4
 */

class SygYouTube {
	private $yt;
	
	/**
	 * @name __construct
	 * @category construct SygYouTube object
	 * @since 1.0.1
	 */
	public function __construct() {
		Zend_Loader::loadClass('Zend_Gdata_YouTube');
		Zend_Loader::loadClass('Zend_Gdata_YouTube_VideoQuery');
		$this->yt = new Zend_Gdata_YouTube();
	}
	
	/**
	 * @name getUserProfile
	 * @category return youTube user profile object
	 * @since 1.0.1
	 * @param $username
	 * @return mixed $userProfile
	 */
	public function getUserProfile($username) {
		$userProfile = null;
		try {
			$this->yt->setMajorProtocolVersion(2); 
			$userProfile = $this->yt->getUserProfile($username);
		} catch (Zend_Gdata_App_HttpException $exception) {
			$userprofile = null;
		}
		return $userProfile;
	}
	 
	/**
	 * @name getUserUploads
	 * @category return youTube user uploads Feed
	 * @since 1.0.1
	 * @param SygGallery $gallery
	 * @param $start = null
	 * @param $per_page = null
	 * @return Zend_Gdata_YouTube_VideoFeed $feed
	 */
	public function getUserUploads(SygGallery $gallery, $start = null, $per_page = null) {
		$username = $gallery->getYtSrc();
		$maxVideoCount = $gallery->getYtMaxVideoCount(); 
		$userProfile = new Zend_Gdata_YouTube_UserProfileEntry();
		$userprofile = $this->getUserProfile($gallery->getYtSrc());
		$totalUpload = $userprofile->getFeedLink('http://gdata.youtube.com/schemas/2007#user.uploads')->countHint;
		$this->yt->setMajorProtocolVersion(2);
		$url = Zend_Gdata_YouTube::USER_URI .'/'. $username .'/'. Zend_Gdata_YouTube::UPLOADS_URI_SUFFIX;
		$query = new Zend_Gdata_YouTube_VideoQuery($url);
		$feed = new Zend_Gdata_YouTube_VideoFeed();

		// mvc < total uploads? -> GET LESS VIDEOS FROM THE CHANNEL (TRUNCATION)
		if ($gallery->getYtMaxVideoCount() < $totalUpload) {
			// get truncated feed
			$startIndex = 1; 
			$query->setStartIndex($startIndex);
			$query->setMaxResults($gallery->getYtMaxVideoCount());
			$feed = $this->yt->getVideoFeed($query);
			
			if (($start !== null) && ($per_page !== null)) {
				// return the right number of videos according to pagination
				// calling the adjustFeed function
				$feed = $this->adjustFeed($feed, $gallery, $start, $per_page);
			}
		} 
		// mvc >= total uploads? -> GET ALL VIDEOS FROM THE CHANNEL (NO TRUNCATION)
		else if ($gallery->getYtMaxVideoCount() >= $totalUpload) {
			if (($start !== null) && ($per_page !== null)) {
		 		// request the right number of videos according to pagination
				$start++;
				$maxResult = $per_page;
			} else {
				// request all the videos without pagination
				$start = 1;
				$maxResult = $totalUpload;
			}
			$query->setStartIndex($start);
			$query->setMaxResults($maxResult);
			$feed = $this->yt->getVideoFeed($query);
		}

		return $feed;
	}
	
	/**
	 * @name getUserList
	 * @category return youTube user list Feed
	 * @since 1.0.1
	 * @param SygGallery $gallery
	 * @param $start = null
	 * @param $per_page = null
	 * @return Zend_Gdata_YouTube_VideoFeed $feed
	 */
	public function getUserList(SygGallery $gallery, $start = null, $per_page = null) {
		$feed = new Zend_Gdata_YouTube_VideoFeed();
		$list_of_videos = preg_split('/\r\n|\r|\n/', $gallery->getYtSrc());
		foreach ($list_of_videos as $key => $value) {
			$list_of_videos[$key] = str_replace('v=', '', parse_url($value, PHP_URL_QUERY));
			$videoEntry = $this->getVideoEntry($list_of_videos[$key]);
			$feed->addEntry($videoEntry);
		}
		$feed = $this->adjustFeed($feed, $gallery, $start, $per_page);
		return $feed;
	}
	
	/**
	 * @name getUserPlaylist
	 * @category return youTube user uploads
	 * @since 1.0.1
	 * @param SygGallery $gallery
	 * @param $start = null
	 * @param $per_page = null
	 * @return Zend_Gdata_YouTube_VideoFeed $feed
	 */
	public function getUserPlaylist(SygGallery $gallery, $start = null, $per_page = null) {
		$feed = new Zend_Gdata_YouTube_VideoFeed();
		$playlist_id = str_replace('list=PL', '', parse_url($gallery->getYtSrc(), PHP_URL_QUERY));
		// set the query url for playlist
		$query_url = 'http://gdata.youtube.com/feeds/api/playlists/'.$playlist_id.'/?v=2&alt=json&feature=plcp';
		// fix the index, gdata url don't use 0 as first index
		$yt_index = $start + 1;
		// check if querying a subset of data
		if ($start && $per_page) {			 
			$query_url .= '&start-index='.$yt_index.'&max-results='.$per_page;
		} else {
			$query_url .= '&start-index='.$yt_index.'&max-results='.SygConstant::SYG_OPTION_YT_QUERY_RESULTS;
		}
		// decode json
		$content = json_decode(file_get_contents($query_url));
		$feed_to_object = $content->feed->entry;
		if (count($feed_to_object)) {
			foreach ($feed_to_object as $item) {
				$videoId = $item->{'media$group'}->{'yt$videoid'}->{'$t'};
				$videoEntry = $this->getVideoEntry($videoId);
				$feed->addEntry($videoEntry);
			}
		}
		$feed = $this->adjustFeed($feed, $gallery, $start, $per_page);
		return $feed;
	}
	
	/**
	 * @name adjustFeed
	 * @category return youTube user uploads
	 * @since 1.3.0
	 * @param $feed
	 * @param $gallery
	 * @param $start = null
	 * @param $per_page = null
	 * @return Zend_Gdata_YouTube_VideoFeed $feed
	 */
	private function adjustFeed(Zend_Gdata_YouTube_VideoFeed $feed, SygGallery $gallery, $start = null, $per_page = null) {
		// truncate feed
		$feed_count = $feed->count();
		if ($gallery->getYtMaxVideoCount() < $feed_count) {
			$feed_count--;
			for ($i = $gallery->getYtMaxVideoCount(); $i <= $feed_count; $i++) {
				$feed->offsetUnset($i);
			}
		}
	
		// feed pagination
		if (($start !== null) && ($per_page !== null) && ($feed->count() > $per_page)) {
			$feed_page = new Zend_Gdata_YouTube_VideoFeed();
			$end = intval($start + $per_page) - 1;
			for ($i = $start; $i <= $end; $i++) {
				if ($feed->offsetGet($i)) $feed_page->addEntry($feed->offsetGet($i));
			}
			$feed = $feed_page;
		}
	
		return $feed;
	}
	
	/**
	 * @name getVideoEntry
	 * @category return a YouTube Video
	 * @since 1.3.0
	 * @param $video_code
	 * @return Zend_Gdata_YouTube_VideoEntry $video
	 */
	public function getVideoEntry($video_code = null) {
		$this->yt->setMajorProtocolVersion(2);
		$video = $this->yt->getVideoEntry($video_code);
		return $video;
	}
	
	/**
	 * @name countVideoEntry
	 * @category return the number of video
	 * @since 1.3.0
	 * @param $gallery
	 * @return int $count
	 */
	public function countVideoEntry(SygGallery $gallery) {
		$count = 0;
		if ($gallery->getYtSrc() && $gallery->getGalleryType() && $gallery->getYtMaxVideoCount()) {
			$feed = new Zend_Gdata_YouTube_VideoFeed();
			if ($gallery->getGalleryType() == 'feed') {
				$feed = $this->getuserUploads($gallery);
				$count = $feed->count();
			} else if ($gallery->getGalleryType() == 'list') {
				$list_of_videos = preg_split( '/\r\n|\r|\n/', $gallery->getYtSrc());
				$count = count($list_of_videos);
				// truncate feed
				if ($gallery->getYtMaxVideoCount() < $count) {
					$count = $gallery->getYtMaxVideoCount();
				}
			} else if ($gallery->getGalleryType() == 'playlist') {
				$playlist_id = str_replace ('list=PL', '', parse_url($gallery->getYtSrc(), PHP_URL_QUERY));
				$content = json_decode(file_get_contents('http://gdata.youtube.com/feeds/api/playlists/'.$playlist_id.'/?v=2&alt=json&feature=plcp&start-index=1&max-results='.SygConstant::SYG_OPTION_YT_QUERY_RESULTS));
				$feed_to_object = $content->feed->entry;
				$count = count($feed_to_object);
				// truncate feed
				if ($gallery->getYtMaxVideoCount() < $count) {
					$count = $gallery->getYtMaxVideoCount();
				}
			}
		} 
		return $count;
	}
	
	/**
	 * @name getVideoFeed
	 * @category get a youtube video feed
	 * @since 1.3.0
	 * @param $gallery
	 * @param $start
	 * @param $per_page
	 * @throws Exception
	 * @return mixed $feed
	 */
	public function getVideoFeed(SygGallery $gallery, $start = null, $per_page = null) {
		$feed = new Zend_Gdata_YouTube_VideoFeed();
		if ($gallery->getGalleryType() == 'feed') {
			$feed = $this->getUserUploads($gallery, $start, $per_page);
		} else if ($gallery->getGalleryType() == 'list') {
			$feed = $this->getUserList($gallery, $start, $per_page);
		} else if ($gallery->getGalleryType() == 'playlist') {
			$feed = $this->getUserPlaylist($gallery, $start, $per_page);
		}
	
		return $feed;
	}
}
?>