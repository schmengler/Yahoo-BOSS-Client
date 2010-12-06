<?php
/**
 * Single search result of news search
 * 
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2010 SGH informationstechnologie UG
 * @license BSD
 * @link http://creativecommons.org/licenses/BSD/ 
 * @package YBC
 * @version 1.0 
 * 
 * @property-read string $abstract Abstract of news story.
 * @property-read string $clickurl Click this link to reach story, if present.
 * @property-read string $language Language of story.  
 * @property-read string $date Last publication date of story. 
 * @property-read string $title Title (or Headline) of the story. 
 * @property-read string $url Link to story.
 * @property-read string $source Source publication. 
 * @property-read string $sourceurl URL of source publication. 
 * @property-read string $time Last publication time of story.
 * 
 */
class YBC_NewsResult extends YBC_AbstractResult
{
	protected $language;
	protected $source;
	protected $sourceurl;
	protected $time;
}