<?php
namespace YBC;
/**
 * Abstract class for search queries
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
abstract class AbstractQuery implements Query
{
	const LOCALE_ARGENTINA = 'Argentina';
	const LOCALE_AUSTRIA = 'Austria';
	const LOCALE_AUSTRALIA = 'Australia';
	const LOCALE_BRAZIL = 'Brazil';
	const LOCALE_CANADA_ENGLISH = 'Canada - English';
	const LOCALE_CANADA_FRENCH = 'Canada - French';
	const LOCALE_CATALAN = 'Catalan';
	const LOCALE_CHILE = 'Chile';
	const LOCALE_COLUMBIA = 'Columbia';
	const LOCALE_CZECH_REPUBLIC = 'Czech Republic';
	const LOCALE_DENMARK = 'Denmark';
	const LOCALE_FINLAND = 'Finland';
	const LOCALE_FRANCE = 'France';
	const LOCALE_GERMANY = 'Germany';
	const LOCALE_HONG_KONG = 'Hong Kong';
	const LOCALE_HUNGARY = 'Hungary';
	const LOCALE_INDONESIA_ENGLISH = 'Indonesia - English';
	const LOCALE_INDONESIA_INDONESIAN = 'Indonesia - Indonesian';
	const LOCALE_INDIA = 'India';
	const LOCALE_ISRAEL = 'Israel';
	const LOCALE_ITALY = 'Italy';
	const LOCALE_JAPAN = 'Japan';
	const LOCALE_KOREA = 'Korea';
	const LOCALE_MALAYSIA_ENGLISH = 'Malaysia - English';
	const LOCALE_MALAYSIA = 'Malaysia';
	const LOCALE_MEXICO = 'Mexico';
	const LOCALE_NETHERLANDS = 'Netherlands';
	const LOCALE_NEW_ZEALAND = 'New Zealand';
	const LOCALE_NORWAY = 'Norway';
	const LOCALE_PERU = 'Peru';
	const LOCALE_PHILIPPINES = 'Philippines';
	const LOCALE_PHILIPPINES_ENGLISH = 'Philippines - English';
	const LOCALE_ROMANIA = 'Romania';
	const LOCALE_RUSSIA = 'Russia';
	const LOCALE_SINGAPORE = 'Singapore';
	const LOCALE_SPAIN = 'Spain';
	const LOCALE_SWEDEN = 'Sweden';
	const LOCALE_SWITZERLAND_FRENCH = 'Switzerland - French';
	const LOCALE_SWITZERLAND_GERMAN = 'Switzerland - German';
	const LOCALE_SWITZERLAND_ITALIAN = 'Switzerland - Italian';
	const LOCALE_THAILAND = 'Thailand';
	const LOCALE_TAIWAN = 'Taiwan';
	const LOCALE_TURKEY = 'Turkey';
	const LOCALE_UNITED_KINGDOM = 'United Kingdom';
	const LOCALE_UNITED_STATES_ENGLISH = 'United States - English';
	const LOCALE_UNITED_STATES_SPANISH = 'United States - Spanish';
	const LOCALE_VENEZUELA = 'Venezuela';
	const LOCALE_VIETNAM = 'Vietnam';
	/**
	 * @var string[][] supported combinations of region and lang
	 * @link http://developer.yahoo.com/search/boss/boss_guide/supp_regions_lang.html
	 */
	private static $supportedRegionsAndLanguages = array(
		'Argentina' => array('region' => 'ar', 'lang' => 'es'),
		'Austria' => array('region' => 'at', 'lang' => 'de'),
		'Australia' => array('region' => 'au', 'lang' => 'en'),
		'Brazil' => array('region' => 'br', 'lang' => 'pt'),
		'Canada - English' => array('region' => 'ca', 'lang' => 'en'),
		'Canada - French' => array('region' => 'ca', 'lang' => 'fr'),
		'Catalan' => array('region' => 'ct', 'lang' => 'ca'),
		'Chile' => array('region' => 'cl', 'lang' => 'es'),
		'Columbia' => array('region' => 'co', 'lang' => 'es'),
		'Czech Republic' => array('region' => 'cz', 'lang' => 'cs'),
		'Denmark' => array('region' => 'dk', 'lang' => 'da'),
		'Finland' => array('region' => 'fi', 'lang' => 'fi'),
		'France' => array('region' => 'fr', 'lang' => 'fr'),
		'Germany' => array('region' => 'de', 'lang' => 'de'),
		'Hong Kong' => array('region' => 'hk', 'lang' => 'tzh'),
		'Hungary' => array('region' => 'hu', 'lang' => 'hu'),
		'Indonesia - English' => array('region' => 'id', 'lang' => 'en'),
		'Indonesia - Indonesian' => array('region' => 'id', 'lang' => 'id'),
		'India' => array('region' => 'in', 'lang' => 'en'),
		'Israel' => array('region' => 'il', 'lang' => 'he'),
		'Italy' => array('region' => 'it', 'lang' => 'it'),
		'Japan' => array('region' => 'jp', 'lang' => 'jp'),
		'Korea' => array('region' => 'kr', 'lang' => 'kr'),
		'Malaysia - English' => array('region' => 'my', 'lang' => 'en'),
		'Malaysia' => array('region' => 'my', 'lang' => 'ms'),
		'Mexico' => array('region' => 'mx', 'lang' => 'es'),
		'Netherlands' => array('region' => 'nl', 'lang' => 'nl'),
		'New Zealand' => array('region' => 'nz', 'lang' => 'en'),
		'Norway' => array('region' => 'no', 'lang' => 'no'),
		'Peru' => array('region' => 'pe', 'lang' => 'es'),
		'Philippines' => array('region' => 'ph', 'lang' => 'tl'),
		'Philippines - English' => array('region' => 'ph', 'lang' => 'en'),
		'Romania' => array('region' => 'ro', 'lang' => 'ro'),
		'Russia' => array('region' => 'ru', 'lang' => 'ru'),
		'Singapore' => array('region' => 'sg', 'lang' => 'en'),
		'Spain' => array('region' => 'es', 'lang' => 'es'),
		'Sweden' => array('region' => 'se', 'lang' => 'sv'),
		'Switzerland - French' => array('region' => 'ch', 'lang' => 'fr'),
		'Switzerland - German' => array('region' => 'ch', 'lang' => 'de'),
		'Switzerland - Italian' => array('region' => 'ch', 'lang' => 'it'),
		'Thailand' => array('region' => 'th', 'lang' => 'th'),
		'Taiwan' => array('region' => 'tw', 'lang' => 'tzh'),
		'Turkey' => array('region' => 'tr', 'lang' => 'tr'),
		'United Kingdom' => array('region' => 'uk', 'lang' => 'en'),
		'United States - English' => array('region' => 'us', 'lang' => 'en'),
		'United States - Spanish' => array('region' => 'us', 'lang' => 'es'),
		'Venezuela' => array('region' => 've', 'lang' => 'es'),
		'Vietnam' => array('region' => 'vn', 'lang' => 'vi')
	);
	/**
	 * @var string search term
	 */
	protected $query;
	/**
	 * @var int Ordinal position of first result. First position is 0. Default sets start to 0. 
	 */
	protected $start = 0;
	/**
	 * @var int Total number of results to return. Maximum value is 50. Default sets count to 10.
	 */
	protected $count = 10;
	/**
	 * @var string Specifies the language search product to query. Default sets lang to "en". Must be used in parallel with region. Other language results may appear in results. For strict filtering use the stringlang parameter described below.
	 * @see  $supportedRegionsAndLanguages
	 */
	protected $lang = 'en';
	/**
	 * @var string Specifies which regional (country) search product to query. Default sets region to "us". Must be used in parallel with lang.
	 * @see  $supportedRegionsAndLanguages
	 */
	protected $region = 'us';
	/**
	 * @var int Default is 0. (no strictness enforced) Setting strictlang=1  activates the strict language filtering based on the lang parameter defined in the query. 
	 */
	protected $strictlang;
	/**
	 * @var string Restrict BOSS search results to a set of pre-defined sites. Multiple sites must be comma separated. Example: (sites=abc.com,cnn.com). The Images service does not yet support multiple sites. 
	 */
	protected $sites;
	/**
	 * @see WebQuery::$view, ImageQuery::$view, NewsQuery::$view
	 */
	protected $view;
	/**
	 * @var bool By default for web search result titles and abstracts contain <b> and </b> HTML tags around the search term. Use style=raw to remove the bold tags around the search terms in titles and abstracts. 
	 */
	protected $style;

	/**
	 * Identifies search type (web, images, news)
	 */
	abstract public function getVertical();
	/**
	 * @param string $query search term or query string like /ysearch/web/v1/foo?params
	 */
	public function __construct($query)
	{
		if (0===preg_match('#/ysearch/(.+)/(.+)/(.+)\?(.+)$#U', $query, $matches)) {
			$this->setQuery($query);
			return;
		}
		list($queryString, $vertical, $version, $search, $params) = $matches;
		$this->setQuery(urldecode($search));
		$queryAttributes = array_keys(get_class_vars(get_class($this)));
		parse_str($params, $arrayParams);
		foreach($arrayParams as $key=>$value) {
			if (in_array($key, $queryAttributes)) {
				$this->$key = $value;
			}
		}
	}
	/**
	 * @return string Search term
	 */
	public function getQuery() {
		return $this->query;
	}
	/**
	 * @return int Ordinal position of first result. First position is 0.
	 */
	public function getStart() {
		return (int)$this->start;
	}
	/**
	 * @return int Total number of results to return.
	 */
	public function getCount() {
		return $this->count;
	}
	/**
	 * @return string The language search product to query.
	 */
	public function getLang() {
		return $this->lang;
	}
	/**
	 * @return string The regional (country) search product to query.
	 */
	public function getRegion() {
		return $this->region;
	}
	/**
	 * @return string A locale string of format [region]-[lang]
	 */
	public function getLocale() {
		return sprintf('%s-%s', $this->region, $this->lang);
	}
	/**
	 * @return bool The strict language filtering based on the lang parameter.
	 */
	public function isStrictLang() {
		return (bool)$this->strictlang;
	}
	/**
	 * @return string[] Sites to which the search result is restricted. Empty array for no restriction.
	 */
	public function getSites() {
		return empty($this->sites)
			? array()
			: explode(',', $this->sites);
	}
	/**
	 * @return string View specification
	 */
	public function getView() {
		return $this->view;
	}
	/**
	 * @return string 'raw' if the bold tags around the search terms in titles and abstracts should be removed.
	 */
	public function getStyle() {
		return $this->style;
	}
	/**
	 * @return bool true if the bold tags around the search terms in titles and abstracts should be removed.
	 */
	public function isRawStyle() {
		return $this->style==='raw';
	}
	/**
	 * Sets search query
	 * 
	 * @param string $query
	 * @return YBC\Query
	 */
	public function setQuery($query)
	{
		$this->query = $query;
		return $this;
	}
	/**
	 * Sets start and count positions of resultset
	 * 
	 * @param int $start
	 * @param int $count
	 * @return YBC\Query
	 */
	public function setLimit($start, $count)
	{
		$this->start = (int)$start;
		if ($this->start < 0) {
			$this->start = 0;
		}
		$this->count = (int)$count;
		if ($this->count > 50) {
			$this->count = 50;
		} elseif ($this->count < 1) {
			$this->count = 1;
		}
		return $this;
	}
	/**
	 * Sets region and lang on the basis of a locale string. The string can be in
	 * different formats:
	 * 'us-en': sets region to 'us' and language to 'en'
	 * 'de': sets region to 'de' and language to 'de'
	 * YBC\AbstractQuery::LOCALE_HONG_KONG: sets region to 'hk' and language to 'tzh'
	 * 
	 * @param string $locale
	 * @return YBC\Query
	 */
	public function setLocale($locale)
	{
		if (array_key_exists($locale, self::$supportedRegionsAndLanguages)) {
			list($this->region, $this->lang) = self::$supportedRegionsAndLanguages[$locale];
			return $this;
		}
		list($region, $lang) = explode('-', $locale) + array(1=>$locale);
		if (in_array(array('region' => $region, 'lang' => $lang), self::$supportedRegionsAndLanguages)) {
			$this->region = $region;
			$this->lang = $lang;
			return $this;
		}
		throw new \InvalidArgumentException('Invalid locale string ' . $locale);
	}
	/**
	 * Sets strict language filtering
	 * 
	 * @param bool $strict
	 * @return YBC\Query
	 */
	public function setStrictLang($strict)
	{
		$this->strictLang = $strict ? 1 : 0;
		return $this;
	}
	/**
	 * Sets sites to search
	 * 
	 * @param string[] $sites
	 */
	public function setSites(array $sites)
	{
		$this->sites = join(',', $sites);
		return $this;
	}
	/**
	 * Adds site to search
	 * 
	 * @param string $site
	 */
	public function addSite($site)
	{
		$sites = $this->getSites();
		$sites[] = $site;
		$this->setSites($sites);
		return $this;
	}
	/**
	 * Sets view parameter
	 * 
	 * @param string $view
	 */
	public function setView($view)
	{
		$this->view = $view;
		return $this;
	}
	/**
	 * Sets style=raw parameter
	 * 
	 * @param bool $raw
	 */
	public function setRawStyle($raw)
	{
		$this->style = $raw ? 'raw' : null;
		return $this;
	}
	/**
	 * @return url encoded query string
	 */
	public function getParameterString()
	{
		return http_build_query($this);
	}
	/**
	 * Returns full BOSS url with given appId
	 * 
	 * @param string $appId
	 */
	public function getBossUrl($appId){
		return sprintf('http://boss.yahooapis.com/ysearch/%s/%s/%s?appid=%s&%s',
			urlencode($this->getVertical()),
			urlencode(BOSS_VERSION),
			urlencode($this->getQuery()),
			urlencode($appId),
			$this->getParameterString()
		);
	}
}