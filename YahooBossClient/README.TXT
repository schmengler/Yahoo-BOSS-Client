+-----------------------------------------------------------------------------+
|                            Yahoo BOSS Client                                |
+-----------------------------------------------------------------------------+

- Synopsis
- Requirements
- Files
- Step-by-Step Usage
- Extending

Synopsis
--------
Yahoo BOSS (Build your Own Search Service) is a free search API. This package
can retrieve results of web, news and image search and also cache them.


Requirements
------------
The package requires PHP 5.3.0 or later with ini setting allow_url_fopen.

To use the package, just include YBC.lib.php

You will need a BOSS AppId from Yahoo. Get one for free at:

	http://developer.yahoo.com/boss


Files
-----
readme.txt - the file you are reading right now
license.txt - BSD license
example.php - example: simple demonstration
YBC.lib.php - library loader, include this file to use the package
YBC/AbstractQuery.php - class file: base class for queries
YBC/AbstractResult.php - class file: base class for result
YBC/Cache.php - class file: cache interface
YBC/CacheException.php - class file: cache exception
YBC/Client.php - class file: main class
YBC/FileCache.php - class file: a filesystem based implementation of cache
YBC/ImagesQuery.php - class file: class for image search queries
YBC/ImagesResult.php - class file: class for image search results
YBC/NewsQuery.php - class file: class for news search queries
YBC/NewsResult.php - class file: class for news search results
YBC/NullCache.php - class file: dummy implementation of cache
YBC/Query.php - class file: query interface
YBC/ResultSet.php - class file: class for the whole result
YBC/WebQuery.php - class file: class for web search queries
YBC/WebResult.php - class file: class for web search results


Step-by-Step Usage
------------------

To initialize the client write

	$ybc = new YBC\Client(APPID);

where APPID is your BOSS AppId (see: http://developer.yahoo.com/boss)

If you want to use the cache, instantiate a cache object and provide it to the
client constructor

	$dir = '/tmp/ybc-cache';
	$cache = new YBC\FileCache($dir);
	$ybc = new YBC\Client(APPID, $cache);

$dir must be the absolute path to an existing writable directory. By default it
is '../cache' relative to the YBC class directory. You can also use your own
caching mechanism (see: Extending)

A query is generated like this:

	$webQuery = new YBC\WebQuery('search term');
	$newsQuery = new YBC\NewsQuery('search term');
	$imagesQuery = new YBC\ImagesQuery('search term');

To determine how many result are shown and beginning from which offset, use
setLimit(), for example to retrieve the first five results (preset is 0,10):

	$webQuery->setLimit(0,5);

To determine a region and language, use setLocale(), which allows different
parameters (preset is 'us-en'):

a) single key:

	$webQuery->setLocale('de'); // region 'de', language 'de'

b) combined key:

	$webQuery->setLocale('us-en'); // region 'us', language 'en'

c) class constant:

	$webQuery->setLocale(YBC\AbstractQuery::LOCALE_HONG_KONG // region 'hk', language 'tzh'

Additionaly you can enforce strict language checking with setStrictLang()

	$webQuery->setStrictLang(true);

To search only selected sites, use setSites() or addSite():

	$webQuery->setSites(array('github.com', 'phpclasses.org');
	$webQuery->addSite('sgh-it.eu');

By default, the search term gets surrounded with <b>-Tags in title and
description of the result. To turn this off, use setRawStyle():

	$webQuery->setRawStyle(true);

These options are available in all query objects (web, news, images). But there
are many more options for each query type, for example:

	// longer preview text:
	$webQuery->setLongAbstract(true);
	// include number of saves in delicious:
	$webQuery->setDeliciousSavesView(true);

	// get only news from the last 2 days:
	$newsQuery->setAge('2d');
	// order news results by date:
	$newsQuery->setOrderBy(YBC\NewsQuery::ORDERBY_DATE);

	// get only images of wallpaper sizes:
	$imagesQuery->setDimensions(YBC\ImagesQuery::DIMENSIONS_WALLPAPER);
	// deactivate filter for offensive content:
	$imagesQuery->setFilter(false);

For all the options see phpDoc comments of YBC\WebQuery, YBC\ImagesQuery and
YBC\NewsQuery

It is also useful to read the BOSS API Guide to see what is possible within BOSS

	http://developer.yahoo.com/search/boss/boss_guide/index.html

Tip: The query object has a fluent interface, you also can write something like:

	$webQuery->setLimit(10,10)->setLongAbstract(true);

After instantiating and if necessary configuring the query object you can
execute the query like so:

	$resultSet = $ybc->query($webQuery);

The returned YBC\ResultSet object is an iterator over YBC\WebResult and provides
some additional infos, for example the total number of hits and a query object
for the next page:

	$totalHits = $resultSet->getTotalhits();
	$nextQuery = $resultSet->getNextpageQuery(); 

To iterate over the results, just use foreach. The result attributes can be
accessed directly:

	foreach($resultSet as $result) {
		echo <<<EOT
<div>
	<h2>$result->title</h2>
	<p>$result->abstract</p>
	<p><a href="$result->clickurl">$result->url</a></p>
	<p>$result->date</p>
</div>
EOT;
	}

For a complete reference about the result classes see phpDoc comments of
YBC\ResultSet, YBC\WebResult, YBC\ImagesResult and YBC\NewsResult. Also -again-
it may be helpful to read the BOSS API Guide.

	http://developer.yahoo.com/search/boss/boss_guide/index.html

Now just go and try it out :-)


Extending
---------

As mentioned above, you can easily implement your own caching mechanisms, i.e.
a MySQL based cache. Just implement the YBC\Cache interface (see YBC/Cache.php)

Note that the get() and delete() methods expect Query objects as parameters. In
the FileCache implementation a hash of the object is used as identifier, which
should work out pretty good:

	$id = md5(serialize($query));

The spl_object_hash() function is NOT appliable here because it only hashes the
object id to identify an object at runtime!