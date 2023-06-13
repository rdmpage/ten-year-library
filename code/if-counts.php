<?php

// Index Fungorum

require_once('coverage-decade.php');

$database_filename = 'sqlite:/Users/rpage/Development/index-fungorum-coldp/if.db';

$sql = 'SELECT COUNT(id) AS count FROM names';		

$num = number_of_names($database_filename, $sql);

echo "Number of names=$num\n";

$sql = 'SELECT COUNT(id) AS count FROM names WHERE title IS NOT NULL';		

$num_pubs = number_of_names($database_filename, $sql);

echo "Number of publications=$num_pubs\n";



$sql = 'SELECT COUNT(id) AS count FROM names WHERE <IDENTIFIER> IS NOT NULL';		

$identifiers = array('doi', 'handle', 'jstor', 'biostor', 'bhl', 'url', 'pdf', 'wikidata');

$results = identifier_counts($database_filename, $sql, $identifiers);


$results['names'] = $num;
$results['publications'] = $num_pubs;



$terms = array();
foreach ($identifiers as $id)
{

	$terms[] = '(' . $id . ' IS NOT NULL AND ' . $id . ' <> "")';
}		

$sql = 'SELECT COUNT(id) AS count FROM names WHERE ' . join(' OR ', $terms);

$num_with_ids = number_of_names($database_filename, $sql);
$results['identifier'] = $num_with_ids ;

print_r($results);

$keys = array('names', 'publications', 'doi', 'handle', 'jstor', 'biostor', 'bhl', 'url', 'pdf', 'wikidata', 'identifier');

foreach ($keys as $k)
{
	echo str_pad($k, 10, ' ') . " " . str_pad($results[$k], 10, ' ', STR_PAD_LEFT) . "\n";
}

?>
