<?php

function getFile($url) {

	/*
	$json_url = $url;
	$ch = curl_init( $json_url );
	$options = array(
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HTTPHEADER => array('Content-type: application/json') ,
	);
	curl_setopt_array( $ch, $options );
	$result = curl_exec($ch); // Getting JSON result string
	*/

	$curl = curl_init();
	curl_setopt_array( $curl, array(
		CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_CONNECTTIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => false,
		CURLOPT_SSL_VERIFYPEER => FALSE,
		CURLOPT_SSL_VERIFYHOST => 2,
		CURLOPT_USERAGENT => 'curl/7.24.0 (x86_64-apple-darwin12.0) libcurl/7.24.0 OpenSSL/0.9.8r zlib/1.2.5',
		CURLOPT_URL => $url ) );

	$result = curl_exec( $curl );
	curl_close( $curl );

	return $result;
}

function getJson($url) {
	// cache files are created like cache/abcdef123456...
	$cacheFile = 'cache' . DIRECTORY_SEPARATOR . md5($url);

	if (file_exists($cacheFile)) {
		$fh = fopen($cacheFile, 'r');
		$cacheTime = trim(fgets($fh));

		// if data was cached recently, return cached data
		if ($cacheTime > strtotime('-60 minutes')) {
			return fread($fh, filesize($cacheFile));
		}

		// else delete cache file
		fclose($fh);
		unlink($cacheFile);
	}

	$json = getFile($url);
	$fh = fopen($cacheFile, 'w');
	fwrite($fh, time() . "\n");
	fwrite($fh, $json);
	fclose($fh);

	return $json;
}


$topics = array(
	array (
		"id" => "technology",
		"title" => "Technology",
		"color" => array(34,136,204), // #28c
	),
	array (
		"id" => "science_and_environment",
		"title" => "Science",
		"color" => array(102,204,51), // #6c3
	),
	array (
		"id" => "entertainment_and_arts",
		"title" => "Entertainment",
		"color" => array(255,102,0), // #f60
	),
	array (
		"id" => "world",
		"title" => "World",
		"color" => array(187,204,17), // #bc1
	),
	array (
		"id" => "headlines",
		"title" => "Headlines",
		"color" => array(136,17,170), // #81a
	),
);

$current_topic = $topics[0]['id'];
$current_topic_index = 0;
if ($_GET && !empty($_GET['topic'])) {
	$out = $_GET['topic'];
	$out_counter = 0;
	foreach ($topics as $topic) {
		if ($topic['id'] == $_GET['topic']) {
			$current_topic = $_GET['topic'];
			$current_topic_index = $out_counter;
		}
		$out_counter++;
	}
}

// $json = getJson('http://api.bbcnews.appengine.co.uk/stories/'.$current_topic);
$json = getJson('https://news.moro.es/api/api.php?id='.$current_topic);
$json = json_decode($json, true);
$json = $json['stories'];

$limit = rand(8, count($json));

$data = array();
for ($i=0; $i < $limit; $i++) {
	$data[] = array(
		'text' => $json[$i]['description'],
		'link' => $json[$i]['link'],
		'date' => date('l jS \of F Y h:i:s A', $json[$i]['published']),
	);
}


?>
