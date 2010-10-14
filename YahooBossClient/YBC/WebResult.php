<?php
namespace YBC;
/**
 * Single search result of web search
 * 
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2010 SGH informationstechnologie UG
 * @license BSD
 * @link http://creativecommons.org/licenses/BSD/ 
 * @package YBC
 * @version 1.0
 * 
 * @property-read string $abstract Abstract with keywords highlighted with HTML tags. abstract=long  will retrieve and display an abstract of a web document up to 300 characters. This expanded abstract provides the requester with a larger piece of information to work from in a web search query. 
 * @property-read string $clickurl Returns a navigation URL that leads to the target URL for each result. A clickurl might lead through a redirect server, which provides Yahoo! with important usage data from search result sets. See coding requirement (url  vs clickurl) in overview 
 * @property-read string $date Returns date in YYYY/MM/DD format
 * @property-read string $dispurl Returns the URLs of documents matching the query result. Use this field only for display purposes on result pages. To direct search users to the target document, use the clickurl value 
 * @property-read string $language The language of the document.
 * @property-read string $size Returns the document’s size in bytes
 * @property-read string $title Title with keywords highlighted with HTML tags
 * @property-read string $url URL of result
 * @property-read string $delicious_saves The number of times a document was saved in delicious.
 * @property-read string $delicious_toptags Retrieves the top public delicious tags for a document and the counts associated with each tag. 
 * @property-read string $keyterms When view=keyterms is used in query string the keyterms  section is included in the response. This includes a list of related words and phrases with the <term> subheadings. 
 * 
 */
class WebResult extends AbstractResult
{
	protected $size;
	protected $dispurl;
	protected $language;
	protected $delicious_saves;
	protected $delicious_toptags;
	protected $keyterms;
}