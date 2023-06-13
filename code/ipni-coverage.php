<?php

// Index Fungorum

require_once('coverage-decade.php');


$database_filename = 'sqlite:/Users/rpage/Development/ipni-coldp/ipni.db';



$force = false;
//$force = true;

if (!file_exists('ipni.json') || $force)
{

	$sql = 'SELECT COUNT(id) AS count, publication AS container, substr(publicationyearfull,1,4)/10 * 10 AS decade 
		FROM names 
		WHERE publication IS NOT NULL AND publication <> "" AND publicationyearfull <> "" 
		GROUP BY publication, decade;';				

	$limit = 50;

	$coverage = get_coverage($database_filename, $sql, $limit);

	file_put_contents('ipni.json', json_encode($coverage));
}

$json = file_get_contents('ipni.json');
$coverage = json_decode($json, true);



// add counts

$sql = 'SELECT COUNT(id) AS count FROM names WHERE publication ="<CONTAINER>" 
AND publication <> "" AND publicationyearfull <> "" 
AND (doi IS NOT NULL OR jstor IS NOT NULL OR handle IS NOT NULL OR url IS NOT NULL OR pdf IS NOT NULL OR cinii IS NOT NULL OR bhl IS NOT NULL OR biostor IS NOT NULL OR url IS NOT NULL OR pdf IS NOT NULL OR isbn IS NOT NULL)';				

$coverage = add_counts($database_filename, $sql, $coverage);

print_r($coverage);

// displayImage

$html = to_html($coverage, '#73AC13');

file_put_contents('plants.html', $html);

?>
