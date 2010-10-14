<?php
namespace YBC;
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
class NullCache implements Cache
{
	public function get(Query $query)
	{
		return null;
	}
	public function save(ResultSet $result)
	{
	}
	public function delete(Query $query)
	{
	}
	public function deleteAll()
	{
	}
}