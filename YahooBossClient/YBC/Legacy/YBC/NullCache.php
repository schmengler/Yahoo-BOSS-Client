<?php
/**
 * Dummy implementation of search result cache, does not cache anything
 * 
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2010 SGH informationstechnologie UG
 * @license BSD
 * @link http://creativecommons.org/licenses/BSD/ 
 * @package YBC
 * @version 1.0
 */
class YBC_NullCache implements YBC_Cache
{
	public function get(YBC_Query $query)
	{
		return null;
	}
	public function save(YBC_ResultSet $result)
	{
	}
	public function delete(YBC_Query $query)
	{
	}
	public function deleteAll()
	{
	}
}