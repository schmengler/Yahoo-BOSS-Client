<?php
/**
 * Abstract class for single seach results
 * 
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2010 SGH informationstechnologie UG
 * @license BSD
 * @link http://creativecommons.org/licenses/BSD/ 
 * @package YBC
 * @version 1.0
 * 
 */
abstract class YBC_AbstractResult
{
	protected $abstract;
	protected $clickurl;
	protected $date;
	protected $title;
	protected $url;

	/**
	 * @access package
	 * @param array $responseArray Array of results from JSON response
	 */
	public function __construct(array $responseArray = array())
	{
		foreach($responseArray as $key=>$value) {
			$this->$key = $value;
		}
	}
	/**
	 * Getter for read-only properties
	 * 
	 * @param string $var
	 * @return string
	 */
	public function __get($var)
	{
		return $this->$var;
	}
}