<?php

// Index Fungorum

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

$sql = 'SELECT COUNT(id) AS c FROM names WHERE <IDENTIFIER> IS NOT NULL';		

$identifiers = array('doi', 'handle', 'jstor', 'biostor', 'bhl', 'url', 'pdf', 'wikidata');

$results = identifier_counts_mysql($db, $sql, $identifiers);

print_r($results);

foreach ($results as $k => $v)
{
	echo str_pad($k, 10, ' ') . " " . str_pad($v, 10, ' ', STR_PAD_LEFT) . "\n";
}


?>
