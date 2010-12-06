<?php
/**
 * Result set returned by search query
 * 
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2010 SGH informationstechnologie UG
 * @license BSD
 * @link http://creativecommons.org/licenses/BSD/ 
 * @package YBC
 * @version 1.0
 */
class YBC_ResultSet implements IteratorAggregate
{
	/**
	 * @var YBC_Query
	 */
	private $query;
	/**
	 * @var DateTime
	 */
	private $time;
	/**
	 * @var int only used for serialization
	 **/
	private $_timestamp;

	private $responsecode;
	private $nextpage;
	private $totalhits;
	private $deephits;
	private $count;
	private $start;
	/**
	 * @var AbstractResult[]
	 */
	private $results = array();
	/**
	 * 
	 * @access package
	 * @param array $responseArray Array from JSON response
	 * @param YBC_Query $query Corresponding YBC_Query object
	 * @param DateTime $time Time when the Result was fetched from BOSS API
	 */
	public function __construct(array $responseArray, YBC_Query $query, DateTime $time)
	{
		foreach($responseArray as $key=>$value) {
			switch($key) {
				case 'resultset_web':
					foreach($value as $result) {
						$this->results[] = new YBC_WebResult($result);
					}
					break;
				case 'resultset_news':
					foreach($value as $result) {
						$this->results[] = new YBC_NewsResult($result);
					}
					break;
				case 'resultset_images':
					foreach($value as $result) {
						$this->results[] = new YBC_ImagesResult($result);
					}
					break;
				default:
					$this->$key = $value;
			}
		}
		$this->query = $query;
		$this->time = $time;
	}
	public function __sleep()
	{
		$this->_timestamp = $this->time->format('U');
		return array_keys(get_object_vars($this));
	}
	public function __wakeup()
	{
		$this->time = new DateTime('@'.$this->_timestamp);
	}	
	/**
	 * Implementation of IteratorAggregate
	 * 
	 * @return ArrayIterator Iterator over results.
	 */
	public function getIterator()
	{
		return new ArrayIterator($this->results);
	}
	/**
	 * @return YBC_Query Query that retrieved this resultset
	 */
	public function getQuery() {
		return $this->query;
	}
	/**
	 * @return int Response code, should be 200
	 */
	public function getResponsecode() {
		return (int)$this->responsecode;
	}
	/**
	 * @return string BOSS API query string for the next page
	 */
	public function getNextpage() {
		return $this->nextpage;
	}
	/**
	 * Returns YBC_Query object for the next page
	 * 
	 * @return YBC_Query Query object for the next page
	 * @todo allow other query implementations?
	 */
	public function getNextpageQuery() {
		switch($this->query->getVertical()) {
			case 'web':
				$class = 'WebQuery'; break;
			case 'news':
				$class = 'NewsQuery'; break;
			case 'images':
				$class = 'ImagesQuery'; break;
			default:
				throw new UnexpectedValueException('YBC_Query::getVertical() returned strange value: ' . $this->query->getVertical());
		}
		return new $class($this->nextpage);
	}
	/**
	 * @return int A result count that reflects no duplicates. The totalhits value is an approximation, and its value may change depending on the requested “start” and “count” values, because the approximation is adjusted as more exact result URLs are processed. A normal use for totalhits is to determine how many pages of results to offer in search result navigation. Since totalhits is an approximation, and the value may change as “start” increases on successive result pages, the result page navigation may need to be adjusted as a user browses result pages. 
	 */
	public function getTotalhits() {
		return (int)$this->totalhits;
	}
	/**
	 * @return int It returns an approximate count that reflects duplicate documents and all documents from a host. deephits, therefore, is invariably equal to or larger than TotalHits. The deephits value is normally used as an information display on a search result page, reporting how many total documents matched the search terms. 
	 */
	public function getDeephits() {
		return (int)$this->deephits;
	}
	/**
	 * @return int Indicates how many results to show per page. The value shown in results is the smaller of the default or explicit “count” request argument value or the actual number of results in the response. The result set will include the requested “count” unless there are fewer than that number of matching documents. 
	 */
	public function getCount() {
		return (int)$this->count;
	}
	/**
	 * @return int The first numeric result to display. The value shown in results echoes the default or explicit “start” request argument value. When used with ”count”, you can display follow-on pages of results. 
	 */
	public function getStart() {
		return (int)$this->start;
	}
	/**
	 * @return AbstractResult[] array of results
	 */
	public function getResults() {
		return $this->results;
	}


	
}