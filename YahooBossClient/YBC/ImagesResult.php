<?php
namespace YBC;
/**
 * Single search result of image search
 * 
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2010 SGH informationstechnologie UG
 * @license BSD
 * @link http://creativecommons.org/licenses/BSD/ 
 * @package YBC
 * @version 1.0
 * 
 * @property-read string $abstract Description of image  
 * @property-read string $clickurl URL to click to view image
 * @property-read string $date Last modification date of image YYYY/MM/DD
 * @property-read string $size Size of image file 
 * @property-read string $title Title of image (usually the filename) 
 * @property-read string $url URL of image itself 
 * @property-read string $filename Filename of image 
 * @property-read string $format Format of image 
 * @property-read string $width Width of full-size image 
 * @property-read string $height Height of full-size image 
 * @property-read string $mimetype MIME type of image 
 * @property-read string $refererclickurl Clickable link to page in which image was found 
 * @property-read string $refererurl Original link to page in which image was found 
 * @property-read string $thumbnail_url Thumbnail image
 * @property-read string $thumbnail_widthThumbnail width
 * @property-read string $thumbnail_height Thumbnail height
 * 
 */
class ImagesResult extends AbstractResult
{
	protected $size;
	protected $filename;
	protected $format;
	protected $width;
	protected $height;
	protected $mimetype;
	protected $refererclickurl;
	protected $refererurl;
	protected $thumbnail_url;
	protected $thumbnail_width;
	protected $thumbnail_height;
}