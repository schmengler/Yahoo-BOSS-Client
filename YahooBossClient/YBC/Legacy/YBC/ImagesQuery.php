<?php
/**
 * Image search query
 * 
 * BOSS Version: v1 (state: 2010-10-13)
 * 
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2010 SGH informationstechnologie UG
 * @license BSD
 * @link http://creativecommons.org/licenses/BSD/ 
 * @package YBC
 * @version 1.0
 */
class YBC_ImagesQuery extends YBC_AbstractQuery
{
	/**
	 * @var string Images of all sizes
	 */
	const DIMENSIONS_ALL = 'all';
	/**
	 * @var string Small images are generally thumbnail or icon sized.
	 */
	const DIMENSIONS_SMALL = 'small';
	/**
	 * @var string Medium sized images are average sized; usually not exceeding an average screen size.
	 */
	const DIMENSIONS_MEDIUM = 'medium';
	/**
	 * @var string Large images are screen size or larger
	 */
	const DIMENSIONS_LARGE = 'large';
	/**
	 * @var string Images that match 4:3 screen resolutions
	 */
	const DIMENSIONS_WALLPAPER = 'wallpaper';
	/**
	 * @var string Images that match 16:10 screen resolutions
	 */
	const DIMENSIONS_WIDEWALLPAPER = 'widewallpaper';
	
	private static $supportedDimensions = array(
		'all', 'small', 'medium', 'large', 'wallpaper', 'widewallpaper'
	);
	
	/**
	 * @var string Whether or not to activate the Offensive Content Reduction filter. If set to yes, content marked as offensive is omitted from results.
	 */
	protected $filter = 'yes';
	/**
	 * @var string Small images are generally thumbnail or icon sized. Medium sized images are average sized; usually not exceeding an average screen size. Large images are screen size or larger. Size pairs other than those listed are ignored 
	 */
	protected $dimensions = 'all';
	/**
	 * @var string Search for this URL. Depending on other query restrictions, returns all image objects with this referring URL.
	 */
	protected $refererurl;
	/**
	 * @var string Search for this URL. Returns this exact image result. 
	 */
	protected $url;
	
	public function getVertical() {
		return 'images';
	}
	/**
	 * @return bool activated "offensive content" filter?
	 */
	public function hasFilter() {
		return $this->filter==='yes';
	}
	/**
	 * @return string dimension filter
	 */
	public function getDimensions() {
		return $this->dimensions;
	}
	/**
	 * @return referer url filter
	 */
	public function getRefererUrl() {
		return $this->refererurl;
	}
	/**
	 * @return single image url
	 */
	public function getUrl() {
		return $this->url;
	}
	/**
	 * Sets "offensive content" filter
	 * 
	 * @param bool $active
	 * @return YBC_ImagesQuery
	 */
	public function setFilter($active)
	{
		$this->filter = $active ? 'yes' : 'no';
		return $this;
	}
	/**
	 * Sets dimensions
	 * 
	 * @param string $dimensions
	 * @return YBC_ImagesQuery
	 */
	public function setDimensions($dimensions)
	{
		if (!in_array($dimensions, self::$supportedDimensions)) {
			throw new InvalidArgumentException('Invalid dimensions ' . $dimensions);
		}
		$this->dimensions = $dimensions;
		return $this;
	}
	/**
	 * Sets referer url
	 * 
	 * @param string $url
	 * @return YBC_ImagesQuery
	 */
	public function setRefererUrl($url)
	{
		$this->refererurl = $url;
		return $this;
	}
	/**
	 * Sets single image url
	 * 
	 * @param unknown_type $url
	 * @return YBC_ImagesQuery
	 */
	public function setUrl($url)
	{
		$this->url = $url;
		return $this;
	}
}