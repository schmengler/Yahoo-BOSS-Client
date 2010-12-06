<?php
/**
 * Interface for YBC_Query objects
 * 
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2010 SGH informationstechnologie UG
 * @license BSD
 * @link http://creativecommons.org/licenses/BSD/ 
 * @package YBC
 * @version 1.0
 *
 */
interface YBC_Query
{
	/**
	 * Returns full BOSS url with given appId
	 * 
	 * @param string $appId
	 */
	public function getBossUrl($appId);
}