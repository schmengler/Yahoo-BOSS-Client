<?php
namespace YBC;
const BOSS_VERSION = 'v1';
/**
 * The Yahoo BOSS Client main class
 * 
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2010 SGH informationstechnologie UG
 * @license BSD
 * @link http://creativecommons.org/licenses/BSD/ 
 * @package YBC
 * @version 1.0
 */
class Client
{
	/**
	 * @var string
	 */
	private $appId;
	/**
	 * @var YBC\Cache
	 */
	private $cache;
	/**
	 * @var \DateInterval
	 */
	private $defaultCacheLifeTime;

	/**
	 * 
	 * @param string $appId
	 * @param YBC\Cache $cache YBC cache, if omitted, no cache will be used
	 */
	public function __construct($appId, Cache $cache = null)
	{
		$this->appId = $appId;
		$this->cache = $cache ?: new NullCache();
		$this->defaultCacheLifeTime = new \DateInterval('P1D');
	}
	/**
	 * 
	 * @param \DateInterval $defaultCacheLifeTime default lifetime of cached results
	 * @return YBC\Cache
	 */
	public function setDefaultCacheLifeTime(\DateInterval $defaultCacheLifeTime)
	{
		$this->defaultCacheLifeTime = $defaultCacheLifeTime;
		return $this;
	}
	/**
	 * @param Query $query
	 * @param bool $useCache
	 * @param \DateInterval $cacheLifeTime
	 * @return YBC\ResultSet
	 */
	public function query(Query $query, $useCache = true, \DateInterval $cacheLifeTime = null)
	{
		if ($useCache) {
			$cachedResult = $this->cache->get($query);
			if ($cachedResult!==null) {
				return $cachedResult;
			}
		}
		$result = $this->makeResultSet($query, file_get_contents($query->getBossUrl($this->appId)));
		if ($useCache) {
			$this->cache->save($result, $cacheLifeTime ?: $this->defaultCacheLifeTime);
		}
		return $result;
	}
	private function makeResultSet(Query $query, $jsonResult)
	{
		$arrayResult = json_decode($jsonResult, true);
		return new ResultSet($arrayResult['ysearchresponse'], $query, new \DateTime);
	}
}