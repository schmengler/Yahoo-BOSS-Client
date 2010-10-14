<?php
namespace YBC;
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
interface Cache
{
	/**
	 * Get a result from cache
	 * 
	 * @param Query $query
	 * @return ResultSet|null
	 */
	public function get(Query $query);
	/**
	 * Cache a result
	 * 
	 * @param ResultSet $result
	 * @param DateInterval $lifetime
	 * @return void
	 */
	public function save(ResultSet $result, \DateInterval $lifetime);
	/**
	 * Delete a single cached result
	 * 
	 * @param Query $query
	 * @return void
	 */
	public function delete(Query $query);
	/**
	 * Delete all cached results
	 */
	public function deleteAll();
}