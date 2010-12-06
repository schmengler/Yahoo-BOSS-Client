<?php
/**
 * News search query
 * 
 * BOSS Version: v1 (state: 2010-10-13)
 * 
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2010 SGH informationstechnologie UG
 * @license BSD
 * @link http://creativecommons.org/licenses/BSD/ 
 * @package YBC
 * @version 1.0
 */
class YBC_NewsQuery extends YBC_AbstractQuery
{
	/**
	 * @var string Results will be returned with the most relevant first
	 */
	const ORDERBY_RELEVANCE = 'relevance';
	/**
	 * @var string Results will be returned with the most recent first
	 */
	const ORDERBY_DATE = 'date';
	
	private static $supportedOrders = array(
		'relevance', 'date'
	);
	
	/**
	 * @var string Age can be specified using a string made an integer and one of the letters "s", "m", "h", "d" and "w" representing seconds, minutes, hours, days and weeks. 
	 */
	protected $age = '7d';
	/**
	 * @var string To order by date add orderby=date to the query string. Results will be returned with the most recent first.  
	 */
	protected $orderby = 'relevance';
	
	public function getVertical() {
		return 'news';
	}
	/**
	 * @return string Age specification: An integer and one of the letters "s", "m", "h", "d" and "w" representing seconds, minutes, hours, days and weeks.
	 */
	public function getAge() {
		return $this->age;
	}
	/**
	 * @return string Order specification: 'date' or 'relevance'
	 */
	public function getOrderBy() {
		return $this->orderby;
	}
	/**
	 * Sets document age restriction
	 * 
	 * Use age to retrieve documents by age:
	 * setAge('[value]d')
	 * NOTE: Maximum [value] cannot be greater than 1000.
	 * The default is 30 days, and valid values are [1-30]d. (News Search maintains a 30-day index.) The following example searches the full index:
	 * setAge('30d')
	 * Age can be specified using a string made an integer and one of the letters "s", "m", "h", "d" and "w" representing seconds, minutes, hours, days and weeks.
	 * No spaces are allowed in the string. Some examples:
	 * setAge('30d');
	 * setAge('1w');
	 * setAge('12h');
	 * To specify an age range two values can be concatenated with a dash/hyphen for example:
	 * setAge('5d-10d'); // Between 5 and 10 days old
	 * setAge('2w-30d'); // Between 2 weeks and 30 days old
	 * Multiple ranges or more than one age parameter is not supported.
	 *  
	 * @param string $age
	 */
	public function setAge($age)
	{
		if (!preg_match('/^[1-3]?[0-9][smhdw](-[1-3]?[0-9][smhdw])?$/', $age)) {
			throw new InvalidArgumentException('Invalid age parameter ' . $age);
		}
		$this->age = $age;
		return $this;
	}
	/**
	 * Sets result order
	 * 
	 * @param string $orderBy valid values are YBC_NewsQuery::ORDERBY_RELEVANCE and YBC_NewsQuery::ORDERBY_DATE
	 */
	public function setOrderBy($orderBy)
	{
		if (!in_array($orderBy, self::$supportedOrders)) {
			throw new InvalidArgumentException('Invalid orderby parameter ' . $orderBy);
		}
		$this->orderBy = $orderBy;
		return $this;
	}
	/**
	 * Define if results should contain the language attribute
	 * 
	 * @param bool $active
	 */
	public function setLanguageView($active)
	{
		$this->view = $active ? 'language' : null;
		return $this;
	}
}