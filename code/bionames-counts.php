<?php

// ION

require_once('coverage-decade.php');

//--------------------------------------------------------------------------------------------------
$db = NewADOConnection('mysqli');
$db->Connect("localhost", 
	'root' , '' , 'ion');

// Ensure fields are (only) indexed by column name
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

$db->EXECUTE("set names 'utf8'"); 

//--------------------------------------------------------------------------------------------------

$sql = 'SELECT COUNT(id) AS count FROM names';		
$num = number_of_names_mysql($db, $sql);

echo "Number of names=$num\n";


$sql = 'SELECT COUNT(id) AS count FROM names WHERE publication IS NOT NULL';		
$num_pubs = number_of_names_mysql($db, $sql);


$sql = 'SELECT COUNT(id) AS c FROM names WHERE <IDENTIFIER> IS NOT NULL';		
$identifiers = array('doi', 'handle', 'jstor', 'biostor', 'bhl', 'url', 'pdf', 'wikidata');
$results = identifier_counts_mysql($db, $sql, $identifiers);

$terms = array();
foreach ($identifiers as $id)
{

	$terms[] = '(' . $id . ' IS NOT NULL AND ' . $id . ' <> "")';
}		

$sql = 'SELECT COUNT(id) AS count FROM names WHERE ' . join(' OR ', $terms);

$num_with_ids = number_of_names_mysql($db, $sql);
$results['identifier'] = $num_with_ids ;

$results['names'] = $num;
$results['publications'] = $num_pubs;


print_r($results);

$keys = array('names', 'publications', 'doi', 'handle', 'jstor', 'biostor', 'bhl', 'url', 'pdf', 'wikidata', 'identifier');

foreach ($keys as $k)
{
	echo str_pad($k, 10, ' ') . " " . str_pad($results[$k], 10, ' ', STR_PAD_LEFT) . "\n";
}

?>
