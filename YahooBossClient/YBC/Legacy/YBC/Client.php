<?php
define('BOSS_VERSION', 'v1');
/**
 * The Yahoo BOSS YBC_Client main class
 * 
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2010 SGH informationstechnologie UG
 * @license BSD
 * @link http://creativecommons.org/licenses/BSD/ 
 * @package YBC
 * @version 1.0
 */
class YBC_Client
{
	/**
	 * @var string
	 */
	private $appId;
	/**
	 * @var YBC_Cache
	 */
	private $cache;
	/**
	 * @var DateInterval
	 */
	private $defaultCacheLifeTime;

	/**
	 * 
	 * @param string $appId
	 * @param YBC_Cache $cache YBC cache, if omitted, no cache will be used
	 */
	public function __construct($appId, YBC_Cache $cache = null)
	{
		$this->appId = $appId;
		$this->cache = $cache ? $cache : new YBC_NullCache();
		$this->defaultCacheLifeTime = 24 * 60 * 60;
	}
	/**
	 * 
	 * @param int $defaultCacheLifeTime default lifetime of cached results
	 * @return YBC_Cache
	 */
	public function setDefaultCacheLifeTime($defaultCacheLifeTime)
	{
		$this->defaultCacheLifeTime = $defaultCacheLifeTime;
		return $this;
	}
	/**
	 * @param YBC_Query $query
	 * @param bool $useCache
	 * @param int $cacheLifeTime
	 * @return YBC_ResultSet
	 */
	public function query(YBC_Query $query, $useCache = true, $cacheLifeTime = null)
	{
		if ($useCache) {
			$cachedResult = $this->cache->get($query);
			if ($cachedResult!==null) {
				return $cachedResult;
			}
		}
		$result = $this->makeResultSet($query, file_get_contents($query->getBossUrl($this->appId)));
		if ($useCache) {
			$this->cache->save($result, $cacheLifeTime ? $cacheLifeTime : $this->defaultCacheLifeTime);
		}
		return $result;
	}
	private function makeResultSet(YBC_Query $query, $jsonResult)
	{
		$arrayResult = json_decode($jsonResult, true);
		return new YBC_ResultSet($arrayResult['ysearchresponse'], $query, new DateTime);
	}
}