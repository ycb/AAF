<?php

/**
 * @name Sliding Youtube Gallery Plugin Style Data Bean
 * @category Sliding Youtube Gallery Style Object
 * @since 1.3.0
 * @author: Luca Martini @ webEng
 * @license: GNU GPLv3 - http://www.gnu.org/copyleft/gpl.html
 * @version: 1.4.4
 */

class SygStyle {
	// this object attributes
	private $styleName;
	private $styleDetails;
	private $boxWidth;
	private $boxBackground;
	private $boxRadius;
	private $boxPadding;
	private $thumbHeight;
	private $thumbWidth;
	private $thumbBorderSize;
	private $thumbBorderColor;
	private $thumbBorderRadius;
	private $thumbOverlaySize;
	private $thumbImage;
	private $thumbDistance;
	private $thumbButtonOpacity;
	private $thumbUrl;
	private $percOccW;
	private $percOccH;
	private $thumbTop;
	private $thumbLeft;
	private $descWidth;
	private $descFontSize;
	private $descFontColor;
	private $id;
	
	// recordset type
	public static $rsType = array('%s','%s','%s','%d','%d','%d','%s','%d','%d','%s','%d','%d','%f','%d','%d','%d','%d','%d','%d');
	
	// attribute to exclude in serialization
	public $exclude = array('rsType', 'exclude');
	
	/**
	 * @name __construct
	 * @category construct SygDao object
	 * @since 1.2.5
	 * @param $key
	 */
	public function __construct($key = null) {
		if (is_string($key)) $key = unserialize ($key);
		$this->mapThis($key);
	}

	/**
	 * @name mapThis
	 * @category data object mapping from resultset 
	 * @since 1.2.5
	 * @param $result
	 */
	private function mapThis($result = null) {
		$result = (object) $result;
		
		// style name
		$this->setStyleName($result->syg_style_name);
		$this->setStyleDetails($result->syg_style_details);
		
		// box option values
		$this->setBoxBackground(($result->syg_box_background) ? $result->syg_box_background : SygConstant::SYG_BOX_DEFAULT_BACKGROUND_COLOR);
		$this->setBoxPadding($result->syg_box_padding);
		$this->setBoxRadius($result->syg_box_radius);
		$this->setBoxWidth($result->syg_box_width);
		
		// description option values
		$this->setDescFontColor(($result->syg_description_fontcolor) ? ($result->syg_description_fontcolor) : SygConstant::SYG_DESC_DEFAULT_FONT_COLOR);
		$this->setDescFontSize($result->syg_description_fontsize);
		$this->setDescWidth(($result->syg_thumbnail_width > 0) ? $result->syg_thumbnail_width : SygConstant::SYG_THUMB_DEFAULT_WIDTH);
		
		// thumbnail option values
		$this->setThumbBorderColor(($result->syg_thumbnail_bordercolor) ? $result->syg_thumbnail_bordercolor: SygConstant::SYG_THUMB_DEFAULT_BORDER_COLOR);
		$this->setThumbBorderRadius($result->syg_thumbnail_borderradius);
		$this->setThumbBorderSize($result->syg_thumbnail_bordersize);
		$this->setThumbButtonOpacity($result->syg_thumbnail_buttonopacity);
		$this->setThumbDistance($result->syg_thumbnail_distance);
		$this->setThumbHeight(($result->syg_thumbnail_height > 0) ? $result->syg_thumbnail_height : SygConstant::SYG_THUMB_DEFAULT_HEIGHT);
		$this->setThumbImage((!empty($result->syg_thumbnail_image)) ? $result->syg_thumbnail_image : SygConstant::SYG_THUMB_DEFAULT_IMAGE);
		$this->setThumbWidth(($result->syg_thumbnail_width > 0) ? $result->syg_thumbnail_width : SygConstant::SYG_THUMB_DEFAULT_WIDTH);
		$this->setThumbOverlaySize($result->syg_thumbnail_overlaysize);
		
		// additional graphic option values
		$this->setPercOccH($this->getThumbOverlaySize() / ($this->getThumbHeight() + ($this->getThumbBorderSize()*2)));
		$this->setPercOccW($this->getThumbOverlaySize() / ($this->getThumbWidth() + ($this->getThumbBorderSize()*2)));
		$this->setThumbTop(50 - ($this->getPercOccH() / 2 * 100));
		$this->setThumbLeft(50 - ($this->getPercOccW() / 2 * 100));
		
		// id
		$this->setId($result->id);
	}
	
	/**
	 * @name getJsonData 
	 * @category object data parser
	 * @since 1.2.5
	 * @return string $json
	 */
	function getJsonData() {
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
	 * @name toDto
	 * @category object data parser
	 * @since 1.2.5
	 * @param $full, if true export style with its calculated fields
	 * @return array $dto
	 */
	public function toDto($full = false) {
		$dto = array('syg_style_name'			=> $this->getStyleName(),
				'syg_style_details'				=> $this->getStyleDetails(),
				'syg_box_background'			=> $this->getBoxBackground(),
				'syg_box_padding' 				=> $this->getBoxPadding(),
				'syg_box_radius'				=> $this->getBoxRadius(),
				'syg_box_width' 				=> $this->getBoxWidth(),
				'syg_description_fontcolor' 	=> $this->getDescFontColor(),
				'syg_description_fontsize'		=> $this->getDescFontSize(),
				'syg_description_width'			=> $this->getDescWidth(),
				'syg_thumbnail_bordercolor'		=> $this->getThumbBorderColor(),
				'syg_thumbnail_borderradius'	=> $this->getThumbBorderRadius(),
				'syg_thumbnail_bordersize'		=> $this->getThumbBorderSize(),
				'syg_thumbnail_buttonopacity'	=> $this->getThumbButtonOpacity(),
				'syg_thumbnail_distance'		=> $this->getThumbDistance(),
				'syg_thumbnail_height'			=> $this->getThumbHeight(),
				'syg_thumbnail_image'			=> $this->getThumbImage(),
				'syg_thumbnail_width'			=> $this->getThumbWidth(),
				'syg_thumbnail_overlaysize'		=> $this->getThumbOverlaySize(),
				'id'							=> $this->getId());
		
		if ($full) {
			$full_array = $dto;
			$full_array['syg_thumbnail_top'] = $this->getThumbTop();
			$full_array['syg_thumbnail_left'] = $this->getThumbLeft();
			$full_array['syg_thumbnail_url'] = $this->getThumbUrl();
			$dto = $full_array; 			
		}
		
		return $dto;
	}
	
	/**
	 * @name getStyleName
	 * @category getters and setters
	 * @since 1.2.5
	 * @return the $styleName
	 */
	public function getStyleName() {
		return $this->styleName;
	}

	/**
	 * @name setStyleName
	 * @category getters and setters
	 * @since 1.2.5
	 * @param $styleName
	 */
	public function setStyleName($styleName) {
		$this->styleName = $styleName;
	}

	/**
	 * @name getBoxWidth
	 * @category getters and setters
	 * @since 1.2.5
	 * @return the $boxWidth
	 */
	public function getBoxWidth() {
		return $this->boxWidth;
	}

	/**
	 * @name setBoxWidth
	 * @category getters and setters
	 * @since 1.2.5
	 * @param $boxWidth
	 */
	public function setBoxWidth($boxWidth) {
		$this->boxWidth = $boxWidth;
	}

	/**
	 * @name getBoxBackground
	 * @category getters and setters
	 * @since 1.2.5
	 * @return the $boxBackground
	 */
	public function getBoxBackground() {
		return $this->boxBackground;
	}

	/**
	 * @name setBoxBackground
	 * @category getters and setters
	 * @since 1.2.5
	 * @param $boxBackground
	 */
	public function setBoxBackground($boxBackground) {
		$this->boxBackground = $boxBackground;
	}

	/**
	 * @name getBoxRadius
	 * @category getters and setters
	 * @since 1.2.5
	 * @return the $boxRadius
	 */
	public function getBoxRadius() {
		return $this->boxRadius;
	}

	/**
	 * @name setBoxRadius
	 * @category getters and setters
	 * @since 1.2.5
	 * @param $boxRadius
	 */
	public function setBoxRadius($boxRadius) {
		$this->boxRadius = $boxRadius;
	}

	/**
	 * @name getBoxPadding
	 * @category getters and setters
	 * @since 1.2.5
	 * @return the $boxPadding
	 */
	public function getBoxPadding() {
		return $this->boxPadding;
	}

	/**
	 * @name setBoxPadding
	 * @category getters and setters
	 * @since 1.2.5
	 * @param $boxPadding
	 */
	public function setBoxPadding($boxPadding) {
		$this->boxPadding = $boxPadding;
	}

	/**
	 * @name getThumbHeight
	 * @category getters and setters
	 * @since 1.2.5
	 * @return the $thumbHeight
	 */
	public function getThumbHeight() {
		return $this->thumbHeight;
	}

	/**
	 * @name setThumbHeight
	 * @category getters and setters
	 * @since 1.2.5
	 * @param $thumbHeight
	 */
	public function setThumbHeight($thumbHeight) {
		$this->thumbHeight = $thumbHeight;
	}

	/**
	 * @name getThumbWidth
	 * @category getters and setters
	 * @since 1.2.5
	 * @return the $thumbWidth
	 */
	public function getThumbWidth() {
		return $this->thumbWidth;
	}

	/**
	 * @name setThumbWidth
	 * @category getters and setters
	 * @since 1.2.5
	 * @param $thumbWidth
	 */
	public function setThumbWidth($thumbWidth) {
		$this->thumbWidth = $thumbWidth;
	}

	/**
	 * @name getThumbBorderSize
	 * @category getters and setters
	 * @since 1.2.5
	 * @return the $thumbBorderSize
	 */
	public function getThumbBorderSize() {
		return $this->thumbBorderSize;
	}

	/**
	 * @name setThumbWidth
	 * @category getters and setters
	 * @since 1.2.5
	 * @param $thumbWidth
	 */
	public function setThumbBorderSize($thumbBorderSize) {
		$this->thumbBorderSize = $thumbBorderSize;
	}

	/**
	 * @name getThumbBorderColor
	 * @category getters and setters
	 * @since 1.2.5
	 * @return the $thumbBorderColor
	 */
	public function getThumbBorderColor() {
		return $this->thumbBorderColor;
	}

	/**
	 * @name setThumbBorderColor
	 * @category getters and setters
	 * @since 1.2.5
	 * @param $thumbBorderColor
	 */
	public function setThumbBorderColor($thumbBorderColor) {
		$this->thumbBorderColor = $thumbBorderColor;
	}

	/**
	 * @name getThumbBorderRadius
	 * @category getters and setters
	 * @since 1.2.5
	 * @return the $thumbBorderRadius
	 */
	public function getThumbBorderRadius() {
		return $this->thumbBorderRadius;
	}

	/**
	 * @name setThumbBorderRadius
	 * @category getters and setters
	 * @since 1.2.5
	 * @param $thumbBorderRadius
	 */
	public function setThumbBorderRadius($thumbBorderRadius) {
		$this->thumbBorderRadius = $thumbBorderRadius;
	}

	/**
	 * @name getThumbOverlaySize
	 * @category getters and setters
	 * @since 1.2.5
	 * @return the $thumbOverlaySize
	 */
	public function getThumbOverlaySize() {
		return $this->thumbOverlaySize;
	}

	/**
	 * @name setThumbOverlaySize
	 * @category getters and setters
	 * @since 1.2.5
	 * @param $thumbOverlaySize
	 */
	public function setThumbOverlaySize($thumbOverlaySize) {
		$this->thumbOverlaySize = $thumbOverlaySize;
	}

	/**
	 * @name getThumbImage
	 * @category getters and setters
	 * @since 1.2.5
	 * @return the $thumbImage
	 */
	public function getThumbImage() {
		return $this->thumbImage;
	}

	/**
	 * @name setThumbImage
	 * @category getters and setters
	 * @since 1.2.5
	 * @param $thumbImage
	 */
	public function setThumbImage($thumbImage) {
		$this->thumbImage = $thumbImage;
	}

	/**
	 * @name getThumbDistance
	 * @category getters and setters
	 * @since 1.2.5
	 * @return the $thumbDistance
	 */
	public function getThumbDistance() {
		return $this->thumbDistance;
	}

	/**
	 * @name setThumbDistance
	 * @category getters and setters
	 * @since 1.2.5
	 * @param $thumbDistance
	 */
	public function setThumbDistance($thumbDistance) {
		$this->thumbDistance = $thumbDistance;
	}

	/**
	 * @name getThumbButtonOpacity
	 * @category getters and setters
	 * @since 1.2.5
	 * @return the $thumbButtonOpacity
	 */
	public function getThumbButtonOpacity() {
		return $this->thumbButtonOpacity;
	}

	/**
	 * @name setThumbButtonOpacity
	 * @category getters and setters
	 * @since 1.2.5
	 * @param $thumbButtonOpacity
	 */
	public function setThumbButtonOpacity($thumbButtonOpacity) {
		$this->thumbButtonOpacity = $thumbButtonOpacity;
	}

	/**
	 * @name getThumbUrl
	 * @category getters and setters
	 * @since 1.2.5
	 * @return the $thumbUrl
	 */
	public function getThumbUrl() {
		return $this->thumbUrl;
	}

	/**
	 * @name setThumbUrl
	 * @category getters and setters
	 * @since 1.2.5
	 * @param $thumbUrl
	 */
	public function setThumbUrl($thumbUrl) {
		$this->thumbUrl = $thumbUrl;
	}

	/**
	 * @name getPercOccW
	 * @category getters and setters
	 * @since 1.2.5
	 * @return the $percOccW
	 */
	public function getPercOccW() {
		return $this->percOccW;
	}

	/**
	 * @name setPercOccW
	 * @category getters and setters
	 * @since 1.2.5
	 * @param $percOccW
	 */
	public function setPercOccW($percOccW) {
		$this->percOccW = $percOccW;
	}

	/**
	 * @name getPercOccH
	 * @category getters and setters
	 * @since 1.2.5
	 * @return the $percOccH
	 */
	public function getPercOccH() {
		return $this->percOccH;
	}

	/**
	 * @name setPercOccH
	 * @category getters and setters
	 * @since 1.2.5
	 * @param $percOccH
	 */
	public function setPercOccH($percOccH) {
		$this->percOccH = $percOccH;
	}

	/**
	 * @name getThumbTop
	 * @category getters and setters
	 * @since 1.2.5
	 * @return the $thumbTop
	 */
	public function getThumbTop() {
		return $this->thumbTop;
	}

	/**
	 * @name setThumbTop
	 * @category getters and setters
	 * @since 1.2.5
	 * @param $thumbTop
	 */
	public function setThumbTop($thumbTop) {
		$this->thumbTop = $thumbTop;
	}

	/**
	 * @name getThumbLeft
	 * @category getters and setters
	 * @since 1.2.5
	 * @return the $thumbLeft
	 */
	public function getThumbLeft() {
		return $this->thumbLeft;
	}

	/**
	 * @name setThumbLeft
	 * @category getters and setters
	 * @since 1.2.5
	 * @param $thumbLeft
	 */
	public function setThumbLeft($thumbLeft) {
		$this->thumbLeft = $thumbLeft;
	}

	/**
	 * @name getDescWidth
	 * @category getters and setters
	 * @since 1.2.5
	 * @return the $descWidth
	 */
	public function getDescWidth() {
		return $this->descWidth;
	}

	/**
	 * @name setDescWidth
	 * @category getters and setters
	 * @since 1.2.5
	 * @param $descWidth
	 */
	public function setDescWidth($descWidth) {
		$this->descWidth = $descWidth;
	}

	/**
	 * @name getDescFontSize
	 * @category getters and setters
	 * @since 1.2.5
	 * @return the $descFontSize
	 */
	public function getDescFontSize() {
		return $this->descFontSize;
	}

	/**
	 * @name setDescFontSize
	 * @category getters and setters
	 * @since 1.2.5
	 * @param $descFontSize
	 */
	public function setDescFontSize($descFontSize) {
		$this->descFontSize = $descFontSize;
	}

	/**
	 * @name getDescFontColor
	 * @category getters and setters
	 * @since 1.2.5
	 * @return the $descFontColor
	 */
	public function getDescFontColor() {
		return $this->descFontColor;
	}

	/**
	 * @name setDescFontColor
	 * @category getters and setters
	 * @since 1.2.5
	 * @param $descFontColor
	 */
	public function setDescFontColor($descFontColor) {
		$this->descFontColor = $descFontColor;
	}

	/**
	 * @name getStyleDetails
	 * @category getters and setters
	 * @since 1.2.5
	 * @return the $styleDetails
	 */
	public function getStyleDetails() {
		return $this->styleDetails;
	}

	/**
	 * @name setStyleDetails
	 * @category getters and setters
	 * @since 1.2.5
	 * @param $styleDetails
	 */
	public function setStyleDetails($styleDetails) {
		$this->styleDetails = $styleDetails;
	}

	/**
	 * @name getId
	 * @category getters and setters
	 * @since 1.2.5
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @name setId
	 * @category getters and setters
	 * @since 1.2.5
	 * @param $id
	 */
	public function setId($id) {
		$this->id = $id;
	}
	
	/**
	 * @name getRsType
	 * @category getters and setters
	 * @since 1.2.5
	 * @return the $rsType
	 */
	public static function getRsType() {
		return SygStyle::$rsType;
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