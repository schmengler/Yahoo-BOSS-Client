<?php
namespace YBC;
/**
 * Web search query
 * 
 * BOSS Version: v1 (state: 2010-10-13)
 * Note: since YBC uses the JSON format to retrieve and store results, Searchmonkey views are not supported
 * 
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2010 SGH informationstechnologie UG
 * @license BSD
 * @link http://creativecommons.org/licenses/BSD/ 
 * @package YBC
 * @version 1.0
 */
class WebQuery extends AbstractQuery
{
	/**
	 * @var string HTML: HTML documents
	 */
	const TYPE_HTML = 'html';
	/**
	 * @var string TXT: Plain text documents
	 */
	const TYPE_TEXT = 'text';
	/**
	 * @var string PDF: Portable Document Format
	 */
	const TYPE_PDF = 'pdf';
	/**
	 * @var string XLS,XLA,XL: Microsoft Excel
	 */
	const TYPE_XL = 'xl';
	/**
	 * @var string DOC: Microsoft Word
	 */
	const TYPE_MSWORD = 'msword';
	/**
	 * @var string PPT: Microsoft Power Point
	 */
	const TYPE_PPT = 'ppt';
	/**
	 * @var string Contains TYPE_XL, TYPE_MSWORD, TYPE_PPT
	 */
	const TYPEGROUP_MSOFFICE = 'msoffice';
	/**
	 * @var string Contains TYPE_TEXT, TYPE_PDF, TYPE_XL, TYPE_MSWORD, TYPE_PPT
	 */
	const TYPEGROUP_NONHTML = 'nonhtml';

	private static $supportedTypes = array(
		'html', 'text', 'pdf', 'xl', 'msword', 'ppt', 'msoffice', 'nonhtml'
	);
	/**
	 * @var string Filter out adult or hate content. Syntax: [-porn] [-hate]
	 */
	protected $filter;
	/**
	 * @var string Specifies document formats (pdf, msoffice,etc). 
	 */
	protected $type;
	/**
	 * @var string abstract=long will retrieve and display an abstract of a web document up to 300 characters. This expanded abstract provides the requestor with a larger piece of information to work from in a web search query. The default for abstract is an abbreviated description
	 */
	protected $abstract;
	/**
	 * @var string
	 */
	protected $view;
	
	public function getVertical() {
		return 'web';
	}
	/**
	 * @return string[] array with filter names ('hate', 'porn') as keys and boolean values
	 */
	public function getFilter() {
		$filter = array();
		$filter['hate'] = $this->hasHateFilter();
		$filter['porn'] = $this->hasPornFilter();
		return $filter;
	}
	/**
	 * @return bool activated porn filter?
	 */
	public function hasPornFilter() {
		return strpos($this->filter, '-porn')!==false;
	}
	/**
	 * @return bool activated hate filter?
	 */
	public function hasHateFilter() {
		return strpos($this->filter, '-hate')!==false;
	}
	/**
	 * @return string[] array with document types as keys and boolean values (include/exclude)
	 */
	public function getTypes() {
		if (empty($this->type)) {
			return array();
		}
		$result = array();
		$_types = explode(',', $this->type);
		foreach($_types as $type) {
			if ($type[0]==='-') {
				$result[substr($type,1)] = false;
			} else {
				$result[$type] = true;
			}
		}
		return $result;
	}
	/**
	 * @return bool long abstract (up to 300 characters)?
	 */
	public function isLongAbstract() {
		return $this->abstract==='long';
	}
	/**
	 * Sets content filter
	 * 
	 * @param bool[] $filter array with filter names ('hate', 'porn') as keys and boolean values (true=filter on)
	 * @return YBC\WebQuery
	 */
	public function setFilter(array $filter)
	{
		$_filter = '';
		if ($filter['hate']) $_filter .= '-hate';
		if ($filter['porn']) $_filter .= ' -porn';
		$this->filter = $_filter;
		return $this;
	}
	/**
	 * Sets porn filter
	 * 
	 * @param bool $active
	 * @return YBC\WebQuery
	 */
	public function setPornFilter($active)
	{
		$filter = $this->getFilter();
		$filter['porn'] = (bool)$active;
		$this->setFilter($filter);
		return $this;
	}
	/**
	 * Sets hate filter
	 * 
	 * @param bool $active
	 * @return YBC\WebQuery
	 */
	public function setHateFilter($active)
	{
		$filter = $this->getFilter();
		$filter['hate'] = (bool)$active;
		$this->setFilter($filter);
		return $this;
	}
	/**
	 * Sets document types to include and exclude
	 * 
	 * @param array $types array with types as keys and boolean values
	 * @return YBC\WebQuery
	 */
	public function setTypes(array $types)
	{
		$_types = array();
		foreach($types as $type => $selected) {
			if (!in_array($type, self::$supportedTypes)) {
				throw new \InvalidArgumentException('Invalid type ' . $type);
			}
			$_types[] = $selected ? $type : '-'.$type;
		}
		$this->type = join(',', $_types);
		return $this;
	}
	/**
	 * Sets or unsets the abstract=long parameter
	 * 
	 * @param bool $longAbstract Retrieve long abstract (up to 300 characters)?
	 * @return YBC\WebQuery
	 */
	public function setLongAbstract($longAbstract)
	{
		$this->abstract = $longAbstract ? 'long' : null;
		return $this;
	}
	private function setSingleView($type, $active)
	{
		$view = empty($this->view) ? array() : explode(',', $this->view);
		$key = array_search($type, $view, true);
		if ($key!==false && !$active) {
			unset($view[$key]);
		} elseif ($active) {
			$view[] = $type;
		}
		$this->view = join(',', $view);
		return $this;
	}
	/**
	 * Sets or unsets the keyterms view
	 * 
	 * @param bool $active Retrieve related words and phrases for each search result. 
	 */
	public function setKeytermsView($active)
	{
		return $this->setSingleView('keyterms', $active);
	}
	/**
	 * Sets or unsets the delicious_saves view
	 * 
	 * @param bool $active Retrieve the number of times a document was saved in delicious. 
	 */
	public function setDeliciousSavesView($active)
	{
		return $this->setSingleView('delicious_saves', $active);
	}
	/**
	 * Sets or unsets the delicious_toptags view
	 * 
	 * @param bool $active Retrieve the top public delicious tags for a document and the counts associated with each tag. 
	 */
	public function setDeliciousTopTagsView($active)
	{
		return $this->setSingleView('delicious_toptags', $active);
	}
	/**
	 * Sets or unsets the language view
	 * 
	 * @param bool $active Retrieve the language of a document.
	 */
	public function setLanguageView($active)
	{
		return $this->setSingleView('language', $active);
	}
}