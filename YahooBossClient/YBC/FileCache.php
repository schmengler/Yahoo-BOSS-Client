<?php
namespace YBC;

/**
 * File based implementation of search result cache
 * 
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2010 SGH informationstechnologie UG
 * @license BSD
 * @link http://creativecommons.org/licenses/BSD/ 
 * @package YBC
 * @version 1.0
 */
class FileCache implements Cache
{
	/**
	 * @var string absolute path to cache directory
	 */
	private $cacheDir;
	/**
	 * @var string cache filenames
	 */
	private static $cachePattern = 'ybc_%s.cache.php';
	/**
	 * 
	 * @param string $cacheDir absolute path to cache directory
	 */
	public function __construct($cacheDir = null)
	{
		$this->cacheDir = $cacheDir ?: realpath(__DIR__ . '/../cache');
	}
	/**
	 * Get a result from cache
	 * 
	 * @param Query $query
	 * @return ResultSet|null
	 */
	public function get(Query $query)
	{
		$file = $this->queryCacheFile($query);
		if (!file_exists($file)) {
			return null;
		}
		$cached = include $file;
		if (!is_array($cached) || !isset($cached['expires'], $cached['result'])) {
			throw new CacheException('Cache file ' . $file . ' corrupt.');
		}
		if ($cached['expires'] <= time()) {
			return null;
		}
		return unserialize($cached['result']);
	}
	/**
	 * Cache a result
	 * 
	 * @param ResultSet $result
	 * @param DateInterval $lifetime
	 * @return void
	 */
	public function save(ResultSet $result, \DateInterval $lifetime)
	{
		$file = $this->queryCacheFile($result->getQuery());
		$now = new \DateTime;
		$data = sprintf(
			"<?php return array('expires' => %d, 'result' => '%s');",
			$now->add($lifetime)->getTimestamp(),
			addcslashes(serialize($result), "'")
		);
		file_put_contents($file, $data);
	}
	/**
	 * Delete a single cached result
	 * 
	 * @param Query $query
	 * @return void
	 */
	public function delete(Query $query)
	{
		$file = $this->queryCacheFile($query);
		if (file_exists($file)) {
			unlink($file);
		}
	}
	/**
	 * Delete all cached results
	 */
	public function deleteAll()
	{
		foreach(new GlobIterator($this->cacheDir . '/ybc_*.cache.php', FilesystemIterator::CURRENT_AS_PATHNAME ) as $file) {
			unlink($file);
		}
	}
	/**
	 * Deletes expired cache files. It can check all cache files which may be resource expensive or just look for old files and stop after a specific number of files are deleted.
	 * 
	 * @param \DateInterval $olderThan if set, only cache files older than this interval will be checked to save cpu and filesystem usage
	 * @param int $limit if set, the garbage collector stops after deleting $limit files. This is useful if you run it within every nth user request.
	 */
	public function garbageCollector(\DateInterval $olderThan = null, $limit = null)
	{
		$dateOlderThan = new DateTime();
		if ($olderThan) $dateOlderThan->sub($olderThan);
		$counter = 0;
		foreach(new GlobIterator($this->cacheDir . '/' . sprintf(self::$cachePattern, '*')) as $filePath=>$fileInfo) {
			if ($fileInfo->getMTime < $dateOlderThan->getTimestamp()) {
				$cached = include $filePath;
				if (!is_array($cached) || !isset($cached['expires'], $cached['result']) || $cached['expires'] <= time()) {
					unlink($filePath);
					if (++$counter === $limit) {
						return;
					}
				}
			}
		}
	}
	private function queryCacheFile(Query $query)
	{
		return $this->cacheDir . '/' . sprintf(self::$cachePattern, md5(serialize($query)));
	}
}