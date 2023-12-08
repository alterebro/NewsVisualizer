<?php 

$ids = array(
	'technology',
	'science_and_environment',
	'entertainment_and_arts',
	'world',
	'headlines'
);
$req = strtoupper($_SERVER['REQUEST_METHOD']);
$req_id = (isset($_GET) && isset($_GET['id'])) ? $_GET['id'] : false;

// Check first GET Params
if ( $req != 'GET' || !in_array($req_id, $ids)) { die( 'Bad request' ); }

function getRemoteData($path) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $path);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); 
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

$url_bit = ($req_id == 'headlines') ? '' : '/'.$req_id;
$feed_url = 'https://feeds.bbci.co.uk/news'.$url_bit.'/rss.xml';
$feed = simplexml_load_string(getRemoteData($feed_url));


$output = array('stories' => array());
$items_total = count($feed->channel->item);

for ( $i=0; $i<$items_total; $i++ ) {
	$e = $feed->channel->item[$i];
	$item = array(
		"title" => (string) $e->title,
		"description" => (string) $e->description,
		"link" => (string) $e->link,
		"published" => strtotime($e->pubDate)
	);

	$output['stories'][] = $item;
}

$output_json = json_encode($output);

header('Content-type: application/json');
echo $output_json;
?>