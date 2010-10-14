<?php
/**
 * This example shows how to use the Yahoo BOSS Client in general. For information
 * about all the query options and result fields see phpDoc documentation
 */
date_default_timezone_set('Europe/Berlin');


//============================================================================//


/*
 * initialize client and cache
 */
require 'YBC.lib.php';
$appId = 'your-appid-here!';
$cache = new YBC\FileCache();
$ybc = new YBC\Client($appId, $cache);


//============================================================================//


/*
 * build a simple web search query
 */
$query = new YBC\WebQuery('php classes');
$query->setLimit(0, 2)->setLongAbstract(true)->setRawStyle(true)->setLanguageView(true);
/*
 * execute query
 */
$resultSet = $ybc->query($query);
/*
 * output some of the informations
 */
echo 'Total hits for "' . $query->getQuery() . '": ' . $resultSet->getTotalHits() . "\n";
foreach($resultSet as $result) {
	echo "\n";
	echo 'Title: ' . $result->title . "\n";
	echo 'Abstract: ' . $result->abstract . "\n";
	echo 'URL: ' . $result->url . "\n";
	echo 'Language: ' . $result->language . "\n";
}
echo "\n\n";


//============================================================================//


/*
 * now build and execute a query for image search
 */
$query = new YBC\ImagesQuery('paris hilton');
$query->setFilter(false)->setLimit(0, 2);
$resultSet = $ybc->query($query);
echo 'Total hits for "' . $query->getQuery() . '": ' . $resultSet->getTotalHits() . "\n";
foreach($resultSet as $result) {
	echo "\n";
	echo 'Title: ' . $result->title . "\n";
	echo 'Filename: ' . $result->filename . "\n";
	echo 'Abstract: ' . $result->abstract . "\n";
	echo 'URL: ' . $result->url . "\n";
}
echo "\n\n";


//============================================================================//


/*
 * now build and execute a query for news search
 */
$query = new YBC\NewsQuery('censorship');
$query->setAge('30d')->setLimit(0, 2);
$resultSet = $ybc->query($query);
echo 'Total hits for "' . $query->getQuery() . '": ' . $resultSet->getTotalHits() . "\n";
foreach($resultSet as $result) {
	echo "\n";
	echo 'Title: ' . $result->title . "\n";
	echo 'Source: ' . $result->source . "\n";
	echo 'Abstract: ' . $result->abstract . "\n";
	echo 'URL: ' . $result->url . "\n";
	echo 'Language: ' . $result->language . "\n";
}
echo "\n\n";