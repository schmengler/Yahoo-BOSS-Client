<?php
/**
 * Interface for search result cache
 * 
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2010 SGH informationstechnologie UG
 * @license BSD
 * @link http://creativecommons.org/licenses/BSD/ 
 * @package YBC
 * @version 1.0
 */
interface YBC_Cache
{
	/**
	 * Get a result from cache
	 * 
	 * @param YBC_Query $query
	 * @return YBC_ResultSet|null
	 */
	public function get(YBC_Query $query);
	/**
	 * YBC_Cache a result
	 * 
	 * @param YBC_ResultSet $result
	 * @param int $lifetime
	 * @return void
	 */
	public function save(YBC_ResultSet $result, $lifetime);
	/**
	 * Delete a single cached result
	 * 
	 * @param YBC_Query $query
	 * @return void
	 */
	public function delete(YBC_Query $query);
	/**
	 * Delete all cached results
	 */
	public function deleteAll();
}